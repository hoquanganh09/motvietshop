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
use Illuminate\Support\Facades\Cache;

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

        $cacheKey = 'dashboard_stats_' . $type;

        // Fix #4: Cache các query nặng 5 phút để giảm tải DB
        $stats = Cache::remember($cacheKey, 300, function () use ($type) {
            return [
                'earningNow'     => Order::getEarningCount($type),
                'earningPast'    => Order::getEarningCount($type, true),
                'orderNow'       => Order::getOrderByType($type)->count(),
                'orderPast'      => Order::getOrderByType($type, true)->count(),
                'visitorNow'     => Visitor::getVisitorCount($type),
                'visitorPast'    => Visitor::getVisitorCount($type, true),
                'customerNow'    => User::getNewCustomersByType($type)->count(),
                'customerPast'   => User::getNewCustomersByType($type, true)->count(),
                'recentOrders'   => Order::query()->latest()->limit(8)->where('status', OrderStatus::PENDING->value)->get(),
                'productDeliverys' => Order::query()->latest()->limit(10)->with(['orderDetails', 'orderDetails.product', 'orderDetails.product.images'])->where('status', '>', OrderStatus::PROCESSING->value)->get(),
                'bestSellingProducts' => Product::withSum('orderDetails', 'quantity')->orderBy('order_details_sum_quantity', 'desc')->limit(5)->with(['images', 'kind'])->get(),
                'topRatedProducts' => Product::withAvg('reviews', 'rating')->withCount('reviews')->orderBy('reviews_avg_rating', 'desc')->limit(5)->with(['images', 'kind'])->get(),
            ];
        });

        $earningCount     = ['now' => $stats['earningNow'],   'yesterday' => $stats['earningPast']];
        $orderCount       = ['now' => $stats['orderNow'],     'yesterday' => $stats['orderPast']];
        $visitorCount     = ['now' => $stats['visitorNow'],   'yesterday' => $stats['visitorPast']];
        $newCustomerCount = ['now' => $stats['customerNow'],  'yesterday' => $stats['customerPast']];
        $recentOrders     = $stats['recentOrders'];
        $productDeliverys = $stats['productDeliverys'];
        $bestSellingProducts = $stats['bestSellingProducts'];
        $topRatedProducts = $stats['topRatedProducts'];

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
        $maxCount = 10;

        // Fix #5: Dùng DB-level GROUP BY thay vì vòng lặp N+1 trên collection
        $soldKinds = \Illuminate\Support\Facades\DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('kinds', 'products.kind_id', '=', 'kinds.id')
            ->where('orders.status', '>', OrderStatus::SHIPPING->value)
            ->select('kinds.id', 'kinds.name', \Illuminate\Support\Facades\DB::raw('SUM(order_details.quantity) as value'))
            ->groupBy('kinds.id', 'kinds.name')
            ->orderByDesc('value')
            ->limit($maxCount)
            ->get();

        $soldKindIds = $soldKinds->pluck('id')->toArray();

        // Lấp đầy các thể loại còn lại nếu chưa đủ $maxCount
        if ($soldKinds->count() < $maxCount) {
            $extraKinds = Kind::query()
                ->whereNotIn('id', $soldKindIds)
                ->limit($maxCount - $soldKinds->count())
                ->get()
                ->map(fn($k) => ['id' => $k->id, 'name' => $k->name, 'value' => 0]);

            $result = $soldKinds->concat($extraKinds);
        } else {
            $result = $soldKinds;
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
