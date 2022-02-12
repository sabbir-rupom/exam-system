@extends('layouts.master-user')

@section('title') {{ $legacy ? 'Legacy Exams' : 'Custom Exams' }} @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('pageTitle') Exam Papers @endslot
    @endcomponent

    @include('layouts.default-message')

    <div class="row">
        <div class="col-md-6">
            <ul class="nav nav-pills my-2">
                <li class="nav-item">
                    <a {!! $legacy ? 'class="nav-link"' : 'class="nav-link active"  aria-current="page"' !!} href="{{ route('entity.exam.index') }}">
                        Custom Exams
                    </a>
                </li>
                <li class="nav-item">
                    <a {!! $legacy ? 'class="nav-link active"  aria-current="page"' : 'class="nav-link"' !!} href="{{ route('entity.exam.index', ['legacy' => 1]) }}">
                        Legacy Exams
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-success mt-2" href="{{ route('entity.exam.create') }}">Add New</a>
        </div>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead class="table-light">
                    <tr style="vertical-align: middle">
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Type</th>
                        <th>Mark</th>
                        <th>Subject Code</th>
                        @if ($legacy)
                            <th>Legacy Year</th>
                        @endif
                        <th>Status</th>
                        <th class="text-center" style="min-width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ exam_type($exam->type) }}</td>
                            <td>{{ $exam->score }}</td>
                            <td>{{ $exam->subject_code }}</td>
                            @if ($legacy)
                                <td>{{ $exam->c_year }}</td>
                            @endif
                            <td>{{ badge_status($exam->status ? 'active' : 'in-active') }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary" href="{{ route('entity.exam.edit', $exam) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="post" class="d-inline"
                                    action="{{ route('entity.exam.destroy', $exam) }}">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-sm btn-danger delete-confirm action-form" type="button"
                                        data-title="Are you sure?"
                                        data-text="This item will be deleted. Do you wish to proceed?"
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
                {!! $exams->links() !!}
            </div>
        </div>
    </div>

@endsection
