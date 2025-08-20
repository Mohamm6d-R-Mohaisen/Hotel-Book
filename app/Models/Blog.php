<?php

namespace App\Models;

use App\Http\Resources\Admin\BlogResource;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
protected $table = 'blogs';
    public $resource = BlogResource::class;

    protected $fillable = [
        'title',
        'content',
        'author',
        'image',
        'overview',
    ];
}
