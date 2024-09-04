<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead class="bg-light">
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th style="width: 20%" class="pe-2 text-nowrap">Nhân viên</th>
                <th style="width: 20%" class="pe-2 text-nowrap">Email</th>
                <th style="width: 10%" class="pe-2 text-nowrap">Vai trò</th>
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
                    <td class="text-nowrap">{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRole->name }}</td>
                    <td>{{ $user->date_of_birth }}</td>
                    <td class="text-center">
                        <div class="badge badge-light-{{ $status[$user->is_active]['type'] }} fw-bold">
                            {{ $status[$user->is_active]['text'] }}</div>
                    </td>
                    <td class="text-nowrap">{{ $user->created_at }}</td>
                    <td class="text-end text-nowrap">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Hành động
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="/keen/demo1/apps/user-management/users/view.html" class="menu-link px-3">
                                    Sửa
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                    Xóa
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {{ $users->links() }}
</div>
