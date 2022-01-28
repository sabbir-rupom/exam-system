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

    <body data-layout="horizontal">
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.user-topbar')
        {{-- @include('layouts.user-sidebar') --}}
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content app-page">
                <!-- Start content -->
                @yield('content')
                <!-- content -->
            </div>
            @include('layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- END Right Sidebar -->

    @include('layouts.app-scripts')
</body>

</html>
