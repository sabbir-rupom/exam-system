@extends('layouts.master-user')

@section('title') Quiz Create @endsection

@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row pt-4 pb-4">
    <div class="col-md-9 offset-md-2">

        @include('layouts.default-message')

        @component('components.breadcrumb')
        @slot('breadTitle') Exam @endslot
        @slot('title') Quizzes @endslot
        @slot('subtitle') New Quiz @endslot
        @endcomponent

        <div class="card border">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Create Form</h4>

                <form action="{{ route('quiz.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="input--name">Quiz Title</label>
                        <input type="text" class="form-control" id="input--name" placeholder="Enter quiz title"
                            value="{{ old('name', '') }}" autofocus required name="name">

                        @error('name')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--question_amount">Number of Question</label>
                                <input type="number" min="2" max="100" class="form-control" id="input--question_amount"
                                    required name="question_amount" placeholder="enter question amount in numbers"
                                    value="{{ old('question_amount', 2) }}">

                                @error('question_amount')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--duration" data-toggle="tooltip" data-placement="top"
                                    title="Number must be between 0 & 200">
                                    Quiz Duration (in minutes)
                                </label>
                                <input type="number" min="0" max="200" class="form-control" id="input--duration"
                                    required placeholder="enter a number" value="{{ old('duration', '') }}"
                                    name="duration">

                                @error('duration')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--pass_mark" data-toggle="tooltip" data-placement="top"
                                    title="Number must be between 0 & 100">Passing Marks (%)</label>
                                <input type="number" min="0" max="100" class="form-control" id="input--pass_mark"
                                    required placeholder="enter a number" value="{{ old('pass_mark', 0) }}"
                                    name="pass_mark">

                                @error('pass_mark')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-inline-flex mt-4">
                                <span>
                                    <label class="mt-1">Active ?</label>
                                </span>
                                <span>
                                    <input type="checkbox" id="input--status" name="status" switch="bool" checked=""
                                        value="1">
                                    <label class="ms-2" for="input--status" data-on-label="Yes"
                                        data-off-label="No"></label>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="select--questions">Questions</label>
                        <select class="form-select select2" id="select--questions" name="questions[]"
                            aria-label="Select questions" multiple>
                            @if ($questions)
                            @foreach ($questions as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            @endif
                        </select>

                        @error('questions')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
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

@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
@endsection
