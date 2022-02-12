<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
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
        $id = 1;
        $users = User::where('id', '!=', 1)->orderBy('id', 'desc')->get();
        return view('users.index', compact('users', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name'        => 'required',
            'role'        => 'required',
            'email'        => 'required|email',

        ));

        //Insert

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make('123456789');
        $user->save();

        Session::flash('SUCCESS', 'تم اضافة المستخدم بنجاح');

        // redirect
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
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
        $this->validate($request, array(
            'name'        => 'required',
            'role'        => '',
            'email'        => 'required|email',

        ));

        //Insert

        $user =  User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->role = $request->role;
        $user->password = Hash::make('123456789');
        $user->save();

        Session::flash('SUCCESS', 'تم تعديل بيانات المستخدم بنجاح');

        // redirect
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =  User::find($id);
        if ($user->like) {
            $user->like()->delete();
        }
        if ($user->comment) {
            $user->comment()->delete();
        }

        if ($user->order) {
            $user->order()->delete();
        }
        if ($user->works) {
            $user->works()->delete();
        }
        $user->delete();
        Session::flash('SUCCESS', 'تم حذف  المستخدم بنجاح');

        // redirect
        return redirect()->route('users.index');
    }
}