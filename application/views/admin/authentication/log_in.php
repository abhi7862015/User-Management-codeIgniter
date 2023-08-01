<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Log in | ASB - The Abhishek Shrivastav Blogs</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesbrand" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

	<!-- Bootstrap Css -->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?php echo base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

	<div class="home-btn d-none d-sm-block">
		<a href="#" class="text-dark"><i class="fas fa-home h2"></i></a>
	</div>
	<div class="account-pages my-5 pt-sm-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="card overflow-hidden">
						<div class="bg-soft-success">
							<div class="row">
								<div class="col-lg-12">
									<div class="text-primary p-4">
										<h5 class="text-primary">Welcome back!</h5>
										<p>Log in to ASB | The Abhishek Shrivastav Blogs.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body pt-3">
							<div class="pt-4 ">
								<form class="form-horizontal" method="post" action="">

									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" id="username" placeholder="Enter your username">
										<span style="color:red; font-size:13px;"><?php echo form_error('username');  ?></span>
									</div>

									<div class="form-group">
										<label for="password">Password</label>
										<input type="text" class="form-control" name="password" value="<?php echo $password; ?>" id="password" placeholder="Enter your Password">
										<span style="color:red; font-size:13px;"><?php echo form_error('password');  ?></span>
									</div>
									<div> <span style="color:red; font-size:13px;"><?php if(isset($errors[0])) echo $errors[0];  ?></span></div>
										<br>
										<div class="mt-3">
											<button type="submit" class="btn btn-success btn-block waves-effect waves-light" name="submit" value="Login" type="submit">Log in</button>
										</div>
								</form>
							</div>
						</div>
						<div class="mt-5 text-center">
							<div>
								<p>Don't have any account? <a href="<?php echo base_url() ?>index.php/admin/authentication/signup" class="font-weight-medium text-primary">Sign Up </a>here </p>
								<p>© Copyright <i class="mdi mdi-heart text-danger"> </i>ASB | The Abhishek Shrivastav Blogs</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JAVASCRIPT -->
	<script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>

	<!-- App js -->
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
</body>

</html>