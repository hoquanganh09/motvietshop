<x-client.layout.home>
    @include('client.layouts.slider')
    @include('client.layouts.category_banner')

    <!-- Featured products -->
    <section id="featured" class="container mt-5 pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <h2 class="text-center pb-2 pb-sm-3">Sản phẩm</h2>

        @include('client.home.common.product_grid')
    </section>

    {{-- @include('client.layouts.special_collection') --}}
    @include('client.layouts.brands')
    @include('client.layouts.happy_customer')
    {{-- @include('client.layouts.instagram_feed') --}}

    @push('js')
        <script>
            $(() => {
                let page = 1;
                $(document).on('click', '.view-more-product', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href') + `?page=${++page}`;
                    const grid = $('.product-grid');
                    appendView(url, grid);
                });
            });
        </script>
    @endpush
</x-client.layout.home>
