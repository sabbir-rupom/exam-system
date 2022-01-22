@extends('layouts.master-user')

@section('title') {{ session('is_owner') ? session('owner')['domain'] : '' }} | Questions @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Question Papers @endslot
        @slot('pageTitle') Edit Question Paper @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-4 text-center">Builder: {{ ucfirst($questionPaper->category) }} Question Paper</h4>

            <div class="container">

                <div id="builder--panel" class="row" data-form-header="#panel--formHeader"
                    data-form-body="#panel--formBody" data-form-footer="#panel--formFooter" data-json="#input--json"
                    data-questions="#input--questions" data-form-modal="#modal--handleForm">
                    <div class="box-main col-md-12 {{-- col-lg-9 col-md-12order-md-2 --}}">
                        <div id="panel--formHeader" class="panel-box editor"></div>
                        <div id="panel--formBody" class="panel-box"></div>
                        <div id="panel--formFooter" class="panel-box editor"></div>
                    </div>
                    {{-- <div class="box-sidebar bg-warning col-lg-9 col-md-12 order-md-1">

                    </div> --}}
                </div>

                <input type="hidden" id="input--json" value="{{ $questionPaper->data }}">
                <input type="hidden" id="input--questions" value="{{ $questions }}">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal--handleForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modal--label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal--label">Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning btn-save" data-save="">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/html5sortable/html5sortable.min.js') }}"></script>
@endsection

@section('script-bottom')
    <!-- init js -->
    <script src="{{ URL::asset('assets/js/pages/question-paper.init.js') }}"></script>
@endsection
