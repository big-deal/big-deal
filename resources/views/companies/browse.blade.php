@extends('layouts.panel')

@section('title', __('Companies'))

@section('panel')
    <div class="card-body">
        <div class="row  justify-content-sm-center">
            <div class="col-sm-6">
                <a href="{{ route('companies.create') }}" class="btn btn-primary btn-block">
                    <i class="fa fa-fw fa-plus"></i>
                    {{ __('Create') }}
                </a>
            </div>
        </div>
    </div>

    @if($companies->isEmpty())
        <div class="card-body text-center">
            <div class="h3">
                Empty<span class="fa fa-fw fa-lg fa-frown-o"></span>
            </div>
            <div class="h5">
                Create first right now!
            </div>
        </div>
    @else
        <div class="list-group list-group-flush list-group-striped">
            @foreach($companies as $company)
                <a href="{{ route('companies.edit', $company) }}"
                   class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $company->title }}</h5>
                        <small>{{ $company->updated_at->diffForHumans() }}</small>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
    {{ $companies->links('common.pagination') }}
@endsection
