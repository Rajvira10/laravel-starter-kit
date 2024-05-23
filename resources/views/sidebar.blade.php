<style>
    .navbar-nav .nav-sm .nav-link:before {
        display: none;
    }
</style>
@php
    $menus = App\Models\Menu::where('parent_id', null)->orderBy('hierarchy', 'asc')->get();

    $menus = $menus->filter(function ($menu) {
        return $menu->hasPermission();
    });

    $menus = $menus->sortBy('hierarchy');
    $menus = $menus->values();
    $menus = $menus->map(function ($menu) {
        $menu->children = $menu->children->filter(function ($child) {
            return $child->hasPermission();
        });
        $menu->children = $menu->children->sortBy('hierarchy');
        $menu->children = $menu->children->values();
        return $menu;
    });

    $settings = App\Models\Setting::first();

    $logo = $settings->logo ?? 'assets/images/logo.png';
    $favicon = $settings->favicon ?? 'assets/images/favicon.svg';
@endphp
<div class="app-menu navbar-menu">


    <div class="navbar-brand-box mt-3">
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset($favicon) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset($logo) }}" alt="" height="60">
            </span>
        </a>

        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset($favicon) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset($logo) }}" alt="" height="60">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>



                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}" role="button" aria-expanded="false">
                        <i class="bx bx-home-alt"></i> <span data-key="t-dashboards">Home</span>
                    </a>
                </li>

                @foreach ($menus as $menu)
                    @php
                        $active = $show = '';
                        $routeName = Illuminate\Support\Facades\Route::currentRouteName();

                        if (in_array(session('view_name'), $menu->children->pluck('url')->toArray())) {
                            $active = 'active';
                            $show = 'show';
                        }
                    @endphp
                    @if ($menu->children->count() > 0)
                        <li class="nav-item">

                            <a class="nav-link menu-link {{ $active }}" href="#sidebar{{ $menu->id }}"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="sidebar{{ $menu->id }}">

                                <i class="{{ $menu->icon }}"></i> <span
                                    data-key="t-permissions">{{ $menu->name }}</span>
                            </a>
                            <div class="collapse menu-dropdown {{ $show }}" id="sidebar{{ $menu->id }}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach ($menu->children as $child)
                                        <li class="nav-item">
                                            @if ($child->url == '#')
                                                <a class="nav-link menu-link" href="#" role="button"
                                                    aria-expanded="false">
                                                    <i class="{{ $child->icon }}"></i> <span
                                                        data-key="t-users">{{ $child->name }}</span>
                                                </a>
                                            @else
                                                <a href="{{ route($child->url) }}" target="_self"
                                                    class="nav-link {{ session('view_name') == $child->url ? 'active' : '' }}"
                                                    data-key="t-user"><i class="{{ $child->icon }}"></i> <span
                                                        data-key="t-users">{{ $child->name }}</span></a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        @if ($menu->url != '#')
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ $active }}" href="{{ route($menu->url) }}"
                                    role="button" aria-expanded="false">
                                    <i class="{{ $menu->icon }}"></i> <span
                                        data-key="t-dashboards">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link menu-link " href="#" role="button" aria-expanded="false">
                                    <i class="{{ $menu->icon }}"></i> <span
                                        data-key="t-dashboards">{{ $menu->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background">
    </div>
</div>
