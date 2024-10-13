<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $user = auth('admin')->user();
        if ($user) {
            $menu = [
                [
                    'label' => 'Dashboard',
                    'icon' => 'bi bi-speedometer fs-2x',
                    'route' => route('admin.home.dashboard'),
                    'active_route_name' => ['admin.home.dashboard'],
                    'enabled' => $user->can('dashboard'),
                ],
                [
                    'label' => 'Tài khoản',
                    'icon' => 'bi bi-people-fill fs-2x',
                    'items' => [
                        [
                            'label' => 'Danh sách nhân viên',
                            'route' => route('admin.user.index'),
                            'active_route_name' => ['admin.user.index'],
                            'enabled' => true,
                        ],
                        [
                            'label' => 'Danh sách khách hàng',
                            'route' => route('admin.user.customer'),
                            'active_route_name' => ['admin.user.customer'],
                            'enabled' => true,
                        ],
                    ],
                    'enabled' => $user->can('manager-user'),
                ],
                [
                    'label' => 'Sản phẩm',
                    'icon' => 'bi bi-box2 fs-2x',
                    'items' => [
                        [
                            'label' => 'Danh sách phân loại',
                            'route' => route('admin.category.index'),
                            'active_route_name' => ['admin.category.index'],
                            'enabled' => true,
                        ],
                        [
                            'label' => 'Danh sách thể loại',
                            'route' => route('admin.kind.index'),
                            'active_route_name' => ['admin.kind.index'],
                            'enabled' => true,
                        ],
                        [
                            'label' => 'Danh sách màu sắc',
                            'route' => route('admin.color.index'),
                            'active_route_name' => ['admin.color.index'],
                            'enabled' => true,
                        ],
                        [
                            'label' => 'Danh sách size',
                            'route' => route('admin.size.index'),
                            'active_route_name' => ['admin.size.index'],
                            'enabled' => true,
                        ],
                        [
                            'label' => 'Danh sách sản phẩm',
                            'route' => route('admin.product.index'),
                            'active_route_name' => ['admin.product.index', 'admin.product.create', 'admin.product.edit'],
                            'enabled' => true,
                        ],
                    ],
                    'enabled' => true,
                ],
                [
                    'label' => 'Quản lý đơn hàng',
                    'icon' => 'bi bi-basket3-fill fs-2x',
                    'route' => route('admin.order.index'),
                    'active_route_name' => ['admin.order.index', 'admin.order.show'],
                    'enabled' => true,
                ],
                [
                    'label' => 'Quản lý Banner',
                    'icon' => 'bi bi-card-image fs-2x',
                    'route' => route('admin.banner.index'),
                    'active_route_name' => ['admin.banner.index'],
                    'enabled' => true,
                ],
                [
                    'label' => 'Quản lý mã giảm giá',
                    'icon' => 'bi bi-cash fs-2x',
                    'route' => route('admin.coupon.index'),
                    'active_route_name' => ['admin.coupon.index'],
                    'enabled' => $user->can('manager-coupon'),
                ],
                // [
                //     'label' => 'Phân quyên',
                //     'icon' => 'bi bi-bookmarks-fill fs-2x',
                //     'items' => [
                //         [
                //             'label' => 'Danh sách vai trò',
                //             'route' => route('admin.role.index'),
                //             'active_route_name' => [],
                //         ],
                //         [
                //             'label' => 'Thêm mới vai trò',
                //             'route' => route('admin.role.index'),
                //             'active_route_name' => [],
                //         ],
                //         [
                //             'label' => 'Danh sách quyền',
                //             'route' => route('admin.permission.index'),
                //             'active_route_name' => [],
                //         ],
                //     ],
                // ]
            ];

            View::share('menu', $menu);
        }
    }
}
