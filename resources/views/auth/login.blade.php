<!DOCTYPE html>
<html lang="en">
<head>
	<title>ورود</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('Auth/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('Auth/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body >

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{asset('Auth/images/img-01.png')}}" alt="IMG">
				</div>

				<form method="POST" action="{{ route('loginToSite') }}" class="login100-form validate-form">
					<span class="login100-form-title">
						ورود
					</span>
						@csrf
						<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
							<input class="input100" type="text" name="username" placeholder="username">
							@error('username')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
						</div>

						<div   class="wrap-input100 validate-input" data-validate = "Password is required">
							<input class="input100" type="password" name="password" placeholder="Password">
							@error('password')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>

						<div class="container-login100-form-btn">
							<button type="submit" class="login100-form-btn">
								وارد شوید
							</button>
						</div>


				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="{{asset('Auth/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('Auth/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('Auth/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('Auth/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('Auth/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
