<?php

namespace App\Traits;

use App\Enums\ThongKeType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait ModelScopeTrait
{
    public function scopeActive($query)
    {
        $model = new (self::class);
        return $query->where($model->getTable() . '.is_active', 1);
    }

    public function scopeFilter($query, string $type, bool $isPast = false)
    {
        // Fix #1: Dùng copy() để tránh mutate object Carbon::now() gốc
        // Trước đây: $cb->subDay(1) thay đổi $cb vĩnh viễn, khiến query "hôm nay" cũng bị sai
        $cb = Carbon::now();
        $threeMonth = getThreeMonthByMonth($cb->month);
        $between = getStartEndThreeMonthByThreeMonth($threeMonth);

        switch ($type) {
            case ThongKeType::DAY->value:
                $date = $isPast ? $cb->copy()->subDay(1) : $cb;
                $query = $query->whereDay('created_at', $date->day);
                break;
            case ThongKeType::WEEK->value:
                $date = $isPast ? $cb->copy()->subWeek(1) : $cb;
                $query = $query->whereRaw('WEEK(created_at, 3) = ' . $date->week);
                break;
            case ThongKeType::MONTH->value:
                $date = $isPast ? $cb->copy()->subMonth(1) : $cb;
                $query = $query->whereMonth('created_at', $date->month);
                break;
            case ThongKeType::THREE_MONTHS->value:
                if ($isPast) {
                    $isLastYear = false;
                    if ($threeMonth == 1) {
                        $isLastYear = true;
                        $threeMonth = 4;
                    } else {
                        $threeMonth--;
                    }
                    $pastCb = $isLastYear ? $cb->copy()->subYear(1) : $cb->copy();
                    $between = getStartEndThreeMonthByThreeMonth($threeMonth);
                    $query = $query->whereBetween(DB::raw('MONTH(created_at)'), $between);
                    $query = $query->whereYear('created_at', $pastCb->year);
                } else {
                    $query = $query->whereBetween(DB::raw('MONTH(created_at)'), $between);
                    $query = $query->whereYear('created_at', $cb->year);
                }
                break;
            case ThongKeType::YEAR->value:
                $date = $isPast ? $cb->copy()->subYear(1) : $cb;
                $query = $query->whereYear('created_at', $date->year);
                break;
        }

        return $query;
    }
}