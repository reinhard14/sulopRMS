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
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item active"><a href="#">View</a></li>
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
                    <h3 class="card-title">User's Information</h3>
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

                    @if($forms->isEmpty())
                        <div class="row mb-3">
                            <div class="col">
                                <div class="text-center p-5">
                                    <h3>No <span class="text-danger">Form</span> Available.</h3>
                                    <p>Please setup the <span class="text-danger">"Forms"</span> on the department's module.</p>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="row mb-3">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Form</th>
                                            <th>Answers Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($forms as $form)
                                        <tr>
                                            <td>
                                                <strong>{{ $form->department->name }}</strong> - {{ $form->department->description }}
                                            </td>
                                            <td>
                                                {{ $form->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show-answers', ['user' => $user->id, 'form' => $form->id]) }}" class="btn btn-outline-info">View Answers</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" role="button"><i class="bi bi-arrow-left mr-1"></i>Back</a>
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
