<nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
    <div class="container">

        <a class="navbar-brand logo-image"
           href="{{ (request()->userAgent() != 'domain' ? route('web.systemSettings.template', ['domain' => request()->domain]) : '/') }}">
            @if(isset($systemSetting->url_logo))
                <img style="width: 110px;" src="{{ Storage::url($systemSetting->logo) }}"
                     alt="{{ $systemSetting->title ?? config('template.title') }}">
            @else
                <img style="width: 110px;" src="{{ asset(config('template.url_logo')) }}"
                     alt="{{ $systemSetting->title ?? config('template.title') }}">
            @endif
        </a>

        <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ms-auto navbar-nav-scroll">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        Serviços
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item" aria-current="page" href="#header{{ $category->id }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <span class="nav-item" style="width: 261px;">
                <a class="btn-solid-sm bg-default-secondary border-default-secondary color-default-secondary-hover"
                   href="#pricing">{{ $configTemplate->nav_button ?? config('template.nav_button') }}</a>
            </span>
        </div>
    </div>
</nav>
