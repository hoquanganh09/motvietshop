<x-client.layout.home>
    <div class="container py-5">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('client.home.common.user_sidebar')


            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title -->
                    <h1 class="h2 mb-1 mb-sm-2">Thông tin cá nhân</h1>

                    @foreach ($user->addresses as $item)
                        <div class="border-bottom py-4">
                            <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                <div class="d-flex align-items-center gap-3 me-4">
                                    <h2 class="h6 mb-0">{{ $item->name }}</h2>
                                    @if ($item->isDefault())
                                        <span class="badge text-bg-info rounded-pill">Mặc định</span>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="btn-edit-address text-center nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed" data-bs-toggle="collapse" aria-expanded="false"
                                        aria-controls="preview_{{ $item->id }} edit_{{ $item->id }}">
                                        Chỉnh sửa
                                    </a>
                                    <form action="{{ route('client.shippingAddress.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a class="ms-3 text-center nav-link text-decoration-underline p-0"
                                            href="javascript:void(0)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            Xóa
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <div class="primary-address-{{ $item->id }} collapse show" id="preview_{{ $item->id }}" style="">
                                <ul class="list-unstyled fs-sm m-0">
                                    <li>{{ $item->fullname }}</li>
                                    <li>{{ $item->phone_number }}</li>
                                    <li>{{ $item->address }}</li>
                                </ul>
                            </div>
                            <div class="primary-address-{{ $item->id }} collapse" id="edit_{{ $item->id }}" style="">
                                <form class="row g-3 g-sm-4" method="post"
                                    action="{{ route('client.shippingAddress.update', $item->id) }}">
                                    @csrf
                                    @method('put')
                                    <div class="col-sm-12">
                                        <div class="position-relative">
                                            <label for="psa-name_{{ $item->id }}" class="form-label">
                                                Tên của địa chỉ giao hàng
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="psa-name_{{ $item->id }}" value="{{ $item->name }}">
                                            @error('name')
                                                <div style="display: block" class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative">
                                            <label for="psa-fullname_{{ $item->id }}" class="form-label">
                                                Họ và tên
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="fullname"
                                                class="form-control @error('fullname') is-invalid @enderror"
                                                id="psa-fullname_{{ $item->id }}" value="{{ $item->fullname }}">
                                            @error('fullname')
                                                <div style="display: block" class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative">
                                            <label for="psa-phone_number_{{ $item->id }}" class="form-label">
                                                Số điện thoại
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="phone_number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                id="psa-phone_number_{{ $item->id }}"
                                                value="{{ $item->phone_number }}">
                                            @error('phone_number')
                                                <div style="display: block" class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="position-relative">
                                            <label for="psa-address_{{ $item->id }}" class="form-label">
                                                Địa
                                                chỉ
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ $item->address }}</textarea>
                                            @error('address')
                                                <div style="display: block" class="invalid-feedback"></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input" name="is_default" value="1"
                                                id="set-primary-1_{{ $item->id }}"
                                                @if ($item->isDefault()) checked @endif>
                                            <label for="set-primary-1_{{ $item->id }}" class="form-check-label">
                                                Đặt làm địa chỉ mặc
                                                định
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                            <button type="button" class="btn btn-secondary collapsed"
                                                data-bs-toggle="collapse" data-bs-target=".primary-address-{{ $item->id }}"
                                                aria-expanded="false"
                                                aria-controls="preview_{{ $item->id }} edit_{{ $item->id }}">Đóng</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div class="nav pt-4">
                        <a class="nav-link animate-underline fs-base px-0" href="#newAddressModal"
                            data-bs-toggle="modal">
                            <i class="ci-plus fs-lg ms-n1 me-2"></i>
                            <span class="animate-target">Thêm địa chỉ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.modal.add_shipping_address')
    @push('js')
        <script>
            $(() => {
                $(document).on('click', '.btn-edit-address', function () {
                    const ids = $(this).attr('aria-controls').split(' ');
                    
                    $(`#${ids[0]}`).collapse('toggle');
                    $(`#${ids[1]}`).collapse('toggle');
                });
            });
        </script>
    @endpush
</x-client.layout.home>
