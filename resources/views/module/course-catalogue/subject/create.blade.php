@extends('layouts.master-user')

@section('title') New Subject @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Class @endslot
        @slot('breadLink') {{ route('entity.category-class.index') }} @endslot
        @slot('breadSubTitle') Subject @endslot
        @slot('breadSubLink') {{ route('entity.subject.index') }} @endslot
        @slot('pageTitle') Add @endslot
    @endcomponent

    <div class="card py-4">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Create Form</h4>

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="{{ route('entity.subject.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="select--category" class="col-md-3 col-form-label text-end">
                                Select Category<sup class="text-danger">*</sup>
                            </label>
                            <div class="col-md-8">
                                <select class="form-select" id="select--category" name="category_id" aria-label="Select category">
                                    @foreach ($categories as $k => $item)
                                        <option {{ $k === 0 ? 'selected' : '' }} value="{{ $item->id }}">
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
                            <label for="select--category" class="col-md-3 col-form-label text-end">
                                Select Class<sup class="text-danger">*</sup>
                            </label>
                            <div class="col-md-8">
                                <select class="form-select select-source" id="select--class" name="class_id"
                                    aria-label="Select class" data-target="#select--category" data-source="#data--classes">
                                    <option value="">Please Select</option>
                                </select>
                                <input type="hidden" id="data--classes" value="{{ isset($classData) ? $classData : '' }}">
                                @error('class_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="input--name" class="col-md-3 col-form-label text-end">
                                Subject Name <sup class="text-danger">*</sup>
                            </label>
                            <div class="col-md-8">
                                <input type="text" required class="form-control" name="name"
                                    value="{{ old('name', '') }}" placeholder="Enter text here" id="input--name">

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
                                <input type="text" required class="form-control" name="code"
                                    value="{{ old('code', '') }}" placeholder="Enter unique code" id="input--code">

                                @error('code')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-lg mt-3">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
