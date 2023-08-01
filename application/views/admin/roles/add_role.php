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

                        <h4 class="mb-0 font-size-18">Add New Role | The Abhishek Shrivastav Blogs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/roles">Roles List</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/roles/addRole">Add Role</a></li>
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
                            <h5 class="text-primary">Add New Role on ASB | The Abhishek Shrivastav Blogs </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="pt-4 ">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/roles/addRole">

                        <div class="form-group">
                            <label for="role_name">Role Name<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="role_name" value="<?php echo  $role_name;
                                                                                                ?>" id="role_name" placeholder="Role Name">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('role_name');
                                                                        ?></span>
                        </div>

                       

                        <div class="form-group">
                            <label for="role_description">Role Description<span style="color:red;">*</span></label>
                            <textarea class="form-control" name="role_description" id="role_description"><?php echo  $role_description;
                                                                                                ?></textarea>
                            <span style="color:red; font-size:13px;"><?php echo  form_error('role_description');
                                                                        ?></span>
                        </div>

                      
                        <br>


                        <div class="mt-3">

                            <button type="submit" class="btn btn-success waves-effect waves-light float-right" name="submit" value="Submit">Submit</button>
                            <a href="<?php echo base_url(); ?>index.php/admin/roles"><button type="button" class="btn btn-primary waves-effect waves-light float-right mx-2" name="cancel">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-center">

            </div>
        </div>
    </div>
</div>