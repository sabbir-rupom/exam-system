@extends('layouts.master-user')

@section('title') Subject List @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Category @endslot
        @slot('breadLink') {{ route('entity.category.index') }} @endslot
        @slot('breadSubTitle') Class @endslot
        @slot('breadSubLink') {{ route('entity.category-class.index') }} @endslot
        @slot('pageTitle') Subject @endslot
    @endcomponent

    @include('layouts.default-message')

    <div class="">

        <div class="table-responsive my-3">
            <a class="btn btn-success mb-3" href="{{ route('entity.subject.create') }}">Add New</a>
            <table class="table">
                <thead class="table-light">
                    <tr style="vertical-align: middle">
                        <th>#</th>
                        <th>Subject Name</th>
                        <th>Code</th>
                        <th>Class</th>
                        <th>Category</th>
                        <th class="text-center" style="min-width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->subject_name }}</td>
                            <td>{{ $subject->subject_code }}</td>
                            <td>{{ $subject->class_name }}</td>
                            <td>{{ $subject->category_name }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary" href="{{ route('entity.subject.edit', $subject) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="post" class="d-inline"
                                    action="{{ route('entity.subject.destroy', $subject) }}">
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
                {!! $subjects->links() !!}
            </div>
        </div>
    </div>

@endsection
