<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_complain.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$c_title = '';
$c_description = '';
$c_date = '';
$c_month = '';
$c_year = '';
$c_userid = '';
$branch_id = '';
$title = $_data['text_1'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['text_8'];
$form_url = WEB_URL . "complain/addcomplain.php";
$id="";
$hdnid="0";

if(isset($_POST['txtCTitle'])){
	$xmonth = date('m');
	$xyear = date('Y');
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$sql = "INSERT INTO tbl_add_complain(c_title,c_description, c_date, c_month,c_year,c_userid,branch_id) values('$_POST[txtCTitle]','$_POST[txtCDescription]','$_POST[txtCDate]',$xmonth,$xyear,'".(int)$_SESSION['objLogin']['aid']."','" . $_SESSION['objLogin']['branch_id'] . "')";
	//echo $sql;
	//die();
	mysqli_query($sql,$conn);
	mysqli_close($conn);
	$url = WEB_URL . 'complain/complainlist.php?m=add';
	header("Location: $url");
	
}
else{
	$sql = "UPDATE `tbl_add_complain` SET `c_title`='".$_POST['txtCTitle']."',`c_description`='".$_POST['txtCDescription']."',`c_date`='".$_POST['txtCDate']."' WHERE complain_id='".$_GET['id']."'";
	//echo $sql;
	//die();
	mysqli_query($sql,$conn);
	$url = WEB_URL . 'complain/complainlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($conn, "SELECT * FROM tbl_add_complain where complain_id = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){
		
		$c_title = $row['c_title'];
		$c_description = $row['c_description'];
		$c_date = $row['c_date'];
		$hdnid = $_GET['id'];
		$title = $_data['text_1_1'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['text_9'];
		$form_url = WEB_URL . "complain/addcomplain.php?id=".$_GET['id'];
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
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>complain/complainlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo WEB_URL?>complain/addcomplain.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtCTitle">Tittle <span style="color:red;">*</span> :</label>
            <input type="text" name="txtCTitle" value="" id="txtCTitle" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtCDescription">Description <span style="color:red;">*</span> :</label>
            <textarea name="txtCDescription" id="txtCDescription" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="txtCDate">Date <span style="color:red;">*</span> :</label>
            <input type="text" name="txtCDate" value="" id="txtCDate" class="form-control datepicker"/>
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
<script type="text/javascript">
function validateMe(){
	if($("#txtCTitle").val() == ''){
		alert("Title is Required !!!");
		$("#txtCTitle").focus();
		return false;
	}
	else if($("#txtCDescription").val() == ''){
		alert("Description is Required !!!");
		$("#txtCDescription").focus();
		return false;
	}
	else if($("#txtCDate").val() == ''){
		alert("Date is  Required !!!");
		$("#txtCDate").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
