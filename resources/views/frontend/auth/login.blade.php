<!DOCTYPE html>
<!-- 
Jampack
Author: Hencework
Contact: contact@hencework.com
-->
<html lang="en">
<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Classic | Jampack - Admin CRM Dashboard Template</title>
    <meta name="description" content="A modern CRM Dashboard Template with reusable and flexible components for your SaaS web applications by hencework. Based on Bootstrap."/>
    
	<!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('admin/favicon.ico')}}">
    <link rel="icon" href="{{asset('admin/favicon.ico')}}" type="image/x-icon">
	
	<!-- CSS -->
    <link href="{{asset('admin/dist/css/style.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
   	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-footer="simple">
		<!-- Main Content -->
		<div class="hk-pg-wrapper pt-0 pb-xl-0 pb-5">
			<div class="hk-pg-body pt-0 pb-xl-0">
				<!-- Container -->
				<div class="container-xxl">
					<!-- Row -->
					<div class="row">
						<div class="col-sm-10 position-relative mx-auto">
							<div class="auth-content py-8">
								<form class="w-100" action="{{route('login')}}" method="POST">
									@csrf
									<div class="row">
										<div class="col-lg-5 col-md-7 col-sm-10 mx-auto">
											
											<div class="card card-lg card-border">
												<div class="card-body">
													<h4 class="mb-4 text-center">Sign in to your account</h4>
													<div class="row gx-3">
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>User Name</label>
															</div>
															<input class="form-control" placeholder="Enter username or email ID" value="" type="text" name="email">
														</div>
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>Password</label>
																<a href="#" class="fs-7 fw-medium">Forgot Password ?</a>
															</div>
															<div class="input-group password-check">
																<span class="input-affix-wrapper">
																	<input class="form-control" placeholder="Enter your password" value="" type="password" name="password">
																	<a href="#" class="input-suffix text-muted">
																		<span class="feather-icon"><i class="form-icon" data-feather="eye"></i></span>
																		<span class="feather-icon d-none"><i class="form-icon" data-feather="eye-off"></i></span>
																	</a>
																</span>
															</div>
														</div>
													</div>
													<div class="d-flex justify-content-center">
														<div class="form-check form-check-sm mb-3">
															<input type="checkbox" class="form-check-input" id="logged_in" checked>
															<label class="form-check-label text-muted fs-7" for="logged_in">Keep me logged in</label>
														</div>
													</div>
													<button type="submit" class="btn btn-primary btn-uppercase btn-block">Login</button>
													<p class="p-xs mt-2 text-center">New to Jampack? <a href="{{route('register')}}"><u>Create new account</u></a></p>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /Row -->
				</div>
				<!-- /Container -->
			</div>
			<!-- /Page Body -->

			
		
		</div>
		<!-- /Main Content -->
	</div>
    <!-- /Wrapper -->

	<!-- jQuery -->
    <script src="{{asset('admin/vendors/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
   	<script src="{{asset('admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

    <!-- FeatherIcons JS -->
    <script src="{{asset('admin/dist/js/feather.min.js')}}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{asset('admin/dist/js/dropdown-bootstrap-extended.js')}}"></script>

	<!-- Simplebar JS -->
	<script src="{{asset('admin/vendors/simplebar/dist/simplebar.min.js')}}"></script>
	
	<!-- Init JS -->
	<script src="{{asset('admin/dist/js/init.js')}}"></script>
</body>
</html>