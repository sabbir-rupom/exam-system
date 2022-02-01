@extends('layouts.master-user')

@section('title') Category @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Category @endslot
        @slot('breadLink') {{ route('entity.category.index') }} @endslot
        @slot('breadSubTitle') Class @endslot
        @slot('breadSubLink') {{ route('entity.category-class.index') }} @endslot
        @slot('pageTitle') Edit @endslot
    @endcomponent

    <div class="card py-4">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Edit Form</h4>

            <form action="{{ route('entity.category-class.update', $class) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3 row">
                    <label for="select--category" class="col-md-3 col-form-label text-end">
                        Select Category<sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-8">
                        <select class="form-select" id="select--category" name="category_id" aria-label="Select category">
                            @foreach ($categories as $item)
                                <option {{ $item->id === $class->category_id ? 'selected' : '' }} value="{{ $item->id }}">
                                    {{ $item->name }} ({{ $item->code }}) ]</option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input--name" class="col-md-3 col-form-label text-end">
                        Class Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-8">
                        <input type="text" required class="form-control" name="name" value="{{ $class->name }}"
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
                        <input type="text" required class="form-control" name="code" value="{{ $class->code }}"
                            placeholder="Enter unique code" id="input--code">

                        @error('code')
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
