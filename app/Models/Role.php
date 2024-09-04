<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ROOT = 1;
    const SUPER_ADMIN = 2;
    const ADMIN = 3;
    const USER = 4;

    public function users()
    {
        return $this->hasMany(User::class, 'role');
    }
}
