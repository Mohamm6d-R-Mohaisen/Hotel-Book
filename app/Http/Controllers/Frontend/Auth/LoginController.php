<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withInput()->with('error', __('بيانات الدخول غير صحيحة.'));
        }
        
        // Check if user status is active (true/1)
        if (!$user->status) {
            // Account not activated → redirect to verification page
            Session::put('otp_user_id', $user->id);
            return redirect()->route('show.verify-otp')->with('error', __('يرجى تفعيل حسابك عبر رمز التحقق المرسل إليك.'));
        }

        // Login using web guard
        Auth::guard('web')->login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', __('مرحبًا بك :name! تم تسجيل دخولك بنجاح.', ['name' => $user->full_name]));
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', __('تم تسجيل خروجك بنجاح.'));
    }
}
