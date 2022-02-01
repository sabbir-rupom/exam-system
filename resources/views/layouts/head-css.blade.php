<!-- App Icons Css -->
<link href="{{ URL::asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

@yield('css')

<!-- Bootstrap Css -->
{{-- <link href="{{ URL::asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Sweet alert2 Css -->
<link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

<!-- App Css-->
<link href="{{ URL::asset('/assets/css/theme.min.css' . '?x=' . filemtime(public_path('assets/css/theme.min.css'))) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/css/app.min.css' . '?x=' . filemtime(public_path('assets/css/app.min.css'))) }}" rel="stylesheet" type="text/css" />

@admin
<link href="{{ URL::asset('/assets/css/admin.min.css' . '?x=' . filemtime(public_path('assets/css/admin.min.css'))) }}" rel="stylesheet" type="text/css" />
@endadmin

@user
@enduser

@yield('css-bottom')
