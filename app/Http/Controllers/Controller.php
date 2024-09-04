<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $menu = [
            [
                'label' => 'Nhân viên',
                'icon' => 'bi bi-bookmarks-fill fs-2x',
                'items' => [
                    [
                        'label' => 'Danh sách nhân viên',
                        'route' => route('admin.user.index'),
                        'active_route_name' => ['admin.user.index'],
                    ],
                ],
            ],
            [
                'label' => 'Sản phẩm',
                'icon' => 'bi bi-bookmarks-fill fs-2x',
                'items' => [
                    [
                        'label' => 'Danh sách phân loại',
                        'route' => route('admin.category.index'),
                        'active_route_name' => ['admin.category.index'],
                    ],
                    [
                        'label' => 'Danh sách thể loại',
                        'route' => route('admin.kind.index'),
                        'active_route_name' => ['admin.kind.index'],
                    ],
                    [
                        'label' => 'Danh sách màu sắc',
                        'route' => route('admin.color.index'),
                        'active_route_name' => ['admin.color.index'],
                    ],
                    [
                        'label' => 'Danh sách size',
                        'route' => route('admin.size.index'),
                        'active_route_name' => ['admin.size.index'],
                    ],
                    [
                        'label' => 'Danh sách sản phẩm',
                        'route' => route('admin.product.index'),
                        'active_route_name' => ['admin.product.index', 'admin.product.create'],
                    ],
                ],
            ],
            [
                'label' => 'Quản lý Banner',
                'icon' => 'bi bi-bookmarks-fill fs-2x',
                'route' => route('admin.banner.index'),
                'active_route_name' => ['admin.banner.index'],
                
            ],
            [
                'label' => 'Quản lý mã giảm giá',
                'icon' => 'bi bi-bookmarks-fill fs-2x',
                'route' => route('admin.coupon.index'),
                'active_route_name' => ['admin.coupon.index'],
                
            ],
            [
                'label' => 'Phân quyên',
                'icon' => 'bi bi-bookmarks-fill fs-2x',
                'items' => [
                    [
                        'label' => 'Danh sách vai trò',
                        'route' => route('admin.role.index'),
                        'active_route_name' => [],
                    ],
                    [
                        'label' => 'Thêm mới vai trò',
                        'route' => route('admin.role.index'),
                        'active_route_name' => [],
                    ],
                    [
                        'label' => 'Danh sách quyền',
                        'route' => route('admin.permission.index'),
                        'active_route_name' => [],
                    ],
                ],
            ]
        ];

        View::share('menu', $menu);
    }
}
