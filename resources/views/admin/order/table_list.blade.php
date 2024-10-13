<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 20%" class="pe-2 text-nowrap">#</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Trạng thái</th>
                <th style="width: 15%" class="pe-2 text-nowrap text-center">Tổng tiền</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Số sản phẩm</th>
                <th style="width: 15%" class="pe-2 text-nowrap text-center">Người đặt</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Hình thức thanh toán</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày đặt</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
                <tr>
                    <td class="text-centers">
                        <div>
                            <a href="{{ route('admin.order.show', $item->id) }}">{{ $item->code }}</a>
                        </div>
                        <div class="badge badge-light-{{ $item->isPaid() ? 'success' : 'danger' }}">
                            {{ $item->getPaidLabel() }}
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge text-white" style="background: {{ $item->getStatusColor() }}">
                            {{ $item->getStatusLabel() }}
                        </span>
                    </td>
                    <td class="text-nowrap text-center">
                        {{ formatMoney($item->total ?? 0) }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ $item->orderDetails->count() }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ $item->user->fullname }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ $item->getPaymentMethodLabel() }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-order-product btn btn-default btn-sm"
                            href="{{ route('admin.order.show', $item->id) }}">
                            <i class="bi bi-eye text-info"></i>
                            <span class="text-info">Xem</span>
                        </a>
                        @can('delete-order', auth('admin')->user())
                            <a class="btn-destroy-order btn btn-default btn-sm"
                                href="{{ route('admin.order.destroy', $item->id) }}">
                                <i class="bi bi-trash text-danger"></i>
                                <span class="text-danger">Xóa</span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $orders->links() }}
</div>
@push('js')
    <script>
        $(document).on('click', '.btn-destroy-order', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            showConfirm("Bạn có chắc chắn muốn xóa order này?", function() {
                ajax(url, 'delete', {}, function(res) {
                    toast(res.data.message);
                    dispatchReloadEvent();
                });
            });
        });
    </script>
@endpush
