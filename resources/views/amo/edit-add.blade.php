@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
    @includeIf('common.breadcrumb', ['title' => __($company->title), 'href' => route('companies.edit', $company)])
@endsection

@section('title', __('New AmoCRM'))

@section('panel')
    <div class="card-body">
        @component('common.form.edit-add', ['route' => 'companies.amos', 'eloquents' => [$company], 'eloquent' => $amo])
            <div class="form-group">
                @includeIf('common.input.text', [
                    'id' => 'domain', 'name' => 'domain', 'label' => __('Domain'),
                    'placeholder' => __('Domain'), 'value' => old('domain', $amo->domain ?? ''),
                    'required' => true, 'class' => ($errors->has('domain') ? 'is-invalid' : '').' js-auth',
                    'help' => 'Your AmoCRM Domain. For example: new59c8c9cd13f23.amocrm.ru or new59c8c9cd13f23'
                ])
            </div>
            <div class="form-group">
                @includeIf('common.input.text', [
                    'id' => 'login', 'name' => 'login', 'label' => __('Login'),
                    'placeholder' => __('Login'), 'value' => old('login', $amo->login ?? ''),
                    'required' => true, 'class' => ($errors->has('login') ? 'is-invalid' : '').' js-auth',
                ])
            </div>
            <div class="form-group">
                @includeIf('common.input.text', [
                    'id' => 'hash', 'name' => 'hash', 'label' => __('HASH'),
                    'placeholder' => __('HASH'), 'value' => old('hash', $amo->hash ?? ''),
                    'required' => true, 'class' => ($errors->has('hash') ? 'is-invalid' : '').' js-auth',
                    'help' => 'Your API key. You can find out at [your-domain].amocrm.ru/settings/dev'
                ])
            </div>
            {{--Leads Status--}}
            <fieldset class="js-selects" disabled>
                <div class="form-group">
                    @includeIf('common.input.select', [
                        'id' => 'status', 'name' => 'status', 'label' => __('Leads Status'),
                        'placeholder' => __('Choice Leads Status'), 'value' => old('status', $amo->hash ?? ''),
                        'required' => true, 'class' => ($errors->has('status') ? 'is-invalid' : '').' js-status',
                        'help' => 'Leads status after processing. May be individual.'
                    ])
                </div>
                <div class="form-group">
                    @includeIf('common.input.number', [
                        'id' => 'minimum_duration', 'name' => 'minimum_duration', 'label' => __('Minimum Duration'),
                        'placeholder' => __('Minimum Duration'), 'value' => old('minimum_duration', $amo->minimum_duration ?? 0),
                        'required' => true, 'class' => ($errors->has('minimum_duration') ? 'is-invalid' : '').' js-minimum_duration',
                        'help' => ''
                    ])
                </div>
                <div class="form-group">
                    @includeIf('common.input.select', [
                        'id' => 'recording', 'name' => 'recording', 'label' => __('Recording'),
                        'placeholder' => __('Choice Leads Status'), 'value' => old('status', $amo->recording ?? ''),
                        'required' => true, 'class' => ($errors->has('recording') ? 'is-invalid' : '').' js-recording',
                        'help' => '', 'options' => ['0' => 'Не записывать', '1' => 'Входящие', '2' => 'Исходящие', '3' => 'Все звонки',],
                        'without_default' => true
                    ])
                </div>
                <div class="form-group">
                    @includeIf('common.input.select', [
                        'id' => 'roistat', 'name' => 'roistat', 'label' => __('Roistat Field'),
                        'placeholder' => __('Choice Roistat Field'), 'value' => old('roistat', $amo->roistat ?? ''),
                        'required' => true, 'class' => ($errors->has('roistat') ? 'is-invalid' : '').' js-roistat',
                        'help' => 'Setup WEBHOOK to URL'.($amo->id ? ': '.url('/') : '')
                    ])
                    {{--route('api.roistat.webhook', $amoCRM)--}}
                </div>
                <div class="form-group">
                    @includeIf('common.input.select', [
                        'id' => 'field', 'name' => 'field', 'label' => __('Custom Field'),
                        'placeholder' => __('Choice Custom Field'), 'value' => old('field', $amo->field ?? ''),
                        'required' => true, 'class' => ($errors->has('field') ? 'is-invalid' : '').' js-field',
                        'help' => ''
                    ])
                </div>
                <div class="form-group">
                    @includeIf('common.input.select', [
                        'id' => 'value', 'name' => 'value', 'label' => __('Custom Value'),
                        'placeholder' => __('Custom Value'), 'value' => old('value', $amo->value ?? ''),
                        'required' => true, 'class' => ($errors->has('value') ? 'is-invalid' : '').' js-value',
                        'help' => ''
                    ])
                </div>
            </fieldset>
            <div class="row">
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        @endcomponent
    </div>
