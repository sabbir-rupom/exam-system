@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Questions @endslot
        @slot('pageTitle') Add Question @endslot
    @endcomponent

    @include('layouts.default-message')

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4 text-center">Create Form</h4>

        <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
                <label for="input--name" class="col-md-2 col-form-label text-end">
                    Question Type <sup class="text-danger">*</sup>
                </label>
                <div class="col-md-10">
                    @foreach ($questionTypes as $k => $v)
                    <div class="form-check form-radio-primary form-check-inline mt-2">
                        <input class="form-check-input" type="radio" name="question_type" value="{{ $k }}" {{ $k <= 1 ? 'checked="true"' : '' }} data-target="#block--optionPanel" data-label-text="{{ $v }}" data-label-target="#fieldLabel--questionType">
                        <label class="form-check-label">{{ $v }}</label>
                    </div>
                    @endforeach

                    @error('question_type')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="select--group" class="col-md-2 col-form-label text-end">
                    Group
                </label>
                <div class="col-md-2">
                    <select class="form-select" id="select--group" name="group" aria-label="Course select">
                        <option selected value="">--</option>
                        @foreach ($groups as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="select--difficulty" class="col-md-2 col-form-label text-end">
                    Difficulty Level
                </label>
                <div class="col-md-2">
                    <select class="form-select" name="difficulty" id="select--difficulty" aria-label="Difficulty Level">
                        <option selected="" value="1">Easy</option>
                        <option value="2">Medium</option>
                        <option value="3">Hard</option>
                        <option value="4">Extreme</option>
                    </select>

                    @error('difficulty')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row"">
                <label for="input--question_name" class="col-md-2 col-form-label text-end">
                    Question Title <sup class="text-danger">*</sup>
                </label>
                <div class="col-md-10">
                    <input type="text" required class="form-control" name="name" value="{{ old('name', '') }}" placeholder="Enter question title">

                    @error('name')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row" id="toggle--question_detail">
                <label for="input--question_detail" class="col-md-2 col-form-label text-end">
                    Full Question <sup class="text-danger">*</sup>
                </label>
                <div class="col-md-10">
                    <textarea class="form-control rich-text" name="detail" id="input--question_detail"></textarea>

                    @error('detail')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 block-container mt-4">
                <fieldset class="scheduler-border p-3 mb-3">
                    <legend>
                        <span>Question Options</span>
                        (<span id="fieldLabel--questionType">Single Choice</span>)
                    </legend>

                    <div id="block--optionPanel">
                        @include('components.form.question-multiple-choice', ['type' => 1])
                    </div>
                </fieldset>
            </div>

            <div class="mb-3 row" id="toggle--question_explanation">
                <label for="input--question_explanation" class="col-md-2 col-form-label text-end">
                    Question Explanation
                </label>
                <div class="col-md-10">
                    <textarea class="form-control rich-text" name="explanation" id="input--question_explanation"></textarea>

                    @error('explanation')
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

@endsection

@section('script')
<!--tinymce js-->
<script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

<!-- init js -->
<script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/question-builder.init.js') }}"></script>
@endsection
