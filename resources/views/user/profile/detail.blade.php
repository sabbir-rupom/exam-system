@extends('layouts.master-user')

@section('title') My Profile @endsection

@section('content')

<div class="Container-fluid row px-4 mx-4">
    <div class="mt-4 ">
        @component('components.breadcrumb')
        @slot('breadTitle') User @endslot
        @slot('title') Profile @endslot
        @slot('subtitle') My Profile @endslot
        @endcomponent
    </div>

    @include('layouts.default-message')

    <div class="card">
        <div class="card-body">

            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $passwordChange ? '' : 'active' }}" data-bs-toggle="tab" href="#section--basic_profile" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                        <span class="d-none d-sm-block">Basic Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $passwordChange ? 'active' : '' }}" data-bs-toggle="tab" href="#section--change_password" role="tab">
                        <span class="d-block d-sm-none"><i class="bx bxs-key"></i></span>
                        <span class="d-none d-sm-block">Change Password</span>
                    </a>
                </li>
            </ul>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane {{ $passwordChange ? '' : 'active' }}" id="section--basic_profile" role="tabpanel">
                                @include('user.profile.edit-basic-info')
                            </div>
                            <div class="tab-pane {{ $passwordChange ? 'active' : '' }}" id="section--change_password" role="tabpanel">
                                @include('user.profile.change-password')
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

@endsection
