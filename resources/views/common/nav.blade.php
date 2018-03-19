<nav class="navbar navbar-expand-md sticky-top navbar-light navbar-laravel">
    <div class="container">
        <!-- Branding Image -->
        @includeIf('common.nav.branding')

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @includeIf('common.nav.left')
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @includeIf('common.nav.auth')
            </ul>
        </div>
    </div>
</nav>
