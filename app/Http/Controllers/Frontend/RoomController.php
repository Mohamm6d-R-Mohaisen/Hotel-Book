<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\BookingService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
        // Set the Stripe API key
        Stripe::setApiKey(config('services.stripe.secret_key'));

        // Apply middleware for authentication
        $this->middleware('auth')->except(['index', 'show', 'filter']);
    }



    public function index(Request $request)
    {
        $query = Room::with('roomType');

        // أضف الفلتر هنا أيضًا
        if ($request->filled('type')) {
            $query->where('room_type_id', $request->type);
        }

        $rooms = $query->paginate(6)->withQueryString();
        $types = RoomType::all();

        return view('frontend.rooms.index', compact('rooms', 'types'));
    }

    /**
     * Filter rooms based on type.
     */
    public function filter(Request $request)
    {
        $query = Room::with('roomType');

        if ($request->filled('type')) {
            $query->where('room_type_id', $request->type);
        }

        $rooms = $query->paginate(6)->withQueryString();
        $types = RoomType::all();

        // بناء HTML للغرف فقط (مثل اللي في index)
        $html = '';

        foreach ($rooms as $room) {
            $image = $room->images->first() ? asset($room->images->first()->image) : asset('images/placeholder.jpg');
            $title = e($room->title);
            $typeName = e($room->roomType->name);
            $price = e($room->roomType->price_per_night);
            $size = e($room->roomType->size);
            $capacity = e($room->roomType->capacity);
            $url = route('rooms.show', $room->id);

            $html .= "
        <div class='col-lg-4 col-md-6 mb-4'>
            <div class='room-item'>
                <img src='$image' alt='$title'>
                <div class='ri-text'>
                    <h4>$title ($typeName)</h4>
                    <h3>$price$<span>/Pernight</span></h3>
                    <table>
                        <tbody>
                            <tr>
                                <td class='r-o'>Size:</td>
                                <td>$size</td>
                            </tr>
                            <tr>
                                <td class='r-o'>Capacity:</td>
                                <td>Max person $capacity</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href='$url' class='primary-btn'>More Details</a>
                </div>
            </div>
        </div>
        ";
        }

        if (empty($html)) {
            $html = "<p class='text-center'>No rooms found.</p>";
        }

        // الباجينيشن
        $pagination = (string) $rooms->links();

        return response()->json(compact('html', 'pagination'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',

        ]);
        $room = Room::findorfail($request->room_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        // حساب عدد الليالي
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->roomType->price_per_night * $nights;

        $availability = $this->bookingService->checkRoomAvailability(
            $request->room_id,
            $request->check_in,
            $request->check_out
        );

             if (!$availability['available']) {
     return response()->json([
            'available' => false,
            'message' => 'الغرفة غير متاحة للحجز'
        ]);
    }
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['total_amount'] = $totalAmount;
        $data['nights'] = $nights;

        return redirect(
            route('payment.page', ['room_id' => $request->room_id]) . '?' . http_build_query($data)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $room = Room::with('roomType', 'images')->findOrFail($id);
        return view('frontend.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkRoomAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $availability = $this->bookingService->checkRoomAvailability(
            $request->room_id,
            $request->check_in,
            $request->check_out
        );

        if (!$availability['available']) {
     return response()->json([
            'available' => false,
            'message' => 'الغرفة غير متاحة للحجز'
        ]);
    }
        return response()->json([
            'available' => true,
            'message' => 'الغرفة متاحة للحجز'
        ]);
    }
}
