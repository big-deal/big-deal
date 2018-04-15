<label for="{{ $name }}">{{ __($label) }}</label>
<input type="number" id="{{ $id ?? $name }}" name="{{ $name }}" class="form-control {{ $class ?? '' }}"
       placeholder="{{ __($placeholder ?? $label) }}" {{ $required ?? false ? 'required' : '' }}
       value="{{ $value ?? 0 }}" {{ $disabled ?? false ? 'disabled' : '' }}
       {{ $step ? 'step='.$step : '' }} aria-label="{{ __($label) }}">
@isset($help)
    <small id="{{ $id ?? $name }}" class="form-text text-muted">{!! __($help) !!}</small>
@endisset
