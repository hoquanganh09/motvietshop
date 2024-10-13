<x-client.layout.home>
    <div class="container py-5">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('client.home.common.user_sidebar')


            <div class="col-lg-9" id="load-order">
                @include('client.home.common.table_list_order')
            </div>
        </div>
    </div>
    @include('client.modal.order_detail')
    @include('client.modal.product_review')
    @push('js')
        <script>
            $(() => {
                const myOffcanvas = document.getElementById('orderDetails');
                const bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

                const reviewOffcanvas = document.getElementById('reviewOrder');
                const bsReviewOffcanvas = new bootstrap.Offcanvas(reviewOffcanvas);

                $(document).on('click', '.btn-show-order-details', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');

                    ajaxWithLoading(url, 'get', {}, function(res) {
                        myOffcanvas.querySelector('.offcanvas-header').innerHTML = res.data.header;
                        myOffcanvas.querySelector('.offcanvas-body').innerHTML = res.data.body;
                        myOffcanvas.querySelector('.offcanvas-footer').innerHTML = res.data.footer;

                        bsOffcanvas.show();
                    });
                });

                $(document).on('click', '.btn-review', function() {
                    const form = $('#review-form');
                    const data = new FormData(form[0]);

                    ajax(form.attr('action'), 'post', data, function(res) {
                        toast(res.data.message);
                        bsReviewOffcanvas.hide();
                    });
                });

                $(document).on('click', '.btn-show-review', function(e) {
                    e.preventDefault();

                    const url = $(this).attr('href');

                    ajaxWithLoading(url, 'get', {}, function(res) {
                        bsOffcanvas.hide();
                        bsReviewOffcanvas.show();

                        $('#reviewOrder .offcanvas-body').html(res.data);
                    });
                });
            });
        </script>
    @endpush
</x-client.layout.home>
