@extends('layouts.master-user')

@section('title') Create Exam Paper @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('breadTitle') Home @endslot
        @slot('breadSubTitle') Exam Papers @endslot
        @slot('breadSubLink') {{ route('entity.exam.index') }} @endslot
        @slot('pageTitle') Add @endslot
    @endcomponent

    <div class="card py-4">
        <div class="card-body">
            @include('layouts.default-message')

            <h4 class="card-title mb-3 text-center">Create Form</h4>

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('entity.exam.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('components.form.input.text', [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Exam Title',
                        'placeholder' => 'Enter title here',
                        'value' => old('name', ''),
                        'attr' => 'autofocus',
                        'class' => 'form-control',
                        'require' => true,
                        'div_class' => 'mb-3'
                        ])

                        <div class="row mb-3">
                            <div class="col-md-3">
                                @include('components.form.input.text', [
                                'type' => 'number',
                                'name' => 'score',
                                'label' => 'Total Mark',
                                'value' => old('score', 1),
                                'attr' => 'min="1" max="1000"',
                                'class' => 'form-control',
                                'require' => true
                                ])
                            </div>
                            <div class="col-md-3">
                                @include('components.form.input.text', [
                                'type' => 'number',
                                'name' => 'duration',
                                'title' => 'Number must be between 1 & 200',
                                'label' => 'Exam Duration (in minutes)',
                                'value' => old('duration', 1),
                                'attr' => 'min="1" max="200"',
                                'class' => 'form-control',
                                'require' => true
                                ])
                            </div>
                            <div class="col-md-3">
                                @include('components.form.input.text', [
                                'type' => 'number',
                                'name' => 'pass_mark',
                                'label' => 'Passing Marks',
                                'value' => old('pass_mark', 0),
                                'attr' => 'min="1" max="1000"',
                                'class' => 'form-control',
                                'require' => true
                                ])
                            </div>
                            <div class="col-md-3">
                                @include('components.form.input.checkbox', [
                                'name' => 'status',
                                'label' => 'Active ?',
                                'value' => 1,
                                'div_class' => 'mt-radio'
                                ])
                            </div>
                        </div>

                        @include('components.form.input.textarea', [
                        'name' => 'detail',
                        'label' => 'Description',
                        'placeholder' => 'Enter detail text',
                        'value' => old('detail', ''),
                        'div_class' => 'mb-3',
                        'class' => 'form-control',
                        ])

                        <div class="mb-3 row">
                            <div class="col-md-6 my-3">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check show-hidden" name="btnradio"
                                        id="btnradio--legacy-no" autocomplete="off" checked
                                        data-target="#block--legacy-form" data-action="off">
                                    <label class="btn btn-outline-primary" for="btnradio--legacy-no">Regular</label>

                                    <input type="radio" class="btn-check show-hidden" name="btnradio" autocomplete="off"
                                        id="btnradio--legacy-yes" data-target="#block--legacy-form" data-action="on">
                                    <label class="btn btn-outline-primary" for="btnradio--legacy-yes">Legacy</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="select--exam-type">Exam Type</label>
                                    <select class="form-select" id="select--exam-type" name="exam_type">
                                        @foreach (exam_type('all') as $k => $v)
                                            <option value="{{ $k }}" {{ $k == 1 ? 'selected' : '' }}>
                                                {{ $v }}</option>
                                        @endforeach
                                    </select>

                                    @error('exam_type')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 collapse" id="block--legacy-form">
                            <div>
                                Some placeholder content for the first collapse component of this multi-collapse example.
                                This panel is hidden by default but revealed when the user activates the relevant trigger.
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-lg mt-3">Initiate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
