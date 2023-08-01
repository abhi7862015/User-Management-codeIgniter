<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">

                        <h4 class="mb-0 font-size-18">Edit List | ASB</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users/userlist">User List</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users/edituser/<?php echo $user_id;?>">Edit User</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="bg-soft-success">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-primary p-4">
                            <h5 class="text-primary">Edit User details on ASB | The Abhishek Shrivastav Blogs </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <?php if (isset($success_msg)) {
                ?>
                    <div><span style="color:green; font-size:16px;"><?php echo  $success_msg;
                                                                    ?></span></div>
                <?php
                } ?>
                <div class="pt-4 ">
                    <form class="form-horizontal" method="post" action="">

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo  $first_name;
                                                                                                ?>" id="first_name" placeholder="Enter your First Name">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('first_name');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" value="<?php echo  $middle_name;
                                                                                                ?>" id="middle_name" placeholder="Enter your Middle Name">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('middle_name');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo  $last_name; ?>" id="last_name" placeholder="Enter your Last Name">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('last_name'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo  $email; ?>" id="email" placeholder="Create your Email ID">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('email'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo  $username; ?>" id="username" placeholder="Create your username">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('username'); ?></span>
                        </div>
                        <br>

                        <div class="mt-3">

                            <button type="submit" class="btn btn-success waves-effect waves-light float-right" name="submit" value="Submit">Submit</button>
                            <a href="<?php echo base_url(); ?>index.php/admin/users/userlist"><button type="button" class="btn btn-primary waves-effect waves-light float-right mx-2" name="cancel">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-center">

            </div>
        </div>
    </div>
</div>
