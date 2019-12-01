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
	<link rel="stylesheet" href="{{asset('AdminPanel/dist/css/fontawsome-all.css')}}">
	<link rel="stylesheet" href="{{asset('AdminPanel/dist/css/custom-style.css')}}">
<!--===============================================================================================-->
</head>
<body >

		

	<div class="limiter">
			
		<div class="container-login100">
			
			<div class="wrap-login100">
				
				<div class="login100-pic js-tilt text-center" data-tilt>
					<div class="text-center dana-bold">
							سامانه ی مدیریت فروش از راه دور
					</div>
					<img src="{{asset('Auth/images/img-01.png')}}" alt="IMG">
				</div>
				
				<form method="POST" action="{{ route('loginToSite') }}" class="login100-form validate-form">
			
					
						@if(session('message'))
						<div class="alert alert-primary text-right" role="alert">
								<a style="float:left" type="button" class="btn btn-dark btn-sm" data-dismiss="alert" aria-label="Close">
								  <strong class="h6 text-light">
									فهمیدم
								  </strong>
							   </a>
							  <h6 class="alert-heading text-right">
								راهنمایی
							  </h6>
							<hr>
								<p class="mb-0 text-right">{{ session('message') }}</p>
							</div>
						@endif
				
					<span class="login100-form-title dana-bold">
						ورود
					</span>
						@csrf
						<div class="wrap-input100 validate-input text-right" data-validate = "Valid email is required: ex@abc.xyz">
							<input class="input100 text-right" type="text" name="username" placeholder="نام کاربری" value=""  autocomplete="off">
							@error('username')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
							<span class="focus-input100"></span>
							{{-- <span class="symbol-input100">
								<i class="far fa-user"></i>
							</span> --}}
						</div>

						<div   class="wrap-input100 validate-input text-right" data-validate = "Password is required">
							<input class="input100 text-right" type="password" name="password" placeholder="گذرواژه"  value="" autocomplete="off">
							@error('password')
									<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
									</span>
							@enderror
							<span class="focus-input100"></span>
							{{-- <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span> --}}
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
