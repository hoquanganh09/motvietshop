<x-admin.layout.home>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Yêu cầu đổi/trả hàng
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-hover-primary">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">Đổi/trả hàng</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!-- Filter tabs -->
                <ul class="nav nav-tabs mb-5">
                    <li class="nav-item">
                        <a class="nav-link {{ $status === '' ? 'active' : '' }}"
                            href="{{ route('admin.returnRequest.index') }}">Tất cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                            href="{{ route('admin.returnRequest.index', ['status' => 'pending']) }}">
                            Chờ xử lý
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                            href="{{ route('admin.returnRequest.index', ['status' => 'approved']) }}">
                            Đã chấp nhận
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                            href="{{ route('admin.returnRequest.index', ['status' => 'rejected']) }}">
                            Đã từ chối
                        </a>
                    </li>
                </ul>

                <div class="card">
                    <div class="card-body py-4">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead class="bg-light">
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="pe-2">#</th>
                                        <th class="pe-2">Đơn hàng</th>
                                        <th class="pe-2">Khách hàng</th>
                                        <th class="pe-2">Lý do</th>
                                        <th class="pe-2 text-center">Trạng thái</th>
                                        <th class="pe-2">Ngày gửi</th>
                                        <th class="pe-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($returns as $item)
                                        <tr>
                                            <td class="fw-medium">{{ $item->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.order.show', $item->order_id) }}" class="fw-medium text-primary">
                                                    {{ $item->order->code }}
                                                </a>
                                            </td>
                                            <td>{{ $item->user->fullname }}</td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 220px" title="{{ $item->reason }}">
                                                    {{ $item->reason }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-light-{{ $item->getStatusColor() }}">
                                                    {{ $item->getStatusLabel() }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                @if ($item->isPending())
                                                    <button type="button"
                                                        class="btn btn-sm btn-light-primary btn-process-return"
                                                        data-id="{{ $item->id }}"
                                                        data-url="{{ route('admin.returnRequest.update', $item->id) }}"
                                                        data-reason="{{ $item->reason }}">
                                                        Xử lý
                                                    </button>
                                                @else
                                                    <span class="text-muted fs-7">{{ $item->admin_note ?: '—' }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-8">Không có yêu cầu nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            {{ $returns->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Process return modal -->
    <div class="modal fade" id="processReturnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="processReturnForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Xử lý yêu cầu đổi/trả</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Lý do của khách</label>
                            <p id="returnReasonText" class="text-body-secondary border rounded p-3 mb-0 fs-sm"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Ghi chú (tuỳ chọn)</label>
                            <textarea name="admin_note" class="form-control" rows="3"
                                placeholder="Ghi chú phản hồi cho khách..."></textarea>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-medium">Quyết định</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="approved"
                                        id="statusApproved" required>
                                    <label class="form-check-label text-success fw-medium" for="statusApproved">
                                        Chấp nhận (hoàn kho)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="rejected"
                                        id="statusRejected">
                                    <label class="form-check-label text-danger fw-medium" for="statusRejected">
                                        Từ chối
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(() => {
                $(document).on('click', '.btn-process-return', function () {
                    const url = $(this).data('url');
                    const reason = $(this).data('reason');
                    $('#processReturnForm').attr('action', url);
                    $('#returnReasonText').text(reason);
                    $('input[name=status]').prop('checked', false);
                    $('textarea[name=admin_note]').val('');
                    new bootstrap.Modal('#processReturnModal').show();
                });
            });
        </script>
    @endpush
</x-admin.layout.home>
