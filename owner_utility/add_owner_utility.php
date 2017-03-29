<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_owner_utility.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$type = 'Owner';
$floor_no = '';
$unit_no = '';
$month_id = '';
$xyear = date('Y');
$rent = '0.00';
$water_bill = '0.00';
$electric_bill = '0.00';
$gas_bill = '0.00';
$security_bill = '0.00';
$utility_bill = '0.00';
$other_bill = '0.00';
$total_rent = '0.00';
$issue_date = '';
$branch_id = '';
$title = $_data['add_new_owner_utility_title'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_owner_utility_successfully'];
$form_url = WEB_URL . "owner_utility/add_owner_utility.php";
$id="";
$hdnid="0";

//
$owner_name = '';
$ownid = 0;
//

if(isset($_POST['ddlFloorNo'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

	$sql = "INSERT INTO tbl_add_fair(type,floor_no,unit_no,rid,month_id,xyear,water_bill,electric_bill,gas_bill,security_bill,utility_bill,other_bill,total_rent,issue_date,branch_id) values('$type','$_POST[ddlFloorNo]','$_POST[ddlUnitNo]','$_POST[hdnOwnerdId]','$_POST[ddlMonth]','$xyear','$_POST[txtWaterBill]','$_POST[txtElectricBill]','$_POST[txtGasBill]','$_POST[txtSecurityBill]','$_POST[txtUtilityBill]','$_POST[txtOtherBill]','$_POST[txtTotalRent]','$_POST[txtIssueDate]','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($sql,$conn);
	mysql_close($conn);
	$url = WEB_URL . 'owner_utility/owner_utility_list.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_add_fair` SET `floor_no`='".$_POST['ddlFloorNo']."',`unit_no`='".$_POST['ddlUnitNo']."',`rid`='".$_POST['hdnOwnerdId']."',`month_id`='".$_POST['ddlMonth']."',`water_bill`='".$_POST['txtWaterBill']."',`electric_bill`='".$_POST['txtElectricBill']."',`gas_bill`='".$_POST['txtGasBill']."',`security_bill`='".$_POST['txtSecurityBill']."',`utility_bill`='".$_POST['txtUtilityBill']."',`other_bill`='".$_POST['txtOtherBill']."',`total_rent`='".$_POST['txtTotalRent']."',`issue_date`='".$_POST['txtIssueDate']."' WHERE f_id='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	$url = WEB_URL . 'owner_utility/owner_utility_list.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($conn, "SELECT *,o.o_name,o.ownid FROM tbl_add_fair af inner join tbl_add_owner o on o.ownid = af.rid where af.f_id = '" . $_GET['id'] . "' and af.type='Owner'");
	while($row = mysqli_fetch_array($result)){
	
		$floor_no = $row['floor_no'];
		$unit_no = $row['unit_no'];
		$month_id = $row['month_id'];
		$water_bill = $row['water_bill'];
		$electric_bill = $row['electric_bill'];
		$gas_bill = $row['gas_bill'];
		$security_bill = $row['security_bill'];
		$utility_bill = $row['utility_bill'];
		$other_bill = $row['other_bill'];
		$total_rent = $row['total_rent'];
		$issue_date = $row['issue_date'];
		$hdnid = $_GET['id'];
		$owner_name = $row['o_name'];
		$ownid = $row['ownid'];
		$title = $_data['update_owner_utility'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_owner_utility_successfully'];
		$form_url = WEB_URL . "owner_utility/add_owner_utility.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);
}
else{
	//
	$total_rent = (float)$gas_bill + (float)$security_bill;
	$total_rent = number_format($total_rent, 2, '.', ' ');
}
//	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['owner_utility'];?></li>
    <li class="active"><?php echo $_data['add_owner_utility'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>owner_utility/owner_utility_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_owner_utility_entry_form'];?></h3>
      </div>
     
     <form onSubmit="return validateMe();" action="<?php echo WEB_URL; ?>owner_utility/add_owner_utility.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
        <div class="form-group">
            <label for="ddlFloorNo">Floor No :</label>
            <select onchange="getActiveUnit(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
              <option value="">--Select Floor--</option>
                            <option  value="1">2</option>
                            <option  value="2">1</option>
                            <option  value="3">1</option>
                            <option  value="4">2</option>
                            <option  value="5">3</option>
                            <option  value="6">10</option>
                          </select>
          </div>
          <div class="form-group">
            <label for="ddlUnitNo">Unit No :</label>
            <select name="ddlUnitNo" id="ddlUnitNo" onchange="getOwnerInfo(this.value);" class="form-control">
              <option value="">--Select Unit--</option>
                          </select>
          </div>
          <div class="form-group">
            <label for="txtOwnerName">Owner Name :</label>
            <input readonly="readonly" type="text" name="txtOwnerName" style="font-weight:bold;color:red;" value="" id="txtOwnerName" class="form-control" />
            <input type="hidden" id="hdnOwnerdId" name="hdnOwnerdId" value="0" />
          </div>
           <div class="form-group">
            <label for="ddlMonth">Select Month :</label>
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
            <label for="txtWaterBill">Water Bill :</label>
            <div class="input-group">
            <input type="text" name="txtWaterBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtWaterBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtElectricBill">Electric Bill :</label>
            <div class="input-group">
            <input type="text" name="txtElectricBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtElectricBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtGasBill">Gas Bill :</label>
            <div class="input-group">
            <input type="hidden" id="hdnGasBill" name="hdnGasBill" value="0.00" />
            <input type="text" name="txtGasBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtGasBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtSecurityBill">Security Bill :</label>
            <div class="input-group">
            <input type="hidden" id="hdnSecurityBill" name="hdnSecurityBill" value="0.00" />
            <input type="text" name="txtSecurityBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtSecurityBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtUtilityBill">Utility Bill :</label>
            <div class="input-group">
            <input type="text" name="txtUtilityBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtUtilityBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtOtherBill">Other Bill :</label>
            <div class="input-group">
            <input type="text" name="txtOtherBill" onkeyup="calculateFairTotal1();" value="0.00" id="txtOtherBill" class="form-control" />
            <div class="input-group-addon">$</div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtTotalRent">Total Rent  :</label>
            <div class="input-group">
              <input type="hidden" id="hdnTotal" name="hdnTotal" value="0.00" />
              <input type="text" readonly="readonly" name="txtTotalRent" value="0.00" id="txtTotalRent" class="form-control" />
              <div class="input-group-addon"> $ </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtIssueDate">Issue Date :</label>
            <input type="text" name="txtIssueDate" value="" id="txtIssueDate" class="form-control datepicker"/>
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
