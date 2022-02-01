@extends('layouts.master-user')

@section('title') Class List @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Category @endslot
        @slot('breadSubLink') {{ route('entity.category.index') }} @endslot
        @slot('pageTitle') Class @endslot
    @endcomponent

    @include('layouts.default-message')

    <div class="">

        <div class="table-responsive my-3">
            <a class="btn btn-success mb-3" href="{{ route('entity.category-class.create') }}">Add New</a>
            <table class="table">
                <thead class="table-light">
                    <tr style="vertical-align: middle">
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th class="text-center" style="min-width: 120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $class->class_name }}</td>
                            <td>{{ $class->class_code }}</td>
                            <td>{{ $class->category_name }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary" href="{{ route('entity.category-class.edit', $class) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="post" class="d-inline"
                                    action="{{ route('entity.category-class.destroy', $class) }}">
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
                {!! $classes->links() !!}
            </div>
        </div>
    </div>

@endsection
