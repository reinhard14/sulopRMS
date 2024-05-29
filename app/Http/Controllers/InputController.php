<?php

namespace App\Http\Controllers;

use App\Models\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class InputController extends Controller
{

    public function store(Request $request)
    {

        $this->validate($request, [
            'input-type' => 'required',
            'input-label' => 'required',
            'input-required' => 'required',
        ]);
        //convert input label to slug. remove white spaces
        $slug = str_replace(' ', '-', $request->input('input-label'));

        $input = new Input();

        $input->form_id = $request->input('form_id');
        $input->type = $request->input('input-type');
        $input->name = $request->input('input-label');
        $input->required = $request->input('input-required');
        $input->option = $request->input('option');
        //label
        $input->label = Str::lower($slug);
        $input->save();

        //for routing
        $department_id = $request->input('department_id');;

        return redirect()->route('department.show', $department_id);

    }

    public function destroy(Input $input, Request $request)
    {
        $dept_id = $request->input('department_id');

        $input = Input::findOrFail($input->id);
        $input->delete();

        return redirect()->route('department.show', $dept_id);
    }
}
