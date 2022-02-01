@extends('layouts.master-user')

@section('title') Dashboard @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Admin @endslot
        @slot('pageTitle') Dashbaord @endslot
    @endcomponent

    @include('layouts.default-message')

    <div class="">
        <h3 class="text-center">In Development</h3>

    </div>

@endsection
