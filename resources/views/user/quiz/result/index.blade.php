@extends('layouts.master-user')

@section('title') Quiz Result @endsection

@section('css')
<link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row pt-4 pb-4">
    <div class="col-md-8 offset-md-2">

        @include('layouts.default-message')

        @component('components.breadcrumb')
        @slot('breadTitle') Exam @endslot
        @slot('title') Quiz @endslot
        @slot('subtitle') Quiz Results @endslot
        @endcomponent

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title mb-4">Filter Students</h5>

                    <form class="row gy-2 gx-3 align-items-center" method="get"
                        action="{{ route('user.quizzes') }}">
                        <div class="col-sm-auto">
                            <label class="visually-hidden">Search Student</label>
                            <input type="text" class="form-control" id="input--name_key" placeholder="Enter name / email"
                            value="{{ old('name_key', '') }}" autofocus required name="name_key">
                        </div>
                        <div class="col-sm-auto">
                            <button type="submit" class="btn btn-primary w-md">Search</button>
                        </div>
                    </form>

                    <hr>
                        @if ($quizResults)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <th class="text-center">Srl #</th>
                                    <th>Quiz Name</th>
                                    <th>Student Name</th>
                                    <th class="text-center">Total Questions</th>
                                    <th class="text-center">Correct</th>
                                    <th class="text-center">Result</th>
                                    <th class="text-center">-</th>
                                </thead>
                                <tbody>
                                    @foreach ($quizResults as $i => $quiz)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ $quiz->quiz_name }}</td>
                                        <td>{{ $quiz->student_name }}</td>
                                        <td class="text-center">{{ $quiz->questions }}</td>
                                        <td class="text-center">{{ $quiz->answers }}</td>
                                        <td class="text-center">{!! exam_status($quiz->result) !!}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary"
                                                    href="{{ route('user.quiz.result', [ 'quizResult' => $quiz->id ]) }}">
                                                    view result
                                                </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                {!! $quizResults->links() !!}
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning" role="alert">
                            No exam records found
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
@endsection
