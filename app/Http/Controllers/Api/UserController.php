<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            if (auth()->user()->role != 1) {
                $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
                return response()->json([
                    'token' => $token,
                    'user' => Auth::user(),
                    'error' => false,
                    'message_en' => '',
                    'message_ar' => ''
                ], 200);
            } else {
                return response()->json([
                    'error'     => true,
                    'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
                    'message_ar'   => 'عفوا ، ليس لديك صلاحيات الوصول إلى هذه الصفحة',
                ], 200);
            }
        } else {
            return response()->json([
                'error'     => true,
                'message_en'   => 'Sorry, there is an error in your phone or password',
                'message_ar'   => 'عفوا ، هناك خطأ في رقم الهاتف أو كلمة المرور الخاصة بك',
            ], 200);
        }
    }

    //Regester Function
    public function register(Request $request)
    {

        //
        $data = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'role' => ''
            ]
        );

        $data['password']   = Hash::make($request->password);
        $data['role']       = 5;
        $data['name']       = $request->name;
        $data['email']       = $request->email;

        $user = User::create($data);
        //
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'newUser' => $user,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
    }
    // End regester function


    public function profile(Request $request)
    {

        $user = User::find(auth()->user()->id);

        if (isset($user) && auth()->user()->id == $user->id && $user->role != 1) {

            //
            $data = $request->validate(
                [
                    'name' => 'required',
                    'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                    'password' => 'required|min:8',
                    // 'role' => 'required',
                    'bio' => ''
                ]
            );

            $data['password']   = Hash::make($request->password);
            // $data['role']       = $request->role;
            $data['name']       = $request->name;
            $data['email']       = $request->email;
            $data['bio']       = $request->bio;

            $data['password'] = Hash::make($request->password);

            $user->update($data);
            //

            return response()->json([
                'user' => $user,
                'error' => false,
                'message_en' => 'succses edit user data',
                'message_ar' => 'تم تعديل بيانات  المستخدم بنجاح'
            ], 200);
        } else {
            return response()->json([
                'error'     => true,
                'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
                'message_ar'   => 'عفوا ، ليس لديك صلاحيات الوصول إلى هذه الصفحة',
            ], 200);
        }
    }

    public function profile_worker($id)
    {
        $user = User::find($id);

        if (!($user)) {
            return response()->json([
                'error'     => true,
                'message_ar'   => 'هذا المستخدم غير موجود',
            ], 200);
        }

        if (isset($user)) {

            return response()->json([
                'user' => $user,
                'error' => false,
                'message_en' => '',
                'message_ar' => ''
            ], 200);
        }
    }
}