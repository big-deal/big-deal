<label for="{{ $name }}">{{ __($label) }}</label>
<div class="input-group">
    <input type="text" id="{{ $id ?? $name }}" name="{{ $name }}" class="form-control {{ $class ?? '' }}"
           placeholder="{{ __($placeholder ?? $label) }}" {{ $required ?? false ? 'required' : '' }}
           value="{{ $value ?? '' }}" {{ $disabled ?? false ? 'disabled' : '' }}
           aria-label="{{ __($label) }}">
    @if(strlen($slot))
        <div class="input-group-append">
            {{ $slot }}
        </div>
    @endif
</div>
@isset($help)
    <small id="{{ $id ?? $name }}" class="form-text text-muted">{!! __($help) !!}</small>
@endisset
