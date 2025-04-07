<?php
    session_start();
        if((!isset($_SESSION["loggedin"])) || ($_SESSION["user_name"]) != true){
            header("Location: ./signin.php");
        exit;
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>SM-TMS</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/animate.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <!-- fontawesome 6.5.1 -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/fontawesome6.5.1/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/fontawesome6.5.1/all.min.css">

    <link rel="stylesheet" href="assets/plugins/datepicker/daterangepicker.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>

</head>

<body>
    <!-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> -->

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="index.php" class="logo">
                    <img src="assets/img/tailer.jpg" alt="">
                </a>
                <a href="index.php" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                        <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-img"><img src="assets/img/profiles/tailer.jpg" alt="">
                                <span class="status online"></span></span>
                        </a>
                        <div class="dropdown-menu menu-drop-user">
                            <div class="profilename">
                                <div class="profileset">
                                    <span class="user-img"><img src="assets/img/profiles/tailer.jpg" alt="">
                                        <span class="status online"></span></span>
                                    <div class="profilesets">
                                        <h6><?php echo $_SESSION["user_name"] ?></h6>
                                        <!-- <h5>Admin</h5> -->
                                    </div>
                                </div>
                                <hr class="m-0">
                                <!-- <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My
                                    Profile</a>
                                <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                        data-feather="settings"></i>Settings</a> -->
                                <hr class="m-0">
                                <a class="dropdown-item logout pb-0" href="signout.php"><img
                                        src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                            </div>
                        </div>
                    </li>
                <!-- USER PROFILE AVATAR SETTING -->
                <!-- <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-img">
                            <img src="assets/img/profiles/user.jpg" alt="">
                            <span class="status online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                    <img src="assets/img/profiles/user.jpg" alt="">
                                    <span class="status online"></span>
                                </span>
                                <div class="profilesets">
                                    <h6><?php echo htmlspecialchars($_SESSION["user_name"]); ?></h6>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signout.php">
                                <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout
                            </a>
                        </div>
                    </div>
                </li> -->
                <!-- search icon on header  -->
                <!-- <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv"><img src="assets/img/icons/search.svg" alt="img"></a>
                        </form>
                    </div>
                </li> -->

                <!-- notificaation icon -->
                
                <!-- USER PROFILE AVATAR SETTING -->
                <!-- <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="assets/img/profiles/user.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/user.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6><?php echo $_SESSION["user_name"] ?></h6>
                                </div>
                            </div>
                            <hr class="m-0"> -->
                            <!-- <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My
                                Profile</a>
                            <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a> -->
                            <!-- <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signout.php"><img
                                    src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li> -->
            </ul>


            <!-- <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div> -->

        </div>
            <!-- this code is used to get current page url link -->
        <?php $page = substr( $_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class=active>
                            <a href="index.php" class="menu-link"><img src="assets/img/icons/dashboard.svg" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <!-- New order -->
                        <li class="submenu">
                            <a href="javascript:void(0);" class="menu-link"><img src="assets/img/icons/order.svg" alt="img"><span>
                            Orders</span> <span class="menu-arrow"></span></a>
                            <ul class="submenu-items">
                                <li><a <?= $page == "addneworder.php"? 'class="active" ' : ''?> href="addneworder.php">Add New Order</a></li>
                                <li><a <?= $page == "manage_order.php"? 'class="active" ' : ''?> href="manage_order.php">Progress New Order</a></li>
                                
                            </ul>
                        </li>                        
                        <!-- Manage Invoice -->
                        <li class="submenu">
                            <a href="javascript:void(0);" class="menu-link"><img src="assets/img/icons/dash2.svg" alt="img"><span>
                            Invoice</span> <span class="menu-arrow"></span></a>
                            <ul class="submenu-items">                                
                                <li><a <?= $page == "new_invoice.php"? 'class="active" ' : ''?> href="new_invoice.php">Add New Invoice</a></li>
                                <li><a <?= $page == "ready_for_delivery.php"? 'class="active" ' : ''?> href="ready_for_delivery.php">Ready For Delivery</a></li>
                                <li><a <?= $page == "delivered_order.php"? 'class="active" ' : ''?> href="delivered_order.php">Total Delivered Order</a></li>
                            </ul>
                        </li>                        
                        <!-- cutting unit -->
                        <!-- <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/return1.svg" alt="img"><span>
                                    Cutting Unit</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a <?= $page == "stitching.php"? 'class="active" ' : ''?> href="stitching.php">Add to Stitching</a></li>
                                <li><a <?= $page == "product.php"? 'class="active" ' : ''?> href="product.php">Add Product </a></li>
                                <li><a <?= $page == "addproductcode.php"? 'class="active" ' : ''?> href="addproductcode.php">Add Product Code</a></li>
                            </ul>
                        </li> -->
                        <!-- stitching -->
                        <!-- <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/transfer1.svg" alt="img"><span>
                                    Stitching Unit</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a <?= $page == "packing.php"? 'class="active" ' : ''?> href="packing.php">Add Packing </a></li>                                
                                <li><a <?= $page == "productout.php"? 'class="active" ' : ''?> href="productout.php">Packing Out </a></li>
                                <li><a <?= $page == "pending_packing.php"? 'class="active" ' : ''?> href="pending_packing.php">Packing in Stock </a></li>
                                <li><a <?= $page == "monthly_packing.php"? 'class="active" ' : ''?> href="monthly_packing.php">Monthly Packing</a></li>
                                <li><a <?= $page == "monthly_packing_out.php"? 'class="active" ' : ''?> href="monthly_packing_out.php">Monthly Packing Out</a></li>
                            </ul>
                        </li> -->
                        
                        <!-- <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/time.svg" alt="img"><span>
                            Production Report</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a <?= $page == "dailyproduction.php"? 'class="active" ' : ''?> href="dailyproduction.php">Daily Production</a></li>
                                <li><a <?= $page == "product_made_by.php"? 'class="active" ' : ''?> href="product_made_by.php">Monthly Production</a></li>
                                <li><a <?= $page == "product_made_by_csv.php"? 'class="active" ' : ''?> href="product_made_by_csv.php">Monthly Production CSV</a></li>
                                <li><a <?= $page == "empwise_monthly_pro.php"? 'class="active" ' : ''?> href="empwise_monthly_pro.php">Datewise Monthly Production</a></li>
                                
                            </ul>
                        </li> -->
                        <!-- <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/time.svg" alt="img"><span>
                                    Report</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a <?= $page == "totalmaterial.php"? 'class="active" ' : ''?> href="totalmaterial.php">Total Raw Material</a></li>
                                <li><a <?= $page == "total_of_stitching.php"? 'class="active" ' : ''?> href="total_of_stitching.php">Total of Stitching Unit</a></li>
                                <li><a <?= $page == "pending_stockraw.php"? 'class="active" ' : ''?> href="pending_stockraw.php">Remaining Raw Material</a></li>
                            </ul>
                        </li> -->
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/users1.svg" alt="img"><span>
                                    Users</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a <?= $page == "add_employee.php"? 'class="active" ' : ''?> href="add_employee.php">Add New Department</a></li>
                                <li><a <?= $page == "add_new_product.php"? 'class="active" ' : ''?> href="add_new_product.php">Add New Product</a></li>

                            </ul>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
        </div>


        