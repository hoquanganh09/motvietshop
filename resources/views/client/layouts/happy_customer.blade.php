<section class="bg-body-tertiary py-5">
    <div class="container py-1 py-sm-2 py-md-3 py-lg-4 py-xl-5">
        <h2 class="text-center pb-2 pb-md-3 pb-lg-4 pt-xxl-3">Đánh giá của khách hàng</h2>
        <div class="position-relative pb-xxl-3">

            <!-- External slider prev/next buttons visible on screens > 500px wide (sm breakpoint) -->
            <button type="button"
                class="btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle d-none d-sm-inline-flex mt-n4"
                id="reviewsPrev" aria-label="Prev">
                <i class="ci-chevron-left fs-lg animate-target"></i>
            </button>
            <button type="button"
                class="btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 start-100 z-2 translate-middle d-none d-sm-inline-flex mt-n4"
                id="reviewsNext" aria-label="Next">
                <i class="ci-chevron-right fs-lg animate-target"></i>
            </button>

            <!-- Slider -->
            <div class="swiper"
                data-swiper="{
        &quot;slidesPerView&quot;: 1,
        &quot;spaceBetween&quot;: 24,
        &quot;loop&quot;: true,
        &quot;navigation&quot;: {
          &quot;prevEl&quot;: &quot;#reviewsPrev&quot;,
          &quot;nextEl&quot;: &quot;#reviewsNext&quot;
        },
        &quot;pagination&quot;: {
          &quot;el&quot;: &quot;.swiper-pagination&quot;,
          &quot;clickable&quot;: true
        },
        &quot;breakpoints&quot;: {
          &quot;600&quot;: {
            &quot;slidesPerView&quot;: 2
          },
          &quot;992&quot;: {
            &quot;slidesPerView&quot;: 3
          }
        }
      }">
                <div class="swiper-wrapper">

                    @foreach ($reviews as $item)
                    <div class="swiper-slide h-auto">
                        <div class="card h-100 border-0 rounded-4 p-sm-2">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="ratio ratio-1x1 flex-shrink-0" style="max-width: 80px">
                                        <img src="{{ $item->product->getThumbnail() }}" width="80"
                                            alt="Image">
                                    </div>
                                    <div class="ps-2 ms-1">
                                        <div class="d-flex gap-1 fs-xs pb-2 mb-1">
                                            <i class="ci-star-filled text-warning"></i>
                                            <i class="ci-star-filled text-warning"></i>
                                            <i class="ci-star-filled text-warning"></i>
                                            <i class="ci-star-filled text-warning"></i>
                                            <i class="ci-star-filled text-warning"></i>
                                        </div>
                                        <h3 class="h6 mb-0">{{ $item->user->fullname }}</h3>
                                    </div>
                                </div>
                                <p class="mb-0">{{ $item->note }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination (Bullets) -->
                <div class="swiper-pagination position-static pt-3 mt-sm-1 mt-md-2 mt-lg-3"></div>
            </div>
        </div>
    </div>
</section>