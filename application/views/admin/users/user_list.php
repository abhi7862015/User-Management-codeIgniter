<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">

                        <h4 class="mb-0 font-size-18">User List | ASB</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/users/userlist">User List</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Filter row started here -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Filter</h5>

                            <form class="" method="get" action='<?php echo base_url(); ?>index.php/admin/users/filterOutUser'>

                                <div class="row">

                                    <div class="col-lg-4 col-md-4">
                                        <label class="sr-only" for="inlineFormSearchl2">Search</label>
                                        <div class="input-group mb-2 mr-sm-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="mdi mdi-magnify"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="search" id="inlineFormSearchl2" value="<?php if (isset($searched)) echo $searched; ?>" placeholder="Search">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <select class="form-control" id="circleVillage" name="userStatus">
                                            <option value="">Select User Status</option>
                                            <option value="Active" <?php if (isset($user_status) && $user_status == "Active") echo 'selected'; ?>>Active</option>
                                            <option value="Inactive" <?php if (isset($user_status) && $user_status == "Inactive") echo 'selected'; ?>>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4">
                                        <select class="form-control" id="circleVillage" name="userType">
                                            <option value="">Select User Type</option>
                                            <?php
                                            foreach ($roles_details as $rows) {
                                                if ($rows['role_status'] == 'Active') { ?>
                                                    <option value="<?php echo $rows['role_name'] ?>" <?php if (isset($user_type)  && $user_type == $rows['role_name']) echo 'selected'; ?>><?php echo $rows['role_name'] ?></option>
                                            <?php
                                                }
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-md-12 text-right">
                                        <button type="submit" name="submit" value="Searched" class="btn btn-primary mb-2">Submit</button>
                                        <a href="<?php echo base_url(); ?>index.php/admin/users/userlist"><button type="button" name="reset" value="Reset" class="btn btn-secondary ml-2 mb-2">Reset</button></a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Filter end row here -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="TableHeader">

                                <div class="row">
                                    <div class="col-lg-3">
                                        <h4 class="card-title">User List</h4>
                                    </div>

                                    <div class="col-lg-9 text-right">
                                        <div class="headerButtons">
                                            <a href="<?php echo base_url(); ?>index.php/admin/users/exportUsers"> <button class="btn btn-sm btn-warning mr-2" onclick="return (confirm('Are you sure you want to export all users in xlsx format?'));"><i class="mdi mdi-download"></i>Export Users</button></a>
                                            <button class="btn btn-sm btn-danger mr-2" id="submitBtnDeleteUsers" onclick="return (confirm('Are you sure you want to delete all the seletced Users?'));"><i class="mdi mdi-delete"></i> Bulk Delete</button>
                                            <button class="btn btn-sm btn-primary mr-2" id="submitBtnBulkUsers" onclick="return (confirm('Are you sure you want to change all the selected Users\'s status?'));"><i class="mdi mdi-do-not-disturb"></i> Bulk Status Change</button>
                                            <a href="<?php echo base_url(); ?>index.php/admin/users/addUser" class="btn btn-sm btn-success"><i class="mdi mdi-plus"></i>Add User</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <?php if (isset($_SESSION['success_msg'])) { ?>
                                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:green;"><?php echo $_SESSION['success_msg'];
                                                                                                                unset($_SESSION['success_msg']);
                                                                                                                ?></span></div><br>
                            <?php }
                            if (isset($_SESSION['failure_msg'])) { ?>
                                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:red;"><?php echo $_SESSION['failure_msg'];
                                                                                                            unset($_SESSION['failure_msg']);
                                                                                                            ?></span></div><br>

                            <?php } ?>

                            <form method="post" id="bulk_data">
                                <div class="table-responsive">
                                    <table class="table mb-0 listingData dt-responsive" id="datatable">
                                        <thead>
                                            <tr>
                                                <th><input type='checkbox' name='user_all' value='all' id="select_all"></th>
                                                <th>S. No.</th>
                                                <th>Name</th>
                                                <!-- <th>Email</th> -->
                                                <th>Username</th>
                                                <th>Role (user_type)</th>
                                                <!-- <th>User type <br>(this user added by)</th> -->
                                                <th>Created By</th>
                                                <th>Last Edited By</th>
                                                <th>User Status</th>
                                                <th>Last Update Date</th>
                                                <th>Added Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //To list user details
                                            $count = 1;
                                            if (count($user_details) > 0) {
                                                foreach ($user_details as $rows) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><input type='checkbox' class="checkbox" name='<?php echo $rows['user_id']; ?>' value='<?php echo $rows['user_id']; ?>'></th>

                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $rows['first_name'] . " " . $rows['middle_name'] . " " . $rows['last_name']; ?></td>
                                                        <!-- <td ><?php echo $rows['email']; ?></td> -->
                                                        <td><?php echo $rows['user_name']; ?></td>
                                                        <td><?php echo $rows['user_type']; ?>
                                                        </td>
                                                        <!-- <td width=100px><?php if ($rows['user_type_at_creation_time'] != '') {
                                                                                    echo $rows['user_type_at_creation_time'];
                                                                                } else {
                                                                                    echo "Admin";
                                                                                } ?>
                                                        </td> -->
                                                        <td width=100px>
                                                            <?php
                                                            foreach ($created_by_user_details as $key => $value) {
                                                                if ($rows['user_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            foreach ($edited_by_user_details as $key => $value) {
                                                                if ($rows['user_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>

                                                        <td><span class="<?php if ($rows['user_status'] == "Active") echo 'badge badge-pill badge-success';
                                                                            else echo 'badge badge-pill badge-danger'; ?>"><?php echo $rows['user_status']; ?></span></td>
                                                        <td><?php echo $rows['updated_date']; ?></td>
                                                        <td><?php echo $rows['added_date']; ?></td>
                                                        <td width=100px>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/users/editUser/<?php echo $rows['user_id']; ?>" class="text-primary mr-1" data-toggle="tooltip" data-placement="bottom" title="Edit User"><i class="mdi mdi-pencil"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/users/assignRoles/<?php echo $rows['user_id']; ?>" class="text-primary mr-1" data-toggle="tooltip" data-placement="bottom" title="Assign Roles to this User"><i class="mdi mdi-plus-box"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/users/enabledDisabledUser/<?php echo $rows['user_id']; ?>" class="text-danger" <?php if ($rows['user_type'] == NULL) { ?>onclick="return (confirm('First, you need to assign the user\'s role'));" <?php } else { ?>onclick="return (confirm('Are you sure you want to change the user\'s status?'));" <?php } ?> data-toggle="tooltip" data-placement="bottom" title="Change User's Status"><i class="mdi mdi-circle-off-outline"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/users/deleteUser/<?php echo $rows['user_id']; ?>" class="text-danger" onclick="return (confirm('Are you sure you want to delete the user?'));" data-toggle="tooltip" data-placement="bottom" title="Delete User"><i class="mdi mdi-delete mx-2"></i></a>

                                                        </td>
                                                    </tr>
                                            <?php
                                                    $count++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end main content-->


<script>
    $(document).ready(function() {
        $('#select_all').on('click', function() {
            if (this.checked) {
                $('.checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function() {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });

        $("#submitBtnDeleteUsers").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/Users/deleteBulkUsers");
            $("#bulk_data").submit();
        });

        $("#submitBtnBulkUsers").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/Users/bulkUsersStatusChanged");
            $("#bulk_data").submit();
        });
    });
</script>