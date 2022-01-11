@extends('layouts.master-without-nav')

@section('title')
@lang('translation.email_verification_required')
@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')
    <div class="account-pages">
        <div class="text-center auth-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}">
            </a>
        </div>
        <div class="container-fluid form-container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-view pt-3 text-center">
                        @include('layouts.default-message')

                        @if(session()->has('mail-failure') && session()->get('mail-failure') > 0)
                        <div class="form-title mb-2">
                            <h3 class="text-strong">@lang('translation.registration_success')</h3>
                            <div class="text-muted small-text">
                                @lang('translation.an_error_occured')
                            </div>
                        </div>
                        @else
                        <img class="img-fluid w-100" src="{{ asset('assets/images/email-sent.png') }}">
                        <h3 class="text-strong">@lang('translation.check_your_email')</h3>
                        <div class="text-strong">
                            @lang('translation.email_sent') 
                            <i>@lang('translation.activation_link')</i>
                        </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    @endsection