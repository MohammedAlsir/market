<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Work;
use Illuminate\Http\Request;

class CommentController extends Controller
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

        if (!(Work::find($request->work_id))) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا العمل غير موجود'
            ], 200);
        }

        $comment = new Comment();

        $this->validate($request, array(
            'user_id' => '',
            'work_id' => 'required',
            'comment' => 'required',
        ));


        $comment->comment       =  $request->comment;
        $comment->work_id       =  $request->work_id;
        $comment->user_id       = auth()->user()->id;



        $comment->save();
        //

        return response()->json([
            'like' => $comment,
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
        $comment = Comment::find($id);

        if (!($comment)) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا التعليق غير موجود'
            ], 200);
        }

        if ($comment->user_id == auth()->user()->id) {
            $comment->delete();
            //
            return response()->json([
                // 'like' => $like,
                'error' => false,
                'message_en' => '',
                'message_ar' => 'تم حذف التعليق '
            ], 200);
        } else {

            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'عفوا ليس لديك صلاحيات '
            ], 200);
        }
    }
}