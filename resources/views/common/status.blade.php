@if (session('status') || $errors->any())
    <div class="alerts card-body mb-0 pb-0">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('status'))
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
        @endif
    </div>
@endif
