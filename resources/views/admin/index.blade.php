@extends('layouts.master-admin')

@section('title') Dashboard @endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="d-flex flex-column mb-3">
            <h4 class="mb-sm-0 font-size-18">
                @lang('translation.your_account_activity')
            </h4>
            <small class="text-muted mt-2">@lang('translation.dashboard')</small>
        </div>
    </div>

    @endsection
