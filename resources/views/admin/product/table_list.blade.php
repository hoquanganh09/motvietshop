<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 30%" class="pe-2 text-nowrap">Sản phẩm</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Thể loại</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Giá cũ</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Giá mới</th>
                <th style="width: 5%" class="pe-2 text-nowrap text-center">Số lượng</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Trạng thái</th>
                <th style="width: 10%" class="pe-2 text-nowrap text-center">Đánh giá</th>
                <th style="width: 5%" class="pe-2 text-nowrap">Cập nhật</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center flex-wrap">
                            <img width="80" src="{{ $item->getThumbnail() }}" class="img-fluid me-3">
                            <div>{{ $item->name }}</div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>{{ $item->kind->category->name }}</div>
                        <div>{{ $item->kind->name }}</div>
                    </td>
                    <td class="text-nowrap text-center">
                        {{ formatMoney($item->old_price ?? 0) }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ formatMoney($item->price) }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ $item->stock }}
                    </td>
                    <td class="text-nowrap text-center">
                        {{ $item->getStatusLabel() }}
                    </td>
                    <td class="text-nowrap text-center">
                        <div class="rating justify-content-end">
                            @php
                                $avg = $item->reviews->avg('rating');
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="rating-label @if ($i <= $avg) checked @endif">
                                    <i class="ki-duotone ki-star fs-6"></i>
                                </div>
                            @endfor
                        </div>
                    </td>
                    <td class="text-nowraps text-center">{{ $item->updated_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-product btn btn-default btn-sm"
                            href="{{ route('admin.product.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-product btn btn-default btn-sm"
                            href="{{ route('admin.product.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $products->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-delete-product', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                showConfirm("Bạn có chắc chắn muốn xóa sản phẩm?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
