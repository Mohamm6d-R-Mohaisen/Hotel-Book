<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    protected $bookingservice;
    public function __construct(BookingService $bookingservice )
    {
        $this->bookingservice = $bookingservice;
    }
//        $this->middleware('auth');
//        $this->middleware('permission:view_admins|add_admins', ['only' => ['index']]);

    public function index()
    {
        $data['totalRooms'] = Room::count();
        $data['todayCheckIns'] = Booking::whereDate('check_in', today())->count();
        $data['todayCheckOuts'] = Booking::whereDate('check_out', today())->count();
        $data['lastUsers']=User::latest()->take(5)->get();

        $occupiedRoomIds = Booking::whereNotIn('status', ['cancelled', 'checked_out'])
            ->where('check_in', '<=', today())
            ->where('check_out', '>', today())
            ->pluck('room_id')
            ->unique();

        $data['availableRoomsNow'] = Room::count() - $occupiedRoomIds->count();

        // الحجوزات النشطة (غير ملغاة وغير مغادرة)
        $data['activeBookings'] = Booking::with('room')->whereNotIn('status', ['cancelled', 'checked_out'])
            ->orderByDesc('created_at')
            ->get();

        // الحجوزات المغادرة (Check-out)
        $data['checkOutBookings'] = Booking::with('room')->where('status', 'checked_out')
            ->orderByDesc('created_at')
            ->get();


        return view('admin.home.index', compact('data'));
    }
    public function getAvailableRooms(Request $request)
{
    // التحقق من صحة البيانات
    $request->validate([
        'check_in' => 'required|date|before:check_out',
        'check_out' => 'required|date|after:check_in',
        'room_type_id' => 'nullable|exists:room_types,id',
    ]);
    $checkInDate = request('check_in');
    $checkOutDate = request('check_out');
    $roomTypeId = request('room_type_id', null);

    $availableRooms = $this->bookingservice->getAvailableRooms($checkInDate, $checkOutDate, $roomTypeId);

    return response()->json([
        'available_rooms' => $availableRooms->map(function ($room) {
            return [
                'id' => $room->id,
                'room_number' => $room->number,
                'room_type' => $room->roomType->name, // اسم نوع الغرفة
                'price_per_night' => $room->roomType->price_per_night, // سعر الليلة
                'status' => 'available', // الحالة
            ];
        }),
        'count' => $availableRooms->count()
    ]);
}
//    public function getAvailableRooms(Request $request)
//    {
//        $request->validate([
//            'check_in' => 'required|date|before:check_out',
//            'check_out' => 'required|date|after:check_in',
//            'room_type_id' => 'nullable|exists:room_types,id',
//        ]);
//
//        $checkInDate = $request->check_in;
//        $checkOutDate = $request->check_out;
//        $roomTypeId = $request->room_type_id;
//
//        $availableRooms = $this->bookingservice->getAvailableRooms(
//            $checkInDate,
//            $checkOutDate,
//            $roomTypeId
//        );
//
//        return response()->json([
//            'available_rooms' => $availableRooms->map(function ($room) {
//                return [
//                    'id' => $room->id,
//                    'room_number' => $room->room_number,
//                    'room_type' => $room->roomType->name,
//                    'price_per_night' => $room->roomType->price_per_night,
//                ];
//            }),
//            'count' => $availableRooms->count(),
//        ]);
//    }

}
