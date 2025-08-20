<?php
namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCalendar;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Stripe\Refund;

class PaymentService
{

    public function __construct()
    {

        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    /**
     * إنشاء Payment Intent
     */
    public function createPaymentIntent(array $data)
    {
        $totalAmount = $data['total_amount'];

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $totalAmount * 100,
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => $data['user_id'],
                    'room_id' => $data['room_id'],
                    'check_in' => $data['check_in'],
                    'check_out' => $data['check_out'],
                    'total_amount' =>  $data['total_amount'],
                ],
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'amount' => $paymentIntent->amount,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }



    public function processPayment($paymentIntentId)
    {
                try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status !== 'succeeded' ||!$paymentIntent) {
                return redirect()->route('admin.payment.failed')->with('error', 'الدفع لم ينجح.');
            }

            $meta = $paymentIntent->metadata;


        try {
               DB::beginTransaction();

            $checkIn = Carbon::parse($meta['check_in']);
            $checkOut = Carbon::parse($meta['check_out']);

            // حساب عدد الليالي
            $nights = $checkIn->diffInDays($checkOut);

            // الحصول على سعر الغرفة
            $room = Room::findOrFail($meta['room_id']);
            $totalAmount = $room->roomType->price_per_night * $nights;

            // إنشاء الحجز
            $booking = Booking::create([
                'booking_number'=>$this->generateBookingNumber(),
                'room_id' => $meta['room_id'],
                'user_id' => $meta['user_id'],
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'total_amount' => $totalAmount,
                'nights' => $nights,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_intent_id' => $paymentIntent->id,
                'confirmed_at' => now(),
            ]);
            $transaction = Transaction::create([
                'stripe_payment_id' => $paymentIntent->id,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $totalAmount,
                'currency' => strtoupper($paymentIntent->currency),
                'status' => 'completed',
                'payment_method_id' => $paymentIntent->payment_method,
                'metadata' => json_encode($paymentIntent, JSON_UNESCAPED_UNICODE),
                'paid_at' => now(),
            ]);

            // حظر التواريخ في التقويم
            $this->blockDatesInCalendar($booking);

            DB::commit();

            return view('frontend.payment.payment-success', compact('booking'));


        } catch (\Exception $e) {
            DB::rollBack();

              return [
                    'success' => false,
                    'message' => $e->getMessage(),
              ];
              }



        } catch (\Exception $e) {
            return redirect()->route('admin.payment.failed')->with('error', 'حدث خطأ أثناء إنشاء الحجز.');
        }
    }



    /**
     * استرداد الدفع
     */
  public function refundPayment($paymentIntentId, $amount = null)
    {
        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);

            if ($intent->status !== 'succeeded') {
                return [
                    'success' => false,
                    'error' => 'لا يمكن الاسترداد: الدفع لم يُكتمل بنجاح.'
                ];
            }

            if ($intent->amount_refundable <= 0) {
                return [
                    'success' => false,
                    'error' => 'لا يوجد مبلغ قابل للاسترداد.'
                ];
            }

            // إذا لم يُحدد المبلغ، استرد المبلغ كاملاً
            $refundAmount = $amount ? $amount * 100 : null; // بالسنتات

            $refund = Refund::create([
                'payment_intent' => $paymentIntentId,
                'amount' => $refundAmount, // إذا كان null، يُعيد المبلغ كاملاً
                'reason' => 'requested_by_customer',

            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $refund->amount / 100,
                'currency' => strtoupper($refund->currency),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

 private function generateBookingNumber()
    {
return  'BK-' . date('Y') . '-' . str_pad(1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * حظر التواريخ في التقويم
     */

public function blockDatesInCalendar(Booking $booking)
    {
        $dates = [];
        $currentDate = Carbon::parse($booking->check_in);
        $checkOut = Carbon::parse($booking->check_out);
        // إنشاء سجل لكل يوم من أيام الحجز (عدا يوم المغادرة)
        while ($currentDate->lt($checkOut)) {
            $dates[] = [
                'room_id' => $booking->room_id,
                'booking_id' => $booking->id,
                'date' => $currentDate->format('Y-m-d'),
                'status' => 'booked',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $currentDate->addDay();
        }
        // إدخال جميع التواريخ دفعة واحدة
    RoomCalendar::insert($dates);

    }





















    /**
     * تأكيد الدفع بواسطة payment method
     */
    public function confirmPaymentWithMethod(string $paymentIntentId, string $paymentMethodId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // ربط payment method وتأكيد الدفع
            $paymentIntent->confirm([
                'payment_method' => $paymentMethodId,
            ]);

            // تحديث حالة المعاملة
            $transaction = Transaction::where('stripe_payment_id', $paymentIntentId)->first();
            if ($transaction) {
                $transaction->update([
                    'status' => $paymentIntent->status === 'succeeded' ? 'completed' : 'pending'
                ]);
            }

            return [
                'success' => true,
                'payment_intent' => $paymentIntent,
                'status' => $paymentIntent->status
            ];

        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $this->handleStripeError($e)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'حدث خطأ في تأكيد الدفع: ' . $e->getMessage()
            ];
        }
    }

    /**
     * فحص حالة الدفع
     */
    public function getPaymentStatus(string $paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            return [
                'success' => true,
                'stripe_status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'currency' => $paymentIntent->currency,
                'payment_method' => $paymentIntent->payment_method,
                'last_payment_error' => $paymentIntent->last_payment_error
            ];

        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $this->handleStripeError($e)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'حدث خطأ في فحص حالة الدفع: ' . $e->getMessage()
            ];
        }
    }

    /**
     * تأكيد الدفع (للمعاملات النهائية)
     */
    public function confirmPayment(string $paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status !== 'succeeded') {
                return [
                    'success' => false,
                    'error' => 'عملية الدفع غير مكتملة'
                ];
            }

            // تحديث المعاملة
            $transaction = Transaction::where('stripe_payment_id', $paymentIntentId)->first();
            if ($transaction) {
                $transaction->update([
                    'status' => 'completed',
                    'paid_at' => now()
                ]);
            }

            return [
                'success' => true,
                'transaction' => $transaction,
                'payment_intent' => $paymentIntent
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'حدث خطأ في تأكيد الدفع: ' . $e->getMessage()
            ];
        }
    }

    /**
     * تحديث حالة المعاملة
     */
    public function updateTransactionStatus(int $transactionId, string $status)
    {
        try {
            $transaction = Transaction::find($transactionId);
            if ($transaction) {
                $transaction->update(['status' => $status]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * معالجة أخطاء Stripe
     */
    private function handleStripeError(ApiErrorException $e)
    {
        switch ($e->getStripeCode()) {
            case 'card_declined':
                return 'تم رفض البطاقة';
            case 'insufficient_funds':
                return 'الرصيد غير كافي';
            case 'incorrect_cvc':
                return 'رمز الأمان غير صحيح';
            case 'expired_card':
                return 'البطاقة منتهية الصلاحية';
            default:
                return 'حدث خطأ في معالجة الدفع: ' . $e->getMessage();
        }
    }
}
