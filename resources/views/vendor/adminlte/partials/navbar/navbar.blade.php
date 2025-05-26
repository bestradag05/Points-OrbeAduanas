<nav
    class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-bell"></i>
                @if ($notifications->count())
                    <span class="badge badge-danger navbar-badge">{{ $notifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                @forelse ($notifications as $notification)
                    @php
                        $originUser = $originUsers->get($notification->data['oring_user']);
                    @endphp

                    <a href="{{ route('notifications.read', $notification->id) }}" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('storage/' . ($originUser->personal->img_url !== null ? $originUser->personal->img_url : 'personals/user_default.png')) }}"
                                alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ $notification->notifiable->personal->names }}
                                    @if (is_null($notification->read_at))
                                        <span class="badge badge-info">Nueva</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-truncate" style="max-width: 200px; word-break: break-all;"
                                    title="{{ $notification->data['message'] }}">
                                     {{ \Illuminate\Support\Str::limit($notification->data['message'], 80) }}
                                </p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                    {{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <a class="dropdown-item text-center text-muted" href="#">Sin notificaciones nuevas</a>
                @endforelse


            </div>
        </li>

        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if (Auth::user())
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
