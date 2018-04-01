@php
    $js_form_id = \Illuminate\Support\Str::uuid();
@endphp

<a class="{{ $class ?? '' }}" href="{{ $href ?? '#' }}"
   onclick="event.preventDefault(); document.getElementById('{{ $js_form_id }}').submit();">
    {{ $slot }}
</a>

@push('deletes')
    <form id="{{ $js_form_id }}" action="{{ $action }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endpush
