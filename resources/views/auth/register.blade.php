@extends('layouts.master-without-nav')

@section('title') @lang('auth.registration') @endsection

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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 form-view">
                        <div class="p-md-5 p-4">
                            <div class="form-title text-center">
                                <h3 class="text-strong">Create Your Account</h3>
                                {{-- <div class="text-muted small-text">Please Fill Your Details</div> --}}
                            </div>
                            @include('layouts.default-message')
                            <form class="needs-validation mt-4" action="{{ route('register') }}" id="form--signUp"
                                method="post">
                                @csrf
                                <hr>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-information-variant"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="@lang('auth.placeholder_firstname')" autocomplete="off"
                                            aria-label="Firstname" name="firstname" required
                                            value="{{ old('firstname') }}">
                                        <input type="text" class="form-control left-border" placeholder="Lastname"
                                            autocomplete="off" aria-label="Lastname" name="lastname"
                                            value="{{ old('lastname') }}">
                                    </div>
                                    @error('firstname')
                                        <div class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                        <input type="email" class="form-control"
                                            placeholder="@lang('auth.placeholder_email')" aria-label="Email" name="email"
                                            required autocomplete="off" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group auth-pass-inputgroup">
                                        <span class="input-group-text"><i class="mdi mdi-key"></i></span>
                                        <input type="password" class="form-control"
                                            placeholder="@lang('auth.placeholder_password')" aria-label="Password"
                                            aria-describedby="password-addon" name="password" id="password" required>
                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-key-minus"></i></span>
                                        <input type="password" class="form-control"
                                            placeholder="@lang('auth.placeholder_confirm_password')"
                                            aria-label="Confirm Password" required id="password_confirmation"
                                            name="password_confirmation">
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="my-4 d-grid">
                                    <button class="btn btn-success waves-effect waves-light" type="submit">
                                        @lang('auth.button_register')
                                    </button>
                                </div>
                            </form>

                            <div class="text-center">
                                @lang('auth.have_account')
                                <a class="ps-1" href="{{ url('login') }}"> @lang('auth.login')</a>
                            </div>
                        </div>
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
