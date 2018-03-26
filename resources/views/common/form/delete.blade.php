<form action="{{ route($route.'.destroy', $eloquent) }}" method="post">
    @csrf
    @method('DELETE')
    {{ $slot }}
</form>
