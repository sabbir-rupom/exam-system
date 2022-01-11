@extends('layouts.master-without-nav')

@section('title') @lang('auth.registration') @endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')
    <div class="account-pages">
        <div class="text-center auth-logo py-3">
            <a href="{{ url('/') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" style="max-width: 100px">
            </a>
        </div>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-view">
                        <div class="form-title text-center">
                            <h3 class="text-strong">@lang('auth.registration')</h3>
                            <div class="text-muted small-text">Please Fill Your Details</div>
                        </div>
                        @include('layouts.default-message')
                        <form class="needs-validation mt-4" action="{{ route('register') }}" id="form--signUp"
                            method="post">
                            @csrf
                            <hr>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-information-variant"></i></span>
                                    <input type="text" class="form-control" placeholder="@lang('auth.placeholder_firstname')" autocomplete="off"
                                        aria-label="Firstname" name="firstname" required value="{{ old('firstname') }}">
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
                                    <input type="email" class="form-control" placeholder="@lang('auth.placeholder_email')"
                                        aria-label="Email" name="email" required autocomplete="off"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" placeholder="@lang('auth.placeholder_username')" autocomplete="off"
                                        aria-label="Username" name="username" required value="{{ old('username') }}">
                                </div>
                                @error('username')
                                <div class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                    <input type="text" class="form-control" placeholder="Enter phone: 01*********"
                                        aria-label="Mobile Phone " name="phone" required autocomplete="off"
                                        value="{{ old('phone') }}">
                                </div>
                                @error('phone')
                                <div class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="input-group auth-pass-inputgroup">
                                    <span class="input-group-text"><i class="mdi mdi-key"></i></span>
                                    <input type="password" class="form-control" placeholder="@lang('auth.placeholder_password')"
                                        aria-label="Password" aria-describedby="password-addon" name="password"
                                        id="password" required>
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
                                    <input type="password" class="form-control" placeholder="@lang('auth.placeholder_confirm_password')"
                                        aria-label="Confirm Password" required id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                                @error('password_confirmation')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-3 d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-success waves-effect waves-light" type="submit">
                                         @lang('auth.button_register')
                                    </button>
                                </div>
                                <div class="pt-3">
                                    @lang('auth.have_account')
                                    <a class="ps-1" href="{{ url('login') }}"> @lang('auth.login')</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 mt-md-5 text-center">
        <script>
            document.write(new Date().getFullYear())
        </script> Dikkha Quiz</p>
    </div>

    @endsection

    @section('script')
    <script src="{{ URL::asset('assets/libs/jquery-validation/jquery-validation.min.js')}}"></script>
    <!-- validation init -->
    <script src="{{ URL::asset('/assets/js/pages/validation.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/auth.init.js') }}"></script>
    @endsection
