@extends('layouts.master-without-nav')

@section('title')
Request Password Reset
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="form-container">
                        <div class="form-view pt-3">
                            @include('layouts.default-message')
    
                            @if ($email)
                            @if(session()->has('mail-failure') && session()->get('mail-failure') > 0)
                            <div class="form-title mb-2">
                                <h3 class="text-strong">Failed to send Email!</h3>
                                <div class="text-muted small-text">
                                    An error occured during mail send! Please try again later or contact our support center.
                                </div>
                            </div>
                            @else
                            <img class="img-fluid w-100" src="{{ asset('assets/images/email-sent.png') }}">
                            <h3 class="text-strong">Check Your Email</h3>
                            <div class="text-strong">
                                An email has been sent to your address!
                                Complete the process by clicking on the
                                <i>Reset Password</i>
                            </div>
                            @endif
                            @else
                            <div class="form-title mb-2">
                                <h3 class="text-strong">Reset Password!</h3>
                                <div class="text-muted small-text">
                                    An email will be sent to you for further instruction
                                </div>
                                <hr>
                                <form method="POST" action="{{ route('password.forget') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                            <input type="email" class="form-control" placeholder="Email Address"
                                                aria-label="Email" name="email" required autocomplete="off"
                                                value="{{ old('email', '') }}">
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3 d-flex">
                                        <button class="btn-theme waves-effect waves-light" type="submit">
                                            Send Now
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    @endsection