<?php

namespace App\Models;

use App\Http\Resources\Admin\AboutResource;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    public $resource = AboutResource::class;

    protected $fillable = [

        'title',
        'sub_title',
        'description',
        'image1',
        'image2',

    ];


    public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                $r->Where('title', 'LIKE', $search);
            });
        }
        return $query;
    }
}
