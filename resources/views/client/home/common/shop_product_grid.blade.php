<!-- Sorting -->
<div class="d-sm-flex align-items-center justify-content-between mt-n2 mb-3 mb-sm-4">
    <div class="fs-sm text-body-emphasis text-nowrap">Tìm thấy <span class="fw-semibold">{{ $products->total() }}</span>
        sản phẩm
    </div>
    <div class="d-flex align-items-center text-nowrap">
        <label class="form-label fw-semibold mb-0 me-2">Sắp xếp bởi:</label>
        <div style="width: 190px">
            <select name="sort" class="form-select border-0 rounded-0 px-1">
                <option @if ($sort == 'name:asc') selected @endif value="name:asc">Tên: A-Z</option>
                <option @if ($sort == 'name:desc') selected @endif value="name:desc">Tên: Z-A</option>
                <option @if ($sort == 'price:asc') selected @endif value="price:asc">Giá: Thấp đến cao</option>
                <option @if ($sort == 'price:desc') selected @endif value="price:desc">Giá: Cao đến thấp</option>
            </select>
        </div>
    </div>
</div>

<div class="row gy-4 gy-md-5 pb-4 pb-md-5">
    @if ($products->isEmpty())
        <div class="col-12 text-center">
            <img width="450" src="{{ getNoProductImage() }}" class="img-fluid">
        </div>
    @else
        @foreach ($products as $item)
            <x-client.product class="col-6 col-md-4 mb-2 mb-sm-3 mb-md-0" :product="$item" />
        @endforeach
    @endif
</div>

{{ $products->links() }}
