<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BookingService;

use Illuminate\Support\Facades\Log;
use Stripe\Stripe;


class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
        Stripe::setApiKey(config('services.stripe.secret_key'));


        //     $this->middleware('permission:view_admins|add_admins', ['only' => ['index','store']]);
    //     $this->middleware('permission:add_admins', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit_admins', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
    {

        return view('admin.bookings.index');
    }

    public function datatable(Request $request)
    {
        $items = Booking::query()->orderBy('id', 'DESC')->search($request);
        return $this->filterDataTable($items, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::all();
        $data['rooms']=Room::with('roomType')->get();
        return view('admin.bookings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * إنشاء الحجز
     */
   public function store(Request $request)
    {
        // التحقق من صحة البيانات
try {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'room_id' => 'required|exists:rooms,id',
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
    ]);


    $availability = $this->bookingService->checkRoomAvailability(
            $request->room_id,
            $request->check_in,
            $request->check_out
        );

    if (!$availability['available']) {
        return $this->response_api(400, $availability['message']);
    }



                $data=$request->all();

            return response()->json([
                'status' => 200,                       // أو 200
                'message' => 'Payment intent created successfully',
                'redirect_url' => route('admin.payment.page', [
                    'room_id' => $request->room_id,
                ]) . '?' . http_build_query($data)
            ]);



    } catch (\Exception $e) {
        Log::error('Booking error: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء إنشاء الحجز. يرجى المحاولة مرة أخرى.');
    }
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $booking = Booking::with('room')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['booking'] = Booking::with('room.roomType')->findOrFail($id);
        $data['users'] = User::all();
        $data['rooms']=Room::all();
        return view('admin.bookings.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bookingId)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $result = $this->bookingService->updateBookingDates(
            $bookingId,
            $request->check_in,
            $request->check_out
        );

        if ($result['success']) {
            return $this->response_api(200, __('admin.form.added_successfully'), $result['booking']);
        } else {
            // أعد 400 مع رسالة الخطأ الفعلية
            return $this->response_api(400, $result['message']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Booking::destroy($id);
        return $this->response_api(200, __('admin.form.deleted_successfully'), '');
    }

  public function cancel(Request $request, $id)
    {


        $result = $this->bookingService->cancelBooking($id);

      return $this->response_api(200, __('admin.form.deleted_successfully'), '');
    }
}

