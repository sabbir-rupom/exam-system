<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | Dikkha</title>
        <meta content="{{ isset($pagemeta['title']) ? $pagemeta['title'] : 'Test your skills online through Quizzes' }}"
            name="description" />
        <meta content="{{ isset($pagemeta['author']) ? $pagemeta['author'] : 'Dikkha' }}" name="author" />
        <meta property="og:title" content="{{ isset($pagemeta['title']) ? $pagemeta['title'] : 'Dikkha Quiz' }}" />
        <meta property="og:description" content="{{ isset($pagemeta['description']) ? $pagemeta['description'] : 'Test your skills online through Quizzes' }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ isset($pagemeta['url']) ? $pagemeta['url'] : url('/') }}" />
        <meta property="og:image" content="{{ isset($pagemeta['image']) ? $pagemeta['image'] : url('/assets/images/quiz-index.jpg') }}" />
        <meta name="twitter:title" content="{{ isset($pagemeta['title']) ? $pagemeta['title'] : 'Dikkha Quiz' }}">
        <meta name="twitter:description" content="{{ isset($pagemeta['description']) ? $pagemeta['description'] : 'Test your skills online through Quizzes' }}">
        <meta name="twitter:image" content="{{ isset($pagemeta['image']) ? $pagemeta['image'] : url('/assets/images/quiz-index.jpg') }}">
        <meta name="twitter:card" content="app">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @include('layouts.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('layouts.app-scripts')
    <input type="hidden" id="base_url" value="{{ url('/') }}">
    </body>
</html>
