@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Groups @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('pageTitle') Groups @endslot
    @endcomponent

    <div class="container">
        <div class="row">
            @include('layouts.default-message')
            <div class="table-responsive my-3">
                <a class="btn btn-success mb-3" href="{{ route('groups.create') }}">Add New</a>
                <table class="table">
                    <thead class="table-light">
                        <tr style="vertical-align: middle">
                            <th>#</th>
                            <th>Group Name</th>
                            <th>Slug</th>
                            <th class="text-center" style="min-width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->slug }}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('groups.edit', $group) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="post" class="d-inline"
                                        action="{{ route('groups.destroy', $group) }}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger delete-confirm action-form" type="button"
                                        data-title="Are you sure?"
                                        data-text="This group will be deleted. Do you wish to proceed?"
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
                    {!! $groups->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
