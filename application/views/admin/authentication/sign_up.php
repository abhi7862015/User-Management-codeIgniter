<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Signup | ASB - The Abhishek Shrivastav Blogs</title>
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
							<div class="row" >
								<div class="col-lg-12">
									<div class="text-primary p-4">
										<h5 class="text-primary">Welcome to the world of the ASB</h5>
										<p>Sign up to ASB | The Abhishek Shrivastav Blogs.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body pt-3">
						<?php if (isset($_SESSION['success_msg'])) { ?>
                                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:green; font-size:16px;"><?php echo $_SESSION['success_msg'];
                                                                                                                unset($_SESSION['success_msg']);
                                                                                                                ?></span></div><br>
                            <?php }
                            if (isset($_SESSION['failure_msg'])) { ?>
                                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:red;font-size:16px;"><?php echo $_SESSION['failure_msg'];
                                                                                                            unset($_SESSION['failure_msg']);
                                                                                                            ?></span></div><br>

                            <?php } ?>
								<div class="pt-4 ">
								<form class="form-horizontal" method="post" action="">

									<div class="form-group">
										<label for="first_name">First Name</label>
										<input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" id="first_name" placeholder="Enter your First Name">
										<span style="color:red; font-size:13px;"><?php echo form_error('first_name');  ?></span>
									</div>

									<div class="form-group">
										<label for="middle_name">Middle Name</label>
										<input type="text" class="form-control" name="middle_name" value="<?php echo $middle_name; ?>" id="middle_name" placeholder="Enter your Middle Name">
										<span style="color:red; font-size:13px;"><?php echo form_error('middle_name');  ?></span>
									</div>

									<div class="form-group">
										<label for="last_name">Last Name</label>
										<input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>" id="last_name" placeholder="Enter your Last Name">
										<span style="color:red; font-size:13px;"><?php echo form_error('last_name');  ?></span>
									</div>

									<div class="form-group">
										<label for="email">Email</label>
										<input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="email" placeholder="Create your Email ID">
										<span style="color:red; font-size:13px;"><?php echo form_error('email');  ?></span>
									</div>

									<div class="form-group">
										<label for="username">Username</label>
										<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" id="username" placeholder="Create your username">
										<span style="color:red; font-size:13px;"><?php echo form_error('username');  ?></span>
									</div>

									<div class="form-group">
										<label for="password">Password</label>
										<input type="text" class="form-control" name="password" value="<?php echo $password; ?>" id="password" placeholder="Enter your Password">
										<span style="color:red; font-size:13px;"><?php echo form_error('password');  ?></span>
									</div>


									<div class="form-group">
										<label for="confirm_password">Confirm Password</label>
										<input type="password" class="form-control" name="confirm_password" value="<?php echo $confirm_password; ?>" id="confirm_password" placeholder="Confirm your password">
										<span style="color:red; font-size:13px;"><?php echo form_error('confirm_password');  ?></span>
									</div>

									<!-- <div class="form-group">
										<label for="user_type">User Type</label>
										<select name="user_type" class="form-control" id="user_type" disabled>
											<option value="">Select User type</option>?
											<option value="Admin" <?php if ($user_type == "Admin") echo "selected"; ?>> Admin</option>
											<option value="Editor" <?php if ($user_type == "Editor") echo "selected"; ?>>Editor</option>
											<option value="Viewer" <?php if ($user_type == "Viewer") echo "selected"; ?>>Viewer</option>
										</select>
										<span style="color:red; font-size:13px;"><?php echo form_error('user_type');  ?></span>
									</div> -->
									<br>

									<div class="mt-3">
										<button type="submit" class="btn btn-success btn-block waves-effect waves-light" name="signup" value="Signup" type="submit">Sign up</button>
									</div>
								</form>
							</div>
						</div>
						<div class="mt-5 text-center">
							<div>
								<p>Already registrered?<a href="<?php echo base_url() ?>index.php/admin/authentication/login" class="font-weight-medium text-primary"> Log in </a>here </p>
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
