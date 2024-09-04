<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'amount',
        'max_price',
        'is_active',
        'expiration_date',
    ];

    public function isExpired()
    {
        return $this->expiration_date > now();
    }
}
