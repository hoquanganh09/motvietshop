@props([
    'id' => 'editor_' . \Str::random(10),
    'style' => '',
    'class' => '',
    'name' => '',
    'value' => '',
])
<div id="{{ $id }}" class="{{ $class }}" style="{{ $style }}">{!! $value !!}</div>
<input id="{{ $id }}_input" type="hidden" name="{{ $name }}" value="{{ $value }}">

@push('plugin-css')
    @once
        <link rel="stylesheet" href="{{ asset('plugins/quill/quill.snow.css') }}">
    @endonce
@endpush
@push('plugin-js')
    @once
        <script src="{{ asset('plugins/quill/quill.js') }}"></script>
    @endonce
@endpush
@push('js')
    <script>
        $(() => {
            const quill = new Quill('#{{ $id }}', {
                theme: 'snow'
            });

            quill.on('text-change', (delta, oldDelta, source) => {
                $('#{{ $id }}_input').val(quill.root.innerHTML);
            });
        });
    </script>
@endpush
