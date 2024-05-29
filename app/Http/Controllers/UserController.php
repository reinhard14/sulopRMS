<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::paginate(12);
        return view('home', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //show form
    public function show($id)
    {
        $form = Form::findOrFail($id);
        return view('user.form-show', compact('form'));
    }

    public function answersShow($id)
    {

        $loggedUser = Auth::id();
        $form = Form::findOrFail($id);

        //CURRENTLY used on TABLE. maybe can work out.
        $inputs = Input::where('form_id', $id)
                        ->get();

        $userAnswer = Answer::where('user_id', $loggedUser)
                        ->where('form_id', $id)
                        ->latest('created_at')
                        ->get();

        $submissions = $userAnswer->pluck('submission')->unique();

        return view('user.answers-show', compact('form', 'inputs', 'userAnswer','submissions'));
    }

    public function destroyFormAnswers($form, $answers_submission)
    {

        $answers = Answer::where('submission', $answers_submission)
                        ->get();

        foreach ($answers as $answer) {
            $answer->delete();
        }

        return redirect()->route('user.answers-show', $form)->with('success', 'successfully deleted answers.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
