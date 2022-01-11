@extends('layouts.master-user')

@section('title') Quiz List @endsection

@section('content')

<div class="row pt-4 pb-4">
    <div class="col-md-8 offset-md-2">

        @include('layouts.default-message')

        @component('components.breadcrumb')
        @slot('breadTitle') Exam @endslot
        @slot('title') Quizzes @endslot
        @slot('subtitle') Quiz List @endslot
        @slot('actionBtn')
        <a class="btn btn-success ms-3" href="{{ route('quiz.create') }}">Create New</a>  @endslot
        @endcomponent

        <div class="table-responsive">
            @if ($quizzes->isEmpty())
            <p class="text-muted mb-0">
                Sorry you have not owned any quiz!
                Create your first quiz <a href="{{ route('quiz.create') }}">here</a>
            </p>
            @else

            <table class="table mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Passing Mark</th>
                        <th>Question Amount</th>
                        <th>Status</th>
                        <th colspan="2" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $quiz->name }}</td>
                        <td>{{ $quiz->duration }} minutes</td>
                        <td>{{ $quiz->pass_mark . '%' }}</td>
                        <td>{{ $quiz->question_amount }}</td>
                        <td>{{ $quiz->status > 0 ? 'Active' : 'In-active' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm btn-copy" data-copy={{ quiz_exam_link($quiz) }} }}>
                                copy exam link
                            </button>
                            <a class="btn btn-sm btn-primary btn-sm me-1" title="edit this item"
                                href="{{ route('quiz.edit', $quiz) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="post" class="d-inline" action="{{ route('quiz.edit', $quiz) }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-sm btn-danger icon rounded-circle" type="button"
                                    data-title="Are you sure?"
                                    data-text="This quiz will be deleted. Do you wish to proceed?"
                                    data-confirm_text="Yes, Delete" onclick="sweetConfirmSubmit(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $quizzes->links() !!}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
