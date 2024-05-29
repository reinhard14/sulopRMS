@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Home Page') }}</div>

                <div class="card-body">
                    @include('includes.messages')

                    @if ($forms->isEmpty())
                        <h3 class="text-center p-5">Administrator needs to <span class="text-danger">SETUP</span> the site first.</h3>
                    @else
                        <p>Select form to answer below:</p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Created</th>
                                        <th>Form Name</th>
                                        <th>Department</th>
                                        <th>Last updated</th>
                                        <th>Answered?</th>
                                        <th class="text-center">Submitted answers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($forms as $form)
                                    <tr>
                                        <td class="border-0">{{ $form->created_at->format('M. d, Y') }}</td>
                                        <td class="border-0"><a href="{{ route('user.show', $form->id) }}" class="text-decoration-none"> {{ $form->name }}</a></td>
                                        <td class="border-0">{{ $form->department->name }} - {{ $form->department->description }}</td>
                                        <td class="border-0">{{ $form->updated_at->diffForHumans() }}</td>
                                        <td class="border-0"> yes/no </td>
                                        <td class="border-0 text-center">
                                            <a href="{{ route('user.answers-show', $form->id) }}" class="btn btn-primary"><i class="bi bi-list-columns-reverse me-1"></i>View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="pagination justify-content-center mt-4">{{ $forms->links() }} </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
