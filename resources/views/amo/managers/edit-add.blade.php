@extends('layouts.panel')

@section('breadcrumbs')
    @includeIf('common.breadcrumb', ['title' => __('Companies'), 'href' => route('companies.index')])
    @includeIf('common.breadcrumb', ['title' => __($company->title), 'href' => route('companies.edit', [$company])])
    @includeIf('common.breadcrumb', ['title' => __('AmoCRM'), 'href' => route('companies.amos.edit', [$company, $amo])])
@endsection

@section('title', __('Managers'))

@section('panel')
    @component('common.form.edit-add', ['route' => 'companies.amos.managers', 'eloquents' => [$company], 'eloquent' => $amo])
        <div class="table-responsive-sm">
            <table class="table mb-0">
                @forelse($managers as $manager)
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            {{ __($manager->name) }}
                            <div class="float-right">
                                <a class="js-collapser" data-toggle="collapse" href="#collapse_{{ $manager->id }}"
                                   role="button" aria-expanded="false" aria-controls="collapse_{{ $manager->id }}">
                                    <i class="fa fa-compress" aria-hidden="true"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="py-0">
                            <div class="py-2 collapse show" id="collapse_{{ $manager->id }}">
                                @includeIf('amo.settings.fields', ['amo' => $amo, 'model' => $manager, 'errors' => $errors])
                            </div>
                        </td>
                    </tr>
                    </tbody>
                @empty
                    <tbody>
                    <tr>
                        <td>empty</td>
                    </tr>
                    </tbody>
                @endforelse
            </table>
        </div>
        <div class="container my-3">
            <div class="row">
                <div class="col col-lg-4 offset-lg-8">
                    <input type="submit" class="btn btn-outline-primary btn-block" value="Submit">
                </div>
            </div>
        </div>
    @endcomponent
@endsection

@push('scripts')
    <script>
        jQuery(() => {
            $(".collapse")
                .on('show.bs.collapse hide.bs.collapse', (e) => {
                    $('.fa', '[aria-controls=' + $(e.target).attr('id') + ']')
                        .toggleClass('fa-expand')
                        .toggleClass('fa-compress');
                });
        });
    </script>
@endpush
