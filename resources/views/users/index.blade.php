@extends('layout.main')

@section('content')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>كل المستخدمين
            </div>
        </div>
        <div class="portlet-body flip-scroll">
            <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
            <tr>
                <th width="20%">
                        ID
                </th>
                <th>
                        الاسم
                </th>
                <th >
                        البريد الالكتروني
                </th>
                <th>
                        الخدمة المقدمة
                </th>

                <th>
                        العمليات
                </th>
            </tr>
            </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                    {{$id++}}
                            </td>
                            <td>
                                    {{$user->name}}
                            </td>
                            <td >
                                    {{$user->email}}
                            </td>
                            <td >
                                    @if ($user->role == 2)
                                        مصمم
                                    @elseif($user->role == 3)
                                    مصور
                                    @elseif($user->role == 4)
                                    رسام
                                    @elseif($user->role == 5)
                                    مستخدم

                                    @endif
                            </td>

                            <td >
                                    <a href="{{route('users.edit',$user->id)}}" class="btn default">
                                    تعديل <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{route('users.destroy',$user->id)}}" style="display: inline-block" action="">
                                        @csrf
                                        @method('delete')
                                        <button  type="submit" class="btn red">
                                            حذف <i class="fa fa-remove"></i>
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
