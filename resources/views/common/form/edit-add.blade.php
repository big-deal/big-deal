<form method="post"
      action="{{ route($route.'.'.($eloquent->id ? 'update' : 'store'), array_merge($eloquents ?? [], [$eloquent])) }}">
    @csrf
    @if($eloquent->id)@method('PUT')@endif
    {{ $slot }}
</form>
