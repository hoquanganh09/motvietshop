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
@push('js')
    <script>
        $(() => {
            const myOffcanvas = document.getElementById('orderDetails');

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
