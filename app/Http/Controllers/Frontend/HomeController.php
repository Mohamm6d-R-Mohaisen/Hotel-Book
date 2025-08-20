<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AdminNotification;
use App\Models\About;
use App\Models\Blog;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserMessages;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Services\BookingService;
use PHPUnit\Event\Code\Test;
Use App\Models\Testimonial;

class HomeController extends Controller
{
     protected $bookingservice;
    public function __construct(BookingService $bookingservice )
    {
        $this->bookingservice = $bookingservice;
    }


    public function index(){
        $slider =Slider::latest()->first();
        $roomTypes=RoomType::all();
        $about=About::latest()->first();
        $services=Service::all();
        $roomTypes = RoomType::take(4)->get();
        $custemerReviews = Testimonial::all();
        $bloges=Blog::all();

        return view('frontend.home.index',
            [
                'slider' => $slider,
                'roomTypes' => $roomTypes,
                'about' => $about,
                'services' => $services,
                'roomTypes' => $roomTypes,
                'custemerReviews' => $custemerReviews,
                'bloges' => $bloges
            ]);
    }

    public function showContact()
    {
        return view('frontend.home.contactUs');
    }

    public function contactStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject'=> [ 'string'],
            'message' => ['required', 'string'],
        ], [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'message.required' => 'Please enter your message'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $data= $request->only(['name', 'subject', 'email', 'message']);
            $message = UserMessages::create($data);

            $email = Setting::where('key', 'email')->first()->value;
            Mail::to($email)->send(new AdminNotification($message, 'contact'));

            return $this->response_api(200, __('admin.form.added_successfully'), '');
        } catch (\Exception $e) {
            return $this->response_api(400, $this->exMessage($e));
        }
    }
  public function getAvailableRooms(Request $request)
{
    $validator = Validator::make($request->all(), [
        'check_in' => 'required|date|before:check_out',
        'check_out' => 'required|date|after:check_in',
        'room_type_id' => 'nullable|exists:room_types,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $checkInDate = $request->check_in;
    $checkOutDate = $request->check_out;
    $roomTypeId = $request->room_type_id;

    $availableRooms = $this->bookingservice->getAvailableRooms($checkInDate, $checkOutDate, $roomTypeId);

    return response()->json([
        'count' => $availableRooms->count()
    ]);
}
}
