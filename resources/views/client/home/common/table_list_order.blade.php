<div class="ps-lg-3 ps-xl-0">

    <!-- Page title + Sorting selects -->
    <div class="row align-items-center pb-3 pb-md-4 mb-md-1 mb-lg-2">
        <div class="col-md-4 col-xl-6 mb-3 mb-md-0">
            <h1 class="h2 me-3 mb-0">Lịch sử đơn hàng</h1>
        </div>
    </div>


    <!-- Sortable orders table -->
    <div>
        <table class="table align-middle fs-sm text-nowrap">
            <thead>
                <tr>
                    <th scope="col" class="py-3 ps-0">
                        <span class="text-body fw-normal">Đơn hàng <span class="d-none d-md-inline">#</span></span>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                        <button type="button" class="btn fw-normal text-body p-0">Ngày
                            đặt</button>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                        <span class="text-body fw-normal">Trạng thái</span>
                    </th>
                    <th scope="col" class="py-3 d-none d-md-table-cell">
                        <button type="button" class="btn fw-normal text-body p-0">Tổng tiền</button>
                    </th>
                    <th scope="col" class="py-3">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="text-body-emphasis orders-list">
                @foreach ($orders as $item)
                    <tr>
                        <td class="fw-medium pt-2 pb-3 py-md-2 ps-0">
                            <a href="{{ route('client.order.show', $item->id) }}"
                                class="btn-show-order-details d-inline-block animate-underline text-body-emphasis text-decoration-none py-2">
                                <span class="animate-target">{{ $item->code }}</span>
                            </a>
                            <span
                                class="badge {{ $item->isPaid() ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->getPaidLabel() }}</span>
                            <ul class="list-unstyled fw-normal text-body m-0 d-md-none">
                                <li class="d-flex align-items-center">
                                    <span style="background: {{ $item->getStatusColor() }}"
                                        class="rounded-circle p-1 me-2"></span>
                                    {{ $item->getStatusLabel() }}
                                </li>
                                <li>{{ $item->created_at }}</li>
                                <li class="fw-medium text-body-emphasis">{{ formatMoney($item->total) }}
                                </li>
                            </ul>
                        </td>
                        <td class="fw-medium py-3 d-none d-md-table-cell">
                            {{ $item->created_at }}
                            <span class="date d-none">{{ $item->created_at }}</span>
                        </td>
                        <td class="fw-medium py-3 d-none d-md-table-cell">
                            <span class="d-flex align-items-center">
                                <span style="background: {{ $item->getStatusColor() }}"
                                    class="rounded-circle p-1 me-2"></span>
                                {{ $item->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="fw-medium py-3 d-none d-md-table-cell">
                            {{ formatMoney($item->total) }}
                            <span class="total d-none">{{ formatMoney($item->total) }}</span>
                        </td>
                        <td class="py-3 pe-0">
                            <span
                                class="d-flex align-items-center justify-content-end position-relative gap-1 gap-sm-2 ms-n2 ms-sm-0">
                                @for ($i = 0; $i < $item->orderDetails->count() && $i < 3; $i++)
                                    <span>
                                        <img src="{{ $item->orderDetails[$i]->product->getThumbnail() }}"
                                            width="64" alt="Thumbnail">
                                    </span>
                                @endfor
                                @if ($item->orderDetails->count() > 3)
                                    <span class="fw-medium me-1">+{{ $item->orderDetails->count() - 3 }}</span>
                                @endif
                                <a href="{{ route('client.order.show', $item->id) }}"
                                    class="btn-show-order-details btn btn-icon btn-ghost btn-secondary stretched-link border-0">
                                    <i class="ci-chevron-right fs-lg"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Pagination -->
    {{ $orders->links() }}
</div>
