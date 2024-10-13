<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 40%" class="pe-2 text-nowrap">Tên</th>
                <th style="width: 30%" class="pe-2 text-nowrap">Thuộc phân loại</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Số sản phẩm</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kinds as $item)
                <tr>
                    <td class="text-nowrap">
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->category->name }}
                    </td>
                    <td>
                        {{ $item->products->count() }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-kind btn btn-default btn-sm" href="{{ route('admin.kind.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-kind btn btn-default btn-sm" href="{{ route('admin.kind.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $kinds->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-kind', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadView(url);
            });

            $(document).on('click', '.btn-delete-kind', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                showConfirm("Bạn có chắc chắn muốn xóa thể loại?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
