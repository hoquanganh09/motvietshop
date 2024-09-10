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
    @push('js')
        <script>
            $(() => {
                const myOffcanvas = document.getElementById('orderDetails');
                const bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

                $(document).on('click', '.btn-show-order-details', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');

                    ajax(url, 'get', {}, function(res) {
                        myOffcanvas.querySelector('.offcanvas-header').innerHTML = res.data.header;
                        myOffcanvas.querySelector('.offcanvas-body').innerHTML = res.data.body;
                        myOffcanvas.querySelector('.offcanvas-footer').innerHTML = res.data.footer;

                        bsOffcanvas.show();
                    });
                });
            });
        </script>
    @endpush
</x-client.layout.home>
