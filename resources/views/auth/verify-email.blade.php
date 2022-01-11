@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Login')
@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')
    @include('layouts.default-message')
    <div class="account-pages my-3">
        <div class="text-center mb-2">
            <a href="{{ url('/') }}">
                <img class="auth-logo" src="{{ asset('assets/images/logo-dark.png') }}">
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <h1>Verify email</h1>

                    <p>Please verify your email address by clicking the link in the mail we just sent you. Thanks!</p>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    @endsection