<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>
        @hasSection('title') @yield('title') | @endif {{ sur_title() }}
    </title>

    @include('layouts.meta-head')

    @include('layouts.head-css')
</head>

@section('body')

    <body data-sidebar="dark">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @admin
            @include('layouts.admin-topbar')
            @include('layouts.admin-sidebar')
        @else
            @include('layouts.user-topbar')
        @endadmin

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('layouts.app-scripts')
</body>

</html>
