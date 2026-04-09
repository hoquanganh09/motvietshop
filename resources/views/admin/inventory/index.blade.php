<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Quản lý tồn kho
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">Tồn kho</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!-- Stats row -->
                <div class="row g-4 mb-6">
                    <div class="col-sm-4">
                        <a href="{{ route('admin.inventory.index') }}" class="card {{ $filter === 'all' ? 'border border-primary' : '' }} h-100 text-decoration-none">
                            <div class="card-body d-flex align-items-center gap-3 py-4">
                                <div class="symbol symbol-50px">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-duotone ki-package fs-2x text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold">{{ $totalAll }}</div>
                                    <div class="text-muted fs-7">Tổng sản phẩm</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.inventory.index', ['filter' => 'low']) }}" class="card {{ $filter === 'low' ? 'border border-warning' : '' }} h-100 text-decoration-none">
                            <div class="card-body d-flex align-items-center gap-3 py-4">
                                <div class="symbol symbol-50px">
                                    <span class="symbol-label bg-light-warning">
                                        <i class="ki-duotone ki-warning-2 fs-2x text-warning"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-warning">{{ $totalLow }}</div>
                                    <div class="text-muted fs-7">Sắp hết hàng (&lt; 10)</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ route('admin.inventory.index', ['filter' => 'out']) }}" class="card {{ $filter === 'out' ? 'border border-danger' : '' }} h-100 text-decoration-none">
                            <div class="card-body d-flex align-items-center gap-3 py-4">
                                <div class="symbol symbol-50px">
                                    <span class="symbol-label bg-light-danger">
                                        <i class="ki-duotone ki-cross-circle fs-2x text-danger"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-danger">{{ $totalOut }}</div>
                                    <div class="text-muted fs-7">Hết hàng</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <span class="fw-semibold text-gray-700">
                                @if($filter === 'low') Sản phẩm sắp hết hàng
                                @elseif($filter === 'out') Sản phẩm hết hàng
                                @else Tất cả sản phẩm
                                @endif
                            </span>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('admin.order.exportAll') }}" class="btn btn-success btn-sm">
                                <i class="ki-duotone ki-file-down fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>
                                Xuất đơn hàng CSV
                            </a>
                        </div>
                    </div>

                    <div class="card-body py-4">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead class="bg-light">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th style="width: 35%" class="pe-2">Sản phẩm</th>
                                        <th style="width: 15%" class="pe-2 text-center">Danh mục</th>
                                        <th style="width: 10%" class="pe-2 text-center">Giá</th>
                                        <th style="width: 10%" class="pe-2 text-center">Tồn kho</th>
                                        <th style="width: 15%" class="pe-2 text-center">Trạng thái</th>
                                        <th style="width: 15%" class="pe-2 text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img width="60" src="{{ $item->getThumbnail() }}" class="rounded" alt="{{ $item->name }}">
                                                    <div>
                                                        <div class="fw-semibold">{{ $item->name }}</div>
                                                        <div class="text-muted fs-7">ID: {{ $item->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ $item->kind->category->name }}</div>
                                                <div class="text-muted fs-7">{{ $item->kind->name }}</div>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                {{ formatMoney($item->price) }}
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold fs-5 {{ $item->stock <= 0 ? 'text-danger' : ($item->stock < 10 ? 'text-warning' : 'text-success') }}">
                                                    {{ $item->stock ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->stock <= 0)
                                                    <span class="badge badge-light-danger">Hết hàng</span>
                                                @elseif ($item->stock < 10)
                                                    <span class="badge badge-light-warning">Sắp hết</span>
                                                @else
                                                    <span class="badge badge-light-success">Còn hàng</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.product.edit', $item->id) }}" class="btn btn-sm btn-light-primary">
                                                    <i class="bi bi-pencil-square me-1"></i>Cập nhật
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-8">
                                                Không có sản phẩm nào.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin.layout.home>
