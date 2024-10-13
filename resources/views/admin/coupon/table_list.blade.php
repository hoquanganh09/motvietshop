<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 15%" class="pe-2 text-nowrap">Code</th>
                <th style="width: 15%" class="pe-2 text-nowrap">Giảm(%)</th>
                <th style="width: 15%" class="pe-2 text-nowrap">Giảm tối đa</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Số lượng</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Hạn sử dụng</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ formatMoney($item->max_price) }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>
                        {{ $item->expiration_date }}
                        @if (!$item->isExpired())
                            <span class="badge badge-success">Còn hạn</span>
                        @else
                            <span class="badge badge-danger">Hết hạn</span>
                        @endif
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-coupon btn btn-default btn-sm"
                            href="{{ route('admin.coupon.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-coupon btn btn-default btn-sm"
                            href="{{ route('admin.coupon.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $coupons->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-coupon', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadView(url);
            });

            $(document).on('click', '.btn-delete-coupon', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                showConfirm("Bạn có chắc chắn muốn xóa mã giảm giá?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
