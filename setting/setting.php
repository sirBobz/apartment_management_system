<?php include('../header.php'); 
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Demo Settings <small>Control Panel</small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?php echo WEB_URL; ?>setting/setting.php">Settings</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row home_dash_box">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Demo</h3>
          <p>Bill Setup</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/fair.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/utility_bill_setup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Demo</h3>
          <p>Employee Salary</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/fund.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/employee_salary_setup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>SAKO</h3>
          <p>Member Type</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/owner.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/member_type_setup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>SAKO</h3>
          <p>Month Setup</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/report.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/month_setup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>SAKO</h3>
          <p>Year Setup</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/report.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/year_setup.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>SAKO</h3>
          <p>System Setup</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/report.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>setting/language.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<?php include('../footer.php'); ?>
