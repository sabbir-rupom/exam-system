@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Home @endsection

@section('content')

@component('components.breadcrumb')
@slot('breadTitle') Home @endslot
@slot('pageTitle') Dashbaord @endslot
@endcomponent

@include('layouts.default-message')
<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-6">
                    <div class="card dashboard-card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <div class="icon-box">
                                    <i class="bx bx-hive"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body ps-0">
                                    <div class="card-title">
                                        <a href="{{ route('questions.index') }}">Questions</a>
                                    </div>
                                    <div class="card-text">
                                        <a href="{{ route('questions.create') }}">Add Question</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="card dashboard-card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <div class="icon-box">
                                    <i class="bx bx-user"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body ps-0">
                                    <div class="card-title">
                                        <a href="{{ url('user/list') }}">Users</a>
                                    </div>
                                    <div class="card-text">
                                        <a href="{{ url('user/add') }}">Add User</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card dashboard-card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <div class="icon-box">
                                    <i class="bx bx-book"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body ps-0">
                                    <div class="card-title">
                                        <a href="{{ url('course/list') }}">Courses</a>
                                    </div>
                                    <div class="card-text">
                                        <a href="{{ url('course/add') }}">Add Course</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</div>

@endsection
