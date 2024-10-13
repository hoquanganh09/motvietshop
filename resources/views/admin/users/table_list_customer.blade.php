<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 20%" class="pe-2 text-nowrap">Nhân viên</th>
                <th style="width: 20%" class="pe-2 text-nowrap">Email</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Sinh nhật</th>
                <th style="width: 20%" class="pe-2 text-nowrap text-center">Trạng thái</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Ngày tạo</th>
                <th style="width: 10%" class="pe-2 text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $status = [
                    0 => [
                        'text' => 'Không hoạt động',
                        'type' => 'danger',
                    ],
                    1 => [
                        'text' => 'Hoạt động',
                        'type' => 'success',
                    ],
                ];
            @endphp
            @foreach ($users as $user)
                <tr>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.home.profile', $user->id) }}">{{ $user->fullname }}</a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->date_of_birth }}</td>
                    <td class="text-center">
                        <div class="badge badge-light-{{ $status[$user->is_active]['type'] }} fw-bold">
                            {{ $status[$user->is_active]['text'] }}</div>
                    </td>
                    <td class="text-nowrap">{{ $user->created_at }}</td>
                    <td class="text-end text-nowrap">
                        @if ($user->isActive())
                            <a class="btn-change-status-user btn btn-default btn-sm" href="javascript:void(0)">
                                <i class="bi bi-stop-circle text-danger"></i>
                            </a>
                            <form class="d-none" action="{{ route('admin.user.updateActive', $user->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="status" value="0">
                            </form>
                        @else
                            <a class="btn-change-status-user btn btn-default btn-sm" href="javascript:void(0)">
                                <i class="bi bi-play-circle text-success"></i>
                            </a>
                            <form class="d-none" action="{{ route('admin.user.updateActive', $user->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="status" value="1">
                            </form>
                        @endif
                        <a class="btn btn-default btn-sm"
                            href="{{ route('admin.home.profile', $user->id) }}">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </a>
                        <a class="btn-delete-user btn btn-default btn-sm"
                            href="{{ route('admin.user.destroy', $user->id) }}">
                            <i class="bi bi-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $users->links() }}
</div>
@push('js')
    <script>
        $(document).on('click', '.btn-change-status-user', function(e) {
            e.preventDefault();

            const form = $(this).parent().find('form');
            showConfirm("Bạn có chắc chắn muốn đổi trạng thái ?", function () {
                const formData = new FormData(form[0]);

                ajax(form.attr('action'), 'post', formData, function (res) {
                    toast(res.data.message);
                    dispatchReloadEvent();
                });
            });
        });

        $(document).on('click', '.btn-delete-user', function(e) {
            e.preventDefault();

            const url = $(this).attr('href');
            console.log(url);
            
            showConfirm("Bạn có chắc chắn muốn xóa tài khoản ?", function () {
                ajax(url, 'delete', {}, function (res) {
                    toast(res.data.message);
                    dispatchReloadEvent();
                });
            });
        });
    </script>
@endpush
