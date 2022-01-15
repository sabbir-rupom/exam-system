@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('pageTitle') Questions @endslot
    @endcomponent

    @include('layouts.default-message')

    <div class="container">
        <div class="row">
            <div class="table-responsive my-3">
                <a class="btn btn-success mb-3" href="{{ route('questions.create') }}">Add Question</a>
                <table class="table">
                    <thead class="table-light">
                        <tr style="vertical-align: middle">
                            <th>#</th>
                            <th>Question</th>
                            <th>Group</th>
                            <th>Course</th>
                            <th>Question Type</th>
                            <th class="text-center" style="min-width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $ques)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ques->name }}</td>
                                <td>{{ empty($ques->group_name) ? '-' : $ques->group_name }}</td>
                                <td>{{ $ques->course_title }}</td>
                                <td>{{ $questionTypes[$ques->question_type] }}</td>
                                <td class="text-center">
                                    {{-- <button type="button" class="btn btn-sm btn-secondary action-view"
                                        data-url="/ajax/question/view/{{ $ques->id }}" data-modal="#modal--questionView"
                                        data-target="#modal--questionView .modal-body">
                                        <i class="fas fa-eye"></i>
                                    </button> --}}
                                    <a class="btn btn-sm btn-primary" href="{{ route('questions.edit', $ques) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="d-inline"
                                        action="{{ route('questions.delete', $ques) }}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" type="submit"
                                            onclick="if(!confirm('Are you sure to delete this question?')) return false;"><i
                                                class="fas fa-minus"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {!! $questions->links() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal--questionView" tabindex="-1" aria-labelledby="label--questionView"
        aria-hidden="true">
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
