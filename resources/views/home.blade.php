@extends('layouts.master-without-nav')
@section('title') Dikkha Exam @endsection

@section('body')

    <body class="">

    @endsection

    @section('content')

        <div class="min-vh-100 d-flex justify-content-center">
            <div class="my-auto text-center">
                <h1>
                    <span class="has-text-align-center has-lr-font-size d-block mb-3">Dikkha Questions</span>
                </h1>
                <div class="d-flex justify-content-center my-4">
                    <a title="Login now"
                        href="{{ url('/login') }}"
                        class="btn btn-info btn-lg">
                        Login Now
                    </a>
                </div>
            </div>
        </div>

    @endsection
