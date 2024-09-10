<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
        'address',
        'phone_number',
        'is_default',
        'name',
    ];

    public function isDefault(): bool
    {
        return $this->is_default;
    }
}
