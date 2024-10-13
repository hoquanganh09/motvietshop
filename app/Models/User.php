<?php

namespace App\Models;

use App\Enums\ThongKeType;
use App\Traits\ModelScopeTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SearchableTrait, ModelScopeTrait;

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
        'has_send_email_shipping',
        'has_send_email_order',
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

    public static function getNewCustomersByType(string $type, bool $isPast = false)
    {
        $query =  self::query()->active()->filter($type, $isPast);

        return $query->get();
    }

    public function isAdmin()
    {
        return $this->role == Role::ADMIN;
    }

    public function isSuperAdmin()
    {
        return $this->role == Role::SUPER_ADMIN;
    }

    public function isRoot()
    {
        return $this->role == Role::ROOT || $this->is_admin == 1;
    }
}
