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
        $cb = Carbon::now();
        $threeMonth = getThreeMonthByMonth($cb->month);
        $between = getStartEndThreeMonthByThreeMonth($threeMonth);

        switch ($type) {
            case ThongKeType::DAY->value:
                $isPast && $cb->subDay(1);
                $query = $query->whereDay('created_at', $cb->day);
                break;
            case ThongKeType::WEEK->value:
                $isPast && $cb->subWeek(1);
                $query = $query->whereRaw('WEEK(created_at, 3) = ' . $cb->week);
                break;
            case ThongKeType::MONTH->value:
                $isPast && $cb->subMonth(1);
                $query = $query->whereMonth('created_at', $cb->month);
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
                    $isLastYear && $cb->subYear(1);
                    $between = getStartEndThreeMonthByThreeMonth($threeMonth);
                }

                $query = $query->whereBetween(DB::raw('MONTH(created_at)'), $between);
                $query = $query->whereYear('created_at', $cb->year);
                break;
            case ThongKeType::YEAR->value:
                $isPast && $cb->subYear(1);
                $query = $query->whereYear('created_at', $cb->year);
                break;
        }

        return $query;
    }
}