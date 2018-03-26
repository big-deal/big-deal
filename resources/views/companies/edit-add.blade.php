@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
@endsection

@section('title', __($company->title ?? 'New company'))

@section('panel')
    <div class="card-body">
        @component('common.form.edit-add', ['route' => 'companies', 'eloquent' => $company])
            <div class="form-group">
                <label for="title">{{ __('Company title') }}</label>
                <div class="input-group">
                    <input type="text" id="title" name="title" class="form-control"
                           aria-label="{{ __('Company title') }}"
                           placeholder="{{ __('Company title') }}"
                           value="{{ old('title', $company->title ?? '') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary">
                            {{ __('Save') }}
                        </button>
                        @if($company->id)
                            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                @component('common.form.delete', ['route' => 'companies', 'eloquent' => $company])
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa fa-fw fa-trash text-danger"></i> {{ __('Delete') }}
                                    </button>
                                @endcomponent
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcomponent
    </div>
@endsection
