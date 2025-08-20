<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class PaymentController extends Controller
{
    //
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    public function createPaymentIntent($data )
    {

        if (!$data){
            return response()->json(['error' => 'invalid data']);
        }
        return $this->paymentService->createPaymentIntent($data);


    }

    public function showPaymentPage($roomId,Request $request)
    {
        $data=$request->all();
        $room = Room::with('roomType')->findOrFail($roomId);

         if(!$data){
            return $this->response_api(400, 'Invalid data from show payment show');
          }
        $paymentIntent=$this->createPaymentIntent($data);
        if (!$paymentIntent['success']) {
            return $this->response_api(400, $paymentIntent['message']);
        }

        return view('frontend.payment.index', compact('room', 'data','paymentIntent'));
    }


    public function paymentSuccess(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        if (!$paymentIntentId) {
            return redirect()->route('admin.bookings.payment.failed')->with('error', 'معرف الدفع غير موجود.');
        }

return $this->paymentService->processPayment($paymentIntentId);

    }
    public function paymentFailed(Request $request)
    {
        $error = $request->query('error', 'فشلت عملية الدفع.');
        return view('frontend.payment.payment-failed', compact('error'));
    }

}
