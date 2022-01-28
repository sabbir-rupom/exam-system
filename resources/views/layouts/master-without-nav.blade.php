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

    @yield('body')

    @yield('content')

    @include('layouts.app-scripts')
    <input type="hidden" id="base_url" value="{{ url('/') }}">
    </body>
</html>
