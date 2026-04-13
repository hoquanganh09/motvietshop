<x-client.layout.home>
    @include('client.layouts.slider')
    @include('client.layouts.category_banner')

    <!-- Flash Sale section (only shown when active flash sales exist) -->
    @if ($flashSaleProducts->isNotEmpty())
    <section class="container mt-5 pb-4">
        <div class="d-flex align-items-center gap-3 mb-4">
            <span class="badge text-bg-danger fs-sm px-3 py-2 rounded-pill">FLASH SALE</span>
            <h2 class="h4 mb-0">Ưu đãi hôm nay</h2>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
            @foreach ($flashSaleProducts as $product)
                <x-client.product :product="$product" class="col" />
            @endforeach
        </div>
    </section>
    @endif

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
