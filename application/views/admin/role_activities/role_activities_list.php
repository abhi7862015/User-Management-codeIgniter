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

                        <h4 class="mb-0 font-size-18">Roles Activities List | The Abhishek Shrivastav Blogs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/roleActivities">Roles Activities List</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="TableHeader">

                                <div class="row">
                                    <div class="col-lg-3">
                                        <h4 class="card-title">Roles Activities List</h4>
                                    </div>

                                    <div class="col-lg-9 text-right">
                                        <div class="headerButtons">
                                            <a href="<?php echo base_url(); ?>index.php/admin/RoleActivities/exportActivities"> <button class="btn btn-sm btn-warning mr-2" onclick="return (confirm('Are you sure you want to export all roles activities in xlsx format?'));"><i class="mdi mdi-download"></i>Export Activities</button></a>
                                            <button class="btn btn-sm btn-danger mr-2" id="submitBtnDeleteActivities" onclick="return (confirm('Are you sure you want to delete all the seletced Roles Activities?'));"><i class="mdi mdi-delete"></i> Bulk Delete</button>
                                            <button class="btn btn-sm btn-primary mr-2" id="submitBtnBulkActivities" onclick="return (confirm('Are you sure you want to change all the selected Roles Activities\'s status?'));"><i class="mdi mdi-do-not-disturb"></i> Bulk Status Change</button>
                                            <a href="<?php echo base_url(); ?>index.php/admin/roleActivities/addRoleActivities" class="btn btn-sm btn-success"><i class="mdi mdi-plus"></i>Add Role Activities</a>
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
                                                <th><input type='checkbox' name='roles_activities_all' value='all' id="select_all"></th>
                                                <th>S. No.</th>
                                                <th>Role Activities</th>
                                                <th width=100px>Activities Keywords/Classname</th>
                                                <!-- <th>User type <br>(at creation time)</th> -->
                                                <th>Created By</th>
                                                <th>Last Updated By</th>
                                                <th>Activities Status</th>
                                                <th>Last Update Date</th>
                                                <th>Added Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            function limit_text($text, $limit)
                                            {
                                                if (str_word_count($text, 0) > $limit) {
                                                    $words = str_word_count($text, 2);
                                                    $pos   = array_keys($words);
                                                    $text  = substr($text, 0, $pos[$limit]) . '...';
                                                }
                                                return $text;
                                            }

                                            //To list user details
                                            $count = 1;
                                            if (count($roles_activities_details) > 0) {
                                                foreach ($roles_activities_details as $rows) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><input type='checkbox' class="checkbox" name='<?php echo $rows['roles_activities_id']; ?>' value='<?php echo $rows['roles_activities_id']; ?>'></th>
                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $rows['activities_name']; ?></td>
                                                        <td><?php echo $rows['activities_keywords']; ?></td>
                                                        <!-- <td><?php if ($rows['user_type_at_creation_time'] != '') {
                                                                        echo $rows['user_type_at_creation_time'];
                                                                    } else {
                                                                        echo "Admin";
                                                                    } ?>
                                                    </td> -->
                                                        <td>
                                                            <?php
                                                            foreach ($created_by_user_details as $key => $value) {
                                                                if ($rows['roles_activities_id'] == $key) {
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
                                                                if ($rows['roles_activities_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><span class="<?php if ($rows['activities_status'] == "Active") echo 'badge badge-pill badge-success';
                                                                            else echo 'badge badge-pill badge-danger'; ?>"><?php echo $rows['activities_status']; ?></span></td>
                                                        <td><?php echo $rows['updated_date']; ?></td>
                                                        <td><?php echo $rows['added_date']; ?></td>
                                                        <td width="100px">
                                                            <a href="<?php echo base_url(); ?>index.php/admin/RoleActivities/editRoleActivities/<?php echo $rows['roles_activities_id']; ?>" class="text-primary mr-2" data-toggle="tooltip" data-placement="bottom" title="Edit Activities"><i class="mdi mdi-pencil"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/RoleActivities/enabledDisabledRoleActivities/<?php echo $rows['roles_activities_id'] . '/' . $rows['activities_status'];; ?>" class="text-danger" onclick="return (confirm('Are you sure you want to change the Roles Activities status?'));" data-toggle="tooltip" data-placement="bottom" title="Change Activities's Status"><i class="mdi mdi-circle-off-outline"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/RoleActivities/deleteRoleActivities/<?php echo $rows['roles_activities_id']; ?>" class="text-danger" onclick="return (confirm('Are you sure you want to delete the Roles Activities?'));" data-toggle="tooltip" data-placement="bottom" title="Delete Activities"><i class="mdi mdi-delete mx-2"></i></a>
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

        $("#submitBtnDeleteActivities").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/roleActivities/deleteBulkActivities");
            $("#bulk_data").submit();
        });

        $("#submitBtnBulkActivities").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/roleActivities/bulkActivitiesStatusChanged");
            $("#bulk_data").submit();
        });
    });
</script>