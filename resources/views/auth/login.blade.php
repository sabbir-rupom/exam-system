@extends('layouts.master-without-nav')
@section('title') @lang('auth.login') @endsection

@section('body')

    <body class="auth-body-bg home-page">
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
                    <div class="col-md-4 offset-md-4">
                        @include('layouts.default-message')
                        <div class="p-md-5 p-4">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Email Address</label>
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', '') }}" id="username" placeholder="Enter Email"
                                        autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    {{-- <div class="float-end">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}"
                                                                class="text-muted">Forgot password?</a>
                                                        @endif
                                                    </div> --}}
                                    <label class="form-label">Password</label>
                                    <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                        <input type="password" name="password"
                                            class="form-control  @error('password') is-invalid @enderror" id="userpassword"
                                            value="" placeholder="Enter password" aria-label="Password"
                                            aria-describedby="password-addon">
                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="my-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                        In</button>
                                </div>

                                <div class="text-center">
                                    Don't have an account ?
                                    <a href="{{ url('register') }}" class="fw-medium text-primary"> Signup now </a>
                                </div>
                            </form>
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
