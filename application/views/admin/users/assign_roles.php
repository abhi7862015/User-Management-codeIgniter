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

                        <h4 class="mb-0 font-size-18">Assign Roles to the User</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users/userlist">User List</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users/adduser">Add User</a></li>
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
                            <h5 class="text-primary">Assign Roles to the User on ASB | The Abhishek Shrivastav Blogs </h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            //    echo "<pre>";
            //    print_r($roles_details);die;?>
            <div class="card-body pt-3">
                <div class="pt-4 ">
                    <form class="form-horizontal" method="post" action="">

                        <div class="form-group">
                            <label for="user_type">Assign Role</label>
                            <select name="user_type" class="form-control" id="user_type">
                                <option value="">Select Roles</option>
                                <?php
                             
                                if (count($roles_details) > 0) {

                                    foreach($roles_details as $rows) {
                                        if ($rows['role_status'] == 'Active') {
                                ?>
                                            <option value="<?php echo $rows['role_name']; ?>" <?php if ($user_type == $rows['role_name']) echo  "selected"; ?>> <?php echo $rows['role_name']; ?></option>

                                <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <span style="color:red; font-size:13px;"><?php echo  form_error('user_type'); ?></span>
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