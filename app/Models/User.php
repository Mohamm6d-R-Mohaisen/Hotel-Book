<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Resources\Admin\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $resource = UserResource::class;
    protected $table='users';
      protected $fillable = [
        'name',
        'phone_code',
        'phone',
        'email',
        'email_verified_at',
        'username',
        'password',
        'remember_token',
        'status',
        'image',
        'otp',
        'otp_expired_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     public function scopeSearch($query, $request)
    {
        if (!empty($request->search['value'])) {
            $search = '%' . $request->search['value'] . '%';
            return $query->where(function($r) use ($search){
                    $r->where('name', 'LIKE', $search)
                      ->orWhere('email', 'LIKE', $search);
            });
        }
        return $query;
    }

    public function reservations()
    {
        return $this->hasMany(Booking::class);
    }


}
