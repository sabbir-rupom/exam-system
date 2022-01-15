@extends('layouts.master-without-nav')
@section('title') @lang('auth.login') @endsection

@section('body')

    <body class="auth-body-bg home-page">
    @endsection

    @section('content')
        <div class="account-pages">
            <div class="container-fluid form-container">
                <div class="row g-0">
                    <div class="col-md-4 offset-md-4">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-5">
                                        <a href="{{ url('/') }}" class="d-block auth-logo text-center">
                                            <img src="{{ URL::asset('/assets/images/logo.png') }}" alt=""
                                                class="img-fluid w-25">
                                        </a>

                                        @include('layouts.default-message')
                                    </div>
                                    <div class="my-auto">
                                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Email Address</label>
                                                <input name="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', '') }}" id="username"
                                                    placeholder="Enter Email" autocomplete="email" autofocus>
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
                                                <div
                                                    class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                    <input type="password" name="password"
                                                        class="form-control  @error('password') is-invalid @enderror"
                                                        id="userpassword" value="" placeholder="Enter password"
                                                        aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light " type="button" id="password-addon"><i
                                                            class="mdi mdi-eye-outline"></i></button>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                                    In</button>
                                            </div>

                                        </form>
                                    </div>

                                    <div class="mt-4 mt-md-5 text-center">
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Dikkha Quiz</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endsection
