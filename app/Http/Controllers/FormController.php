<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
// use Carbon\Carbon;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'form-name' => 'required'
        ]);

        $form = new Form();

        $form->name = $request->input('form-name');
        $form->department_id = $request->input('department_id');

        $form->save();

        $dept_id = $form->department_id;

        return redirect()->route('department.show', $dept_id);

    }

    public function update(Request $request, Form $form)
    {

        $this->validate($request,[
            'form-name' => 'required'
        ]);

        $form = Form::findOrFail($form->id);

        $form->name = $request->input('form-name');
        // $form->updated_at = Carbon::now();
        $form->save();

        $dept_id = $form->department_id;

        return redirect()->route('department.show', $dept_id);
    }

    public function destroy(Form $form) {

        $dept_id = $form->department_id;

        $form = Form::findOrFail($form->id);
        $form->delete();

        return redirect()->route('department.show', $dept_id);
    }
}
