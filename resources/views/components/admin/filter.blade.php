@props([
    'id' => Str::random(5),
    'data' => [
        [
            'name' => 'test',
            'label' => 'Tét',
            'data' => [
                '123' => 'hehehe',
                '13' => 'hehehe1',
            ],
        ],
    ],
])
<div id="{{ $id }}">
    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-end">
        <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>
        Lọc
    </button>
    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" style="">
        <div class="px-7 py-5">
            <div class="fs-5 text-gray-900 fw-bold">Lựa chọn lọc</div>
        </div>

        <div class="separator border-gray-200"></div>

        <div class="px-7 py-5" data-kt-user-table-filter="form">
            <form>
                @foreach ($data as $field)
                    <div class="mb-10">
                        <label class="form-label fs-6 fw-semibold">{{ $field['label'] }}:</label>

                        <select class="form-select form-select-solid fw-bold" name="{{ $field['name'] }}">
                            <option value="">--- Lựa chọn ---</option>
                            @foreach ($field['data'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </form>

            <!--begin::Actions-->
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn-reset-filter btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                    data-kt-menu-dismiss="true">Làm mới</button>
                <button type="submit" class="btn-filter btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true">Áp
                    dụng</button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Content-->
    </div>
</div>
