<?php 
ob_start();
session_start();
include(__DIR__ . "/config.php");
$page_name = '';
$page_name = pathinfo(curPageURL(),PATHINFO_FILENAME);
function curPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<?php
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}

$image = WEB_URL . 'img/no_image.jpg';	
if(isset($_SESSION['objLogin']['image'])){
	if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){
		$image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];
	}
}
$query_ams_settings = mysqli_query($conn, "SELECT * FROM tbl_settings");
if($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){
	$lang_code_global = $row_query_ams_core['lang_code'];
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_left_menu.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Demo AMS</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.4 -->
<link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome Icons -->
<link href="<?php echo WEB_URL; ?>dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo WEB_URL; ?>dist/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo WEB_URL; ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins 
 folder instead of downloading all of them to reduce the load. -->
<link href="<?php echo WEB_URL; ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck for checkboxes and radio inputs -->
<link href="<?php echo WEB_URL; ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- jQuery 2.1.4 -->
<script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo WEB_URL; ?>dist/js/printThis.js"></script>
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
<span class="main-header"><a href="dashboard.php" class="logo"><span class="logo-mini">Demo</span>
<!-- logo for regular state and mobile devices -->
<span class="logo-lg"><b>Demo</b> Apartment Management System</span> </a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a></nav>
</span>
<header class="main-header"><nav class="navbar navbar-static-top" role="navigation"><div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        
          <ul class="dropdown-menu">
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li>
                  <!-- start message -->
                  <a href="#">
                  <div class="pull-left"> <img src="<?php echo WEB_URL; ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/> </div>
                  </a> </li>
                <!-- end message -->
              </ul>
            </li>
            <li class="footer"><a href="#"></a></li>
          </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
          <ul class="dropdown-menu">
            <li class="header"></li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li></li>
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        <!-- Tasks: style can be found in dropdown.less -->
          <ul class="dropdown-menu">
            <li class="header"></li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li>
                  <!-- Task item -->
                  <a href="#">
                  <h3> Design some buttons <small class="pull-right">20%</small> </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"> <span class="sr-only">20% Complete</span> </div>
                  </div>
                  </a> </li>
                <!-- end task item -->
              </ul>
            </li>
            <li class="footer"> <a href="#">View all tasks</a> </li>
          </ul>
        </li>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user fa-lg"></i> <span class="hidden-xs"><?php echo $_SESSION['objLogin']['r_name']; ?></span> </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header"> <img src="<?php echo $image; ?>" class="img-circle" alt="User Image" />
              <p><?php echo $_SESSION['objLogin']['r_name']; ?><small>Renter<br/><?php echo $_SESSION['objLogin']['branch_name']; ?></small></p>
            </li>
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left"><a data-target="#user_profile" data-toggle="modal" class="btn btn-success btn-flat">Profile</a></div>
              <div class="pull-right"> <a href="<?php echo WEB_URL; ?>logout.php" class="btn btn-danger btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="margin-top:10px;">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="<?php if($page_name != '' && $page_name == 't_dashboard'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>t_dashboard.php"><i class="fa fa-dashboard"></i> <span><?php echo $_data['menu_dashboard'];?></span></a> </li>
        <li class="<?php if($page_name != '' && $page_name == 'tenant_details'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>t_dashboard/tenant_details.php"><i class="fa fa-money"></i><span><?php echo $_data['rented_statement'];?></span></a></li>
        <li class="<?php if($page_name != '' && $page_name == 'r_report'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>t_dashboard/r_report.php"><i class="fa fa-bar-chart-o"></i><span><?php echo $_data['rented_report'];?></span></a></li>
        <li class="<?php if($page_name != '' && $page_name == 'unit_details'){echo 'active';}?>"><a href="<?php echo WEB_URL; ?>t_dashboard/unit_details.php"><i class="fa fa-empire"></i><span><?php echo $_data['unit_details'];?></span></a></li>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">





<!-- Add the sidebar's background. This div must be placed
 immediately after the control sidebar -->
<form id="updateprofile" action="<?php echo WEB_URL; ?>ajax/updateProfile.php" method="post">
  <div class="modal fade" role="dialog" id="user_profile" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Update Your Profile</h4>
        </div>
        <div class="modal-body">
          <?php 
			$image = WEB_URL . 'img/no_image.jpg';	
			if(isset($_SESSION['objLogin']['image'])){
				if(file_exists(ROOT_PATH . '/img/upload/' . $_SESSION['objLogin']['image']) && $_SESSION['objLogin']['image'] != ''){
					$image = WEB_URL . 'img/upload/' . $_SESSION['objLogin']['image'];
				}
			}
		  ?>
          <div align="center"><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
          <h4 align="center"><?php echo $_SESSION['objLogin']['r_name']; ?></h4>
          <h4 align="center">Renter
          </h4>
          <div class="form-group">
            <label class="control-label">Name:&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfileName" name="txtProfileName" value="<?php echo $_SESSION['objLogin']['r_name']; ?>">
          </div>
          <div class="form-group">
            <label class="control-label">Email:&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfileEmail" name="txtProfileEmail" value="<?php echo $_SESSION['objLogin']['r_email']; ?>">
          </div>
          <div class="form-group">
            <label class="control-label">Password:&nbsp;&nbsp;</label>
            <input type="text" class="form-control" id="txtProfilePassword" name="txtProfilePassword" value="<?php echo $_SESSION['objLogin']['r_password']; ?>">
          </div>
          <div style="color:orange;font-weight:bold;text-align:left;font-size:15px;">After update application will be logout automatically.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onClick="javascript:$('#updateprofile').submit();">Update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['objLogin']['rid']; ?>" >
</form>

