<?php

namespace App\Models;

use App\Enums\ThongKeType;
use App\Traits\ModelScopeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visitor extends Model
{
    use HasFactory, ModelScopeTrait;

    protected $fillable = ['ip', 'user_agent', 'created_at', 'updated_at'];

    public static function getVisitorCount(string $type, bool $isPast = false)
    {
        $query =  self::query()->filter($type, $isPast);

        return $query->count();
    }
}
