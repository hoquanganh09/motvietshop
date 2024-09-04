@props([
    'items' => [
        [
            'label' => 'Nhân viên',
            'items' => [
                'label' => 'Danh sách nhân viê1n',
                'route_name' => route('admin.user.index'),
                'active_route_name' => [],
            ],
        ],
    ],
])
@php
    function isActiveRoute(array $routeNames = []): bool
    {
        $routes = array_filter($routeNames, fn($routeName) => Route::is($routeName));

        return count($routes) > 0 ? true : false;
    }
@endphp
<div id="kt_app_sidebar_menu_scroll" class="hover-scroll-y my-5 mx-3">
    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="#kt_app_sidebar_menu" data-kt-menu="true"
        data-kt-menu-expand="false">

        @foreach ($items as $level1)
            @php
                $href = $level1['route'] ?? 'javascript:void(0)';
                $hasChild = !empty($level1['items']);
                $active = isActiveRoute($level1['active_route_name'] ?? []) ? 'active' : '';
            @endphp
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion hover show">
                <a href="{{ $href }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="{{ $level1['icon'] ?? '' }}"></i>
                    </span>
                    <span class="menu-title">{{ $level1['label'] }}</span>

                    @if ($hasChild)
                        <span class="menu-arrow"></span>
                    @endif
                </a>
                @if ($hasChild)
                    <div class="menu-sub menu-sub-accordion">
                        @foreach ($level1['items'] as $level2)
                            @php
                                $href2 = $level2['route'] ?? 'javascript:void(0)';
                                $active = isActiveRoute($level2['active_route_name'] ?? []) ? 'active' : '';
                            @endphp
                            <div class="menu-item">
                                <a class="menu-link {{ $active }}"
                                    href="{{ $href2 }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ $level2['label'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
