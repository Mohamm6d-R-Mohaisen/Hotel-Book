<?php

namespace App\Models;

use App\Http\Resources\Admin\TestimonialResource;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    public $resource=TestimonialResource::class;
    protected $fillable = [
        'name',

        'message',
        'position',
        'image'
    ];


    public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                $r->where('title', 'LIKE', $search);

            });
        }
        return $query;
    }
}
