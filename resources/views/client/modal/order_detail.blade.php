<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="orderDetails" tabindex="-1" aria-labelledby="orderDetailsLabel"
    style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header align-items-start py-3 pt-lg-4">
    </div>

    <!-- Body -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2 pb-3">
    </div>

    <!-- Footer -->
    <div class="offcanvas-header offcanvas-footer">
    </div>
</div>

<!-- Return request modal -->
<div class="modal fade" id="returnRequestModal" tabindex="-1" aria-labelledby="returnRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnRequestModalLabel">Yêu cầu đổi/trả hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-body-secondary fs-sm mb-3">
                    Mô tả lý do bạn muốn đổi hoặc trả hàng. Chúng tôi sẽ liên hệ lại trong vòng 1-3 ngày làm việc.
                </p>
                <div class="mb-3">
                    <label class="form-label fw-medium">Lý do <span class="text-danger">*</span></label>
                    <textarea id="returnReasonInput" class="form-control" rows="4"
                        placeholder="Ví dụ: Sản phẩm bị lỗi, sai size, không đúng màu..."></textarea>
                    <div class="invalid-feedback" id="returnReasonError"></div>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="btnSubmitReturn" class="btn btn-warning">
                    Gửi yêu cầu
                </button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(() => {
            const myOffcanvas = document.getElementById('orderDetails');
            let returnUrl = null;

            $(document).on('click', '.btn-show-return-form', function () {
                returnUrl = $(this).data('url');
                $('#returnReasonInput').val('').removeClass('is-invalid');
                $('#returnReasonError').text('');
                new bootstrap.Modal('#returnRequestModal').show();
            });

            $('#btnSubmitReturn').on('click', function () {
                const reason = $('#returnReasonInput').val().trim();
                if (!reason) {
                    $('#returnReasonInput').addClass('is-invalid');
                    $('#returnReasonError').text('Vui lòng nhập lý do đổi/trả');
                    return;
                }
                $('#returnReasonInput').removeClass('is-invalid');

                const $btn = $(this).prop('disabled', true).text('Đang gửi...');
                ajax(returnUrl, 'post', { reason }, function (res) {
                    bootstrap.Modal.getInstance('#returnRequestModal').hide();
                    toast(res.data.message);
                }, function () {
                    $btn.prop('disabled', false).text('Gửi yêu cầu');
                });
            });

            $(document).on('click', '.btn-cancel-order', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                showConfirm('Bạn có chắc muốn hủy đơn hàng không?', function() {
                    ajax(url, 'put', {}, function(res) {
                        toast(res.data.message);
                        myOffcanvas.querySelector('.offcanvas-header').innerHTML = res.data
                            .header;
                        myOffcanvas.querySelector('.offcanvas-footer').innerHTML = res.data
                            .footer;

                        loadView(location.href, $('#load-order'));
                    });
                });
            });

            $(document).on('click', '.btn-shipped-order', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                ajax(url, 'put', {}, function(res) {
                    toast(res.data.message);
                    myOffcanvas.querySelector('.offcanvas-header').innerHTML = res.data.header;
                    myOffcanvas.querySelector('.offcanvas-footer').innerHTML = res.data.footer;

                    loadView(location.href, $('#load-order'));
                });
            });
        });
    </script>
@endpush
