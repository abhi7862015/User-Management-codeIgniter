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

                        <h4 class="mb-0 font-size-18">Roles List | The Abhishek Shrivastav Blogs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/roles">Blogs List</a></li>
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
                                        <h4 class="card-title">Roles List</h4>
                                    </div>

                                    <div class="col-lg-9 text-right">
                                        <div class="headerButtons">
                                            <a href="<?php echo base_url(); ?>index.php/admin/Roles/exportRoles"> <button class="btn btn-sm btn-warning mr-2" onclick="return (confirm('Are you sure you want to export all roles in xlsx format?'));"><i class="mdi mdi-download"></i>Export Roles</button></a>
                                            <button class="btn btn-sm btn-danger mr-2" id="submitBtnDeleteRoles" onclick="return (confirm('Are you sure you want to delete all the seletced Roles?'));"><i class="mdi mdi-delete"></i> Bulk Delete</button>
                                            <button class="btn btn-sm btn-primary mr-2" id="submitBtnBulkRoles" onclick="return (confirm('Are you sure you want to change all the selected Role\'s status?'));"><i class="mdi mdi-do-not-disturb"></i> Bulk Status Change</button>
                                            <a href="<?php echo base_url(); ?>index.php/admin/roles/addRole" class="btn btn-sm btn-success"><i class="mdi mdi-plus"></i>Add Role</a>
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
                                                <th><input type='checkbox' name='role_all' value='all' id="select_all"></th>

                                                <th>S. No.</th>
                                                <th>Roles/Designation</th>
                                                <th>Description</th>
                                                <!-- <th>User type <br>(at creation time)</th> -->
                                                <th>Created By</th>
                                                <th>Last Updated By</th>
                                                <th>Roles Status</th>
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
                                            if (count($roles_details) > 0) {
                                                foreach ($roles_details as $rows) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><input type='checkbox' class="checkbox" name='<?php echo $rows['role_id']; ?>' value='<?php echo $rows['role_id']; ?>'></th>
                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $rows['role_name']; ?></td>
                                                        <td width=400px><?php echo limit_text($rows['role_description'], 15); ?></td>
                                                        <!-- <td><?php if ($rows['user_type'] != '') {
                                                                        echo $rows['user_type'];
                                                                    } else {
                                                                        echo "Admin";
                                                                    } ?>
                                                    </td> -->
                                                        <td>
                                                            <?php
                                                            foreach ($created_by_user_details as $key => $value) {
                                                                if ($rows['role_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                        <td>
                                                            <?php
                                                            foreach ($edited_by_user_details as $key => $value) {
                                                                if ($rows['role_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?></td>
                                                        <td><span class="<?php if ($rows['role_status'] == "Active") echo 'badge badge-pill badge-success';
                                                                            else echo 'badge badge-pill badge-danger'; ?>"><?php echo $rows['role_status']; ?></span></td>
                                                        <td><?php echo $rows['updated_date']; ?></td>
                                                        <td><?php echo $rows['added_date']; ?></td>
                                                        <td width=150px>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/roles/editRole/<?php echo $rows['role_id']; ?>" class="text-primary mr-2" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                                            <?php
                                                            foreach ($checked_roles_activities_details as $role_id => $checked_roles_activities) {
                                                                if ($role_id == $rows['role_id']) {

                                                            ?>
                                                                    <a href="<?php if ($_SESSION['user_type'] != 'Admin') { ?><?php echo base_url(); ?>index.php/admin/roles/checkUserAuthorization_OnRoleAssignment<?php } ?>" class="text-primary mr-2 open-AddBookDialog_<?php echo $rows['role_id']; ?>" <?php if ($_SESSION['user_type'] == 'Admin') {
                                                                                                                                                                                                                                                                                                                    echo "data-toggle=\"modal\"";
                                                                                                                                                                                                                                                                                                                } ?> data-target="#activities_assignment_<?php echo $rows['role_id']; ?>" data-id="<?php echo $rows['role_id']; ?>"><i class="mdi mdi-pipe" data-toggle="tooltip" data-placement="bottom" title="Make Relation with Activities"></i></a>

                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/roles/seeAllAssignedActivitiesList/<?php echo $rows['role_id']; ?>" class="text-primary mr-2"><i class="mdi mdi-pipe" data-toggle="tooltip" data-placement="bottom" title="Make Relation with Activities"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/roles/enabledDisabledRole/<?php echo $rows['role_id'] . '/' . $rows['role_status'];; ?>" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Change Role's Status" onclick="return (confirm('Are you sure you want to change the Roles/Designation status?'));"><i class="mdi mdi-circle-off-outline"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/roles/deleteRole/<?php echo $rows['role_id']; ?>" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Role" onclick="return (confirm('Are you sure you want to delete the Roles/Designation?'));"><i class="mdi mdi-delete mx-2"></i></a>

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

        $("#submitBtnDeleteRoles").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/Roles/deleteBulkRoles");
            $("#bulk_data").submit();
        });

        $("#submitBtnBulkRoles").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/Roles/bulkRolesStatusChanged");
            $("#bulk_data").submit();
        });
    });
</script>
<!-- Modal -->

<?php foreach ($checked_roles_activities_details as $role_id => $checked_roles_activities) {
    $CI = new Roles_details_model();
    $role_name = $CI->getRoleById($role_id);
    if ($role_name[0]['role_name'] == 'Admin') {
?>
        <script>
            $(document).on("click", ".open-AddBookDialog_<?php echo $role_id; ?>", function() {
                var myroleId = $(this).data('id');
                var myBookIdVAlue = $("#roleId_<?php echo $role_id; ?>").val(myroleId);
            });
        </script>
        <div class="modal fade bd-example-modal-lg" id="activities_assignment_<?php echo $role_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/Roles/assignRoleActivities">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Assign Activities to their Roles</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- modal body Start -->
                        <div class="modal-body">

                            <span style="color:red; font-weight:1000;">NOTE:</span><span style="color:orange;font-weight:500;"> Please select any activities type to assign activties to the current role. </span>
                            <br>
                            <br>
                            <input class="form-check-input" id="roleId_<?php echo $role_id; ?>" type="hidden" name="roleId" value="">

                            <div class="table-responsive">
                                <table class="table mb-0 listingData dt-responsive" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th><input type='checkbox' name='role_all' value='all' id="select_all"></th>
                                            <th>Activities Name (Real Class Name)</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($all_roles_activities_details as $rows) {
                                        ?>
                                            <div class="form-check">
                                                <tr>
                                                    <td><input class="form-check-input" type="checkbox" checked name="<?php echo $rows['roles_activities_id']; ?>" value="<?php echo $rows['roles_activities_id']; ?>" id="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>"></td>
                                                    <td><?php echo $count; ?></td>
                                                    <td><label class="form-check-label" for="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
                                                            <?php echo $rows['activities_name']; ?>
                                                        </label>
                                                    </td>
                                                    <td><?php echo $rows['activities_description']; ?></td>
                                                </tr>
                                            </div>
                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- modal body End -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit" value="Submit">Assign Activities</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {

        if (count($checked_roles_activities) > 0) {
        ?>
            <script>
                $(document).on("click", ".open-AddBookDialog_<?php echo $role_id; ?>", function() {
                    var myroleId = $(this).data('id');
                    var myBookIdVAlue = $("#roleId_<?php echo $role_id; ?>").val(myroleId);
                });
            </script>
            <div class="modal fade bd-example-modal-lg" id="activities_assignment_<?php echo $role_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/Roles/assignRoleActivities">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Assign Activities to their Roles</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <span style="color:red; font-weight:1000;">NOTE:</span><span style="color:orange;font-weight:500;"> Please select any activities type to assign activties to the current role. </span>
                                <br>
                                <br>
                                <input class="form-check-input" id="roleId_<?php echo $role_id; ?>" type="hidden" name="roleId" value="">

                                <div class="table-responsive">
                                    <table class="table mb-0 listingData dt-responsive" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th><input type='checkbox' name='role_all' value='all' id="select_all"></th>
                                                <th>Activities Name (Real Class Name)</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($all_roles_activities_details as $rows) {
                                            ?> <tr>
                                                    <div class="form-check">
                                                        <td><?php echo $count; ?></td>
                                                        <td> <input class="form-check-input" type="checkbox" name="<?php echo $rows['roles_activities_id']; ?>" <?php foreach ($checked_roles_activities as $values) {
                                                                                                                                                                    if ($rows['roles_activities_id'] == $values['roles_activities_id']) echo "checked";
                                                                                                                                                                } ?> value="<?php echo $rows['roles_activities_id']; ?>" id="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
                                                        </td>
                                                        <td> <label class="form-check-label" for="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
                                                                <?php echo $rows['activities_name']; ?>
                                                            </label>
                                                        </td>
                                                        <td><?php echo $rows['activities_description']; ?></td>
                                                    </div>
                                                </tr>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Assign Activities</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else {
        ?>
            <script>
                $(document).on("click", ".open-AddBookDialog_<?php echo $role_id; ?>", function() {
                    var myroleId = $(this).data('id');
                    var myBookIdVAlue = $("#roleId_<?php echo $role_id; ?>").val(myroleId);
                });
            </script>
            <div class="modal fade bd-example-modal-lg" id="activities_assignment_<?php echo $role_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/Roles/assignRoleActivities">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Assign Activities to their Roles</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <span style="color:red; font-weight:1000;">NOTE:</span><span style="color:orange;font-weight:500;"> Please select any activities type to assign activties to the current role. </span>
                                <br>
                                <br>
                                <input class="form-check-input" id="roleId_<?php echo $role_id; ?>" type="hidden" name="roleId" value="">

                                <div class="table-responsive">
                                    <table class="table mb-0 listingData dt-responsive" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S. No.</th>
                                                <th><input type='checkbox' name='role_all' value='all' id="select_all"></th>
                                                <th>Activities Name (Real Class Name)</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($all_roles_activities_details as $rows) {
                                            ?>
                                                <tr>
                                                    <div class="form-check">
                                                        <td><?php echo $count; ?></td>
                                                        <td><input class="form-check-input" type="checkbox" name="<?php echo $rows['roles_activities_id']; ?>" value="<?php echo $rows['roles_activities_id']; ?>" id="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
                                                        </td>
                                                        <td><label class="form-check-label" for="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
                                                                <?php echo $rows['activities_name']; ?>
                                                            </label>
                                                        </td>
                                                        <td><?php echo $rows['activities_description']; ?></td>
                                                    </div>
                                                </tr>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Assign Activities</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php
        }
    }
} ?>