<section class="bg-body-tertiary">
    <div class="container">
        <div class="row">

            <!-- Titles master slider -->
            <div class="col-md-6 col-lg-5 d-flex flex-column">
                <div class="py-4 mt-auto">
                    <div class="swiper pb-1 pt-3 pt-sm-4 py-md-4 py-lg-3"
                        data-swiper="{
            &quot;spaceBetween&quot;: 24,
            &quot;loop&quot;: true,
            &quot;speed&quot;: 400,
            &quot;controlSlider&quot;: &quot;#heroImages&quot;,
            &quot;pagination&quot;: {
              &quot;el&quot;: &quot;#sliderBullets&quot;,
              &quot;clickable&quot;: true
            },
            &quot;autoplay&quot;: {
              &quot;delay&quot;: 5500,
              &quot;disableOnInteraction&quot;: false
            }
          }">
                        <div class="swiper-wrapper align-items-center">
                            @foreach ($banners as $item)
                                <div class="swiper-slide text-center text-md-start">
                                    <p class="fs-xl mb-2 mb-lg-3 mb-xl-4">{{ $item->title }}</p>
                                    <h2 class="display-4 text-uppercase mb-4 mb-xl-5">
                                        {{ $item->content }}
                                    </h2>
                                    <a class="btn btn-lg btn-outline-dark" href="{{ route('client.home.shop') }}">
                                        Xem ngay
                                        <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Slider bullets (pagination) -->
                <div
                    class="d-flex justify-content-center justify-content-md-start pb-4 pb-xl-5 mt-n1 mt-md-auto mb-md-3 mb-lg-4">
                    <div class="swiper-pagination position-static w-auto pb-1" id="sliderBullets"></div>
                </div>
            </div>

            <!-- Linked images (controlled slider) -->
            <div class="col-md-6 col-lg-7 align-self-end">
                <div class="position-relative ms-md-n4">
                    <div class="ratio" style="--cz-aspect-ratio: calc(662 / 770 * 100%)"></div>
                    <div class="swiper position-absolute top-0 start-0 w-100 h-100 user-select-none" id="heroImages"
                        data-swiper="{
            &quot;allowTouchMove&quot;: false,
            &quot;loop&quot;: true,
            &quot;effect&quot;: &quot;fade&quot;,
            &quot;fadeEffect&quot;: {
              &quot;crossFade&quot;: true
            }
          }">
                        <div class="swiper-wrapper">
                            @foreach ($banners as $item)
                            <div class="swiper-slide">
                                <img src="{{ $item->getImage() }}" class="rtl-flip"
                                    alt="Image">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
