@props([
    'id' => Str::random(10),
    'url' => '',
    'search' => '',
    'filter_id' => '',
])
<div id="{{ $id }}">
    {{ $slot }}
</div>

@push('js')
    <script>
        function dispatchReloadEvent() {
            document.dispatchEvent(new CustomEvent('reload_handle_ajax'), {});
        }
        $(() => {
            const view = $('#{{ $id }}');
            const data = {};
            const timeout = 300;
            let clearTimeOut = null;

            // reload
            $(document).on('reload_handle_ajax', function(e) {
                loadView(`{{ $url }}?${new URLSearchParams(data).toString()}`, view);
            });

            // pagination
            view.on('click', '.pagination .page-item:not(.disabled):not(.active)', function(e) {
                e.preventDefault();

                const page = new URLSearchParams($(this).find('a').attr('href').split('?').pop()).get(
                    'page');
                data.page = page;

                loadView(`{{ $url }}?${new URLSearchParams(data).toString()}`, view);
            });

            // search
            $(`{{ $search }}`).on('input', function(e) {
                data.page = 0;
                if (clearTimeOut != null) {
                    clearTimeout(clearTimeOut);
                    clearTimeOut = null;
                }

                clearTimeOut = setTimeout(() => {
                    data.search = $(this).val();
                    loadView(`{{ $url }}?${new URLSearchParams(data).toString()}`, view);
                }, timeout);
            });

            // filter
            $(`{{ $filter_id }} .btn-filter`).on('click', function(e) {
                const formData = $(`{{ $filter_id }} form`).serialize();

                formData.split('&').forEach(item => {
                    const [key, value] = item.split('=');
                    data[key] = value;
                });

                loadView(`{{ $url }}?${new URLSearchParams(data).toString()}`, view);
            });

            // reset filter
            $(`{{ $filter_id }} .btn-reset-filter`).on('click', function(e) {
                const form = $(`{{ $filter_id }} form`);

                form.find('select[name]').each(function() {
                    this.selectedIndex = 0;
                    data[this.getAttribute('name')] = '';
                });

                loadView(`{{ $url }}?${new URLSearchParams(data).toString()}`, view);
            });
        })
    </script>
@endpush
