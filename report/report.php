<?php include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> Settings <small>Control Panel</small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?php echo WEB_URL; ?>report/report.php">Report</a></li>
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
          
          <p>Fair Report</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/fair.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>report/fair_report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          
          <p>Rented Report</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/owner.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>report/rented_report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
     <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
         
          <p>Visitors Report</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/owner.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>report/visitors_report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
         
          <p>Unit Status Report</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/room.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>report/unit_report.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
    <!-- start menu -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
    
          <p>Fund Status</p>
        </div>
        <div class="icon dashboard_image"> <img height="80" width="80" src="<?php echo WEB_URL; ?>img/fund.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>report/fund_status.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- end menu -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<?php include('../footer.php'); ?>
