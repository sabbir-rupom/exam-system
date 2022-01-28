@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Login')
@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')

    <div class="auth-full-page-content flex-column">
        <!-- body-top -->
        <div class="mx-auto py-4">
            <a href="{{ url('/') }}" class="d-block auth-logo text-center">
                <img src="{{ URL::asset('/assets/images/logo.png') }}" alt="" class="img-fluid">
            </a>
        </div>

        <!-- body-main -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    @include('layouts.default-message')

                    <h1>Verify email</h1>

                    <p>Please verify your email address by clicking the link in the mail we just sent you. Thanks!</p>
                </div>
            </div>
        </div>

        <!-- body-bottom -->
        <div class="mt-auto text-center">
            <script>
                document.write(new Date().getFullYear())
            </script> © {{ env('APP_NAME', 'Exam Management System') }}
        </div>
    </div>

    @endsection
