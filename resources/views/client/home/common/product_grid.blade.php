<!-- Nav pills -->
<div class="row g-0 overflow-x-auto pb-2 pb-sm-3 mb-3">
    <div class="col-auto pb-1 pb-sm-0 mx-auto">
        <ul class="nav nav-pills flex-nowrap text-nowrap">
            <li class="nav-item">
                <a class="nav-link {{ $category == null ? 'active' : '' }}"
                    href="{{ route('client.home.index') }}#featured">
                    Tất cả
                </a>
            </li>
            @foreach ($categories as $item)
                <li class="nav-item">
                    <a class="nav-link {{ $category == $item['id'] ? 'active' : '' }}"
                        href="{{ route('client.home.index', ['category' => $item['id']]) }}#featured">
                        {{ $item['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Products grid -->
<div class="product-grid row row-cols-2 row-cols-md-3 row-cols-lg-4 gy-4 gy-md-5 pb-xxl-3">
    @foreach ($products as $item)
        <x-client.product :product="$item" />
    @endforeach
</div>
@if ($canViewMore)
    <div class="text-center">
        <a class="view-more-product text-dark" href="{{ route('client.home.index') }}">Xem thêm</a>
    </div>
@endif
