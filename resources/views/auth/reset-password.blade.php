@extends('layouts.master-without-nav')

@section('title')
Reset Account Password
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

                            <div class="form-title mb-2">
                                <h3 class="text-strong">Change Password!</h3>
                                <div class="text-muted small-text">
                                    Please fill up the following fields:
                                </div>
                                <hr>
                                <form method="POST" action="{{ route('user.password.reset') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="mb-3">
                                        <div class="input-group auth-pass-inputgroup">
                                            <span class="input-group-text"><i class="mdi mdi-key"></i></span>
                                            <input type="password" class="form-control" placeholder="Password"
                                                aria-label="Password" aria-describedby="password-addon" name="password"
                                                id="password" required>
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-key-minus"></i></span>
                                            <input type="password" class="form-control" placeholder="Confirm Password"
                                                aria-label="Confirm Password" required id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                        @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3 d-flex">
                                        <button class="btn-theme waves-effect waves-light" type="submit">
                                            Reset Password
                                        </button>
                                        <input type="hidden" name="data" value="{{ $data }}">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                    </div>
                                    @error('id')
                                    <div class="invalid-feedback d-block">
                                        Invalid request
                                    </div>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    @endsection