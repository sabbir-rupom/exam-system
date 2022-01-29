<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/') }}" class="logo">
                    <img class="img-fluid" src="{{ URL::asset('/assets/images/logo.png') }}"
                        style="max-width: 100px">
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">
            <div class="topnav mt-0">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('user/home') }}" role="button">
                                        <span key="t-dashboard">@lang('translation.topbar_home')</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                                        <span key="t-quiz_exams">Quiz Exams</span>
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-item" key="t-questions">
                                                @lang('translation.Questions')
                                            </a>
                                        </div>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-item" key="t-quizzes">
                                                @lang('translation.topbar_quizzes')
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    @switch(Session::get('lang'))
                        @case('bn')
                            <img src="{{ URL::asset('/assets/images/flags/bn.jpg') }}" alt="Header Language" height="16">
                            <span class="align-middle ms-1">Bn</span>
                        @break
                        @default
                            <img src="{{ URL::asset('/assets/images/flags/en.jpg') }}" alt="Header Language" height="16"> <span
                                class="align-middle ms-1">En</span>
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <form method="post" action="{{ url('/switch-language') }}">
                        @csrf
                        <input type="hidden" name="lang" value="bn">
                        <button type="submit" class="dropdown-item notify-item language">
                            <img src="{{ URL::asset('/assets/images/flags/bn.jpg') }}" alt="lang-image"
                                class="me-1" height="12"> <span class="align-middle">Bengali</span>
                        </button>
                    </form>
                    <form method="post" action="{{ url('/switch-language') }}">
                        @csrf
                        <input type="hidden" name="lang" value="en">
                        <button type="submit" class="dropdown-item notify-item language">
                            <img src="{{ URL::asset('/assets/images/flags/en.jpg') }}" alt="lang-image"
                                class="me-1" height="12"> <span class="align-middle">English</span>
                        </button>
                    </form>

                </div>
            </div>
            @auth
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                            src="{{ auth() && auth()->user()->photo ? storage_url(auth()->user()->photo) : asset('/assets/images/users/avatar-1.jpg') }}"
                            alt="Header Avatar">
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span
                                key="t-profile">@lang('translation.topbar_profile')</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                key="t-logout">@lang('translation.topbar_logout')</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth

        </div>
    </div>
</header>
