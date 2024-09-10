<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SearchableTrait;

    const ACTIVE = 1;
    const INACTIVE = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'date_of_birth',
        'phone_number',
        'email_verified_at',
        'role',
        'email',
        'password',
        'is_admin',
        'is_active',
        'provider',
        'social_id',
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

    public static function searchFields(): array
    {
        return [
            'fullname',
            'date_of_birth',
            'phone_number',
            'email',
        ];
    }

    public function isActive()
    {
        return $this->is_active == static::ACTIVE;
    }

    public function getRole()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    public function isEmailVerified()
    {
        return $this->email_verified_at != null;
    }

    public function getPrefixName()
    {
        $fullname = stripVN($this->fullname);
        $parts = explode(' ', $fullname);
        $first = $parts[0][0];
        $last = '';
        
        if (count ($parts) > 1) {
            $last = array_pop($parts)[0];
        }
        $fullname = $first . $last;

        return strtoupper($fullname);
    }

    public function addresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
