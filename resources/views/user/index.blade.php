@extends('layouts.master-user')

@section('title') My Home @endsection

@section('content')

<div class="Container-fluid my-4">
    <div class="row">
        @include('layouts.default-message')

        <div class="col-md-6 offset-md-3">
            <table class="table table-striped">
                <tr>
                    <th>Total Quizzes</th>
                    <td>{{ $total['quizzes'] }}</td>
                </tr>
                <tr>
                    <th>Total Pass</th>
                    <td>{{ $total['quiz_pass'] }}</td>
                </tr>
            </table>
        </div>
    </div>

</div>

@endsection
