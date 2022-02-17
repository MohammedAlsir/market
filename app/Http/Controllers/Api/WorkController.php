<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkController extends Controller
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
        $data = $request->validate(
            [
                'name' => 'required',
                'price' => 'required',
                'details' => 'required',
                'photo' => '',
                'user_id' => ''
            ]
        );

        $data['name']       = $request->name;
        $data['price']       = $request->price;
        $data['details']       = $request->details;
        $data['user_id']       = auth()->user()->id;

        if ($request->photo) {
            $imagePath = public_path() . '/images/works';
            $getImage = $request->photo;
            $imageName = time() . '.' . $getImage->extension();
            $getImage->move($imagePath, $imageName);
            $data['photo']       = $imageName;
        }



        $work = Work::create($data);
        //

        return response()->json([
            'new_Work' => $work,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work = Work::with('likes')->with('comments')->find($id);

        if (!($work)) {
            return response()->json([
                'error'     => true,
                'message_ar'   => 'هذا العمل غير موجود',
            ], 200);
        }
        // if ($work->user_id == auth()->user()->id) {

        return response()->json([
            'work' => $work,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
        // } else {
        //     return response()->json([
        //         'error'     => true,
        //         'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
        //         'message_ar'   => 'عفوا ، ليس لديك صلاحيات الوصول إلى هذه الصفحة',
        //     ], 200);
        // }
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = Work::find($id);
        if (!(isset($work))) {
            return response()->json([
                'error'     => true,
                // 'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
                'message_ar'   => 'عفو لا يوجد عناصر هنا ',
            ], 200);
        }
        if ($work->user_id == auth()->user()->id) {

            $work->delete();
            return response()->json([
                // 'new_Work' => $work,
                'error' => false,
                'message_en' => '',
                'message_ar' => 'تم الحذف بنجاح'
            ], 200);
        } else {
            return response()->json([
                'error'     => true,
                'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
                'message_ar'   => 'عفوا ، ليس لديك صلاحيات الوصول إلى هذه الصفحة',
            ], 200);
        }
    }

    public function fix(Request $request, $id)
    {
        $work = Work::find($id);
        if ($work->user_id == auth()->user()->id) {
            //
            $data = $request->validate(
                [
                    'name' => 'required',
                    'price' => 'required',
                    'details' => 'required',
                    'photo' => '',
                    'user_id' => ''
                ]
            );

            $data['name']       = $request->name;
            $data['price']       = $request->price;
            $data['details']       = $request->details;
            // $data['user_id']       = auth()->user()->id;

            if ($request->photo) {
                $imagePath = public_path() . '/images/works';
                $getImage = $request->photo;
                $imageName = time() . '.' . $getImage->extension();
                $getImage->move($imagePath, $imageName);
                $data['photo']       = $imageName;
            }



            $work->update($data);
            //

            return response()->json([
                'new_Work' => $work,
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
    }

    public function all_work_by_section($id)
    {
        $works = [];
        $all = Work::with(['user', 'likes', 'comments'])->get();

        foreach ($all as $item) {
            if ($item->user->role == $id) {
                $works[] = $item;
            }
        }

        return response()->json([
            'works' => $works,
            // 'countLike' => $all->likes()->count(),
            // 'works' => $works,
            'error'     => true,
            'message_en'   => '',
            'message_ar'   => '',
        ], 200);
    }

    public function all_works()
    {
        $works = Work::with(['user', 'likes', 'comments'])->get();

        foreach ($works as $work) {
            $work->user_name = $work->user->name;
            $work->user_role = $work->user->role;
            $work->user_email = $work->user->email;
            $work->user_bio = $work->user->bio;

            $work->like_count = $work->likes->count();
            $work->comment_count = $work->comments->count();
        }


        return response()->json([
            'works' => $works,
            'error'     => false,
            'message_en'   => '',
            'message_ar'   => '',
        ], 200);
    }

    public function user_work($id)
    {
        $user = User::with('works')->find($id);

        if (!(isset($user))) {
            return response()->json([
                'error'     => true,
                // 'message_en'   => 'Unauthorised ,Sorry, you do not have access to this page ',
                'message_ar'   => 'عفوا هذا المستخدم غير موجود  ',
            ], 200);
        }


        return response()->json([
            'all_works' => $user,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
    }
}