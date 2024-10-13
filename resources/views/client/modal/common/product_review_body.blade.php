<form id="review-form" action="{{ route('client.review.store', $order->id) }}" method="post">
    @csrf
    @php
        $ids = [];
    @endphp
    @foreach ($order->orderDetails as $item)
        @if (!in_array($item->product_id, $ids))
            @php
                $ids[] = $item->product_id;
            @endphp
            <hr>
            <div>
                <input type="hidden" name="arr[{{ $item->product_id }}][product_id]" value="{{ $item->product_id }}">
                <input type="hidden" name="arr[{{ $item->product_id }}][order_id]" value="{{ $item->order_id }}">

                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <a class="flex-shrink-0" href="{{ route('client.home.productDetail', $item->product_id) }}">
                            <img src="{{ $item->product->getThumbnail() }}" width="60"
                                alt="{{ $item->product->name }}">
                        </a>
                        <div class="w-100 min-w-0 ps-2 ps-xl-3">
                            <h5 class="d-flex animate-underline mb-2">
                                <a class="d-block fs-sm fw-medium text-truncate animate-target"
                                    href="{{ route('client.home.productDetail', $item->product_id) }}">{{ $item->product->name }}</a>
                            </h5>
                            <ul class="list-unstyled gap-1 fs-xs mb-0">
                                <li><span class="text-body-secondary">Thể loại:</span> <span
                                        class="text-dark-emphasis fw-medium">{{ $item->product->kind->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Chất lượng sản phẩm</label>
                    <div class="d-flex gap-1 me-2">
                        <input type="hidden" name="arr[{{ $item->product_id }}][rating]" value="5">
                        <i data-value="1" class="rating ci-star-filled text-warning"></i>
                        <i data-value="2" class="rating ci-star-filled text-warning"></i>
                        <i data-value="3" class="rating ci-star-filled text-warning"></i>
                        <i data-value="4" class="rating ci-star-filled text-warning"></i>
                        <i data-value="5" class="rating ci-star-filled text-warning"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhận xét</label>
                    <textarea name="arr[{{ $item->product_id }}][note]" class="form-control" rows="5"></textarea>
                </div>
            </div>
            <hr>
        @endif
    @endforeach
</form>
