<?php
namespace App\Services;


use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomCalendar;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{

    public function __construct()
    {

    }



    /**
     * فحص توفر الغرف في فترة معينة مع إمكانية استثناء حجز معين (مفيد عند التعديل)
     */

    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate, $excludeBookingId = null)
    {
        $checkIn = Carbon::parse($checkInDate);
        $checkOut = Carbon::parse($checkOutDate);

        // التحقق من صحة التواريخ
        if ($checkIn->gte($checkOut)) {
            return [
                'available' => false,
                'message' => 'تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول'
            ];
        }

        // البحث عن أي حجوزات متعارضة باستثناء الحجز الحالي (إذا تم تحديده)
        $conflictingBookings = Booking::where('room_id', $roomId)
            ->whereNotIn('status', ['cancelled', 'checked_out']);

        // استثناء الحجز الحالي من التحقق
        if ($excludeBookingId) {
            $conflictingBookings->where('id', '!=', $excludeBookingId);
        }

        $conflictingBookings = $conflictingBookings->where(function($query) use ($checkIn, $checkOut) {
            $query->where(function($q) use ($checkIn, $checkOut) {
                // حالة 1: الحجز الجديد يبدأ خلال حجز موجود
                $q->where('check_in', '<=', $checkIn)
                    ->where('check_out', '>', $checkIn);
            })->orWhere(function($q) use ($checkIn, $checkOut) {
                // حالة 2: الحجز الجديد ينتهي خلال حجز موجود
                $q->where('check_in', '<', $checkOut)
                    ->where('check_out', '>=', $checkOut);
            })->orWhere(function($q) use ($checkIn, $checkOut) {
                // حالة 3: الحجز الجديد يحتوي حجز موجود بالكامل
                $q->where('check_in', '>=', $checkIn)
                    ->where('check_out', '<=', $checkOut);
            });
        })->exists();

        if ($conflictingBookings) {
            return [
                'available' => false,
                'message' => 'الغرفة محجوزة في هذه الفترة'
            ];
        }

        // فحص التقويم (RoomCalendar) - استثناء الحجز الحالي
        $blockedQuery = RoomCalendar::where('room_id', $roomId)
            ->whereBetween('date', [$checkIn, $checkOut->copy()->subDay()]);

        if ($excludeBookingId) {
            $blockedQuery->where('booking_id', '!=', $excludeBookingId);
        }

        $blockedDates = $blockedQuery->exists();

        if ($blockedDates) {
            return [
                'available' => false,
                'message' => 'توجد تواريخ محجوزة في الفترة المطلوبة'
            ];
        }

        return [
            'available' => true,
            'message' => 'الغرفة متاحة للحجز'
        ];
    }

    /**
     * البحث عن الغرف المتاحة في فترة معينة
     */
    public function getAvailableRooms($checkInDate, $checkOutDate, $roomTypeId = null)
    {
        $checkIn = Carbon::parse($checkInDate);
        $checkOut = Carbon::parse($checkOutDate);

        // الحصول على جميع الغرف
        $query = Room::where('status', '!=', 'maintenance');

        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }

        $allRooms = $query->pluck('id');

        // الحصول على الغرف المحجوزة في هذه الفترة
        $bookedRoomIds = Booking::whereNotIn('status', ['cancelled', 'checked_out'])
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where(function($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<=', $checkIn)
                        ->where('check_out', '>', $checkIn);
                })->orWhere(function($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                        ->where('check_out', '>=', $checkOut);
                })->orWhere(function($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '>=', $checkIn)
                        ->where('check_out', '<=', $checkOut);
                });
            })
            ->pluck('room_id')
            ->unique();

        // الغرف المتاحة
        $availableRoomIds = $allRooms->diff($bookedRoomIds);

        return Room::whereIn('id', $availableRoomIds)
            ->with('roomType')
            ->get();
    }
    /**
     * البحث عن الغرف المتاحة في فترة معينة
     */

    /**
     * إنشاء حجز جديد وتثبيت الأيام
     */
    /**
     * إنشاء الحجز والتجهيز للدفع
     */

    public function createBooking($paymentIntent,$meta)
    {
        DB::beginTransaction();

        try {
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


            DB::commit();

            return view('frontend.payment.payment-success', compact('booking'));


        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    /**
     * تثبيت الأيام المحجوزة في التقويم
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
     * تعديل تواريخ الحجز (الدخول والخروج)
     */
    public function updateBookingDates($bookingId, $newCheckIn, $newCheckOut)
    {
        DB::beginTransaction();

        try {

            $booking = Booking::findOrFail($bookingId);
            $roomId = $booking->room_id;

            $newCheckIn = Carbon::parse($newCheckIn);
            $newCheckOut = Carbon::parse($newCheckOut);

            // التحقق من صحة التواريخ
            if ($newCheckIn->gte($newCheckOut)) {
                return [
                    'success' => false,
                    'message' => 'تاريخ المغادرة يجب أن يكون بعد تاريخ الوصول'
                ];
            }

            // التحقق من توفر الغرفة مع استثناء الحجز الحالي
            $availability = $this->checkRoomAvailability(
                $roomId,
                $newCheckIn,
                $newCheckOut,
                $bookingId // <-- استثناء الحجز الحالي من الفحص
            );

            if (!$availability['available']) {
                return [
                    'success' => false,
                    'message' => $availability['message']
                ];
            }

            // حساب عدد الليالي الجديدة
            $nights = $newCheckIn->diffInDays($newCheckOut);

            // تحديث سعر الحجز بناءً على السعر الجديد
            $room = Room::findOrFail($roomId);
            $totalAmount = $room->roomType->price_per_night * $nights;

            // حفظ التواريخ القديمة لاستخدامها في تنظيف التقويم
            $oldCheckIn = Carbon::parse($booking->check_in);
            $oldCheckOut = Carbon::parse($booking->check_out);

            // تحديث الحجز
            $booking->update([
                'check_in' => $newCheckIn,
                'check_out' => $newCheckOut,
                'total_amount' => $totalAmount,
            ]);

            // تحديث جدول التقويم:
            // 1. حذف التواريخ القديمة
            RoomCalendar::where('booking_id', $bookingId)->delete();

            // 2. إدخال التواريخ الجديدة
            $this->blockDatesInCalendar($booking);

            DB::commit();

            return [
                'success' => true,
                'booking' => $booking->fresh(['room', 'user']),
                'nights' => $nights,
                'message' => 'تم تحديث تواريخ الحجز بنجاح'
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * إلغاء الحجز وتحرير الأيام
     */
 public function cancelBooking($bookingId)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($bookingId);

            // إذا كان الحجز ملغىً بالفعل
            if ($booking->status === 'cancelled') {
                return [
                    'success' => false,
                    'message' => 'هذا الحجز ملغىً بالفعل.'
                ];
            }


            // تحديث حالة الحجز
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            // حذف الأيام من التقويم
            RoomCalendar::where('booking_id', $bookingId)->delete();


            DB::commit();

            return [
                'success' => true,
                'message' => 'تم إلغاء الحجز واسترداد المبلغ بنجاح.'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'فشل في إلغاء الحجز: ' . $e->getMessage()
            ];
        }
    }

    /**
     * توليد رقم حجز فريد
     */
    private function generateBookingNumber()
    {
    //  return   'BK-' . date('Y') . '-' . str_pad(6, '0', STR_PAD_LEFT);
    return  'BK-' . date('Y') . '-' . str_pad(1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * الحصول على تقويم الإشغال لغرفة معينة
     */
    public function getRoomCalendar($roomId, $month, $year)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $bookedDates = RoomCalendar::where('room_id', $roomId)
            ->whereBetween('date', [$startDate, $endDate])
            ->pluck('date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        return $bookedDates;
    }
}
