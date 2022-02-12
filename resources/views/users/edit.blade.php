@extends('layout.main')

@section('content')
    <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">
                تعديل بيانات المستخدم
            </div>

        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{route('users.update' ,$user->id)}}" method="POST" class="form-horizontal">
                @csrf
                @method('put')
                <div class="form-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label">الاسم </label>
                        <div class="col-md-4">
                            <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="الاسم ">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">البريد الالكتروني </label>
                        <div class="col-md-4">
                            <input type="email" name="email"  value="{{$user->email}}" class="form-control" placeholder="البريد الالكتروني ">

                        </div>
                    </div>

                    @if ($user->role != 5)
                         <div class="form-group">
                            <label class="col-md-3 control-label">نوع الخدمة المقدمة</label>
                            <div class="col-md-4">
                                <select name="role" class="form-control" >
                                    <option {{$user->role == 2? 'selected':''}} value="2">مصمم</option>
                                    <option {{$user->role == 3? 'selected':''}} value="3">مصور</option>
                                    <option {{$user->role == 4? 'selected':''}} value="4">رسام</option>
                                </select>

                            </div>
                        </div>
                    @endif



                    <div class="form-actions top">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn   green">تعديل</button>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
@endsection
