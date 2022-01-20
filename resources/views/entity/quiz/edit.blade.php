@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Quizzes @endslot
        @slot('breadSubLink') {{ route('quizzes.index') }} @endslot
        @slot('pageTitle') Edit Quiz @endslot
    @endcomponent


    <div class="card">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Edit Form</h4>

            <form action="{{ route('quizzes.update', $quiz) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group mb-3">
                    <label for="input--name">Quiz Title</label>
                    <input type="text" class="form-control" id="input--name" placeholder="Enter quiz title"
                        value="{{ $quiz->name }}" autofocus required name="name">

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
                                value="{{ $quiz->question_amount }}">

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
                            <input type="number" min="0" max="200" class="form-control" id="input--duration" required
                                placeholder="enter a number" value="{{ $quiz->duration }}" name="duration">

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
                            <input type="number" min="0" max="100" class="form-control" id="input--pass_mark" required
                                placeholder="enter a number" value="{{ $quiz->pass_mark }}" name="pass_mark">

                            @error('pass_mark')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-inline-flex mt-4">
                            <div class="form-check pt-3">
                                <input class="form-check-input" type="checkbox" id="input--status"
                                    value="1" name="status" {{ $quiz->status > 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="input--status">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="select--questions" class="d-block">
                        Questions
                        <button type="button" class="btn btn-sm btn-success float-end mt-n2" data-bs-toggle="modal"
                            data-bs-target="#modal--newQuestion">
                            + Add New
                        </button>
                    </label>
                    <select class="form-select select2" id="select--questions" name="questions[]"
                        aria-label="Select questions" multiple>
                        @php
                            if ($questions) {
                                foreach ($questions as $item) {
                                    $ss = '';
                                    if (array_key_exists($item->id, $quizQuestions)) {
                                        $ss = 'selected';
                                        unset($quizQuestions[$item->id]);
                                    }
                                    echo '<option ' . $ss . ' value="' . $item->id . '">' . $item->name . '</option>';
                                }
                            }
                            if (!empty($quizQuestions)) {
                                foreach ($quizQuestions as $key => $value) {
                                    echo '<option seelcted value="' . $key . '">' . $value . '</option>';
                                }
                            }
                        @endphp
                    </select>

                    @error('questions')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-lg mt-3">Update</button>
                    <input type="submit" class="btn btn-warning btn-lg ms-2 mt-3" name="question_paper" value="Set Question Paper">
                </div>

            </form>
        </div>
    </div>

    <div class="modal fade" id="modal--newQuestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modal--label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal--label">New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('components.form.question-full')
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
@endsection
