<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 40%" class="pe-2 text-nowrap">Size chữ</th>
                <th style="width: 40%" class="pe-2 text-nowrap">Size số</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $item)
                <tr>
                    <td class="text-nowrap">
                        {{ $item->name }}
                    </td>
                    <td class="text-nowrap">
                        {{ $item->number }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-size btn btn-default btn-sm" href="{{ route('admin.size.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-size btn btn-default btn-sm" href="{{ route('admin.size.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $sizes->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-size', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadView(url);
            });

            $(document).on('click', '.btn-delete-size', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                showConfirm("Bạn có chắc chắn muốn xóa size?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
