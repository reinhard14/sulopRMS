@extends('layouts.admin-master-layout')


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="ml-2">User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active"><a href="#">View</a></li>
                    <li class="breadcrumb-item active"><a href="#">Answers</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- general form elements disabled -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User's answers on {{ $form->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <!-- text input -->
                        <div class="col">
                            <label>First Name</label>
                            <p> {{ $user->name }} </p>
                        </div>
                        <div class="col">
                            <label>Last Name</label>
                            <p> {{ $user->lastname }} </p>
                        </div>
                        <div class="col">
                            <label>Email</label>
                            <p> {{ $user->email }} </p>
                        </div>
                    </div>


                    {{-- change this here --}}
                    @if ($submissionPaginate->isEmpty())
                        <div class="row mb-5 border border-1">
                            <div class="col text-center p-5">
                                <h4>This user has not submitted any <span class="text-danger">ANSWERS</span> for this form yet.</h4>
                            </div>
                        </div>

                    @else
                        <div class="row mb-3">
                            <div class="col text-center">
                                <h1>{{ $form->name }}</h1>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <div class="table-responsive">

                                    {{-- working version --}}
                                        @foreach ($submissions as $index => $submission)
                                        <div class="mb-5 border border-secondary p-3">
                                            <div class="d-flex justify-content-between">
                                                <a href="#collapseForm{{ $loop->iteration }}" class="" data-bs-toggle="collapse">submitted {{ $loop->remaining + 1 }}</a>
                                                {{ $userAnswer[$index]->created_at->format('M. d, Y') }} ({{ $userAnswer[$index]->created_at->diffForHumans() }})
                                            </div>

                                            <div class="collapse show" id="collapseForm{{ $loop->iteration }}">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Form Input</th>
                                                            <th class="text-center">Answers Submitted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border border-1">
                                                        @foreach ($inputs as $input)
                                                            <tr>
                                                                <td class="text-center border-0">{{ $input->name }}</td>
                                                                @foreach ($input->answers as $answer)
                                                                    @if($answer->submission === $submission )
                                                                        <td class="text-center border-0">{{ ($answer->answer === null) ? 'No answer' : $answer->answer  }}</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="pagination justify-content-center my-3">{{ $submissionPaginate->links() }} </div>
                    @endif

                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary" role="button"><i class="bi bi-arrow-left mr-1"></i>Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

</div>

<!-- Administrator JS -->
<script src="{{ asset('dist/js/pages/administrator.js') }}"></script>

{{-- container end --}}
@endsection
