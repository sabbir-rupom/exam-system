@extends('layouts.master-without-nav')
@section('title') DikkhaLMS: An eLearning Platform @endsection

@section('body')

    <body class="">

    @endsection

    @section('content')

        <div class="min-vh-100 d-flex justify-content-center">
            <div class="my-auto text-center">
                <h1> <span class="has-text-align-center has-lr-font-size d-block mb-3">The LMS</span> <span
                        class="has-text-align-center has-material-black-color has-text-color has-xxl-font-size d-block"><strong><strong>built
                                for success</strong></strong></span> </h1>
                <p class="has-text-align-center has-m-font-size">Build a smarter organization with the training platform
                    designed to help great teams grow</p>
                <div class="d-flex justify-content-center my-4">
                    <a title="Login now"
                        href="{{ app_url('login') }}"
                        class="btn btn-info btn-lg">
                        Login Now
                    </a>
                </div>
            </div>
        </div>

    @endsection
