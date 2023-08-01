<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ASB | The Abhishek Shrivastav Blogs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Skote is a fully featured premium admin dashboard template built on top of awesome Bootstrap 4.4.1" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">

                        <a href="<?php echo base_url().'index.php/admin/dashboard'?>" class="logo logo-light">
                            <span class="logo-sm">
                                <h1 style='color:white;margin-top:20px;'><i class='mdi mdi-blogger'></i></h1>
                            </span>
                            <span class="logo-lg">
                                <h1 style='color:white;margin-top:20px;'><i class='mdi mdi-blogger mr-2'></i>ASB</h1>
                                <!-- <img src="<?php echo base_url(); ?>assets/images/logo-light.png" alt="" height="20"> -->
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-backburger"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?php echo base_url(); ?>assets/images/dummy-profile.png" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ml-1" key="t-henry">
                                <?php
                                if (count($user_details) > 0) {
                                    echo $user_details[0]['first_name'] . " " . $user_details[0]['last_name'];
                                }
                                ?>
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->

                            <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle mr-1"></i> <span key="t-lock-screen"> <?php
                                                                                                                                                        if (count($user_details) > 0) {
                                                                                                                                                            echo $user_details[0]['user_type'];
                                                                                                                                                        }
                                                                                                                                                        ?></span></a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item text-danger" href="<?php echo base_url(); ?>index.php/admin/dashboard/logout/<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i><i class="mdi mdi-logout"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Docs</li>

                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/dashboard" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/users/userlist" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>Users List</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/blogs" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>Blogs List</span>
                            </a>

                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/BlogsCategories" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>Blogs Categories List</span>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/roles" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>Roles List</span>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo base_url(); ?>index.php/admin/roleActivities" class="waves-effect">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span>Roles Activities List</span>
                            </a>
                        </li>


                        <li>
                            <a href="<?php echo base_url(); ?>index.php/frontend/Home" class="waves-effect">
                                <i class="mdi mdi-share"></i>
                                <span>Go To the Website</span>
                            </a>
                        </li>





                    </ul>

                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->