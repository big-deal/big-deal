<form action="{{ route($route.'.'.($eloquent->id ? 'update' : 'store'), $eloquent) }}" method="post">
    @csrf
    @if($eloquent->id)@method('PUT')@endif
    {{ $slot }}
</form>
