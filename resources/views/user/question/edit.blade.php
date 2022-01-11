@extends('layouts.master-user')

@section('title') @lang('translation.question_edit') @endsection

@section('content')

    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-md-12">

                @include('layouts.default-message')

                @component('components.breadcrumb')
                    @slot('breadTitle') @lang('translation.admin') @endslot
                    @slot('title') @lang('translation.Questions') @endslot
                    @slot('subtitle') @lang('translation.edit_question') @endslot
                @endcomponent

                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-center">@lang('translation.edit_form')</h4>

                        <form action="{{ route('exam.question.edit', $ques) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
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
                                                value="{{ $k }}"
                                                {{ $k == $ques->question_type ? 'checked="true"' : '' }}>
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
                                        @foreach (\App\Models\Question::DIFFICULTIES as $k => $v)
                                            <option value="{{ $k }}"
                                                {{ $ques->difficulty == $k ? 'selected' : '' }}>{{ $v }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('difficulty')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row"">
                                    <label for=" input--question_name" class="col-md-2 col-form-label text-end">
                                Question Title
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" value="{{ $ques->name }}"
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
                                        id="input--question_detail">{{ empty($ques->detail) ? '' : $ques->detail }}</textarea>

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

                                    <div
                                        class="q-option-block q-1 q-2 {{  question_type_match('single', $ques->question_type) || question_type_match('multiple', $ques->question_type) ? '' : 'd-none' }}">
                                        @php $counter = 1; @endphp
                                        @if (question_type_match('single', $ques->question_type) || question_type_match('multiple', $ques->question_type))
                                            @foreach ($options as $item)
                                                <div class="row mb-3" data-index="{{ $counter }}">
                                                    <label class="col-sm-2 col-form-label text-end">
                                                        Option #<span class="counter">{{ $counter }}</span>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" required
                                                            placeholder="enter option detail"
                                                            name="option[id_{{ $item['id'] }}]"
                                                            value="{{ $item['content'] }}">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check form-check-right mt-2">
                                                            <input class="form-check-input checkbox-array"
                                                                data-input="answer" type="checkbox"
                                                                {{ $item['answer'] ? 'checked="true"' : '' }}>
                                                            <input type="hidden" class="depend-input-array"
                                                                name="answer[id_{{ $item['id'] }}]"
                                                                value="{{ $item['answer'] ? 1 : '' }}">
                                                            <label class="form-check-label">
                                                                Is answer?
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-danger btn-sm delete-confirm"
                                                            data-url="{{ url('/ajax/question/option/' . $item['id']) }}"
                                                            data-parent=".row"
                                                            data-param="{{ json_encode(['_method' => 'delete', 'question_id' => $ques->id]) }}">Delete</button>
                                                    </div>
                                                    @php $counter++; @endphp
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="row option-block mb-3" data-index="{{ $counter }}">
                                            <label class="col-sm-2 col-form-label text-end">
                                                Option #<span class="counter">{{ $counter }}</span>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control not-required"
                                                    placeholder="enter option detail" name="option[]">
                                            </div>
                                            <div class="col-sm-3">
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

                                    @error('option')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="mb-3 row" id="toggle--question_explanation">
                                <label for="input--question_explanation" class="col-md-2 col-form-label text-end">
                                    Question Explanation
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control rich-text" name="explanation"
                                        id="input--question_explanation">{{ $ques->explanation }}</textarea>

                                    @error('explanation')
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
