<?php include('header_emp.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_admin_dashboard.php');
?>
<?php
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}

$mysalery = 0;
//unit count for owner
$result_amount = mysqli_query($conn, "SELECT sum(amount) as total FROM  tbl_add_employee_salary_setup where emp_name =".(int)$_SESSION['objLogin']['eid']);
if($row_amount_total = mysqli_fetch_array($result_amount)){
	$total_amount = $row_amount_total['total'];
}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $_data['dashboard_emp'];?><small><?php echo $_data['control'];?></small> </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL; ?>e_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
        <li class="active"><?php echo $_data['dash'];?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- /.row start -->
      <div class="row home_dash_box">
	  <!-- col start -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner"><h3><?php echo $total_amount .CURRENCY; ?></h3>
              <p><?php echo $_data['salary_statement'];?></p>
            </div>
            <div class="icon"> <img height="80" width="80" src="img/fund.png"></a> </div>
            <a href="<?php echo WEB_URL; ?>e_dashboard/salary_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
        </div>
        <!-- ./col end -->
        <!-- col start -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner"><h3>Demo</h3>
              <p><?php echo $_data['salary_report'];?></p>
            </div>
            <div class="icon"> <img height="80" width="80" src="img/report.png"></a> </div>
            <a href="<?php echo WEB_URL; ?>e_dashboard/e_report.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
        </div>
        <!-- ./col end -->
        <!-- col start -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner"><h3>Demo</h3>
              <p><?php echo $_data['rented_details'];?></p>
            </div>
            <div class="icon"> <img height="80" width="80" src="img/user.png"></a> </div>
            <a href="<?php echo WEB_URL; ?>e_dashboard/rented_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
        </div>
        <!-- ./col end -->
        <!-- col start -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner"><h3>Demo</h3>
              <p><?php echo $_data['member_details'];?></p>
            </div>
            <div class="icon"> <img height="80" width="80" src="img/owner.png"></a> </div>
            <a href="<?php echo WEB_URL; ?>e_dashboard/member_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
        </div>
        <!-- ./col end -->
      </div>
      <!-- /.row end -->
    </section>
    <!-- /.content -->
    <?php include('footer.php'); ?>
