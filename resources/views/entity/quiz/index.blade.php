@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Groups @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('pageTitle') Quizzes @endslot
    @endcomponent

    <div class="container">
        <div class="row">
            @include('layouts.default-message')
            <div class="table-responsive my-3">
                <a class="btn btn-success mb-3" href="{{ route('quizzes.create') }}">Add New</a>
                @if ($quizzes->isEmpty())
                    <p class="text-muted mb-0">
                        Sorry you have not owned any quiz!
                        Create your first <a href="{{ route('quizzes.create') }}">quiz here</a>
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
                            @foreach ($quizzes as $quiz)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $quiz->name }}</td>
                                    <td>{{ $quiz->duration }} minutes</td>
                                    <td>{{ $quiz->pass_mark . '%' }}</td>
                                    <td>{{ $quiz->question_amount }}</td>
                                    <td>{{ $quiz->status > 0 ? 'Active' : 'In-active' }}</td>
                                    <td class="text-center">
                                        {{-- <button type="button" class="btn btn-success btn-sm btn-copy"
                                            data-copy={{ get_exam_link($quiz) }} }}>
                                            copy exam link
                                        </button> --}}
                                        <a class="btn btn-sm btn-primary btn-sm me-1" title="edit this item"
                                            href="{{ route('quizzes.edit', $quiz) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="post" class="d-inline"
                                            action="{{ route('quizzes.destroy', $quiz) }}">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-danger delete-confirm action-form" type="button"
                                                data-title="Are you sure?"
                                                data-text="This quiz will be deleted. Do you wish to proceed?"
                                                data-confirm_text="Yes, Delete">
                                                <i class="fas fa-minus"></i>
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
