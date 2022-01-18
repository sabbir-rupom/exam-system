@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Questions @endslot
        @slot('breadSubLink') {{ route('questions.index') }} @endslot
        @slot('pageTitle') Edit Question @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Edit Form</h4>

            <form action="{{ route('questions.update', $ques) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3 row">
                    <label for="input--name" class="col-md-2 col-form-label text-end">
                        Question Type <sup class="text-danger">*</sup>
                    </label>
                    <div class="col-md-10">
                        @foreach ($questionTypes as $k => $v)
                            <div class="form-check form-radio-primary form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="question_type" value="{{ $k }}"
                                    {{ $k == $ques->question_type ? 'checked="true"' : '' }}
                                    data-target="#block--optionPanel" data-label-text="{{ $v }}"
                                    data-label-target="#fieldLabel--questionType">
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
                    {{-- <label for="select--group" class="col-md-2 col-form-label text-end">
                        Group
                    </label>
                    <div class="col-md-2">
                        <select class="form-select" id="select--group" name="group" aria-label="Course select">
                            <option selected value="">--</option>
                            @foreach ($groups as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <label for="select--difficulty" class="col-md-2 col-form-label text-end">
                        Difficulty Level
                    </label>
                    <div class="col-md-2">
                        <select class="form-select" name="difficulty" id="select--difficulty"
                            aria-label="Difficulty Level">
                            @foreach (\App\Models\Question\Question::DIFFICULTIES as $k => $v)
                                <option value="{{ $k }}" {{ $ques->difficulty == $k ? 'selected' : '' }}>
                                    {{ $v }}</option>
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

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-4 row" id="toggle--question_detail">
                    <label for="input--question_detail" class="col-md-2 col-form-label text-end">
                        Question Full
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
                            (<span id="fieldLabel--questionType">Single Choice</span>)
                        </legend>

                        <div class="q-option-block">
                            @php $counter = 1; @endphp
                            @if (in_array($ques->question_type, [\App\Models\Question\Question::TYPE_SINGLE, \App\Models\Question\Question::TYPE_MULTIPLE]))
                                @foreach ($options as $item)
                                    <div class="row mb-3" data-index="{{ $counter }}">
                                        <label class="col-sm-2 col-form-label text-end">
                                            Option #<span class="counter">{{ $counter }}</span>
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" required
                                                placeholder="enter option detail" name="option[id_{{ $item['id'] }}]"
                                                value="{{ $item['content'] }}">
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check form-check-right mt-2">
                                                <input class="form-check-input checkbox-array" data-input="answer"
                                                    type="checkbox" {{ $item['answer'] ? 'checked="true"' : '' }}>
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
                                                data-url="{{ route('ajax.entity.delete') }}" data-parent=".row"
                                                data-param="{{ json_encode([
                                                    '_method' => 'delete',
                                                    'entity' => 'question',
                                                    'type' => 'option',
                                                    'question_id' => $ques->id,
                                                    'option_id' => $item['id'],
                                                ]) }}">Delete</button>
                                        </div>
                                        @php $counter++; @endphp
                                    </div>
                                @endforeach

                            @elseif ($ques->question_type == \App\Models\Question\Question::TYPE_FILL_GAP)
                                @foreach ($options as $item)
                                    <div class="row mb-3" data-index="{{ $counter }}">
                                        <label class="col-sm-2 col-form-label text-end">
                                            Answer #<span class="counter">{{ $counter }}</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" required
                                                placeholder="enter option detail" name="option[id_{{ $item['id'] }}]"
                                                value="{{ $item['content'] }}">
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-danger btn-sm delete-confirm"
                                                data-url="{{ route('ajax.entity.delete') }}" data-parent=".row"
                                                data-param="{{ json_encode([
                                                    '_method' => 'delete',
                                                    'entity' => 'question',
                                                    'type' => 'option',
                                                    'question_id' => $ques->id,
                                                    'option_id' => $item['id'],
                                                ]) }}">Delete</button>
                                        </div>
                                        @php $counter++; @endphp
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div id="block--optionPanel" class="q-option-block">
                            @if (in_array($ques->question_type, [\App\Models\Question\Question::TYPE_SINGLE, \App\Models\Question\Question::TYPE_MULTIPLE]))
                                @include('components.form.question-multiple-choice', ['type' => $ques->question_type])
                            @elseif ($ques->question_type == \App\Models\Question\Question::TYPE_FILL_GAP)
                                @include('components.form.question-fill-gap')
                            @elseif ($ques->question_type == \App\Models\Question\Question::TYPE_TEXT_SHORT)
                                @include('components.form.question-text-answer', ['text' => 'short'])
                            @elseif ($ques->question_type == \App\Models\Question\Question::TYPE_TEXT_BROAD)
                                @include('components.form.question-text-answer', ['text' => 'long'])
                            @endif
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

@endsection

@section('script')
    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/question-builder.init.js') }}"></script>
@endsection
