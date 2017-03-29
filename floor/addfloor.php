<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_floor.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$branch_id = '';
$title = 'Add New Floor';
$button_text = $_data['save_button_text'];
$successful_msg="Add Floor Successfully";
$form_url = WEB_URL . "floor/addfloor.php";
$id="";
$hdnid="0";

if(isset($_POST['txtFloor'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	
	$sql = "INSERT INTO `tbl_add_floor`(floor_no,`branch_id`) values('$_POST[txtFloor]','" . $_SESSION['objLogin']['branch_id'] . "')";

	//echo $sql;
	//die();
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'floor/floorlist.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_add_floor` SET `floor_no`='".$_POST['txtFloor']."' WHERE fid='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	$url = WEB_URL . 'floor/floorlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = ("SELECT * FROM tbl_add_floor where fid = '" . $_GET['id'] . "'");
	$result = mysqli_query($conn,$result);
	while($row = mysqli_fetch_array($result)){
		
		$floor_no = $row['floor_no'];
		$hdnid = $_GET['id'];
		$title = 'Update Floor';
		$button_text = $_data['update_button_text'];
		$successful_msg="Update Floor Successfully";
		$form_url = WEB_URL . "floor/addfloor.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}
if(isset($_GET['mode']) && $_GET['mode'] == 'view'){
	$title = 'View Floor Details';
}	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['add_new_floor_top_title'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_floor_information_breadcam'];?></li>
    <li class="active"><?php echo $_data['add_new_add_floor_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>floor/floorlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_floor_entry_text'];?></h3>
      </div>


      <form onSubmit="return validateMe();" action="<?php echo WEB_URL; ?>floor/addfloor.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtFloor"><span class="errorStar">*</span> Floor No :</label>
            <input type="text" name="txtFloor"  id="txtFloor" class="form-control" />
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Save Information"/>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?> " name="hdn"/>
      </form>
     
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->







<script type="text/javascript">
function validateMe(){
	if($("#txtFloor").val() == ''){
		alert("Floor Required !!!");
		$("#txtFloor").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