@endsection

@push('scripts')
    <script>
        jQuery(($) => {
            let fields = {};

            function errorHandling(error) {
                fields = {};

                $(".js-selects")
                    .attr("disabled", "disabled");

                if (error.code === 101) {
                    $('#domain')
                        .closest('.form-group')
                        .addClass('has-error');
                } else if ([110, 112].indexOf(error.code) !== -1) {
                    $('#login, #hash')
                        .closest('.form-group')
                        .addClass('has-error');
                }
            }

            $(".js-auth")
                .on("change", (event) => {
                    $(".js-selects")
                        .attr("disabled", "disabled");
                    $('#domain, #login, #hash')
                        .closest('.form-group')
                        .removeClass('has-error');

                    let query = {};

                    $('.js-auth')
                        .each((index, emelent) => {
                            let $el = $(emelent);
                            query[$el.attr('name')] = $el.val();
                        });

                    for (let index in query) {
                        if (!query[index]) {
                            $('.js-form-lock')
                                .removeAttr("disabled");
                            return;
                        }
                    }

                    $.post('{{ route('api.amo.auth') }}', query)
                        .done((data) => {
                            if (data.response) {
                                fields = data.response.fields;
                                let $status = $('.js-status');
                                let $roistat = $('.js-roistat');
                                let $field = $('.js-field');

                                do {
                                    $status = $('.js-status');

                                    $status
                                        .find('option:gt(0)')
                                        .remove();

                                    $.each(data.response.statuses, (index, item) => {
                                        $optgroup = $('<optgroup>')
                                            .attr('label', item.name);

                                        $.each(item.statuses, (index, status) => {
                                            $optgroup
                                                .append(
                                                    $('<option>')
                                                        .attr('value', status.id)
                                                        .text(status.name)
                                                );
                                        });

                                        $status
                                            .append(
                                                $optgroup
                                            );
                                    });
                                } while (false);

                                do {
                                    $field
                                        .find('option:gt(0)')
                                        .remove();

                                    $.each(data.response.fields, (index, item) => {
                                        $field
                                            .append(
                                                $('<option>')
                                                    .attr('value', item.id)
                                                    .text(item.name)
                                            );
                                    });
                                } while (false);

                                do {
                                    $roistat
                                        .find('option:gt(0)')
                                        .remove();

                                    $.each(data.response.fields, (index, item) => {
                                        $roistat
                                            .append(
                                                $('<option>')
                                                    .attr('value', item.id)
                                                    .text(item.name)
                                            );
                                    });
                                } while (false);

                                $(".js-selects")
                                    .removeAttr("disabled");

                            } else if (data.error) {
                                errorHandling(data.error);
                            }
                        })
                        .fail(($xhr) => {
                            let data = $xhr.responseJSON;
                            errorHandling(data.error);
                        })
                        .always(() => {
                            $('.js-form-lock')
                                .removeAttr("disabled");
                        });
                })
                .first()
                .trigger("change");

            $(".js-field")
                .on("change", (event) => {
                    let $el = $(event.currentTarget),
                        $val = $('#value');

                    if ($el.val()) {
                        $.each(fields, (index, item) => {
                            if (item.id === $el.val() && item.enums) {
                                $val
                                    .removeAttr("disabled");

                                $.each(item.enums, (id, name) => {
                                    $val
                                        .append(
                                            $('<option>')
                                                .attr('value', id)
                                                .text(name)
                                        );
                                });
                            }
                        });
                    } else {
                        $val
                            .attr("disabled", "disabled")
                            .find('option:gt(0)')
                            .remove();
                    }
                })
                .trigger("change");

            setTimeout(() => {
                $("#status").val('{{ old('status', $amo->status ?? '') }}');
                $("#roistat").val('{{ old('roistat', $amo->roistat ?? '') }}');
                $("#field").val('{{ old('field', $amo->field ?? '') }}').trigger("change");
                $("#value").val('{{ old('value', $amo->value ?? '') }}');
                $("#minimum_duration").val('{{ old('minimum_duration', $amo->minimum_duration ?? '') }}');
                $("#recording").val('{{ old('recording', $amo->recording ?? '') }}');
            }, 1e3);
        });
    </script>
@endpush
