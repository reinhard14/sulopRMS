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
                    <li class="breadcrumb-item active"><a href="#">User</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-none d-sm-block">
                            <h3>List </h3>
                        </div>
                        <div class="d-sm-none">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        <div class="form-inline">
                            <a href="#create-user-modal" class="btn btn-primary mr-1" data-bs-toggle="modal"><i class="bi bi-person-add mr-1"></i></ion-icon>Add</a>
                            <form method="post" action="#" id="deleteForm">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="selectedUserIds" id="selectedUserIds" value="">
                                <button type="submit" class="btn btn-danger" id="checkboxDeleteButton" disabled>
                                    <i class="bi bi-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    @if ($users->isEmpty())
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-5">
                                    <h3 >No <span class="text-danger">Users</span> yet.</h3>
                                    <p> Click the <span class="text-info">"Add"</span> button to add a user.</p>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="row">
                            <div class="col">
                                <div class="row mb-3 d-flex border border-primary">
                                    <div class="col d-flex align-items-center justify-content-start p-2 border border-danger">
                                        <form method="GET" action="#">
                                        {{-- <form method="GET" action="#"> --}}
                                            <input type="text" name="search">
                                            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                                        </form>
                                    </div>

                                    <div class="col d-flex align-items-center justify-content-between p-2 border border-danger">
                                        <div class="">
                                            Date Filter:
                                        </div>
                                        <div class="">
                                            from -
                                            <input type="date" class="">
                                        </div>
                                        <div class="">
                                            to -
                                            <input type="date" class="">
                                        </div>
                                    </div>

                                    <div class="col-3 d-flex align-items-center justify-content-end p-2 border border-info">
                                        <div>
                                            Filter:
                                            <select>
                                                <option>All</option>
                                                <option>With Answers</option>
                                                <option>No Answers</option>
                                            </select>
                                        </div>
                                        <div>
                                            <form method="POST" action="#">
                                                <button type="submit" class="btn btn-info btn-sm ml-1">Filter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- after filter --}}
                                <div class="row">
                                    <div class="col d-flex justify-content-end border border-warning">
                                        <div class="mr-1">
                                            <p> <strong> Current view - </strong></p>
                                        </div>
                                        @if ($sortByLastname || $sortByFirstname)
                                            <div>
                                                <p> Last: <strong> {{ $sortByLastname }}</strong> First: <strong>{{ $sortByFirstname }}</strong> </p>
                                            </div>
                                        @else
                                            <p>
                                                Default
                                            </p>
                                        @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    @if ($toggleSortLastname === 'desc')
                                                        <a href="{{ route('admin.users.index', ['sortByLastname' => 'asc']) }}" type="submit" class="btn text-primary"
                                                            data-toggle="tooltip" title="Click to ascend Last name."><strong>Last Name</strong> <i class="bi bi-sort-alpha-down-alt"></i> </a>
                                                    @else
                                                        <a href="{{ route('admin.users.index', ['sortByLastname' => 'desc']) }}" type="submit" class="btn text-primary"
                                                            data-toggle="tooltip" title="Click to descend Last name."><strong>Last Name</strong> <i class="bi bi-sort-alpha-up"></i> </a>
                                                    @endif
                                                </th>
                                                <th>
                                                    @if ($toggleSortFirstname === 'desc')
                                                        <a href="{{ route('admin.users.index', ['sortByFirstname' => 'asc']) }}" type="submit" class="btn text-primary"
                                                            data-toggle="tooltip" title="Click to ascend First name."><strong>First Name</strong> <i class="bi bi-sort-alpha-down-alt"></i> </a>
                                                    @else
                                                        <a href="{{ route('admin.users.index', ['sortByFirstname' => 'desc']) }}" type="submit" class="btn text-primary"
                                                            data-toggle="tooltip" title="Click to descend First name."><strong>First Name</strong> <i class="bi bi-sort-alpha-up"></i> </a>
                                                    @endif
                                                </th>
                                                <th class="text-center">Action</th>
                                                <th class="text-center">Form/s Submitted</th>
                                                <th class="text-right">
                                                    <label class="form-check-label" for="deleteMasterCheckbox">Delete?</label>
                                                    <input type="checkbox" id="deleteMasterCheckbox">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->lastname }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <a href="#edit-user-modal-{{ $user->id }}" data-bs-toggle="modal">
                                                                <i class="bi bi-person-gear"></i> Edit
                                                            </a>
                                                            <form method="post" action="{{ route('admin.users.destroy', $user->id) }}" class="deleteAdminForm">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn text-danger"> <i class="bi bi-person-x"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-info"><i class="bi bi-file-earmark-break"></i> View</a>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="checkbox" class="deleteItemCheckboxes" data-admin-id="{{ $user->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="pagination justify-content-center mt-4">{{ $users->appends(['sortByLastname' => $sortByLastname])->links() }} </div>
                            </div>
                        </div>

                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /. card -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>

{{--* Modal components here --}}
<x-admin-user.create />

@foreach ($users as $user)
    <x-admin-user.edit :user="$user" />
@endforeach


<!-- Administrator JS -->
<script src="{{ asset('dist/js/pages/user-administrator.js') }}"></script>

{{-- container end --}}
@endsection


