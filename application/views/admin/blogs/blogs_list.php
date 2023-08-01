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

                        <h4 class="mb-0 font-size-18">Blogs List | The Abhishek Shrivastav Blogs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/blogs">Blogs List</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <!--<div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Filter</h5>

                            <form class="" method="get" action='<?php echo base_url(); ?>index.php/admin/dashboard/filterOutUser'>

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
                                            <option value="Admin" <?php if (isset($user_type)  && $user_type == 'Admin') echo 'selected'; ?>>Admin</option>
                                            <option value="Viewer" <?php if (isset($user_type) && $user_type == 'Viewer') echo 'selected'; ?>>Viewer</option>
                                            <option value="Updater" <?php if (isset($user_type) && $user_type == 'Updater') echo 'selected'; ?>>Updater</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-md-12 text-right">
                                        <button type="submit" name="submit" value="Searched" class="btn btn-primary mb-2">Submit</button>
                                        <a href="<?php echo base_url(); ?>index.php/admin/dashboard/userlist"><button type="button" name="reset" value="Reset" class="btn btn-secondary ml-2 mb-2">Reset</button></a>
                                    </div>

                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="TableHeader">

                                <div class="row">
                                    <div class="col-lg-3">
                                        <h4 class="card-title">Blogs List</h4>
                                    </div>

                                    <div class="col-lg-9 text-right">
                                        <div class="headerButtons">
                                            <a href="<?php echo base_url(); ?>index.php/admin/blogs/exportBlogs"> <button class="btn btn-sm btn-warning mr-2" onclick="return (confirm('Are you sure you want to export all blogs in xlsx format?'));"><i class="mdi mdi-download"></i>Export Blogs</button></a>
                                            <button class="btn btn-sm btn-danger mr-2" id="submitBtnDeleteBlogs" onclick="return (confirm('Are you sure you want to delete all the seletced Blogs?'));"><i class="mdi mdi-delete"></i> Bulk Delete</button>
                                            <button class="btn btn-sm btn-primary mr-2" id="submitBtnBulkStatus" onclick="return (confirm('Are you sure you want to change all the selected Blog\'s status?'));"><i class="mdi mdi-do-not-disturb"></i> Bulk Status Change</button>
                                            <a href="<?php echo base_url(); ?>index.php/admin/blogs/addBlog" class="btn btn-sm btn-success"><i class="mdi mdi-plus"></i>Add Blog</a>
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
                                                <th><input type='checkbox' name='blog_all' value='all' id="select_all"></th>
                                                <th>S. No.</th>
                                                <th>Blog Title</th>
                                                <th>Categoies Name</th>
                                                <!-- <th >User type <br>(at creation time)</th> -->
                                                <th width=100px>Created By</th>
                                                <th>Last Edited By</th>
                                                <th>Blogs Status</th>
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
                                            if (count($blogs_details) > 0) {
                                                foreach ($blogs_details as $rows) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><input type='checkbox' class="checkbox" name='<?php echo $rows['blog_id']; ?>' value='<?php echo $rows['blog_id']; ?>'></th>
                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $rows['blog_title']; ?></td>
                                                        <td>
                                                            <?php
                                                            foreach ($blogs_categories_details as $key => $value) {
                                                                if ($rows['blog_id'] == $key) {
                                                                    echo $value[0]['categories_name'];
                                                                }
                                                            }
                                                            ?></td>
                                                        <!-- <td><?php if ($rows['user_type_at_creation_time'] != '') {
                                                                        echo $rows['user_type_at_creation_time'];
                                                                    } else {
                                                                        echo "Admin";
                                                                    } ?></td> -->

                                                        <td>
                                                            <?php
                                                            foreach ($created_by_user_details as $key => $value) {
                                                                if ($rows['blog_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                        <td>
                                                            <?php
                                                            foreach ($edited_by_user_details as $key => $value) {
                                                                if ($rows['blog_id'] == $key) {
                                                                    if (count($value) > 0) {
                                                                        echo $value[0]['first_name'] . " " . $value[0]['last_name'];
                                                                    }
                                                                }
                                                            }
                                                            ?></td>
                                                        <td><span class="<?php if ($rows['blog_status'] == "Active") echo 'badge badge-pill badge-success';
                                                                            else echo 'badge badge-pill badge-danger'; ?>"><?php echo $rows['blog_status']; ?></span></td>

                                                        <td><?php echo $rows['updated_date']; ?></td>
                                                        <td><?php echo $rows['added_date']; ?></td>
                                                        <td width=100px>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/blogs/editBlog/<?php echo $rows['blog_id'] ?>" class="text-primary mr-2"><i class="mdi mdi-pencil" data-toggle="tooltip" data-placement="bottom" title="Edit Blogs"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/blogs/enabledDisabledBlog/<?php echo $rows['blog_id'] . '/' . $rows['blog_status'];; ?>" class="text-danger" onclick="return (confirm('Are you sure you want to change the Blogs status?'));" data-toggle="tooltip" data-placement="bottom" title="Change Blog's Status"><i class="mdi mdi-circle-off-outline"></i></a>
                                                            <a href="<?php echo base_url(); ?>index.php/admin/blogs/deleteBlog/<?php echo $rows['blog_id']; ?>" class="text-danger" onclick="return (confirm('Are you sure you want to delete the Blogs?'));" data-toggle="tooltip" data-placement="bottom" title="Delete Blog"><i class="mdi mdi-delete mx-2"></i></a>

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

        $("#submitBtnDeleteBlogs").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/blogs/deleteBulkBlogs");
            $("#bulk_data").submit();
        });

        $("#submitBtnBulkStatus").click(function() {
            $("#bulk_data").attr('action', "<?php echo base_url(); ?>index.php/admin/blogs/bulkBlogsStatusChanged");
            $("#bulk_data").submit();
        });
    });
</script>