<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Work;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['work'])->where('user_id', auth()->user()->id)->get();
        return response()->json([
            'orders' => $orders,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
    }

    // new Function
    public function user_order()
    {
        $orders = Order::with(['user', 'work' => function ($q) {
            $q->where('user_id', auth()->user()->id);
        }])->get();

        if ($orders->count() > 0) {
            return response()->json([
                'orders' => $orders,
                'error' => false,
                'message_en' => '',
                'message_ar' => ''
            ], 200);
        } else {
            return response()->json([
                'orders' => $orders,
                'error' => true,
                'message_en' => '',
                'message_ar' => ''
            ], 200);
        }
    }

    public function all($id)
    {
        $orders = Order::with('work')->where('user_id', auth()->user()->id)->where('status', $id)->get();
        return response()->json([
            'orders' => $orders,
            'error' => false,
            'message_en' => '',
            'message_ar' => ''
        ], 200);
    }

    public function status(Request $request, $id)
    {

        $orders = Order::with('work')->find($id);
        if (!($orders)) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا العنصر غير موجود'
            ], 200);
        }

        if ($orders->work->user_id == auth()->user()->id) {

            $data = $request->validate(
                [
                    'status' => 'required',
                ]
            );

            $data['status']       = $request->status;
            $orders->update($data);

            return response()->json([
                'orders' => $orders,
                'error' => false,
                'message_en' => '',
                'message_ar' => ''
            ], 200);
        } else {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'عفوا ليس لديك صلاحيات'
            ], 200);
        }
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
        $this->validate($request, array(
            'status' => '',
            'user_id' => '',
            'work_id' => 'required',
        ));

        if (!(Work::find($request->work_id))) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا العمل غير موجود'
            ], 200);
        }

        $order = new Order();
        if (Order::where('user_id', auth()->user()->id)->where('work_id', $request->work_id)->count() > 0) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'لقد قمت بطلب هذا العمل من قبل '
            ], 200);
        }

        $order->work_id       =  $request->work_id;
        $order->user_id       = auth()->user()->id;



        $order->save();
        //

        return response()->json([
            'order' => $order,
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
        $order = Order::find($id);

        if (!($order)) {
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'هذا الطلب غير موجود'
            ], 200);
        }

        if ($order->user_id == auth()->user()->id) {
            $order->delete();
            //
            return response()->json([
                'error' => false,
                'message_en' => '',
                'message_ar' => 'تم  حذف الطلب'
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