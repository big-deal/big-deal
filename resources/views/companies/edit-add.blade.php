@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
@endsection

@section('title', __($company->title ?? 'New company'))

@section('panel')
    @php/** @var \App\Models\Company $company */@endphp
    <div class="card-body">
        @component('common.form.edit-add', ['route' => 'companies', 'eloquent' => $company])
            <div class="form-group">
                @component('common.input.text', [
                    'id' => 'title', 'name' => 'title', 'label' => __('Company title'),
                    'placeholder' => __('Company title'), 'value' => old('title', $company->title ?? ''),
                ])
                    <button type="submit" class="btn btn-outline-primary">
                        {{ __('Save') }}
                    </button>
                    @if($company->id)
                        @component('common.dropdown', ['class' => 'btn-outline-secondary'])
                            @component('common.form.delete', [
                                'class' => 'dropdown-item',
                                'action' => route('companies.destroy', $company),
                            ])<i class="fa fa-fw fa-trash text-danger"></i> {{ __('Delete') }}
                            @endcomponent
                        @endcomponent
                    @endif
                @endcomponent
            </div>
        @endcomponent
    </div>
    @if($company->id)
        <div class="table-responsive-sm">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th colspan="5">
                        <h5 class="m-0">
                            {{ __('AmoCRM Configuration') }}
                        </h5>
                    </th>
                </tr>
                </thead>
                <thead class="thead-dark">
                <tr>
                    <th scope="col" colspan="2">{{ __('Domain') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th></th>
                    <th scope="col">
                        @if(!$company->amo)
                            <a href="{{ route('companies.amos.create', [$company]) }}"
                               class="btn btn-sm btn-primary btn-block">
                                <i class="fa fa-fw fa-plus d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ __('Append') }}</span>
                            </a>
                        @endif
                    </th>
                </tr>
                </thead>
                <tbody>
                @if($company->amo)
                    <tr>
                        <td colspan="2">
                            {{ $company->amo->domain }}
                        </td>
                        <td class="text-{{ $company->amo->active ? 'success' : 'danger' }}">
                            {{__( $company->amo->active ? 'Ok' : 'Failed' )}}
                        </td>
                        <td align="right">
                            <div
                                style="@if(!$company->amo->active){{ 'display: inline-block;cursor: not-allowed !important;' }}@endif">
                                <a href="{{ route('companies.amos.managers.edit', [$company, $company->amo]) }}"
                                   class="btn btn-sm btn-outline-primary @if(!$company->amo->active){{ 'disabled' }}@endif">
                                    <i class="fa fa-fw fa-users"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('companies.amos.edit', [$company, $company->amo]) }}"
                               class="btn btn-sm btn-outline-primary btn-block">
                                <i class="fa fa-fw fa-trash d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ __('Edit') }}</span>
                            </a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <th scope="row" colspan="5" class="text-center">{{ __('Empty') }}</th>
                    </tr>
                @endif
                </tbody>
                <thead>
                <tr>
                    <th colspan="5">
                        <h5 class="m-0">
                            {{ __('Beeline PBX Configuration') }}
                        </h5>
                    </th>
                </tr>
                </thead>
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Token') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th></th>
                    <th scope="col">
                        <a href="{{ route('companies.beelines.create', [$company]) }}"
                           class="btn btn-sm btn-primary btn-block">
                            <i class="fa fa-fw fa-plus d-sm-none"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Append') }}</span>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($company->beelines as $beeline)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $beeline->token }}</td>
                        <td class="text-{{ $beeline->subscribe_id ? 'success' : 'danger' }}">
                            {{__( $beeline->subscribe_id ? 'Ok' : 'Failed' )}}
                        </td>
                        <td></td>
                        <td colspan="2">
                            @component('common.form.delete', [
                                'class' => 'btn btn-sm btn-outline-danger btn-block',
                                'action' => route('companies.beelines.destroy', [$company, $beeline]),
                            ])<i class="fa fa-fw fa-trash d-sm-none"></i>
                            <span class="d-none d-sm-inline-block">{{ __('Remove') }}</span>
                            @endcomponent
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th scope="row" colspan="5" class="text-center">{{ __('Empty') }}</th>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection
