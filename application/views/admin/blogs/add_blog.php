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

                        <h4 class="mb-0 font-size-18">Add New Blog | The Abhishek Shrivastav Blog</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/blogs">Blogs List</a></li>
                                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>index.php/admin/blogs/addblog">Add Blog</a></li>
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
                            <h5 class="text-primary">Add New Blog on ASB | The Abhishek Shrivastav Blog </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="pt-4 ">
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/admin/blogs/addBlog">

                        <div class="form-group">
                            <label for="blog_title">Blog Title<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="blog_title" value="<?php echo  $blog_title;
                                                                                                ?>" id="blog_title" placeholder="Blog Title">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('blog_title');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="blogs_categories">Select Blog Categories<span style="color:red;">*</span></label>
                            <select class="form-control" name="blogs_categories" id="blogs_categories">
                                <option value="">Select Blogs Categories</option>
                                <?php
                                foreach ($categories_details as $rows) {
                                    if ($rows['categories_status'] == "Active") {
                                ?>
                                        <option value="<?php echo $rows['blogs_categories_id'];
                                                        ?>" <?php if ($rows['blogs_categories_id'] == $blogs_categories_id) {
                                                                echo 'selected';
                                                            } ?>><?php echo $rows['categories_name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <span style="color:red; font-size:13px;"><?php echo  form_error('blogs_categories');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="short_desc">Short Description<span style="color:red;">*</span></label>
                            <textarea class="form-control" name="short_desc" id="short_desc"><?php echo  $short_desc;
                                                                                                ?></textarea>
                            <span style="color:red; font-size:13px;"><?php echo  form_error('short_desc');
                                                                        ?></span>
                        </div>

                        <div class="form-group">
                            <label for="blog_content">Blog Content<span style="color:red;">*</span></label>
                            <textarea class="form-control" name="blog_content" id="blog_content"><?php echo  $blog_content;
                                                                                                    ?></textarea>
                            <span style="color:red; font-size:13px;"><?php echo  form_error('blog_content'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="blog_keywords">Blog Keywords<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="blog_keywords" value="<?php echo  $blog_keywords;
                                                                                                ?>" id="blog_keywords" placeholder="Enter Keywords by commas separated">
                            <span style="color:red; font-size:13px;"><?php echo  form_error('blog_keywords'); ?></span>
                        </div>

                       
                        <br>


                        <div class="mt-3">

                            <button type="submit" class="btn btn-success waves-effect waves-light float-right" name="submit" value="Submit">Submit</button>
                            <a href="<?php echo base_url(); ?>index.php/admin/blogs"><button type="button" class="btn btn-primary waves-effect waves-light float-right mx-2" name="cancel">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-center">

            </div>
        </div>
    </div>
</div>