<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;


class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'answer' => 'required',
            'submission' => 'required',
        ]);

        $formId = $request->input('form_id');
        $user_id = $request->input('user_id');

        $input_ids = $request->input('input_id', []); // Get input_ids or initialize as an empty array if null
        $answers = $request->input('answer', []);

        foreach ($input_ids as $key => $input_id) {
            $inputAnswer = new Answer();

            $inputAnswer->answer = $answers[$key]; // Match each answer with its input_id
            $inputAnswer->user_id = $user_id;
            $inputAnswer->input_id = $input_id;
            $inputAnswer->form_id = $formId;
            $inputAnswer->submission = $request->input('submission');
            $inputAnswer->save();
        }

        return redirect()->route('user.show', $formId)->with('success', 'Answer submission is completed!');
    }
}
