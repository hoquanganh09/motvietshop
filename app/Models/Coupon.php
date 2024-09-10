<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, ModelScopeTrait;

    protected $fillable = [
        'code',
        'discount',
        'amount',
        'max_price',
        'is_active',
        'expiration_date',
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function isExpired()
    {
        return $this->expiration_date < now();
    }
}
