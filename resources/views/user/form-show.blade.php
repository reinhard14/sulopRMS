@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ $form->name }} Form
                </div>

                <div class="card-body">
                    @include('includes.messages')

                    @if ($form->inputs->isEmpty())
                        <div class="row">
                            <div class="col text-center">
                                <div class="p-5">
                                    <h4 class="text-danger">No input set for {{ $form->name }} yet.</h4>
                                    <p>Please wait for the administrator to setup the form.</p>
                                </div>
                                <div>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="row mb-5 p-5">
                        <form method="POST" action="{{ route('answer.store') }}" id="submitAnswer">
                            @csrf
                            <input type="hidden" name="form_id" value="{{ $form->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                            @foreach ($form->inputs as $input)
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <div class="input-group mb-2">
                                            <input type="hidden" name="input_id[]" value="{{ $input->id }}">
                                            <input type="hidden" name="submission" value="{{ $form->id }}-{{ $input->id }}-{{ Str::uuid() }}">

                                            <label for="answer_{{ $input->id }}" class="input-group-text">
                                                {{ $input->name }} {{ ($input->required === 'required') ? '*' : '' }}
                                            </label>
                                            <input type="{{ $input->type }}" name="answer[]" class="form-control"
                                            id="answer_{{ $input->id }}" {{ ($input->required === 'required') ? $input->required : '' }}>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
                            </div>
                        </div>

                        <form>
                        <div class="d-flex justify-content-between">
                            <small>
                                Input that has <span class="text-danger">"*"</span> asterisk is a required field.
                            </small>
                            <small class="text-right">
                                last updated last: {{ $form->updated_at->diffForHumans(); }}
                            </small>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('dist/js/pages/user/form.js') }}"></script>
@endsection
