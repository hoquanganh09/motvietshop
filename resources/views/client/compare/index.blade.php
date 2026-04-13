<x-client.layout.home>
    @push('head-meta')
        <title>So sánh sản phẩm — {{ config('app.name') }}</title>
    @endpush

    <nav class="container pt-2 pt-xxl-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">So sánh sản phẩm</li>
        </ol>
    </nav>

    <section class="container pb-5 pb-lg-7">
        <h1 class="h3 mb-4">So sánh sản phẩm</h1>

        @if ($products->isEmpty())
            <div class="text-center py-5">
                <i class="ci-repeat fs-1 text-body-tertiary d-block mb-3" style="font-size: 4rem !important;"></i>
                <h5 class="text-body-secondary mb-3">Chưa có sản phẩm nào để so sánh</h5>
                <p class="text-body-tertiary mb-4">Hãy thêm sản phẩm vào danh sách so sánh từ trang cửa hàng.</p>
                <a href="{{ route('client.home.shop') }}" class="btn btn-dark">
                    Tiếp tục mua sắm
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center" style="min-width: 600px">
                    <!-- Product images + names -->
                    <thead>
                        <tr class="bg-body-tertiary">
                            <th class="text-start fw-semibold" style="width: 160px">Sản phẩm</th>
                            @foreach ($products as $product)
                                <th>
                                    <div class="position-relative d-inline-block">
                                        <button type="button"
                                            class="btn-compare-remove btn btn-icon btn-sm btn-secondary position-absolute top-0 end-0 rounded-circle z-2"
                                            data-url="{{ route('client.compare.remove', $product->id) }}"
                                            data-bs-toggle="tooltip" data-bs-title="Xóa khỏi so sánh"
                                            style="margin-top: -10px; margin-right: -10px;">
                                            <i class="ci-close fs-xs"></i>
                                        </button>
                                        <a href="{{ route('client.home.productDetail', $product->id) }}">
                                            <img src="{{ $product->getThumbnail() }}" alt="{{ $product->name }}"
                                                class="rounded mb-2" style="width: 120px; height: 140px; object-fit: cover;">
                                        </a>
                                        <div class="fw-semibold fs-sm text-dark">
                                            <a href="{{ route('client.home.productDetail', $product->id) }}" class="text-dark text-decoration-none">
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)
                                <th>
                                    <div class="text-body-tertiary py-4">
                                        <i class="ci-plus fs-3 d-block mb-2"></i>
                                        <a href="{{ route('client.home.shop') }}" class="fs-sm text-body-tertiary text-decoration-none">
                                            Thêm sản phẩm
                                        </a>
                                    </div>
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Price -->
                        <tr>
                            <td class="text-start fw-medium bg-body-tertiary">Giá</td>
                            @foreach ($products as $product)
                                <td>
                                    <span class="fw-bold {{ $product->isOnFlashSale() ? 'text-danger' : '' }}">
                                        {{ formatMoney($product->getCurrentPrice()) }}
                                    </span>
                                    @if ($product->isSale() || $product->isOnFlashSale())
                                        <br><del class="fs-xs text-body-tertiary">{{ formatMoney($product->price) }}</del>
                                    @endif
                                </td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td class="text-body-tertiary">—</td>@endfor
                        </tr>
                        <!-- Category -->
                        <tr>
                            <td class="text-start fw-medium bg-body-tertiary">Danh mục</td>
                            @foreach ($products as $product)
                                <td class="fs-sm">{{ $product->kind->name ?? '—' }}</td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td class="text-body-tertiary">—</td>@endfor
                        </tr>
                        <!-- Stock -->
                        <tr>
                            <td class="text-start fw-medium bg-body-tertiary">Tồn kho</td>
                            @foreach ($products as $product)
                                <td>
                                    @if ($product->stock > 0)
                                        <span class="badge text-bg-success">Còn hàng ({{ $product->stock }})</span>
                                    @else
                                        <span class="badge text-bg-danger">Hết hàng</span>
                                    @endif
                                </td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td class="text-body-tertiary">—</td>@endfor
                        </tr>
                        <!-- Sizes -->
                        <tr>
                            <td class="text-start fw-medium bg-body-tertiary">Kích thước</td>
                            @foreach ($products as $product)
                                <td class="fs-sm">
                                    @forelse ($product->sizes as $s)
                                        <span class="badge text-bg-light border me-1">{{ $s->size->name }}</span>
                                    @empty
                                        <span class="text-body-tertiary">—</span>
                                    @endforelse
                                </td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td class="text-body-tertiary">—</td>@endfor
                        </tr>
                        <!-- Colors -->
                        <tr>
                            <td class="text-start fw-medium bg-body-tertiary">Màu sắc</td>
                            @foreach ($products as $product)
                                <td>
                                    <div class="d-flex justify-content-center flex-wrap gap-1">
                                        @forelse ($product->colors as $c)
                                            <span class="d-inline-block rounded-circle border"
                                                style="width:20px;height:20px;background:{{ $c->color->name }}"
                                                title="{{ $c->color->label }}"></span>
                                        @empty
                                            <span class="text-body-tertiary">—</span>
                                        @endforelse
                                    </div>
                                </td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td class="text-body-tertiary">—</td>@endfor
                        </tr>
                        <!-- Action -->
                        <tr>
                            <td class="bg-body-tertiary"></td>
                            @foreach ($products as $product)
                                <td>
                                    <a href="{{ route('client.home.productDetail', $product->id) }}"
                                        class="btn btn-dark btn-sm w-100">
                                        Xem chi tiết
                                    </a>
                                </td>
                            @endforeach
                            @for ($i = $products->count(); $i < 3; $i++)<td></td>@endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <button type="button" id="btn-compare-clear-all" class="btn btn-outline-danger btn-sm">
                    <i class="ci-trash me-1"></i>Xóa tất cả so sánh
                </button>
            </div>
        @endif
    </section>

    @push('js')
        <script>
            $(function () {
                $(document).on('click', '.btn-compare-remove', function () {
                    const url = $(this).data('url');
                    const $row = $(this).closest('th');
                    ajax(url, 'delete', {}, function (res) {
                        toast(res.data.message);
                        updateCompareBar(res.data.count);
                        setTimeout(() => location.reload(), 600);
                    });
                });

                $('#btn-compare-clear-all').on('click', function () {
                    ajax('{{ route('client.compare.clear') }}', 'delete', {}, function (res) {
                        toast(res.data.message);
                        updateCompareBar(0);
                        setTimeout(() => location.reload(), 600);
                    });
                });
            });
        </script>
    @endpush
</x-client.layout.home>
