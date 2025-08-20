<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Admin\RoomTypeResource;

class RoomType extends Model
{
    //
    use HasFactory;
    protected $table= 'room_types';
    public $resource = RoomTypeResource::class;
    protected $fillable = [
        'name',
        'price_per_night',
        'image',
        'size',
        'capicity',

    ];
    public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                    $r->where('name', 'LIKE', $search);

            });
        }
        return $query;
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }


}
