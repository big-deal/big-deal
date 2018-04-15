<label for="{{ $name }}">{{ __($label) }}</label>
<select id="{{ $id ?? $name }}" name="{{ $name }}" class="custom-select {{ $class ?? '' }}"
    {{ $required ?? false ? 'required' : '' }}>
    @if(!($without_default ?? false))
        <option value="" selected disabled>{{ __($placeholder ?? $label) }}</option>
    @endif
    @foreach($options ?? [] as $_value => $option)
        <option value="{{ $_value }}" {{ ($_value == $value ?? !$_value) ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
</select>
@isset($help)
    <small id="{{ $id ?? $name }}" class="form-text text-muted">{!! __($help) !!}</small>
@endisset
