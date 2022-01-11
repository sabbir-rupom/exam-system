@extends('layouts.master-user')

@section('title') @lang('translation.question_create') @endsection

@section('content')

    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-md-12 ms-5">

                @include('layouts.default-message')

                @component('components.breadcrumb')
                    @slot('breadTitle') @lang('translation.admin') @endslot
                    @slot('title') @lang('translation.Questions') @endslot
                    @slot('subtitle') @lang('translation.new_question') @endslot
                @endcomponent

                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-center">@lang('translation.create_form')</h4>
                        <form action="{{ route('exam.question.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label for="input--name" class="col-md-2 col-form-label text-end">
                                    Question Type <sup class="text-danger">*</sup>
                                </label>
                                <div class="col-md-6">
                                    @foreach ($questionTypes as $k => $v)
                                        <div class="form-check form-radio-primary form-check-inline mt-2">
                                            <input class="form-check-input show-hidden-block"
                                                data-target=".q-option-block.q-{{ $k }}"
                                                data-target_sibling=".q-option-block" type="radio" name="question_type"
                                                value="{{ $k }}" {{ $k == 1 ? 'checked="true"' : '' }}>
                                            <label class="form-check-label">{{ $v }}</label>
                                        </div>
                                    @endforeach

                                    @error('question_type')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="select--difficulty" class="col-md-2 col-form-label text-end">
                                    Difficulty Level
                                </label>
                                <div class="col-md-2">
                                    <select class="form-select" name="difficulty" id="select--difficulty"
                                        aria-label="Difficulty Level">
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

                            <div class="mb-3 row">
                                <label for=" input--question_name" class="col-md-2 col-form-label text-end">
                                    Question Tag
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" value="{{ old('name', '') }}"
                                        placeholder="Enter question title">

                                    <sub class="text-muted">This information will not appear during quiz exam</sub>

                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row" id="toggle--question_detail">
                                <label for="input--question_detail" class="col-md-2 col-form-label text-end">
                                    Main Question
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control rich-text" name="detail"
                                        id="input--question_detail"></textarea>

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
                                    </legend>

                                    <div class="q-option-block q-1 q-2">

                                        @for ($i = 1; $i <= 2; $i++)

                                            <div class="row option-block mb-3" data-index="{{ $i }}">
                                                <label class="col-sm-2 col-form-label text-center">
                                                    Option #<span class="counter">{{ $i }}</span>
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" required
                                                        placeholder="enter option detail" name="option[]">
                                                </div>
                                                <div class="col-sm-2 text-center">
                                                    <div class="form-check form-check-right mt-2">
                                                        <input class="form-check-input checkbox-array" data-input="answer"
                                                            type="checkbox">
                                                        <input type="hidden" class="depend-input-array" name="answer[]">
                                                        <label class="form-check-label">
                                                            Is answer?
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        @endfor
                                    </div>
                                    <div class="block-action row">
                                        <div class="col-md-10 offset-md-2">
                                            <button type="button" class="btn btn-success btn-add-more"
                                                data-target=".option-block">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-remove-more"
                                                data-target=".option-block" data-min="2">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-none q-option-block q-3">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label text-end">
                                                Option Left</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="option_left"
                                                    placeholder="Option for Left Mapping" aria-label="Option Left">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label text-end">
                                                Option Right</span>
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="option_right"
                                                    placeholder="Option for Right Mapping" aria-label="Option Right">
                                            </div>
                                        </div>
                                        @error('option')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </fieldset>

                            </div>

                            <div class="mb-3 row" id="toggle--question_explanation">
                                <label for="input--question_explanation" class="col-md-2 col-form-label text-end">
                                    Question Explanation
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control rich-text" name="explanation"
                                        id="input--question_explanation"></textarea>

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
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/quiz-builder.init.js') }}"></script>
@endsection
