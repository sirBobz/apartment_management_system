<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_maintenance_cost.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$m_title = '';
$m_date = '';
$m_amount = '';
$m_details = '';
$m_month = 0;
$m_year = 0;
$branch_id = '';
$title = $_data['add_title_text'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['add_msg'];
$form_url = WEB_URL . "maintenance/add_maintenance_cost.php";
$id="";
$hdnid="0";

if(isset($_POST['txtMTitle'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

	$sql = "INSERT INTO tbl_add_maintenance_cost(m_title, m_date, xmonth, xyear, m_amount, m_details,branch_id) values('$_POST[txtMTitle]','$_POST[txtMDate]','$_POST[ddlMonth]','$_POST[ddlYear]','$_POST[txtMAmount]','$_POST[txtMDetails]','" . $_SESSION['objLogin']['branch_id'] . "')";
	//echo $sql;
	//die();
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'maintenance/maintenance_cost_list.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_add_maintenance_cost` SET `m_title`='".$_POST['txtMTitle']."',`m_date`='".$_POST['txtMDate']."',`xmonth`='".$_POST['ddlMonth']."',`xyear`='".$_POST['ddlYear']."',`m_amount`='".$_POST['txtMAmount']."',`m_details`='".$_POST['txtMDetails']."' WHERE mcid='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	$url = WEB_URL . 'maintenance/maintenance_cost_list.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($conn, "SELECT * FROM tbl_add_maintenance_cost where mcid = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){
		
		$m_title = $row['m_title'];
		$m_date = $row['m_date'];
		$m_amount = $row['m_amount'];
		$m_details = $row['m_details'];
		$m_month = $row['xmonth'];
		$m_year = $row['xyear'];
		$hdnid = $_GET['id'];
		$title = $_data['update_title_text'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_msg'];
		$form_url = WEB_URL . "maintenance/add_maintenance_cost.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['maintenance_cost'];?></li>
    <li class="active"><?php echo $_data['add_m_cost'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['m_cost_entry_form'];?></h3>
      </div>
      
      <form onSubmit="return validateMe();" action="<?php echo WEB_URL?>maintenance/add_maintenance_cost.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtMDate">Date :</label>
            <input type="text" name="txtMDate" value="" id="txtMDate" class="form-control datepicker"/>
          </div>
          <div class="form-group">
            <label for="ddlMonth"> Month :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--Select Month--</option>
                            <option  value="1">January</option>
                            <option  value="2">February</option>
                            <option  value="3">March</option>
                            <option  value="4">April</option>
                            <option  value="5">May</option>
                            <option  value="6">June</option>
                            <option  value="7">July</option>
                            <option  value="8">August</option>
                            <option  value="9">September</option>
                            <option  value="10">Octobor</option>
                            <option  value="11">November</option>
                            <option  value="12">December</option>
                          </select>
          </div>
          <div class="form-group">
            <label for="ddlYear"> Year :</label>
            <select name="ddlYear" id="ddlYear" class="form-control">
              <option value="">--Select Year--</option>
                            <option  value="3">2011</option>
                            <option  value="4">2012</option>
                            <option  value="5">2013</option>
                            <option  value="6">2014</option>
                            <option  value="7">2015</option>
                            <option  value="8">2016</option>
                            <option  value="9">2017</option>
                            <option  value="10">2018</option>
                            <option  value="11">2019</option>
                            <option  value="12">2020</option>
                          </select>
          </div>
          <div class="form-group">
            <label for="txtMTitle">Maintenance Title :</label>
            <input type="text" name="txtMTitle" value="" id="txtMTitle" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtMAmount">Amount :</label>
            <div class="input-group">
              <input type="text" name="txtMAmount" value="" id="txtMAmount" class="form-control" />
              <div class="input-group-addon"> $ </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtMDetails">Details :</label>
            <textarea name="txtMDetails" id="txtMDetails" class="form-control"></textarea>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Save Information"/>
          </div>
        </div>
        <input type="hidden" value="0" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
