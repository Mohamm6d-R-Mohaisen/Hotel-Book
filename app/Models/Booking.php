<?php

namespace App\Models;

use App\Http\Resources\Admin\BookingResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Booking extends Model
{
    //
    protected $dates = ['check_in', 'check_out'];
    public $resource=BookingResource::class;

    protected $fillable= [
        'booking_number',
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'nights',
        'total_amount',
        'status',
        'payment_status',
        'payment_intent_id',
        'transaction_id',
        'confirmed_at',
        'cancelled_at',
        'checked_in_at',
        'checked_out_at',
        'notes',
        'special_requests'
    ];
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];
//
    public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                $r->Where('room_id', 'LIKE', $search);
            });
        }
        return $query;
    }
//public function confirmationUrl()
//{
//    return URL::temporarySignedRoute(
//        'admin.booking.confirm', // الاسم الذي سنعرفه لاحقًا
//        now()->addDays(3), // الرابط صالح لمدة 3 أيام
//        ['booking' => $this->id]
//    );
//}
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function calendarDates()
    {
        return $this->hasMany(RoomCalendar::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
