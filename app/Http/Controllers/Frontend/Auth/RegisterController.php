<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOTP;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    //
    public function create()
    {
        return view('frontend.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Create user with inactive status
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'otp_code' => rand(100000, 999999),
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'status' => false,
        ]);

        // Store user ID in session for OTP verification
        Session::put('otp_user_id', $user->id);
        

        // // Send OTP email
        // Mail::to($user->email)->send(new VerificationCodeMail($user));
        // SendOTP::dispatch($user);
        return redirect()->route('show.verify-otp')
            ->with('success', __('تم إرسال رمز التحقق إلى بريدك الإلكتروني.'));
    }

    public function showVerifyForm()
    {
        return view('frontend.auth.verify-otp');
    }

    public function resendOtp()
    {
        // التأكد من وجود مستخدم في الجلسة
        $userId = Session::get('otp_user_id');
        if (!$userId) {
            return back()->with('error', __('لا يمكن العثور على بيانات المستخدم.'));
        }

        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', __('المستخدم غير موجود.'));
        }

        // Generate new OTP
        $user->update([
            'otp_code' => rand(100000, 999999),
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        // Mail::to($user->email)->send(new VerificationCodeMail($user));

        return back()->with('success', __('رمز جديد تم إرساله إلى بريدك الإلكتروني.'));
    }

    public function verifyOtp(Request $request)
    {
        // 1. التحقق من وجود المستخدم في الجلسة
        $userId = Session::get('otp_user_id');
        if (!$userId) {
            return back()->with('error', __('لا يمكن العثور على بيانات المستخدم.'));
        }

        // Find user
        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', __('المستخدم غير موجود.'));
        }

        // 2. التحقق من البيانات المدخلة
        $request->validate([
            'otp_code' => 'required|numeric|digits:6',
        ]);

        // 3. التحقق من الرمز والصلاحية
        if ($user->otp_code != $request->otp_code) {
            return back()->with('error', __('الرمز غير صحيح.'));
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with('error', __('انتهت صلاحية الرمز.'));
        }

        // 4. تحديث بيانات المستخدم
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
            'status' => true,
        ]);

        // 5. تسجيل دخول المستخدم
        Auth::guard('web')->login($user);

        // 6. حذف الجلسة بعد التحقق
        Session::forget('otp_user_id');

        // 7. إعادة التوجيه
        return redirect()->route('home')->with('success', __('تم تفعيل حسابك بنجاح!'));
    }
}
