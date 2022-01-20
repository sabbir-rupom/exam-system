@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Groups @endslot
        @slot('breadSubLink') {{ route('groups.index') }} @endslot
        @slot('pageTitle') Edit Group @endslot
    @endcomponent


    <div class="card">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Edit Form</h4>

            <form action="{{ route('groups.update', $group) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3 row"">
                    <label for=" input--group_name" class="col-md-2 col-form-label text-end">
                    Group Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-10">
                        <input type="text" required class="form-control" name="name" value="{{ $group->name }}"
                            placeholder="Enter text here">

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row"">
                    <label for=" input--group_slug" class="col-md-2 col-form-label text-end">
                    Slug <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-10">
                        <input type="text" required class="form-control" name="slug" value="{{ $group->slug }}"
                            placeholder="Enter short code">

                        @error('slug')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-lg mt-3">Update</button>
                </div>

            </form>
        </div>
    </div>

@endsection
