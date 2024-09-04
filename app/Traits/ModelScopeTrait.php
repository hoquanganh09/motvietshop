<?php

namespace App\Traits;

trait ModelScopeTrait
{
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}