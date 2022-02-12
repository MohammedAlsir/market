<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>تسجيل الدخول </title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
		type="text/css" />

	<link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
		type="text/css" />
	<link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{ asset('assets/admin/pages/css/login.css') }}" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css" id="style_color" />
	<link href="{{ asset('assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="login">
	<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
	<div class="menu-toggler sidebar-toggler">
	</div>
	<!-- END SIDEBAR TOGGLER BUTTON -->
	<!-- BEGIN LOGO -->
	<div class="logo">
		<a href="index.html">
			{{-- <img src="../../assets/admin/layout2/img/logo-big.png" alt="" /> --}}
		</a>
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content" dir="rtl">
		<!-- BEGIN LOGIN FORM -->
		<form method="POST" action="{{route('login')}}" class="login-form" action="index.html" method="post">
			@csrf
            <h3 class="form-title">تسجيل الدخول</h3>
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button>

			</div>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">البريد الالكتروني</label>
                 @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
				<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
					placeholder="البريد الالكتروني" name="email" />
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">كلمة المرور</label>
				<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
					placeholder="كلمة المرور" name="password" />
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-success uppercase">تسجيل الدخول</button>

			</div>

		</form>
		<!-- END LOGIN FORM -->

	</div>
	<div class="copyright">

	</div>

	<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/admin/pages/scripts/login.js') }}" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function () {
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			Login.init();
			Demo.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>