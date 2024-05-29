@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Answers submitted for {{ $form->name }}</div>

                <div class="card-body">
                    @include('includes.messages')

                    {{-- change this here --}}
                    @if ($submissions->isEmpty())
                        <div class="row">
                            <div class="col text-center ">
                                <div class="p-5 mb-5">
                                    <h4> No <span class="text-danger">ANSWERS</span></h4>
                                    <p>This user has not submitted any answers for this form yet.</p>
                                </div>
                                <div>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
                                </div>
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
                                    @foreach ($submissions as $index => $submission)
                                        <div class="mb-5 border border-secondary p-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <a href="#collapseForm{{ $loop->iteration }}" class="me-1" data-bs-toggle="collapse">submission {{ $loop->remaining + 1 }} </a>
                                                    {{ $userAnswer[$index]->created_at->format('M. d, Y') }} ({{ $userAnswer[$index]->created_at->diffForHumans() }})
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <a href="#" class=""><i class="bi bi-pencil-square"></i></a>


                                                    <form method="POST" action="{{ route('user.answers-delete', ['form' => $form->id,
                                                                                                                'answers_submission' => $userAnswer[$index]->submission]) }}"
                                                    class="deleteFormAnswers">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn text-danger" ><i class="bi bi-trash mr-1"></i></button>
                                                    </form>
                                                </div>
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
                                                                        <td class="text-center border-0">{{ $answer->answer }}</td>
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

                        <div class="row">
                            <div class="col text-center">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
                            </div>
                        </div>
                    @endif
                    {{-- <div class="pagination justify-content-center mt-4">{{ $answers->links() }} </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('dist/js/pages/user-end/answers-show.js') }}"></script>
@endsection
