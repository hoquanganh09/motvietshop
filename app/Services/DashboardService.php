<?php

namespace App\Services;

use App\Enums\ThongKeType;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardFilters(string $defaultName = ThongKeType::MONTH->value): array
    {
        $filters = [
            [
                'label' => 'Theo ngày',
                'name' => ThongKeType::DAY->value,
                'default' => false,
                'text' => 'trong ngày'
            ],
            [
                'label' => 'Theo tuần',
                'name' => ThongKeType::WEEK->value,
                'default' => false,
                'text' => 'trong tuần'
            ],
            [
                'label' => 'Theo tháng',
                'name' => ThongKeType::MONTH->value,
                'default' => false,
                'text' => 'trong tháng'
            ],
            [
                'label' => 'Theo quý',
                'name' => ThongKeType::THREE_MONTHS->value,
                'default' => false,
                'text' => 'trong quý'
            ],
            [
                'label' => 'Theo năm',
                'name' => ThongKeType::YEAR->value,
                'default' => false,
                'text' => 'trong năm'
            ],
        ];

        array_walk($filters, function (&$item) use ($defaultName) {
            if ($item['name'] == $defaultName) {
                $item['default'] = true;
            }
        });

        return $filters;
    }

    public function getFilterActive(array $filters)
    {
        return collect($filters)->where('default', true)->first();
    }

    public function mapTypeToChartX(string $type)
    {
        $result = [];

        switch ($type) {
            case ThongKeType::DAY->value:
                $result = [
                    '00:00',
                    '04:00',
                    '08:00',
                    '12:00',
                    '16:00',
                    '20:00',
                ];
                break;
            case ThongKeType::WEEK->value:
                $result = [
                    'Thứ 2',
                    'Thứ 3',
                    'Thứ 4',
                    'Thứ 5',
                    'Thứ 6',
                    'Thứ 7',
                    'CN',
                ];
                break;
            case ThongKeType::MONTH->value:
                $result = [
                    'Tuần 1',
                    'Tuần 2',
                    'Tuần 3',
                    'Tuần 4',
                    'Tuần 5',
                ];
                break;
            case ThongKeType::THREE_MONTHS->value:
                $result = [
                    'Quý 1',
                    'Quý 2',
                    'Quý 3',
                    'Quý 4',
                ];
                break;
            case ThongKeType::YEAR->value:
                $result = array_map(fn($item) => 'Tháng ' . $item, range(1, 12));
                break;
        }

        return $result;
    }

    public function mapDataWithType($data, string $type, string $field)
    {
        $result = [];

        switch ($type) {
            case ThongKeType::DAY->value:
                $result = [
                    $this->getDataBetweenTime($data, '00:00', '03:59')->sum($field),
                    $this->getDataBetweenTime($data, '04:00', '07:59')->sum($field),
                    $this->getDataBetweenTime($data, '08:00', '11:59')->sum($field),
                    $this->getDataBetweenTime($data, '12:00', '15:59')->sum($field),
                    $this->getDataBetweenTime($data, '16:00', '19:59')->sum($field),
                    $this->getDataBetweenTime($data, '20:00', '23:59')->sum($field),
                ];
                break;
            case ThongKeType::WEEK->value:
                $result = [
                    $data->filter(fn($item) => $item->created_at->weekDay() == 1)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 2)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 3)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 4)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 5)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 6)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekDay() == 0)->sum($field),
                ];
                break;
            case ThongKeType::MONTH->value:
                $result = [
                    $data->filter(fn($item) => $item->created_at->weekOfMonth == 1)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekOfMonth == 2)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekOfMonth == 3)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekOfMonth == 4)->sum($field),
                    $data->filter(fn($item) => $item->created_at->weekOfMonth == 5)->sum($field),
                ];
                break;
            case ThongKeType::THREE_MONTHS->value:
                $result = [
                    $this->getDateByThreeMonth($data, 1)->sum($field),
                    $this->getDateByThreeMonth($data, 2)->sum($field),
                    $this->getDateByThreeMonth($data, 3)->sum($field),
                    $this->getDateByThreeMonth($data, 4)->sum($field),
                ];
                break;
            case ThongKeType::YEAR->value:
                $result = [
                    $data->filter(fn($item) => $item->created_at->month == 1)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 2)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 3)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 4)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 5)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 6)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 7)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 8)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 9)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 10)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 11)->sum($field),
                    $data->filter(fn($item) => $item->created_at->month == 12)->sum($field),
                ];
                break;
        }
        return $result;
    }

    private function getDataBetweenTime($data, $start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        return $data->filter(function ($item) use ($start, $end) {
            $check = Carbon::parse($item->created_at->format('H:m'));

            return $check >= $start && $check <= $end;
        });
    }

    private function getDateByThreeMonth($data, $threeMonth)
    {
        $arr = getStartEndThreeMonthByThreeMonth($threeMonth);

        return $data->filter(function ($item) use ($arr) {
            return $item->created_at->month >= $arr['start'] && $item->created_at->month <= $arr['end'];
        });
    }
}
