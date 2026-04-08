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
use App\Services\DashboardService;

class HomeController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function dashboard()
    {
        if (!auth('admin')->user()->can('dashboard')) {
            return to_route('admin.product.index');
        }
        $type = request('filter', ThongKeType::MONTH->value);
        $filters = $this->dashboardService->getDashboardFilters($type);
        $activeFilter = $this->dashboardService->getFilterActive($filters);

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
        $chartX = $this->dashboardService->mapTypeToChartX($type);
        $dataOrder = $this->dashboardService->mapDataWithType(Order::query()->filter($type)->get(), $type, 'total');
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

}
