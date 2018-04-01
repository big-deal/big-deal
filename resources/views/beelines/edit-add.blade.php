@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
    @includeIf('common.breadcrumb', ['title' => __($company->title), 'href' => route('companies.edit', $company)])
@endsection

@section('title', __('New Beeline Token'))

@section('panel')
    <div class="card-body">
        @component('common.form.edit-add', ['route' => 'companies.beelines', 'eloquents' => [$company], 'eloquent' => $beeline])
            <div class="form-group">
                @component('common.input.text', [
                    'id' => 'token', 'name' => 'token', 'label' => __('Beeline Token'),
                    'placeholder' => __('Beeline Token'), 'value' => old('token', $beeline->token ?? ''),
                    'required' => true, 'class' => $errors->has('token') ? 'is-invalid' : '',
                    'help' => 'You can get API token from <a href="https://cloudpbx.beeline.ru/#Настройки">API tab</a>'
                ])
                    <button type="submit" class="btn btn-outline-primary">
                        {{ __('Save') }}
                    </button>
                @endcomponent
            </div>
        @endcomponent
    </div>
@endsection
