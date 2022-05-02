<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Dashboard</title>
	
	<link rel="shortcut icon" type="<?= base_url('assets/image/png" href="images/favicon.png'); ?>" />
	<!-- <link rel="stylesheet" href="vendor/chartist/css/chartist.min.css"> -->
    <link href="<?= base_url('assets/vendor/datatables/css/jquery.dataTables.min.css'); ?>" rel="stylesheet">
  <!--   <link href="https://www.flaticon.com/uicons"> -->

	<link href="<?= base_url('assets/vendor/jquery-nice-select/css/nice-select.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/vendor/lightgallery/css/lightgallery.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
   <!--  <link href="<?= base_url('assets/css/owl.carousel.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->

	
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="gooey">
		  <span class="dot"></span>
		  <div class="dots">
			<span></span>
			<span></span>
			<span></span>
		  </div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?php echo site_url('admin'); ?>" class="brand-logo" style="background-color: #fff;">
				<img src="<?= base_url('assets/images/logo-full.png'); ?>" alt="" width="100%">
				

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		



<div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							
                        </div>
                        <ul class="navbar-nav header-right">
							
							<li class="nav-item dropdown  header-profile">
								<a class="btn btn-primary btn-rounded" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
									<?php echo $this->session->userdata('admin_name'); ?>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="<?= site_url('admin/profile'); ?>" class="dropdown-item ai-icon">
										<svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
										<span class="ms-2">Profile </span>
									</a>
									<!-- <a href="<?= site_url('admin/change-password'); ?>" class="dropdown-item ai-icon">
										<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
										<span class="ms-2">Change Password </span>
									</a> -->
									<a href="<?= site_url('admin/logout'); ?>" class="dropdown-item ai-icon">
										<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
										<span class="ms-2">Logout </span>
									</a>
								</div>
							</li>
							
                        </ul>
                    </div>
				</nav>
			</div>
		</div>