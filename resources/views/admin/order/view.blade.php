<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Thông tin đơn hàng
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-hover-primary">
                                Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.order.index') }}" class="text-muted text-hover-primary">
                                Đơn hàng
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">
                            Thông tin đơn hàng
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-xxl ">
                <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Thông tin đơn hàng
                                    <span class="badge badge-light-{{ $order->isPaid() ? 'success' : 'danger' }}">
                                        {{ $order->getPaidLabel() }}
                                    </span>
                                </h2>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base"
                                    data-select2-id="select2-data-161-pji5">
                                    <!--begin::Filter-->

                                    <!--begin::Export-->
                                    <a target="_blank" href="{{ route('admin.order.export', $order->id) }}" class="btn btn-light-primary me-3">
                                        <i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        In hóa đơn
                                        </a>
                                    <!--end::Export-->
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-calendar fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    Ngày tạo
                                                </div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $order->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-wallet fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span></i>
                                                    Phương thức thanh toán
                                                </div>
                                            </td>
                                            <td class="fw-bold text-end">
                                                {{ $order->getPaymentMethodLabel() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-wallet fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span></i>
                                                    Trạng thái
                                                </div>
                                            </td>
                                            <td class="fw-bold text-end">
                                                <span class="badge text-white"
                                                    style="background: {{ $order->getStatusColor() }}">
                                                    {{ $order->getStatusLabel() }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order details-->

                    <!--begin::Customer details-->
                    <div class="card card-flush py-4  flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Thông tin khách hàng</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-profile-circle fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i> Khách hàng
                                                </div>
                                            </td>

                                            <td class="fw-bold text-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <!--begin:: Avatar -->
                                                    <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                        <a href="javascript:void(0)">
                                                            <div class="symbol-label">
                                                                <img src="{{ getUserAvatar() }}" alt="Dan Wilson"
                                                                    class="w-100">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <!--end::Avatar-->

                                                    <!--begin::Name-->
                                                    <a href="javascript:void(0)"
                                                        class="text-gray-600 text-hover-primary">
                                                        {{ $order->user->fullname }}
                                                    </a>
                                                    <!--end::Name-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-sms fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span></i> Địa
                                                    chỉ email
                                                </div>
                                            </td>
                                            <td class="fw-bold text-end">
                                                <a href="javascript:void(0)" class="text-gray-600 text-hover-primary">
                                                    {{ $order->user->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-duotone ki-phone fs-2 me-2"><span
                                                            class="path1"></span><span class="path2"></span></i> Số
                                                    điện thoại
                                                </div>
                                            </td>
                                            <td class="fw-bold text-end">{{ $order->user->phone_number }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Customer details-->
                </div>

                <div class="d-flex flex-column gap-7 gap-lg-10 pt-10">
                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                        <!--begin::Shipping address-->
                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                            <!--begin::Background-->
                            <div
                                class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                <i class="ki-duotone ki-delivery" style="font-size: 13em">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </div>
                            <!--end::Background-->

                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Địa chỉ nhận hàng</h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0 fs-6">
                                <div>
                                    Họ và tên: {{ $order->fullname }}
                                </div>
                                <div>
                                    Số điện thoại: {{ $order->phone_number }}
                                </div>
                                <div>
                                    Địa chỉ: {{ $order->address }}
                                </div>
                                <div>
                                    Ghi chú: {{ $order->note }}
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Shipping address-->
                    </div>

                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Đơn hàng #{{ $order->code }}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Sản phẩm</th>
                                            <th class="min-w-100px text-end">Thể loại</th>
                                            <th class="min-w-70px text-end">Số lượng</th>
                                            <th class="min-w-100px text-end">Giá tiền</th>
                                            <th class="min-w-100px text-end">Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($order->orderDetails as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Thumbnail-->
                                                        <a href="{{ route('admin.product.edit', $item->product->id) }}"
                                                            class="symbol symbol-50px">
                                                            <span class="symbol-label"
                                                                style="background-image:url({{ $item->product->getThumbnail() }});"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->

                                                        <!--begin::Title-->
                                                        <div class="ms-5">
                                                            <a href="{{ route('admin.product.edit', $item->product->id) }}"
                                                                class="fw-bold text-gray-600 text-hover-primary">{{ $item->product->name }}</a>
                                                            <div class="fs-7 text-muted">Size: {{ $item->size->name }}
                                                            </div>
                                                            <div class="fs-7 text-muted">Màu sắc:
                                                                {{ $item->color->label }}
                                                            </div>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    {{ $item->product->kind->name }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="text-end">
                                                    {{ formatMoney($item->price) }}
                                                </td>
                                                <td class="text-end">
                                                    {{ formatMoney($item->price * $item->quantity) }}
                                                </td>
                                            </tr>
                                            @php
                                                $total += $item->price * $item->quantity;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Tổng tiền
                                            </td>
                                            <td class="text-end">
                                                {{ formatMoney($total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Vận chuyển
                                            </td>
                                            <td class="text-end">
                                                {{ formatMoney(0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Mã giảm giá
                                            </td>
                                            <td class="text-end">
                                                -{{ formatMoney($order->discount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fs-3 text-gray-900 text-end fw-bold">
                                                Tổng tiền cuối cùng
                                            </td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end">
                                                {{ formatMoney($order->total) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <div class="">
                                <form action="{{ route('admin.order.update', $order->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    @if (!$order->isCancel())
                                        <button type="submit" name="status" value="1"
                                            class="btn btn-danger">Hủy</button>
                                    @endif
                                    @if ($order->canProcessing())
                                        <button type="submit" name="status" value="3"
                                            class="btn btn-info">Xác nhận đơn hàng</button>
                                    @endif
                                    @if ($order->canShipping())
                                        <button type="submit" name="status" value="4"
                                            class="btn btn-warning">Vận chuyển</button>
                                    @endif
                                    @if ($order->canShipped())
                                        <button type="submit" name="status" value="5"
                                            class="btn btn-success">Vận chuyển thành công</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Product List-->
                </div>
            </div>
        </div>
    </div>
</x-admin.layout.home>
