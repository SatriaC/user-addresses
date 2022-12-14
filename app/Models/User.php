<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'default_address_name',
        'default_address',
        'default_address_latitude',
        'default_address_longitude',
    ];


    public function address()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function default()
    {
        return $this->address()->where('is_default', 1)->get()->first() ?? '';
    }

    public function getDefaultAddressNameAttribute()
    {
        return $this->default()->name ?? '';
    }

    public function getDefaultAddressAttribute()
    {
        return $this->default()->address ?? '';
    }

    public function getDefaultAddressLatitudeAttribute()
    {
        return $this->default()->latitude ?? '';
    }

    public function getDefaultAddressLongitudeAttribute()
    {
        return $this->default()->longitude ?? '';
    }
}
