<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Input;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password as RulesPassword;


class AdminUserController extends Controller
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
    public function index(Request $request)
    {

        // Check if sorting parameter exists in the URL
        $sortByLastname = $request->query('sortByLastname');
        $sortByFirstname = $request->query('sortByFirstname');
        // // echo '<pre>' ;
        // print_r($sortByLastname);
        // // echo '</pre>';

        // Default sorting order
        $sortByColumn = 'lastname';
        $sortOrder = 'asc';

        // set column to sort
        if ($sortByFirstname) {
            $sortByColumn = 'name';
        }

        // Determine sorting order based on the parameter (asc or desc)
        $sortOrder = ($sortByLastname === 'desc' || $sortByFirstname === 'desc') ? 'desc' : 'asc';

        $toggleSortLastname = $this->sortOrder($sortByLastname);
        $toggleSortFirstname = $this->sortOrder($sortByFirstname);

        //query
        $usersQuery = User::where('role_id', 3)
                    ->orderBy($sortByColumn, $sortOrder);

        // Searching
        if (request('search')) {
            $usersQuery->where('name', 'like', '%' . request('search') . '%');

        }

        $users = $usersQuery->paginate(12);
        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
        //endsearch

        //append sorting parameters to pagination links.
        $users->appends(['sortByLastname' => $sortByLastname, 'sortByFirstname' => $sortByFirstname]);

        return view('admin-users.index', compact(
            'users',
            'sortByLastname',
            'sortByFirstname',
            'toggleSortLastname',
            'toggleSortFirstname'
        ));

    }

    private function sortOrder($sortBy) {
        return ($sortBy === 'desc') ? 'desc' : 'asc';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //used modal component.
    }

    // public function search (Request $request) {
    //     // $search = $request->search;

    //     // dd($request);
    //     //admin-users.index

    //     return view('admin-users.index', compact(
    //         'users',
    //         'sortByLastname',
    //         'sortByFirstname',
    //         'toggleSortLastname',
    //         'toggleSortFirstname'
    //     ));
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => ['required',
            RulesPassword::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'role_id' => 'required',
        ]);

        $user = New User;
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role_id = $request->input('role_id');
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $forms = Form::all();

        return view('admin-users.show', compact('user', 'forms'));
    }

    public function showAnswers($user, $form)
    {
        $userId = $user;
        $formId = $form;

        $user = User::findOrFail($user); //used
        $form = Form::findOrFail($form); //used

        //CURRENTLY used on TABLE. maybe can work out.
        $inputs = Input::where('form_id', $formId)
                        ->get();

        $userAnswer = Answer::where('user_id', $userId)
                            ->where('form_id', $formId)
                            ->latest('created_at')
                            ->get();

        $submissionPaginate = Answer::select('*')
                            ->where('user_id', $userId)
                            ->where('form_id', $formId)
                            // ->groupBy('submission')
                            ->paginate(10);

        $submissions = $userAnswer->pluck('submission')->unique();
        $userAnswer;

        return view('admin-users.show-answers', compact('user', 'form', 'inputs',
                                                        'userAnswer', 'submissions',
                                                        'submissionPaginate')
                    );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $forms = Form::all();

        return view('admin-users.edit', compact('user', 'forms'));
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
        $this->validate($request, [
            'password' => ['required',
                        RulesPassword::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()],
        ]);
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.users.index');

    }

    public function destroySelected(Request $request)
    {
        $selectedUserIds = explode(',', $request->input('selectedUserIds'));

        foreach($selectedUserIds as $userId) {
            $user = User::find($userId);
            $user->delete();
        }

        return redirect()->route('admin.users.index');
    }
}
