<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>asset/admin/css/bootstrap/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>asset/admin/css/metisMenu/metisMenu.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>asset/admin/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>asset/admin/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>asset/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>asset/admin/js/jquery-2.1.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>asset/admin/js/bootstrap/bootstrap.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url() ?>asset/admin/js/metisMenu/metisMenu.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url() ?>asset/admin/js/sb-admin-2.js"></script>
    <script src="<?php echo base_url() ?>asset/admin/js/jquery.validate.js"></script>
     <script src="<?php echo base_url()?>asset/vendors/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url()?>asset/vendors/ckeditor/adapters/jquery.js"></script>
</head>

 <body>
    <div id="wrapper">
        
           <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="javascript:void(0)">Best Buy Admin Panel</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-nav sidebar-icon hide-on-small">
                    <li><a href="javascript:void(0)" class="toggle-sidebar" title="Toggle Sidebar"><i class="fa fa-bars" aria-hidden="true" id="#icon-sidebar"></i></a></li>
                </ul>

                <ul class="nav navbar-top-links navbar-right">
                   
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                            
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="void(0)"> <?php echo ucfirst($this->session->userdata('name')) ?></a>
                            </li>
                             <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                          
                           
                            <li><a href="<?php echo base_url()?>index.php/admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation" id="left-sidebar">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li><a href="dashboard.html"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                            
                            <li class="">
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Category  Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managecategory/new"><i class="fa fa-check-circle" aria-hidden="true"></i> New Category</a>
                                    </li>
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managecategory"><i class="fa fa-check-circle" aria-hidden="true"></i> Manage Category</a>
                                    </li>
                                    
                                   
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Field  Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managefield"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Field</a>
                                    </li>
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managefield/new"><i class="fa fa-plus-square" aria-hidden="true"></i> ADD New Field</a>
                                    </li>
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Product  Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/manageproduct"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Product</a>
                                    </li>
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/manageproduct/new"><i class="fa fa-plus-square" aria-hidden="true"></i> Add New Product</a>
                                    </li>
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Order  Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>index.php/manageorder"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Order</a>
                                    </li>
                                   
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Customer Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/manageuser/view"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Customer</a>
                                    </li>
                                    
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>      
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Tax Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managetax/view"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Tax</a>
                                    </li>
                                    <li>
                                        <a href="<?php  echo base_url()?>/index.php/managetax/add"><i class="fa fa-plus-square" aria-hidden="true"></i> Add New Tax</a>
                                    </li>
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>                      
                            <li class="">
                                <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> Content Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    <li>
                                        <a href="<?php  echo base_url()?>index.php/managecontent/view"><i class="fa fa-plus-square" aria-hidden="true"></i> Manage Content</a>
                                    </li>
                                    <li>
                                        <a href="<?php  echo base_url()?>index.php/managecontent/new"><i class="fa fa-plus-square" aria-hidden="true"></i> Add New Content</a>
                                    </li>
                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>   
                           
                            
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
           <div id="page-wrapper">
               <div class="container-fluid">
                   <a href="" class="scrollToTop"></a>