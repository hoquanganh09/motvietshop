<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 40%" class="pe-2 text-nowrap">Tên</th>
                <th style="width: 40%" class="pe-2 text-nowrap">Nhãn</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colors as $item)
                <tr>
                    <td class="text-nowrap">
                        <span class="color-preview" style="background: {{ $item->name }}"></span>
                        {{ $item->name }}
                    </td>
                    <td class="text-nowrap">
                        {{ $item->label }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-color btn btn-default btn-sm" href="{{ route('admin.color.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-color btn btn-default btn-sm" href="{{ route('admin.color.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $colors->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-color', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadView(url);
            });

            $(document).on('click', '.btn-delete-color', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                showConfirm("Bạn có chắc chắn muốn xóa màu sắc?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
