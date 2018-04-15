@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
    @includeIf('common.breadcrumb', ['title' => __($company->title), 'href' => route('companies.edit', $company)])
@endsection

@section('title', __('New AmoCRM'))

@section('panel')
    <div class="card-body">
        @component('common.form.edit-add', ['route' => 'companies.amos', 'eloquents' => [$company], 'eloquent' => $amo])
            <fieldset class="js-form-lock" disabled>
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
                @includeIf('amo.settings.fields', ['amo' => $amo, 'model' => $amo, 'errors' => $errors])
                <div class="row">
                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </fieldset>
        @endcomponent
    </div>
@endsection
