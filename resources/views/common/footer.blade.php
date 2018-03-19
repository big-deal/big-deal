<footer class="footer">
    <div class="container text-center">
        <span class="text-muted">
            @if (have_fun())
                Made with rum and even more rum<i class="fa fa-fw fa-lg fa-smile-o" aria-hidden="true"></i>
            @else
                <div class="d-inline-block mt-3 mb-1">
                Made with <i class="fa fa-fw fa-lg fa-heart-o" style="color:red" aria-hidden="true"></i> by
                <a href="mailto:Igor@Finag.in?subject=amoPBX%20{{ url('/') }}" target="_blank">
                    Igor<i class="fa fa-at" aria-hidden="true"></i>Finag.in
                </a>
                </div>
                <div class="d-inline-block mt-1 mb-3">
                <i class="fa fa-copyright" aria-hidden="true"></i>
                2017
                @if(\Carbon\Carbon::now()->year != 2017)
                    - {{ \Carbon\Carbon::now()->year }}
                @endif
                </div>
            @endif
        </span>
    </div>
</footer>
