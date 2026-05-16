<header class="header header-new">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="#!">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="{{ route('home') }}" class="navbar-brand logo">
                    <img src="{{ $dynamicLogo }}" class="img-fluid" alt="Logo">
                </a>
                <a href="{{ route('home') }}" class="navbar-brand logo-small">
                    <img src="{{ $dynamicLogo }}" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="{{ route('home') }}" class="menu-logo">
                        <img src="{{ $dynamicLogo }}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="#!"> <i class="fas fa-times"></i></a>
                </div>
                <div class="mobile-header d-flex flex-column justify-content-between h-100">
                    <ul class="main-nav align-items-lg-center list-menus">
                        <li class="d-none d-lg-block">
                            <div>
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-toggle bg-light-300 fw-medium"
                                        data-bs-toggle="dropdown">
                                        <i class="ti ti-layout-grid me-1"></i>{{ __('Categories') }}
                                    </a>
                                    <ul class="dropdown-menu home-category-scroll">
                                        @if ($categoriess->isNotEmpty())
                                        @foreach ($categoriess as $category)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('productlistcategory', $category->slug) }}">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                        @else
                                        <li><a class="dropdown-item">{{ __('Categories unavailable') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @foreach($menuList as $menu)
                        @foreach($menu['menus'] as $item)
                        @if(!empty($item['submenus']))
                        <li class="nav-item has-submenu active">
                            <a class="nav-link" href="#!">
                                {{ $item['name'] }} <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="submenu">
                                @foreach($item['submenus'] as $submenu)
                                <li>
                                    <a href="{{ route('dynamic.page', ['slug' => $submenu['url']]) }}"
                                        target="{{ $submenu['target'] }}">
                                        {{ $submenu['name'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li
                            class="{{ Request::url() == url($item['url']) ? 'active' : '' }} {{ $item['url'] === 'blogs' ? 'blog_menu' : '' }}">
                            <a href="{{ route('dynamic.page', ['slug' => $item['url']]) }}"
                                target="{{ $item['target'] }}">
                                {{ $item['name'] }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                        <?php if ($singlevendor == 'off' || $singlevendor == null) { ?>

                        <li class="nav-item">
                            @if(!Auth::check())
                            <a class="nav-link" href="#!" data-bs-toggle="modal"
                                data-bs-target="#provider">
                                {{ __('become_provider') }}
                            </a>
                            @endif
                        </li>
                        <?php } ?>
                    </ul>
                    <ul>
                        @if (!empty(Auth::id()))

                        @else
                        <li class="nav-item px-3 py-1 w-100 d-lg-none d-block">
                            <a class="nav-link btn btn-light" href="#" data-bs-toggle="modal"
                                data-bs-target="#login-modal"><i class="ti ti-lock me-2"></i>{{ __('Signin') }}</a>
                        </li>
                        <li class="nav-item px-3 py-1 mb-3 d-lg-none d-block">
                            <a class="nav-link btn btn-linear-primary" href="#" data-bs-toggle="modal"
                                data-bs-target="#register-modal"><i
                                    class="ti ti-user-filled me-2"></i>{{ __('Join us') }}</a>
                        </li>
                        @endif
                    </ul>
                </div>

            </div>

            <div class="header-btn d-flex align-items-center">
                @if (!empty(Auth::id()))

                <div class="provider-head-links">
                    <a href="#!"
                        class="d-flex align-items-center justify-content-center me-2 notify-link"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                            class="feather-bell bellcount"></i></a>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown notify-users p-4">
                        <div
                            class="d-flex dropdown-body align-items-center justify-content-between border-bottom p-0 pb-3 mb-3 notify-header">
                            <h6 class="notification-title">{{ __('Notifications') }} <span
                                    class="fs-18 text-gray notificationcount"></span></h6>
                            <div class="d-flex align-items-center">
                                <a class="text-primary fs-15 me-3 lh-1 markallread">{{ __('Mark all as read') }}</a>
                            </div>
                        </div>
                        <div class="noti-content">
                            <div class="d-flex flex-column" id="notification-data"
                                data-empty_info="{{ __('No New Notification Found') }}">
                            </div>
                        </div>
                        <div class="d-flex p-0 notification-footer-btn">
                            <a href="#" class="btn btn-light rounded  me-2 cancel cancelnotify">{{ __('Cancel') }}</a>
                            <a href="{{route('user.notification')}}"
                                class="btn btn-dark rounded viewall ">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
                <div class="provider-head-links">
                </div>
                <div class="dropdown" style="position: relative;">
                    <a href="#!" data-bs-toggle="dropdown" aria-expanded="false" class="">
                        <div class="booking-user d-flex align-items-center">
                            <span class="user-img">
                                @if (!empty(Auth::user()->userDetails->profile_image) &&
                                file_exists(public_path('storage/profile/' . Auth::user()->userDetails->profile_image)))
                                <img src="{{ optional(Auth::user()->userDetails)->profile_image ? asset('storage/profile/' . Auth::user()->userDetails->profile_image) : asset('assets/img/profile-default.png') }}"
                                    class="headerProfileImg" alt="user">
                                @else
                                <img src="{{ asset('assets/img/profile-default.png') }}" alt="Default Profile Image"
                                    class="img-fluid rounded-circle headerProfileImg">
                                @endif
                            </span>
                        </div>
                    </a>
                    @php
                    $dashboardRoute = route('provider.dashboard');
                    $profileRoute = route('provider.profile');

                    if (Auth::user()->user_type == 3) {
                    $dashboardRoute = route('user.dashboard');
                    } elseif (Auth::user()->user_type == 4) {
                    $dashboardRoute = route('staff.dashboard');
                    }
                    @endphp
                    <ul class="dropdown-menu p-2 " style="position: absolute; left: -7rem;">
                        @if(isset($permission) && Auth::user()->user_type == 4)
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ $dashboardRoute }}">
                                <i class="ti ti-layout-grid me-1"></i>{{ __('Dashboard') }}</a>
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('provider.profile') }}"><i
                                    class="ti ti-user me-1"></i>{{ __('My Profile') }}</a></li>
                        @else
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ $dashboardRoute }}">
                                <i class="ti ti-layout-grid me-1"></i>{{ __('Dashboard') }}</a>
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ (Auth::user()->user_type == 3) ? route('user.profile') : route('provider.profile') }}"><i
                                    class="ti ti-user me-1"></i>{{ __('My Profile') }}</a></li>
                        @endif
                        <li><a class="dropdown-item d-flex align-items-center logoutUser"
                                href="{{ route('logout') }}"><i class="ti ti-logout me-1"></i>{{ __('Logout') }}</a>
                        </li>
                    </ul>
                </div>
                @else

            </div>
            <ul class="nav header-navbar-rht">
                <li class="nav-item pe-1">
                    <a class="nav-link btn btn-light" href="#" data-bs-toggle="modal" data-bs-target="#login-modal"><i
                            class="ti ti-lock me-2"></i>{{ __('Signin') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-linear-primary" href="#" data-bs-toggle="modal"
                        data-bs-target="#register-modal"><i class="ti ti-user-filled me-2"></i>{{ __('Join us') }}</a>
                </li>
            </ul>
            @endif
        </nav>
    </div>
</header>
<!-- /Header -->