@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | User Add @endsection

@section('content')

@component('components.breadcrumb')
@slot('breadTitle') Home @endslot
@slot('pageTitle') Dashbaord @endslot
@endcomponent

@include('layouts.default-message')

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $bulk ? '' : 'active' }}" data-bs-toggle="tab" href="#single_form" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                    <span class="d-none d-sm-block">Add Single</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $bulk ? 'active' : '' }}" data-bs-toggle="tab" href="#bulk_form" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user-plus"></i></span>
                    <span class="d-none d-sm-block">Add Bulk</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane {{ $bulk ? '' : 'active' }}" id="single_form" role="tabpanel">
                @include('components.form.user-single')
            </div>
            <div class="tab-pane {{ $bulk ? 'active' : '' }}" id="bulk_form" role="tabpanel">
                @include('admin.user.student.include.bulk-form')
            </div>
        </div>
    </div>
</div>

@endsection
