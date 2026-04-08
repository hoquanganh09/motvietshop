<x-client.layout.home>
    <section class="container py-5 mt-4 mt-lg-5 mb-lg-4 mb-xl-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="text-center mb-5">
                    <h1 class="h2">Tra Cứu Vận Đơn</h1>
                    <p class="fs-sm text-body-secondary">Nhập Mã đơn hàng và Số điện thoại đặt hàng để xem tình trạng vận chuyển.</p>
                </div>

                <div class="card border-0 shadow-sm custom-card">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('client.home.postTracking') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <label class="form-label">Mã đơn hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="order_code" placeholder="VD: 1024" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" name="phone" placeholder="VD: 0987654321" required>
                                </div>
                                <div class="col-12 mt-4 text-center">
                                    <button type="submit" class="btn btn-lg btn-dark w-100 w-sm-auto">Tiến hành tra cứu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if(isset($searched))
                    <div class="mt-5 pt-3">
                        @if($order)
                            <div class="card border-0 shadow-sm overflow-hidden text-center text-sm-start">
                                <div class="card-body p-4">
                                    <h5 class="mb-4">Thông tin đơn hàng #{{ $order->id }}</h5>
                                    
                                    <!-- Tracking progress -->
                                    <div class="position-relative mb-5 pt-2">
                                        <div class="progress position-absolute top-50 start-0 translate-middle-y w-100" style="height: 4px; z-index: 1;">
                                            @php
                                                $width = 0;
                                                if($order->status > 0) $width = 33 * $order->status;
                                                if($order->status == 3) $width = 100;
                                            @endphp
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $width }}%"></div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between position-relative z-2">
                                            <!-- Step 1 -->
                                            <div class="text-center" style="width: 25%;">
                                                <div class="btn btn-icon btn-sm {{ $order->status >= 0 ? 'btn-success text-white' : 'btn-light border text-muted' }} rounded-circle mb-2 pointer-events-none">
                                                    <i class="ci-check"></i>
                                                </div>
                                                <div class="fs-xs fw-medium text-body-emphasis">Đặt hàng</div>
                                                <div class="fs-xs text-body-secondary mt-1">{{ $order->created_at->format('d/m/Y') }}</div>
                                            </div>
                                            <!-- Step 2 -->
                                            <div class="text-center" style="width: 25%;">
                                                <div class="btn btn-icon btn-sm {{ $order->status >= 1 ? 'btn-success text-white' : 'btn-light border text-muted' }} rounded-circle mb-2 pointer-events-none">
                                                    <i class="ci-package"></i>
                                                </div>
                                                <div class="fs-xs fw-medium text-body-emphasis">Xác nhận</div>
                                            </div>
                                            <!-- Step 3 -->
                                            <div class="text-center" style="width: 25%;">
                                                <div class="btn btn-icon btn-sm {{ $order->status >= 2 ? 'btn-success text-white' : 'btn-light border text-muted' }} rounded-circle mb-2 pointer-events-none">
                                                    <i class="ci-truck"></i>
                                                </div>
                                                <div class="fs-xs fw-medium text-body-emphasis">Đang vận chuyển</div>
                                            </div>
                                            <!-- Step 4 -->
                                            <div class="text-center" style="width: 25%;">
                                                <div class="btn btn-icon btn-sm {{ $order->status >= 3 ? 'btn-success text-white' : 'btn-light border text-muted' }} rounded-circle mb-2 pointer-events-none">
                                                    <i class="ci-home"></i>
                                                </div>
                                                <div class="fs-xs fw-medium text-body-emphasis">Thành công</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h6 class="mb-3 border-bottom pb-2">Sản phẩm</h6>
                                    @foreach($order->orderDetails as $detail)
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $detail->product->getThumbnail() }}" width="60" class="rounded" alt="Product">
                                            <div class="ps-3">
                                                <h6 class="fs-sm mb-1"><a href="{{ route('client.home.productDetail', $detail->product) }}" class="text-dark">{{ $detail->product->name }}</a></h6>
                                                <div class="fs-xs text-body-secondary">Số lượng: {{ $detail->quantity }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="ci-info-circle fs-xl me-3"></i>
                                <div>
                                    <strong>Không tìm thấy đơn hàng!</strong> Mã đơn hoặc Số điện thoại không chính xác.
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-client.layout.home>
