<button class="btn {{ $class or '' }} dropdown-toggle dropdown-toggle-split" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropdown</span>
</button>
<div class="dropdown-menu">
    {{ $slot }}
</div>
