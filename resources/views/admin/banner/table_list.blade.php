<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 15%" class="pe-2 text-nowrap">Ảnh</th>
                <th style="width: 20%" class="pe-2 text-nowrap">Tiêu đề</th>
                <th style="width: 45%" class="pe-2 text-nowrap">Nội dung</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $item)
                <tr>
                    <td>
                        <img width="100" src="{{ $item->getImage() }}" alt="photo" class="img-fluid">
                    </td>
                    <td class="text-nowraps">
                        {{ $item->title }}
                    </td>
                    <td class="text-nowraps">
                        {{ $item->content }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn-edit-banner btn btn-default btn-sm"
                            href="{{ route('admin.banner.edit', $item->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-banner btn btn-default btn-sm"
                            href="{{ route('admin.banner.destroy', $item->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $banners->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-banner', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadView(url);
            });

            $(document).on('click', '.btn-delete-banner', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                showConfirm("Bạn có chắc chắn muốn xóa banner?", function() {
                    ajax(url, 'delete', {}, function(res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
