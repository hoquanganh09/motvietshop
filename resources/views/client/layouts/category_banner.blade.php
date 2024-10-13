<section class="container pt-4">
    <div class="swiper"
        data-swiper="{
      &quot;slidesPerView&quot;: 1,
      &quot;spaceBetween&quot;: 24,
      &quot;pagination&quot;: {
        &quot;el&quot;: &quot;.swiper-pagination&quot;,
        &quot;clickable&quot;: true
      },
      &quot;breakpoints&quot;: {
        &quot;680&quot;: {
          &quot;slidesPerView&quot;: 2
        },
        &quot;992&quot;: {
          &quot;slidesPerView&quot;: 3
        }
      }
    }">
        <div class="swiper-wrapper">
            @foreach ($categories as $item)
                <div class="swiper-slide">
                    <div class="hover-effect-opacity position-relative">
                        <div class="d-flex justify-content-between position-relative z-2 ps-2 ps-xl-3">
                            <div class="d-flex flex-column min-w-0 p-3">
                                <h2 class="h5 text-nowrap pt-2 pt-xl-3">{{ $item->name }}</h2>
                                <ul class="nav flex-column gap-2 mt-n1">
                                    @for ($index = 0; $index < $item->kinds->count() && $index < 4; $index++)
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                href="{{ route('client.home.shop', ['category' => $item->id, 'kind' => $item->kinds[$index]->id]) }}">
                                                {{ $item->kinds[$index]->name }}
                                            </a>
                                        </li>
                                    @endfor
                                    @if ($item->kinds->count() > 4)
                                        <li class="d-flex w-100 pt-1">
                                            <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0"
                                                href="{{ route('client.home.shop', ['category' => $item->id ]) }}">
                                                + {{ ($item->kinds->count() - 4) }} thể loại nữa
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="nav hover-effect-target opacity-0 pb-2 pb-xl-3 mt-auto">
                                    <a class="nav-link animate-underline text-body-emphasis text-nowrap p-0"
                                        href="{{ route('client.home.shop', ['category' => $item->id ]) }}">
                                        <span class="animate-target">Xem ngay</span>
                                        <i class="ci-arrow-up-right fs-base ms-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ratio w-100 align-self-end"
                                style="max-width: 220px; --cz-aspect-ratio: calc(305 / 220 * 100%)">
                                <img src="{{ $item->getImage() }}" alt="Image">
                            </div>
                        </div>
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark"
                            style="background: linear-gradient(124deg, #e2daec -29.7%, #e4eefd 65.5%)"></span>
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark"
                            style="background: linear-gradient(124deg, #37343b -29.7%, #222a36 65.5%)"></span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination (Bullets) -->
        <div class="swiper-pagination position-static mt-3 mt-sm-4"></div>
    </div>
</section>
