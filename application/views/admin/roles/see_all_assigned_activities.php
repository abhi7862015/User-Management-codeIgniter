
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/Roles/assignRoleActivities">
                                <span style="color:red; font-weight:1000;">NOTE:</span><span style="color:orange;font-weight:500;"> Please select any activities type to assign activties to the current role. </span>
                                <br>
                                <br>
                                <input class="form-check-input" type="hidden" name="roleId" value="<?php echo $role_id; ?>">

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
                                            <?php $CI = new Roles_details_model();
                                            $role_name = $CI->getRoleById($role_id);
                                            if ($role_name[0]['role_name'] == 'Admin') {
                                                $count = 1;
                                                foreach ($all_roles_activities_details as $rows) {
                                            ?>
                                                    <div class="form-check">
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><input class="form-check-input checkbox" type="checkbox"  checked name="<?php echo $rows['roles_activities_id']; ?>" value="<?php echo $rows['roles_activities_id']; ?>" id="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>"></td>
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
                                            } else {

                                                if (count($checked_roles_activities_details) > 0) {

                                                    $count = 1;
                                                    foreach ($all_roles_activities_details as $rows) {
                                                    ?>
                                                        <tr>
                                                            <div class="form-check">
                                                                <td><?php echo $count; ?></td>
                                                                <td> <input class="form-check-input checkbox" type="checkbox" name="<?php echo $rows['roles_activities_id']; ?>" <?php foreach ($checked_roles_activities_details as $values) {
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
                                                } else {
                                                    $count = 1;
                                                    foreach ($all_roles_activities_details as $rows) {
                                                    ?>
                                                        <tr>
                                                            <div class="form-check">
                                                                <td><?php echo $count; ?></td>
                                                                <td><input class="form-check-input checkbox" type="checkbox"  name="<?php echo $rows['roles_activities_id']; ?>" value="<?php echo $rows['roles_activities_id']; ?>" id="roles_activities_id_<?php echo $rows['roles_activities_id']; ?>">
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
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- modal body End -->
                                <div class="modal-footer">
                                    <a href="<?php echo base_url(); ?>index.php/admin/roles"><button type="button" class="btn btn-secondary waves-effect waves-light float-right mx-2" name="cancel">Cancel</button></a>
                                    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Assign Activities</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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

      
    });
</script>