@extends('layouts.master-user')

@section('title') Dashboard @endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.default-message')

            @admin
                @include('user.dashboard.admin')
            @else
                @include('user.dashboard.teacher')
            @endadmin

        </div>
    </div>

</div>

@endsection
