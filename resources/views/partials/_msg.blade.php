@if(Session::has('SUCCESS'))

<div class="alert alert-success" role="alert" style="margin-top:30px;">
    <strong>تنبيه: </strong>   {{Session::get('SUCCESS')}}
  </div>
@endif

@if(Session::has('error'))

<div class="alert alert-danger" role="alert" style="margin-top:30px;">
    <strong>Error : </strong>   {{Session::get('error')}}
  </div>
@endif


@if(count($errors)>0)

<div class="alert alert-danger" role="alert" style="margin-top:30px;">
    <strong>ERRORS: </strong>
    <ul>
        @foreach($errors->all() as $error)

        <li>
            {{$error}}
        </li>
        @endforeach
    </ul>
  </div>
@endif
