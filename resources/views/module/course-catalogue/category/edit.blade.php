@extends('layouts.master-user')

@section('title') Category @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Category @endslot
        @slot('breadSubLink') {{ route('entity.category.index') }} @endslot
        @slot('pageTitle') Edit @endslot
    @endcomponent

    <div class="card py-4">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Edit Form</h4>

            <form action="{{ route('entity.category.update', $category) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3 row">
                    <label for="input--name" class="col-md-3 col-form-label text-end">
                        Category Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-8">
                        <input type="text" required class="form-control" name="name" value="{{ $category->name }}"
                            placeholder="Enter text here" id="input--name">

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input--code" class="col-md-3 col-form-label text-end">
                        Code <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-8">
                        <input type="text" required class="form-control" name="code" value="{{ $category->code }}"
                            placeholder="Enter unique code" id="input--code">

                        @error('code')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input--detail" class="col-md-3 col-form-label text-end">
                        Description
                    </label>
                    <div class="col-md-8">
                        <textarea required class="form-control" name="detail"placeholder="Enter detail text" id="input--detail">{{
                            $category->detail
                        }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-lg mt-3">Update</button>
                </div>

            </form>
        </div>
    </div>

@endsection
