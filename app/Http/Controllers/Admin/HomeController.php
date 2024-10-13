<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\ThongKeType;
use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (!auth('admin')->user()->can('dashboard')) {
            return to_route('admin.product.index');
        }
        $type = request('filter', ThongKeType::MONTH->value);
        $filters = $this->getDashboardFilters($type);
        $activeFilter = $this->getFilterActive($filters);

        $earningCount = [
            'now' => Order::getEarningCount($type),
            'yesterday' => Order::getEarningCount($type, true),
        ];

        $orderCount = [
            'now' => Order::getOrderByType($type)->count(),
            'yesterday' => Order::getOrderByType($type, true)->count(),
        ];

        $visitorCount = [
            'now' => Visitor::getVisitorCount($type),
            'yesterday' => Visitor::getVisitorCount($type, true),
        ];

        $newCustomerCount = [
            'now' => User::getNewCustomersByType($type)->count(),
            'yesterday' => User::getNewCustomersByType($type, true)->count(),
        ];

        $recentOrders = Order::query()
            ->latest()
            ->limit(8)
            ->where('status', OrderStatus::PENDING->value)
            ->get();

        $productDeliverys = Order::query()
            ->latest()
            ->limit(10)
            ->with([
                'orderDetails',
                'orderDetails.product',
                'orderDetails.product.images',
            ])
            ->where('status', '>', OrderStatus::PROCESSING->value)
            ->get();

        $bestSellingProducts = Product::withSum('orderDetails', 'quantity')
            ->orderBy('order_details_sum_quantity', 'desc')
            ->limit(5)
            ->with([
                'images',
                'kind',
            ])
            ->get();

        $topRatedProducts = Product::withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('reviews_avg_rating', 'desc')
            ->limit(5)
            ->with([
                'images',
                'kind',
            ])
            ->get();

        return view('admin.home.dashboard', compact(
            'earningCount',
            'orderCount',
            'newCustomerCount',
            'filters',
            'visitorCount',
            'activeFilter',
            'type',
            'recentOrders',
            'productDeliverys',
            'bestSellingProducts',
            'topRatedProducts',
        ));
    }

    public function getChartOrder()
    {
        $type = request('filter', ThongKeType::MONTH->value);
        $chartX = $this->mapTypeToChartX($type);
        $dataOrder = $this->mapDataWithType(Order::query()->filter($type)->get(), $type, 'total');
        $dataOrder = array_map(fn($item) => round($item / 1000), $dataOrder);

        return response()->json([
            'x' => $chartX,
            'y' => $dataOrder,
        ]);
    }

    public function getChartKindSale()
    {
        $type = request('filter', ThongKeType::MONTH->value);
        $orders = Order::query()->filter($type)
            ->where('status', '>', OrderStatus::SHIPPING->value)
            ->with([
                'orderDetails',
                'orderDetails.product',
                'orderDetails.product.kind',
            ])
            ->get()
            ->pluck('orderDetails.*.product.kind')
            ->flatten();

        $result = $orders->groupBy('id')->map(function ($item) {
            return [
                'value' => $item->count(),
                'name' => $item->first()->name,
                'id' => $item->first()->id,
            ];
        });
        $result = $result->sortBy('value', SORT_REGULAR, true);
        $maxCount = 10;

        if ($result->count() > $maxCount) {
            $result = $result->slice(0, $maxCount);
        } else {
            $kinds = Kind::query()
                ->whereNotIn('id', $result->pluck('id')->toArray())
                ->limit($maxCount - $result->count())
                ->get();

            $kinds = $kinds->map(function ($item) {
                return [
                    'value' => 0,
                    'name' => $item->name,
                    'id' => $item->id,
                ];
            });

            $result = $result->merge($kinds);
        }

        return response()->json($result->toArray());
    }

    public function profile(User $user)
    {
        if (!auth('admin')->user()->can('update-profile', [$user])) {
            abort(404);
        }
        return view('admin.home.profile', compact('user'));
    }

    private function getDashboardFilters(string $defaultName = ThongKeType::MONTH->value): array
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

    private function getFilterActive(array $filters)
    {
        return collect($filters)->where('default', true)->first();
    }

    private function mapTypeToChartX(string $type)
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

    private function mapDataWithType($data, string $type, string $field)
    {
        $result = [];

        switch ($type) {
            case ThongKeType::DAY->value:
                $result = [
                    $this->getDataBetweenTime($data, '00:00', '03:59')->sum($field),
                    $this->getDataBetweenTime($data, '04:00', '07:59')->sum($field),
                    $this->getDataBetweenTime($data, '08:00', '11:59')->sum($field),
                    $this->getDataBetweenTime($data, '12:00', '15:59')->sum($field),
                    $this->getDataBetweenTime($data, '14:00', '19:59')->sum($field),
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
