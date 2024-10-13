<x-client.layout.home>
    <div class="container py-5">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">
            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            @include('client.home.common.user_sidebar')


            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title + Master switch -->
                    <div class="nav flex-nowrap align-items-center justify-content-between pb-3 mb-3 mb-lg-4">
                        <h1 class="h2 me-3 mb-0">Thông báo</h1>
                        <div class="form-check form-switch nav-link animate-underline p-0 m-0"
                            data-master-checkbox="{&quot;container&quot;: &quot;#notifications&quot;, &quot;label&quot;: &quot;Chọn tất cả&quot;, &quot;labelChecked&quot;: &quot;Bỏ chọn tất cả&quot;}">
                            <label for="notifications-master" class="form-check-label animate-target me-5">
                                Bỏ chọn tất cả
                            </label>
                            <div class="ps-3">
                                <input type="checkbox" class="form-check-input" id="notifications-master"
                                    checked="">
                            </div>
                        </div>
                    </div>


                    <!-- Notification switches list -->
                    <div class="d-flex flex-column gap-4" id="notifications">
                        @foreach ($notis as $item)
                            <div class="form-check form-switch mb-0">
                                <input @if ($user->{$item['attr']} ?? false) checked @endif type="checkbox" name="{{ $item['attr'] }}" class="form-check-input" id="{{ $item['attr'] }}">
                                <label class="form-check-label ps-2" for="{{ $item['attr'] }}">
                                    <span class="d-block h6 mb-2">{{ $item['label'] }}</span>
                                    <span class="fs-sm">{{ $item['des'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.modal.add_shipping_address')
    @push('js')
        <script>
            $('#notifications input[type=checkbox]').on('change', function() {
                ajax(`{{ route('client.auth.changeNoti') }}`, 'post', {
                    [$(this).attr('name')]: $(this).is(':checked') ? 1 : 0
                }, function (res) {
                    toast(res.data.message);
                });
            });

            $('#notifications-master').on('change', function() {
                let data = {};

                $('#notifications input[type=checkbox]').each(function() {
                    data[$(this).attr('name')] = $(this).is(':checked') ? 1 : 0
                });
                
                ajax(`{{ route('client.auth.changeNoti') }}`, 'post', data, function (res) {
                    toast(res.data.message);
                });
            });
        </script>
    @endpush
</x-client.layout.home>
