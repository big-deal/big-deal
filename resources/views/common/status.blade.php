@if (session('status'))
    <div class="card-body">
        <div class="alert alert-{{ session('status.reason', 'success') }} alert-dismissible fade show" role="alert">
            @php
                $status_message = session('status.message', function () {
                    $session = session('status');

                    return is_string($session) ? $session : 'Success!';
                });
            @endphp
            {{ $status_message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
