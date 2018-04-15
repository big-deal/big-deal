@php
    $fields = \App\Models\AmoSetting::viewFieldsData($amo, $model, $errors);
    $json = [
        'auth' => $model instanceof \App\Models\Amo,
        'url' => $model instanceof \App\Models\Amo ? route('api.amo.auth') : route('api.amo.fields', $amo),
        'fields' => $fields
    ];
@endphp

<fieldset id="amo-settings-fieldset{{ $model instanceof \App\Models\Amo ? '' : '-'.$model->id }}"
          class="js-selects {{ $model instanceof \App\Models\Amo ? '' : 'js-selects-'.$model->id }}" disabled>
    @foreach($fields as $field)
        <div class="form-group">
            @includeIf($field['view'], $field)
        </div>
    @endforeach
</fieldset>

@push('scripts')
    <script>
        jQuery(($) => {
            $('#amo-settings-fieldset{{ $model instanceof \App\Models\Amo ? '' : '-'.$model->id }}')
                .amoSettings(@json($json));
        });
    </script>
@endpush
