@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @yield('breadcrumbs')
                                <li class="breadcrumb-item active" aria-current="page">
                                    @yield('title')
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @yield('panel')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
