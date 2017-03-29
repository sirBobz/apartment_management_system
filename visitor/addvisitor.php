<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_visitor.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$title = $_data['text_1'];
$button_text=$_data['save_button_text'];
$successful_msg=$_data['text_15'];
$form_url = WEB_URL . "visitor/addvisitor.php";
$id="";
$hdnid="0";
$floor_id = 0;
$unit_id = 0;
$name = '';
$mobile = '';
$address = '';
$intime = '';
$outtime = '';
$xdate = '';
$branch_id = '';
$issue_date = '';
if(isset($_POST['txtName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$month = date('m');
	$year = date('Y');
	$sql = "INSERT INTO `tbl_visitor`(issue_date,name,mobile,address,floor_id,unit_id,intime,outtime,xmonth,xyear,branch_id) values('$_POST[txtIssueDate]','$_POST[txtName]','$_POST[txtMobile]','$_POST[txtAddress]','$_POST[ddlFloorNo]','$_POST[ddlUnitNo]','$_POST[txtInTime]','$_POST[txtOutTime]',$month,$year,'" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'visitor/visitorlist.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_visitor` SET `issue_date`='".$_POST['txtIssueDate']."',`name`='".$_POST['txtName']."',`mobile`='".$_POST['txtMobile']."',`address`='".$_POST['txtAddress']."',`floor_id`='".$_POST['ddlFloorNo']."',`unit_id`='".$_POST['ddlUnitNo']."',`intime`='".$_POST['txtInTime']."',`outtime`='".$_POST['txtOutTime']."' WHERE vid='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	$url = WEB_URL . 'visitor/visitorlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query("SELECT * FROM tbl_visitor where vid = '" . $_GET['id'] . "'",$link);
	while($row = mysqli_fetch_array($result)){
		
		$issue_date = $row['issue_date'];
		$name = $row['name'];
		$mobile = $row['mobile'];
		$floor_id = $row['floor_id'];
		$unit_id = $row['unit_id'];
		$intime = $row['intime'];
		$outtime = $row['outtime'];
		$address = $row['address'];
		$hdnid = $_GET['id'];
		$title = $_data['text_16'];
		$button_text=$_data['update_button_text'];
		$successful_msg=$_data['text_17'];
		$form_url = WEB_URL . "visitor/addvisitor.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_2'];?></li>
    <li class="active"><?php echo $_data['text_3'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>visitor/visitorlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      
       <form onSubmit="return validateMe();" action="<?php echo WEB_URL; ?>visitor/addvisitor.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtFloor">Issue Date :</label>
            <input type="text" name="txtIssueDate" value="" id="txtIssueDate" class="form-control datepicker" />
          </div>
		  <div class="form-group">
            <label for="txtFloor">Name :</label>
            <input type="text" name="txtName" value="" id="txtFloor" class="form-control" />
          </div>
		  <div class="form-group">
            <label for="txtFloor">Mobile :</label>
            <input type="text" name="txtMobile" value="" id="txtFloor" class="form-control" />
          </div>
		  <div class="form-group">
            <label for="txtFloor">Address :</label>
            <textarea name="txtAddress" class="form-control" id="txtAddress"></textarea>
          </div>
		  <div class="form-group">
            <label for="ddlFloorNo">Address :</label>
            <select onchange="getUnitReport(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
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
                            <option  value="1">3</option>
                            <option  value="2">56</option>
                            <option  value="3">602</option>
                          </select>
          </div>
		  <div class="form-group">
            <label for="txtFloor">In Time :</label>
            <input class="time" type="text" name="txtInTime" value="" id="txtInTime" class="form-control" />
          </div>
		  <div class="form-group">
            <label for="txtFloor">Out Time :</label>
            <input class="time" type="text" name="txtOutTime" value="" id="txtOutTime" class="form-control" />
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
