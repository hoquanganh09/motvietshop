<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 15%" class="pe-2 text-nowrap">Ảnh</th>
                <th style="width: 45%" class="pe-2 text-nowrap">Tên</th>
                <th style="width: 20%" class="pe-2 text-nowrap">Số thể loại</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>
                        <img width="100" src="{{ $item->getImage() }}" alt="photo" class="img-fluid">
                    </td>
                    <td class="text-nowraps">
                        {{ $item->name }}
                    </td>
                    <td>
                        {{ $item->kinds->count() }}
                    </td>
                    <td class="text-nowrap">{{ $item->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <div class="dropdown">
                            <button class="btn-sm btn btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton_{{ $item->id }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Hành động
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $item->id }}">
                                <li><a data-id="{{ $item->id }}" class="btn-edit-category dropdown-item"
                                        href="#">Sửa</a>
                                </li>
                                <li><a data-id="{{ $item->id }}" class="btn-delete-category dropdown-item"
                                        href="#">Xóa</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $categories->links() }}
</div>
@push('js')
    <script>
        $(() => {
            $(document).on('click', '.btn-edit-category', function() {
                let url = `{{ route('admin.category.edit', ':id') }}`;
                url = url.replace(':id', this.dataset.id);
                loadView(url);
            });

            $(document).on('click', '.btn-delete-category', function() {
                let url = `{{ route('admin.category.destroy', ':id') }}`;
                url = url.replace(':id', this.dataset.id);
                showConfirm("Bạn có chắc chắn muốn xóa phân loại?", function() {
                    ajax(url, 'delete', {}, function (res) {
                        dispatchReloadEvent();
                        toast(res.data.message);
                    });
                });
            });
        });
    </script>
@endpush
