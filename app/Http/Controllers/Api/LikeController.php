<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LikeController extends Controller
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

        if (!(Work::find($request->work_id))) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا العمل غير موجود'
            ], 200);
        }

        $like = new Like();

        $this->validate($request, array(
            'user_id' => '',
            'work_id' => 'required',
        ));

        if (Like::where('user_id', auth()->user()->id)->where('work_id', $request->work_id)->count() > 0) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'لا يمكن اضافة اعجاب اكثر من مرة'
            ], 200);
        }

        $like->work_id       =  $request->work_id;
        $like->user_id       = auth()->user()->id;



        $like->save();
        //

        return response()->json([
            'like' => $like,
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
        $like = Like::find($id);

        if (!($like)) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا العمل غير موجود'
            ], 200);
        }

        if ($like->user_id == auth()->user()->id) {
            $like->delete();
            //
            return response()->json([
                // 'like' => $like,
                'error' => false,
                'message_en' => '',
                'message_ar' => 'تم الغاء الاعجاب'
            ], 200);
        } else {

            return response()->json([
                // 'like' => $like,
                'error' => false,
                'message_en' => '',
                'message_ar' => 'عفوا ليس لديك صلاحيات '
            ], 200);
        }
    }
}
