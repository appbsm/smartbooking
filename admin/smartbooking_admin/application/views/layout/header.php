<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Booking</title>
    <link rel="icon" type="image/x-icon" href="<?php echo site_url(); ?>/asset/image/logo.ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!--link rel="stylesheet" href="<?php echo site_url(); ?>asset/plugins/fontawesome-free/css/all.min.css"-->
    <script src="https://kit.fontawesome.com/38215a61ca.js" crossorigin="anonymous"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>asset/dist/css/adminlte.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- jQuery -->
    <script src="<?php echo site_url(); ?>/asset/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url(); ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!--<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>-->
    <!-- jQuery UI -->
    <script src="<?php echo site_url(); ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url(); ?>/asset/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo site_url(); ?>/asset/dist/js/demo.js"></script>
    <!-- DateTime Picker -->
    <!--<link rel="stylesheet" href="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css">
    <script src="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js"></script>-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.9.1/jquery-ui-timepicker-addon.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.9.1/jquery-ui-timepicker-addon.min.js"></script>
    <!-- FullCalendar -->
    <!--<link rel="stylesheet" href="<?php echo site_url(); ?>/asset/plugins/fullcalendar/main.css">
    <script src="<?php echo site_url(); ?>/asset/plugins/moment/moment.min.js"></script>
    <script src="<?php echo site_url(); ?>/asset/plugins/fullcalendar/main.js"></script>-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.0.1/fullcalendar.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.0.1/fullcalendar.min.js"></script>
    <!-- DataTables -->
    <!--<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">-->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Table2Csv -->
    <script src="<?php echo site_url(); ?>/asset/dist/js/table2csv.js"></script>
    <!-- BlockUI -->
    <script src="<?php echo site_url(); ?>/asset/dist/js/jquery.blockUI.js"></script>
    <!-- DateRangePicker -->
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />-->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@4.0.0/daterangepicker.min.css">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@4.0.0/daterangepicker.min.js"></script>
    <!-- DataMask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <!-- Custom -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>asset/custom.css">
    <script src="<?php echo site_url(); ?>asset/custom.js"></script>
    <script>
        var app = '';
    </script>
    <style>
        <?php for ($i = 1; $i <= 2000; $i++) { ?>.w<?php echo $i; ?> {
            width: <?php echo $i; ?>px;
            min-width: <?php echo $i; ?>px;
        }
        <?php } ?>
		
		.sidebar-tx {
			color: #fff !important;
	 	}
		.sidebar-tx:hover {
			color: #c2c7d0 !important;
		}
		[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link {
			/*color: #c2c7d0;*/
			color: #fff !important;
		}
		[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link:hover {
			color: #c2c7d0 !important;
		}
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!--li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo home_url(); ?>" class="nav-link"><font color="black"><?php echo _r('Home', 'หน้าแรก'); ?></font></a>
                </li-->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <!--li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li-->
                <!-- Messages Dropdown Menu -->
                <!--li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img src="<?php echo site_url(); ?>asset/dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img src="<?php echo site_url(); ?>asset/dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img src="<?php echo site_url(); ?>asset/dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li-->
                <!-- Notifications Dropdown Menu -->
                <!--li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li-->
                <li class="nav-item" style="min-width:60px; overflow:hidden; white-space:nowrap; margin-right:8px;">
                    <a href="#" role="button" class="nav-link" style="float:left; padding:7px 0px 0px 0px;" onclick="changeLanguage('<?php echo change_language_url(); ?>', 'TH', (app.step ? app.step : ''))">
                        <font color="<?php echo _r('black', 'blue'); ?>" style="<?php echo _r('', 'text-decoration:underline;'); ?>">TH</font>
                    </a>
                    <span style="float:left; padding:6px 5px 0px 5px;"> | </span>
                    <a href="#" role="button" class="nav-link" style="float:left; padding:7px 0px 0px 0px;" onclick="changeLanguage('<?php echo change_language_url(); ?>', 'EN', (app.step ? app.step : ''))">
                        <font color="<?php echo _r('blue', 'black'); ?>" style="<?php echo _r('text-decoration:underline;', ''); ?>">EN</font>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo user_logout_url(); ?>" role="button">
                        <i class="fas fa-sign-out"></i>
                    </a>
                </li>
                <!--li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li-->
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4" style=" background-color: #102958" >
            <!-- Brand Logo -->
            <a href="<?php echo home_url(); ?>" class="brand-link">
                <img src="<?php echo site_url(); ?>asset/image/logo.png" class="brand-image elevation-3" style="margin-left:7px">
                <span class="brand-text sidebar-tx">Smart Booking</span-->
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo site_url(); ?>asset/image/user.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <?php $s = $this->session->userdata('user_data'); ?>
                        <a href="<?php echo edit_user_url($s['id_user']); ?>" class="d-block sidebar-tx"><?php echo $s['name']; ?></a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <!--div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div-->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!--li class="nav-header">MENU</li-->
                        <?php if (has_permission('dashboard', 'view') || has_permission('calendar', 'view') || has_permission('reservations', 'view') || has_permission('room_register', 'view') || has_permission('guest_booking', 'view') || has_permission('guest', 'view') || has_permission('booking', 'view')) : ?>
                            <li class="<?php echo $active_menu == 'frontdesk' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fas fa-desktop"></i>
                                    <p><?= _r('Front Desk', 'แผนกต้อนรับ'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left:25px">
                                    <?php if (has_permission('dashboard', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo dashboard_url(); ?>" class="nav-link">
                                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                                <p><?= _r('Dashboard', 'แดชบอร์ด'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('calendar', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo calendar_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar nav-icon"></i>
                                                <p><?= _r('Calendar', 'ปฏิทินการจอง'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('reservations', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo reservations_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar-check-o nav-icon"></i>
                                                <p><?= _r('Reservations', 'รายการการจองทั้งหมด'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('room_register', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo room_register_url(); ?>" class="nav-link">
                                                <i class="fa fa-home nav-icon"></i>
                                                <p><?= _r('Room Register', 'การจองของห้องพัก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('guest_booking', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo guest_booking_url(); ?>" class="nav-link">
                                                <i class="fa fa-bed nav-icon"></i>
                                                <p><?= _r('Guest Booking', 'การจองของผู้เข้าพัก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('guest', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo guest_url(); ?>" class="nav-link">
                                                <i class="fa fa-user nav-icon"></i>
                                                <p><?= _r('Guest', 'ผู้เข้าพัก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('booking', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo booking_url(); ?>" class="nav-link">
                                                <i class="fa fa-suitcase-rolling nav-icon"></i>
                                                <p><?= _r('Booking', 'จองห้องพัก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (has_permission('order', 'view')) : ?>
                            <li class="<?php echo $active_menu == 'pos' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fas fa-cash-register"></i>
                                    <p><?= _r('POS', 'จัดการออเดอร์'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left:25px">
                                    <?php if (has_permission('order', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo order_url(); ?>" class="nav-link">
                                                <i class="fa fa-cart-plus nav-icon"></i>
                                                <p><?= _r('Order', 'ออเดอร์'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (has_permission('record_electric_management', 'view') || has_permission('record_water_management', 'view') || has_permission('record_internet_management', 'view')) : ?>
                            <!-- <li class="nav-item menu-is-opening menu-open"> -->
                            <li class="<?php echo $active_menu == 'record' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <!-- Utilities Consumption/Daily Record -->

                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fa fa-file-alt"></i>
                                    <p><?= _r('Utilities Consumption', 'การใช้สาธารณูปโภค'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>

                                <ul class="nav nav-treeview" style="margin-left:25px">
                                     <?php if (has_permission('record_electric_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo record_electric_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar-check-o nav-icon"></i>
                                                <p><?= _r('Detail - Electrical Usage', 'รายละเอียด - การใช้ไฟฟ้า'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('record_water_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo record_electric_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar-check-o nav-icon"></i>
                                                <p><?= _r('Detail - Water Usage', 'รายละเอียด - การใช้น้ำ'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('record_internet_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo record_electric_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar-check-o nav-icon"></i>
                                                <p><?= _r('Detail - Internet Usage', 'รายละเอียด - การใช้อินเตอร์เนต'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (has_permission('reservation_report', 'view') || has_permission('payment_report', 'view') || has_permission('daily_revenue_report', 'view')) : ?>
                            <li class="<?php echo $active_menu == 'report' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fa fa-file-alt"></i>
                                    <p><?= _r('Report', 'รายงาน'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left:25px">
                                    <?php if (has_permission('reservation_report', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo reservation_report_url(); ?>" class="nav-link">
                                                <i class="fa fa-calendar-check-o nav-icon"></i>
                                                <p><?= _r('Reservation Report', 'รายงานการจอง'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('payment_report', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo payment_report_url(); ?>" class="nav-link">
                                                <i class="fa fa-credit-card nav-icon"></i>
                                                <p><?= _r('Payment Report', 'รายงานการชำระเงิน'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('ar_report', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo ar_report_url(); ?>" class="nav-link">
                                                <i class="fa fa-credit-card nav-icon"></i>
                                                <p><?= _r('AR Report', 'AR Report'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('daily_revenue_report', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo daily_revenue_report_url(); ?>" class="nav-link">
                                                <i class="fa fa-donate nav-icon"></i>
                                                <p><?= _r('Daily Revenue Report', 'รายงานรายได้ประจำวัน'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (has_permission('project_management', 'view') || has_permission('room_management', 'view') || has_permission('extra_management', 'view') || has_permission('package_management', 'view') || has_permission('discount_management', 'view') || has_permission('edit_email_setting', 'view') || has_permission('edit_config_setting', 'view') || has_permission('electric_management', 'view') || has_permission('water_management', 'view') || has_permission('internet_management', 'view')) : ?>
                            <li class="<?php echo $active_menu == 'setting' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p><?= _r('Setting', 'การตั้งค่า'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left:25px">
                                    <?php if (has_permission('project_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo project_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-building nav-icon"></i>
                                                <p><?= _r('Project Management', 'ตั้งค่าโปรเจกต์'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('room_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo room_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-home nav-icon"></i>
                                                <p><?= _r('Room Management', 'ตั้งค่าห้องพัก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('electric_management', 'view')) : ?>
                                     <li class="nav-item">
                                        <a href="<?php echo electric_management_url(); ?>" class="nav-link">
                                            <i class="fa fa-gear nav-icon"></i>
                                            <p><?= _r('Utilities Setup', 'ตั้งค่าสาธารณูปโภค'); ?></p>
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                    <?php //if (has_permission('water_management', 'view')) : ?>
                                    <!-- <li class="nav-item">
                                        <a href="<?php echo water_management_url(); ?>" class="nav-link">
                                            <i class="fa fa-gear nav-icon"></i>
                                            <p><?= _r('Water Meter List', 'รายการมิเตอร์น้ำ'); ?></p>
                                        </a>
                                    </li> -->
                                    <?php //endif; ?>

                                    <?php //if (has_permission('internet_management', 'view')) : ?>
                                    <!-- <li class="nav-item">
                                        <a href="<?php echo internet_management_url(); ?>" class="nav-link">
                                            <i class="fa fa-gear nav-icon"></i>
                                            <p><?= _r('Internet Meter List', 'รายการมิเตอร์อินเตอร์เน็ต'); ?></p>
                                        </a>
                                    </li> -->
                                    <?php //endif; ?>

                                    <?php if (has_permission('unit_management', 'view')) : ?>
                                    <li class="nav-item">
                                        <a href="<?php echo unit_management_url(); ?>" class="nav-link">
                                            <i class="fa fa-gear nav-icon"></i>
                                            <p><?= _r('Setting Unit Rate', 'การตั้งค่าอัตราต่อหน่วย'); ?></p>
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('extra_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo extra_url(); ?>" class="nav-link">
                                                <i class="fa fa-plus-circle nav-icon"></i>
                                                <p><?= _r('Extra Management', 'ตั้งค่า Extra'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('package_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo package_url(); ?>" class="nav-link">
                                                <i class="fa fa-boxes nav-icon"></i>
                                                <p><?= _r('Package Management', 'ตั้งค่าแพ็กเกจ'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('discount_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo discount_url(); ?>" class="nav-link">
                                                <i class="fa fa-tag nav-icon"></i>
                                                <p><?= _r('Discount Management', 'ตั้งค่าส่วนลด'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('credit_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo credit_url(); ?>" class="nav-link">
                                                <i class="fa fa-tag nav-icon"></i>
                                                <p><?= _r('Credit Management', 'Credit Management'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('edit_email_setting', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo edit_email_setting_url(); ?>" class="nav-link">
                                                <i class="fa fa-envelope nav-icon"></i>
                                                <p><?= _r('Email Setting', 'ตั้งค่าอีเมล'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('edit_email_setting', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo edit_document_setting_url(); ?>" class="nav-link">
                                                <i class="fa fa-envelope nav-icon"></i>
                                                <p><?= _r('Documents Setting', 'ตั้งค่าเอกสาร'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (has_permission('edit_config_setting', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo edit_config_setting_url(); ?>" class="nav-link">
                                                <i class="fa fa-gear nav-icon"></i>
                                                <p><?= _r('Config Setting', 'ตั้งค่าคอนฟิก'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if (has_permission('role_management', 'view') || has_permission('user_management', 'view')) : ?>
                            <li class="<?php echo $active_menu == 'hr' ? 'nav-item menu-is-opening menu-open' : 'nav-item'; ?>">
                                <a href="#" class="nav-link sidebar-tx">
                                    <i class="nav-icon fa fa-user-circle"></i>
                                    <p><?= _r('HR', 'จัดการผู้ใช้งาน'); ?> <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="margin-left:25px">
                                    <?php if (has_permission('role_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo role_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-user-shield nav-icon"></i>
                                                <p><?= _r('Role Management', 'ตั้งค่า Role'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (has_permission('user_management', 'view')) : ?>
                                        <li class="nav-item">
                                            <a href="<?php echo user_management_url(); ?>" class="nav-link">
                                                <i class="fa fa-user-cog nav-icon"></i>
                                                <p><?= _r('User Management', 'ตั้งค่า User'); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </aside>