<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Admin\RoomResource;
use App\Models\Image;

class Room extends Model
{
    public $resource=RoomResource::class;
    protected $fillable = [
        'category_id',
        'title',
        'number',
        'room_type_id',
        'status',
        'overview',
        'features',
    ];
    protected $casts = [
        'features' => 'array',
    ];
    public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                $r->where('number', 'LIKE', $search);
            });
        }
        return $query;
    }
    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function calendar()
    {
        return $this->hasMany(RoomCalendar::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
