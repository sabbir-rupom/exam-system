@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | User List @endsection

@section('content')

@component('components.breadcrumb')
@slot('breadTitle') Home @endslot
@slot('pageTitle') Dashbaord @endslot
@endcomponent

@include('layouts.default-message')

<div class="card">
    <div class="card-body">
        <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ url('/user/list') }}" method="GET">
            <div class="col-12">
                <input type="text" class="form-control" name="name_key" value="{{ old('name_key') }}" placeholder="Enter name ...">
            </div>
            <div class="col-12">
                <label class="visually-hidden" for="inlineFormSelectPref">User Type</label>
                <select class="form-select" name="user_type" id="inlineFormSelectPref">
                    <option value="" {{ empty(old('user_type')) ? 'selected' : '' }}>All</option>
                    <option value="learner" {{ old('user_type') === 'learner' ? 'selected' : '' }}>Learner</option>
                    <option value="teacher" {{ old('user_type') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-md">Filter Users</button>
                <input type="submit" class="btn btn-secondary ms-2 w-md" value="Download" name="download">
                <a class="btn btn-success ms-2" href="{{ route('owner.user.add', ['userdomain' => auth()->user()->domain_now]) }}">Add New</a>
            </div>
        </form>
    </div>
    <!-- end card body -->
</div>

@endsection
