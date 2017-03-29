<?php include('header_owner.php'); ?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_left_menu.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_admin_dashboard.php');
if($_SESSION['login_type'] != '2'){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$total_unit = 0;
$total_rented = 0;
$total_employee = 0;
$total_fair = 0;
$total_mc = 0;
$total_fund = 0;
$total_owner_utility = 0;
//unit count for owner
$result_unit = mysqli_query($conn, "SELECT count(owner_id) as total_unit FROM tbl_add_owner_unit_relation where owner_id =".(int)$_SESSION['objLogin']['ownid']);
if($row_unit_total = mysqli_fetch_array($result_unit)){
	$total_unit = $row_unit_total['total_unit'];
}

//my rented
$result_rented = mysqli_query($conn, "SELECT count(r.rid) as total_rent FROM tbl_add_owner_unit_relation ur inner join tbl_add_rent r on r.r_unit_no = ur.unit_id where ur.owner_id =".(int)$_SESSION['objLogin']['ownid']);
if($row_rented_total = mysqli_fetch_array($result_rented)){
	$total_rented = $row_rented_total['total_rent'];
}

//employee count
$result_employee = mysqli_query($conn, "SELECT count(eid) as total_employee FROM tbl_add_employee");
if($row_employee_total = mysqli_fetch_array($result_employee)){
	$total_employee = $row_employee_total['total_employee'];
}

//fair count
$result_fair = mysqli_query($conn, "SELECT sum(f.rent) as total FROM tbl_add_fair f inner join tbl_add_owner_unit_relation ur on ur.unit_id = f.unit_no where ur.owner_id =".(int)$_SESSION['objLogin']['ownid']);
if($row_fair_total = mysqli_fetch_array($result_fair)){
	$total_fair = $row_fair_total['total'];
}

//maintaince count
$result_mc = mysqli_query($conn, "SELECT sum(m_amount) as total FROM tbl_add_maintenance_cost");
if($row_mc_total = mysqli_fetch_array($result_mc)){
	$total_mc = $row_mc_total['total'];
}
//fund count
$result_fund = mysqli_query($conn, "SELECT sum(total_amount) as totals FROM tbl_add_fund");
if($row_fund_total = mysqli_fetch_array($result_fund)){
	$total_fund = $row_fund_total['totals'];
}

//utility count
$result_ou = mysqli_query($conn, "SELECT sum(water_bill) as w_bil,sum(electric_bill) as e_bil,sum(gas_bill) as g_bil,sum(security_bill) as s_bil,sum(utility_bill) as u_bil,sum(other_bill) as o_bil FROM tbl_add_fair f inner join tbl_add_owner_unit_relation ur on ur.unit_id = f.unit_no where f.type = 'Owner' and ur.owner_id =".(int)$_SESSION['objLogin']['ownid']);
if($row_ou_total = mysqli_fetch_array($result_ou)){
	$total_owner_utility = (float)(float)$row_ou_total['w_bil'] + (float)$row_ou_total['e_bil'] + (float)$row_ou_total['g_bil'] + (float)$row_ou_total['u_bil'] + (float)$row_ou_total['s_bil'] + (float)$row_ou_total['o_bil'];
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $_data['owner_dashboard'];?><small><?php echo $_data['control_panel'];?></small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>o_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['home_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- /.row start -->
  <div class="row home_dash_box">
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_unit; ?></h3>
          <p><?php echo $_data['text_1'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/room.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/unitdetails.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_rented; ?></h3>
          <p><?php echo $_data['text_2'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/owner.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/tenantdetails.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_employee; ?></h3>
          <p><?php echo $_data['text_3'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/employee.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/employeedetails.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_fair.CURRENCY; ?></h3>
          <p><?php echo $_data['text_4'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/fair.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/fairdetails.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_owner_utility.CURRENCY; ?></h3>
          <p><?php echo $_data['text_5'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/utility.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/owner_utility_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>AMS<?php //echo $total_owner_utility.CURRENCY; ?></h3>
          <p><?php echo $_data['text_6'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/report.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/rented_report.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_mc . CURRENCY; ?></h3>
          <p><?php echo $_data['text_7'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/maintenance.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/maintenance_cost.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
	<!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $total_fund.CURRENCY; ?></h3>
          <p><?php echo $_data['text_8'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/fund.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>o_dashboard/fund_list.php" class="small-box-footer"><?php echo $_data['dashboard_more_info']; ?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
  </div>
  <!-- /.row end -->
</section>
<!-- /.content -->
<?php include('footer.php'); ?>
