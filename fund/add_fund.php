<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_fund.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$owner_id = '';
$month_id = '';
$xyear = '';
$total_amount = '0.00';
$f_date = '';
$purpose = '';
$branch_id = '';
$title = $_data['add_new_fund'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_fund_successfully'];
$form_url = WEB_URL . "fund/add_fund.php";
$id="";
$hdnid="0";

//
$owner_name = '';
$ownid = 0;
//

if(isset($_POST['ddlOwnerName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

	$sql = "INSERT INTO tbl_add_fund(owner_id,month_id,xyear,f_date,total_amount,purpose,branch_id) values('$_POST[ddlOwnerName]','$_POST[ddlMonth]','$_POST[ddlYear]','$_POST[txtDate]','$_POST[txtTotalAmount]','$_POST[txtPurpose]','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'fund/fund_list.php?m=add';
	header("Location: $url");
	
}
else{
	$sql = "UPDATE `tbl_add_fund` SET `owner_id`='".$_POST['ddlOwnerName']."',`month_id`='".$_POST['ddlMonth']."',`xyear`='".$_POST['ddlYear']."',`f_date`='".$_POST['txtDate']."',`total_amount`='".$_POST['txtTotalAmount']."',`purpose`='".$_POST['txtPurpose']."' WHERE fund_id='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'fund/fund_list.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($conn, "SELECT *,o.o_name,o.ownid FROM tbl_add_fund fu inner join tbl_add_owner o on o.ownid = fu.owner_id where fu.fund_id = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){
	
		$owner_id = $row['owner_id'];
		$month_id = $row['month_id'];
		$xyear = $row['xyear'];
		$f_date = $row['f_date'];
		$total_amount = $row['total_amount'];
		$purpose = $row['purpose'];
		$hdnid = $_GET['id'];
		$owner_name = $row['o_name'];
		$ownid = $row['ownid'];
		$title = $_data['update_fund'];
		$button_text = $_data['update_button_text'] ;
		$successful_msg = $_data['update_fund_successfully'];
		$form_url = WEB_URL . "fund/add_fund.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);
}
else{
}
//	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['fund'];?></li>
    <li class="active"><?php echo $_data['add_new_fund_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>fund/fund_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_fund_entry_form'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="ddlOwnerName"><?php echo $_data['add_new_form_field_text_1'];?> :</label>
            <select name="ddlOwnerName" id="ddlOwnerName" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_2'];?>--</option>
              <?php 
				  	$result_owner = mysql_query("SELECT * FROM tbl_add_owner order by ownid ASC",$link);
					while($row_owner = mysql_fetch_array($result_owner)){?>
              <option <?php if($owner_id == $row_owner['ownid']){echo 'selected';}?> value="<?php echo $row_owner['ownid'];?>"><?php echo $row_owner['o_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlMonth"><?php echo $_data['add_new_form_field_text_3'];?> :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_3'];?>--</option>
              <?php 
				  	$result_month = mysql_query("SELECT * FROM tbl_add_month_setup order by m_id ASC",$link);
					while($row_month = mysql_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlYear"><?php echo $_data['add_new_form_field_text_5'];?> :</label>
            <select name="ddlYear" id="ddlYear" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_5'];?>--</option>
              <?php 
				  	$result_month = mysql_query("SELECT * FROM tbl_add_year_setup order by y_id ASC",$link);
					while($row_month = mysql_fetch_array($result_month)){?>
              <option <?php if($xyear == $row_month['y_id']){echo 'selected';}?> value="<?php echo $row_month['y_id'];?>"><?php echo $row_month['xyear'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtDate"><?php echo $_data['add_new_form_field_text_6'];?> :</label>
            <input type="text" name="txtDate" value="<?php echo $f_date;?>" id="txtDate" class="form-control datepicker"/>
          </div>
          <div class="form-group">
            <label for="txtTotalAmount"><?php echo $_data['add_new_form_field_text_7'];?> :</label>
            <div class="input-group">
              <input type="text" name="txtTotalAmount" value="<?php echo $total_amount;?>" id="txtTotalAmount" class="form-control" />
              <div class="input-group-addon"> <?php echo CURRENCY;?> </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtPurpose"><?php echo $_data['add_new_form_field_text_8'];?> :</label>
            <textarea name="txtPurpose" id="txtPurpose" class="form-control"><?php echo $purpose;?></textarea>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $button_text; ?>"/>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
