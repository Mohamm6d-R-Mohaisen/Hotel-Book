<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SaveImageTrait;
use App\Http\Resources\Admin\SliderResource;
class Slider extends Model
{
    use HasFactory, SaveImageTrait;
    public $resource = SliderResource::class;  
    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image',
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