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

                        <h4 class="mb-0 font-size-18">Add Edit Blog Category | The Abhishek Shrivastav Blog</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/bloBlogsCategoriesgs">Blogs Categories List</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/BlogsCategories/editCategories/<?php echo  $categories_id;?>">Edit Blog Category</a></li>
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
                            <h5 class="text-primary">Add Edit Blog Category on ASB | The Abhishek Shrivastav Blog </h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($success_msg)) { ?>
                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:green;"><?php echo $success_msg;
                                                                                                ?></span></div>
            <?php } ?>
            <?php if (isset($failure_msg)) { ?>
                <div style="margin-top: 1rem; margin-left: 1rem;"><span style="color:red;"><?php echo $failure_msg;
                                                                                            ?></span></div>
            <?php }
            ?>
            <div class="card-body pt-3">
                <div class="pt-4 ">
                    <form class="form-horizontal" method="post" action="">

                        <div class="form-group">
                            <label for="categories_name">Category Name<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="categories_name" value="<?php echo  $categories_name;
                                                                                                    ?>" id="categories_name" placeholder="Category Name">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('categories_name');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="categories_desc">Category Description<span style="color:red;">*</span></label>
                            <input class="form-control" name="categories_desc" value="<?php echo $categories_desc; ?>" id="categories_desc" placeholder="Category Description">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('categories_desc');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="categories_keywords">Categories Keywords<span style="color:red;">*</span></label>
                            <input class="form-control" name="categories_keywords" value="<?php echo $categories_keywords;
                                                                                            ?>" id="categories_keywords" placeholder="Add Keywords for categories">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('categories_keywords'); ?></span>
                        </div>

                       
                        <br>

                        <div class="mt-3">

                            <button type="submit" class="btn btn-success waves-effect waves-light float-right" name="submit" value="Submit">Submit</button>
                            <a href="<?php echo base_url(); ?>index.php/admin/BlogsCategories"><button type="button" class="btn btn-primary waves-effect waves-light float-right mx-2" name="cancel">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-center">

            </div>
        </div>
    </div>
</div>