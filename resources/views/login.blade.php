@extends('layouts.master-without-nav')
@section('title') DikkhaLMS: An eLearning Platform @endsection

@section('body')

    <body class="m-0 p-0 vh-100">

    @endsection

    @section('content')

        @include('layouts.default-message')

        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="my-auto">
                <h4 class="text-muted text-center mb-4">Sign in to continue</h4>
                <form id="loginForm" class="form-horizontal auth-home" method="POST" action="">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text label">Domain</span>
                        <input type="text" class="form-control" id="inputDomain" name="domain" required>
                        <span class="input-group-text">.{{ config('app.short_url') }}</span>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text label">Email</span>
                        <input name="email" type="email" class="form-control" placeholder="eg. user@smaple.com" required>
                    </div>
                    <div class="input-group mb-3 auth-pass-inputgroup">
                        <span class="input-group-text label">Password</span>
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                            aria-label="Password" aria-describedby="password-addon">
                        <button class="btn btn-light " type="button" id="password-addon"><i
                                class="mdi mdi-eye-outline"></i></button>
                    </div>

                    <div class="mt-3 d-flex justify-content-center ">
                        <button class="btn btn-primary btn-lg waves-effect waves-light" type="button" onclick="submitForm();">Log In</button>
                        <input type="hidden" id="submitUrl" value="{{ isset($url) ? $url : url('login') }}">
                    </div>

                </form>
            </div>
        </div>
    @endsection

    @section('script-bottom')

        <script>
            function submitForm() {
                let actionUrl = $('#submitUrl').val(), domain = $('#inputDomain').val();

                if(actionUrl.indexOf('{domain}') !== -1) {
                    actionUrl = actionUrl.replace('{domain}',domain);
                }

                $('#loginForm').attr('action', actionUrl).submit();

            }
        </script>

    @endsection
