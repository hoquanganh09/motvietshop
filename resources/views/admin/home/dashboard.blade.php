<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">

        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Dashboard
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            Trang chủ
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="d-flex">
                        <select name="campaign-type"
                            class="filter form-select form-select-sm bg-body border-body w-175px">
                            @foreach ($filters as $item)
                                <option value="{{ $item['name'] }}" @if ($item['default']) selected @endif>
                                    {{ $item['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <!--begin::Row-->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    @php
                        $data = [
                            [
                                'amount' => formatMoney($earningCount['now']),
                                'label' => 'Doanh số ' . $activeFilter['text'],
                                'data' => [
                                    'now' => $earningCount['now'],
                                    'yesterday' => $earningCount['yesterday'],
                                ],
                            ],
                            [
                                'amount' => $visitorCount['now'],
                                'label' => 'Lượt truy cập ' . $activeFilter['text'],
                                'data' => [
                                    'now' => $visitorCount['now'],
                                    'yesterday' => $visitorCount['yesterday'],
                                ],
                            ],
                            [
                                'amount' => $orderCount['now'],
                                'label' => 'Đơn đặt hàng ' . $activeFilter['text'],
                                'data' => [
                                    'now' => $orderCount['now'],
                                    'yesterday' => $orderCount['yesterday'],
                                ],
                            ],
                            [
                                'amount' => $newCustomerCount['now'],
                                'label' => 'Khách hàng mới ' . $activeFilter['text'],
                                'data' => [
                                    'now' => $newCustomerCount['now'],
                                    'yesterday' => $newCustomerCount['yesterday'],
                                ],
                            ],
                        ];
                    @endphp
                    @for ($i = 0; $i < 4; $i++)
                        <div class="col-xxl-3 col-md-6 col-lg-6">
                            <div class="card card-flush mb-5 mb-xl-10">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            @if (isset($data[$i]['prefix']))
                                                <span
                                                    class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">{{ $data[$i]['prefix'] }}</span>
                                            @endif
                                            <span
                                                class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $data[$i]['amount'] }}</span>
                                            @php
                                                $diff = getDiffPercent(
                                                    $data[$i]['data']['now'],
                                                    $data[$i]['data']['yesterday'],
                                                );
                                            @endphp
                                            <span class="badge badge-light-{{ $diff['color'] }} fs-base">
                                                <i
                                                    class="ki-duotone {{ $diff['icon'] }} fs-5 text-{{ $diff['color'] }} ms-n1"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                {{ $diff['percent'] }}%
                                            </span>
                                        </div>
                                        <span
                                            class="text-gray-500 pt-1 fw-semibold fs-6">{{ $data[$i]['label'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                    <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">

                        <div class="card card-flush overflow-hidden h-md-100">
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Thể loại sản phẩm đã bán
                                        {{ $activeFilter['text'] }}</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <div class="card-body">
                                <div id="productSale" style="height: 300px; min-height: 315px;"></div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Col-->
                    <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
                        <!--begin::Chart widget 3-->
                        <div class="card card-flush overflow-hidden h-md-100">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Đơn hàng
                                        {{ $activeFilter['text'] }}</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Chart-->
                                <div id="chartOrder" class="pt-0 w-100 min-h-auto ps-4 pe-6"
                                    style="height: 300px; min-height: 315px;"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <div class="row gy-5 g-xl-10 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-6">

                        <!--begin::List widget 5-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="fw-bold text-gray-900">Sản phẩm yêu thích</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                <th class="text-nowrap ">SẢN PHẨM</th>
                                                <th class="text-nowrap min-w-100px">ĐÁNH GIÁ</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->

                                        <!--begin::Table body-->
                                        <tbody>
                                            @foreach ($topRatedProducts as $item)
                                                <tr>
                                                    <td>
                                                        <div class="me-3 d-flex">
                                                            <img src="{{ $item->getThumbnail() }}"
                                                                class="w-50px ms-n1 me-2" alt="">
                                                            <a href="{{ route('admin.product.edit', $item->id) }}"
                                                                class="text-gray-800 text-hover-primary fw-bold">
                                                                {{ $item->name }}
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex">
                                                            <div class="rating justify-content-end">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <div
                                                                        class="rating-label @if ($i <= $item->reviews_avg_rating) checked @endif">
                                                                        <i class="ki-duotone ki-star fs-6"></i>
                                                                    </div>
                                                                @endfor
                                                            </div>

                                                            <div class="ms-2">{{ $item->reviews_count }} đánh giá</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::List widget 5-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-6">

                        <div class="card h-md-100">
                            <!--begin::Header-->
                            <div class="card-header align-items-center border-0">
                                <!--begin::Title-->
                                <h3 class="fw-bold text-gray-900 m-0">Sản phẩm bán chạy</h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-2">
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="kt_stats_widget_2_tab_1" role="tabpanel">
                                        <!--begin::Table container-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                        <th class="text-nowrap ">SẢN PHẨM</th>
                                                        <th class="text-nowrap text-end min-w-100px">SỐ LƯỢNG MUA</th>
                                                        <th class="text-nowrap pe-0 text-center min-w-100px">THỂ LOẠI
                                                        </th>
                                                        <th class="text-nowrap pe-0 text-end min-w-100px">SỐ LƯỢNG CÒN
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody>
                                                    @foreach ($bestSellingProducts as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="me-3 d-flex">
                                                                    <img src="{{ $item->getThumbnail() }}"
                                                                        class="w-50px ms-n1 me-2" alt="">
                                                                    <a href="{{ route('admin.product.edit', $item->id) }}"
                                                                        class="text-gray-800 text-hover-primary fw-bold">
                                                                        {{ $item->name }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $item->order_details_sum_quantity }}
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $item->kind->name }}
                                                            </td>

                                                            <td class="text-center">
                                                                {{ $item->stock }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table container-->
                                    </div>
                                    <!--end::Tap pane-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>

                <!--begin::Row-->
                <div class="row gy-5 g-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-4">

                        <!--begin::List widget 5-->
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Sản phẩm đã và đang vận
                                        chuyển</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Scroll-->
                                <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 415px">
                                    @foreach ($productDeliverys as $item)
                                        @if ($item->orderDetails?->first())
                                            <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                                                <!--begin::Info-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Wrapper-->
                                                    <div class="me-3">
                                                        <!--begin::Icon-->
                                                        <img src="{{ $item->orderDetails?->first()?->product->getThumbnail() }}"
                                                            class="w-50px ms-n1 me-1" alt="">
                                                        <!--end::Icon-->

                                                        <!--begin::Title-->
                                                        <a href="{{ route('admin.product.edit', $item->orderDetails?->first()?->product->id) }}"
                                                            class="text-gray-800 text-hover-primary fw-bold">
                                                            {{ $item->orderDetails?->first()?->product->name }}
                                                        </a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                                <!--end::Info-->

                                                <!--begin::Customer-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Name-->
                                                    <span class="text-gray-500 fw-bold">Đến:
                                                        <a href="{{ route('admin.order.show', $item->id) }}"
                                                            class="text-gray-800 text-hover-primary fw-bold">
                                                            <div>{{ $item->fullname }} - {{ $item->phone_number }}
                                                            </div>
                                                            <div>{{ $item->address }}</div>
                                                        </a>
                                                    </span>
                                                    <!--end::Name-->

                                                    <!--begin::Label-->
                                                    <span class="badge text-white"
                                                        style="background: {{ $item->getStatusColor() }}">
                                                        {{ $item->getStatusLabel() }}
                                                    </span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Customer-->
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!--end::Scroll-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::List widget 5-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-xl-8">

                        <div class="card h-md-100">
                            <!--begin::Header-->
                            <div class="card-header align-items-center border-0">
                                <!--begin::Title-->
                                <h3 class="fw-bold text-gray-900 m-0">Đơn hàng chờ xác nhận gần đây</h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-2">
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="kt_stats_widget_2_tab_1"
                                        role="tabpanel">
                                        <!--begin::Table container-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                        <th class="w-50px">#</th>
                                                        <th class="text-end min-w-100px">TRẠNG THÁI</th>
                                                        <th class="pe-0 text-end min-w-100px">THANH TOÁN</th>
                                                        <th class="pe-0 text-end min-w-100px">TỔNG TIỀN</th>
                                                        <th class="pe-0 text-end min-w-100px">THỜI GIAN</th>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody>
                                                    @foreach ($recentOrders as $item)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('admin.order.show', $item->id) }}">{{ $item->code }}</a>
                                                            </td>
                                                            <td class="text-end">
                                                                <span class="badge text-white"
                                                                    style="background: {{ $item->getStatusColor() }}">
                                                                    {{ $item->getStatusLabel() }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div
                                                                    class="badge badge-light-{{ $item->isPaid() ? 'success' : 'danger' }}">
                                                                    {{ $item->getPaidLabel() }}
                                                                </div>
                                                            </td>
                                                            <td class="text-end">{{ formatMoney($item->total) }}</td>
                                                            <td class="text-end">{{ $item->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table container-->
                                    </div>
                                    <!--end::Tap pane-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    @push('js')
        <script src="{{ asset('plugins/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <script>
            $(document).on('change', '.filter', function() {
                location.search = `filter=${this.value}`;
            });

            initChartOrder(`{{ route('admin.home.getChartOrder', ['filter' => $type]) }}`);
            initChartProductSale(`{{ route('admin.home.getChartKindSale', ['filter' => $type]) }}`);
        </script>
    @endpush
</x-admin.layout.home>
