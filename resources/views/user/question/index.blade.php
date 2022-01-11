@extends('layouts.master-user')

@section('title') @lang('translation.question_list') @endsection

@section('content')

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-9 offset-md-1">

            @component('components.breadcrumb')
            @slot('breadTitle') @lang('translation.exam_settings') @endslot
            @slot('title') @lang('translation.Questions') @endslot
            @slot('subtitle') @lang('translation.question_list') @endslot
            @slot('actionBtn')
            <a class="text-right btn btn-success waves-effect waves-light" href="{{ route('exam.question.create') }}">+
                @lang('translation.button_create_new')</a>
            @endslot
            @endcomponent

            @include('layouts.default-message')

            <div class="table-responsive">
                @if ($questions->isEmpty())
                <p class="text-muted mb-0">
                    @lang('translation.not_owned_question') <a
                        href="{{ route('exam.question.create') }}">@lang('translation.here')</a>
                </p>
                @else

                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>@lang('translation.question')</th>
                            <th>@lang('translation.difficulty')</th>
                            <th>@lang('translation.course')</th>
                            <th>@lang('translation.question_type')</th>
                            <th class="text-center">@lang('translation.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $ques)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ques->name }}</td>
                            <td>{{ \App\Models\Question::DIFFICULTIES[$ques->difficulty] }}</td>
                            <td>{{ $ques->category == 1 ? $ques->course_title : '' }}</td>
                            <td>{{ $questionTypes[$ques->question_type] }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-default btn-sm me-1 action-view"
                                    data-url="/ajax/question/view/{{ $ques->id }}" data-modal="#modal--questionView"
                                    data-target="#modal--questionView .modal-body">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <a class="btn btn-primary btn-sm me-1" href="{{ route('exam.question.edit', $ques) }}">
                                    <i class="fas fa-edit"></i> @lang('translation.button_edit')
                                </a>
                                <form method="post" class="d-inline" action="{{ route('exam.question.edit', $ques) }}">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm icon rounded-circle" type="button"
                                        data-title="@lang('translation.are_you_sure')"
                                        data-text="@lang('translation.warning_quiz_deleted')"
                                        data-confirm_text="@lang('translation.button_yes_delete')"
                                        data-cancel_text="@lang('translation.button_yes_delete')"
                                        onclick="sweetConfirmSubmit(this)">
                                        <i class="far fa-times-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {!! $questions->links() !!}
                </div>

                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal--questionView" tabindex="-1" aria-labelledby="label--questionView" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body"></div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary ml-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
