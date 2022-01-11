<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>
        @hasSection('title')
            @yield('title')
        @else
            Dikkha LMS
        @endif
    </title>

    @hasSection('head_meta')
        @yield('head_meta')
    @else
        <meta
            content="{{ isset($pagemeta['description']) ? $pagemeta['description'] : 'Test your skills online through Quizzes' }}"
            name="description" />
        <meta content="{{ isset($pagemeta['author']) ? $pagemeta['author'] : 'Dikkha' }}" name="author" />
        <meta property="og:title" content="{{ isset($pagemeta['title']) ? $pagemeta['title'] : 'Dikkha Quiz' }}" />
        <meta property="og:description"
            content="{{ isset($pagemeta['description']) ? $pagemeta['description'] : 'Test your skills online through Quizzes' }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ isset($pagemeta['url']) ? $pagemeta['url'] : url('/') }}" />
        <meta property="og:image"
            content="{{ isset($pagemeta['image']) ? $pagemeta['image'] : url('/assets/images/quiz-index.jpg') }}" />
        <meta name="twitter:title" content="{{ isset($pagemeta['title']) ? $pagemeta['title'] : 'Dikkha Quiz' }}">
        <meta name="twitter:description"
            content="{{ isset($pagemeta['description']) ? $pagemeta['description'] : 'Test your skills online through Quizzes' }}">
        <meta name="twitter:image"
            content="{{ isset($pagemeta['image']) ? $pagemeta['image'] : url('/assets/images/quiz-index.jpg') }}">
        <meta name="twitter:card" content="app">
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
