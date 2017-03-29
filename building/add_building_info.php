<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_building_info.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$name = '';
$address = '';
$security_guard_mobile = '';
$secrataty_mobile = '';
$moderator_mobile = '';
$building_make_year = '';
$building_image = '';
$b_name = '';
$b_address = '';
$b_phone = '';
$branch_id = '';
$title = $_data['text_1'];
$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "building/add_building_info.php";
$id="";
$hdnid="0";
$image_building = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$rowx_unit = array();

if(isset($_POST['txtBName'])){
	$sqlx = "DELETE FROM `tbl_add_building_info`";
	mysqli_query($sqlx,$conn);
	$image_url = uploadImage();
	$sql = "INSERT INTO tbl_add_building_info(name,address, security_guard_mobile, secrataty_mobile,moderator_mobile,building_make_year,b_name,b_address,b_phone,building_image,branch_id) values('$_POST[txtBName]','$_POST[txtBAddress]','$_POST[txtBSecurityGuardMobile]','$_POST[txtBSecrataryMobile]','$_POST[txtBModeratorMobile]','$_POST[txtBMakeYear]','$_POST[txtBlName]','$_POST[txtBlAddress]','$_POST[txtBlPhone]','$image_url','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($sql,$conn);
	//mysql_close($link);
	
}
	$result = mysqli_query($conn, "SELECT *,y.y_id,y.xyear FROM tbl_add_building_info bi inner join tbl_add_year_setup y on y.y_id = bi.building_make_year where bi.branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . " order by bi.name");
	while($row = mysqli_fetch_array($result)){
		
		$name = $row['name'];
		$address = $row['address'];
		$security_guard_mobile = $row['security_guard_mobile'];
		$secrataty_mobile = $row['secrataty_mobile'];
		$moderator_mobile = $row['moderator_mobile'];
		$building_make_year = $row['building_make_year'];
		$b_name = $row['b_name'];
		$b_address = $row['b_address'];
		$b_phone = $row['b_phone'];
		if($row['building_image'] != ''){
			$image_building = WEB_URL . 'img/upload/' . $row['building_image'];
			$img_track = $row['building_image'];
		}
	}
	//mysql_close($link);

//for image upload
function uploadImage(){
	if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
	  $filename = basename($_FILES['uploaded_file']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["uploaded_file"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
		return $newfilename;
	  }
	  else{
	  	return '';
	  }
	}
	return '';
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
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
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 style="color:red;font-weight:bold;" class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
        <div class="form-group">
          <label for="txtBName"><span style="color:red;">*</span>Name :</label>
          <input type="text" name="txtBName" value="a" id="txtBName" class="form-control" />
        </div>
        <div class="form-group">
          <label for="txtBAddress"><span style="color:red;">*</span>Address :</label>
          <textarea name="txtBAddress" id="txtBAddress" class="form-control">a</textarea>
        </div>
        <div class="form-group">
          <label for="txtBSecurityGuardMobile"><span style="color:red;">*</span>Security Guard Mobile:</label>
          <input type="text" name="txtBSecurityGuardMobile" value="a" id="txtBSecurityGuardMobile" class="form-control" />
        </div>
        <div class="form-group">
          <label for="txtBSecrataryMobile"><span style="color:red;">*</span>Secretary Mobile :</label>
          <input type="text" name="txtBSecrataryMobile" value="a" id="txtBSecrataryMobile" class="form-control" />
        </div>
        <div class="form-group">
          <label for="txtBModeratorMobile"><span style="color:red;">*</span>Moderator Mobile :</label>
          <input type="text" name="txtBModeratorMobile" value="a" id="txtBModeratorMobile" class="form-control" />
        </div>
        <div class="form-group">
          <label for="txtBMakeYear"><span style="color:red;">*</span>Buildig Make Year :</label>
          <select name="txtBMakeYear" id="txtBMakeYear" class="form-control">
            <option value="">--Select Year--</option>
                        <option  value="3">2011</option>
                        <option  value="4">2012</option>
                        <option  value="5">2013</option>
                        <option selected value="6">2014</option>
                        <option  value="7">2015</option>
                        <option  value="8">2016</option>
                        <option  value="9">2017</option>
                        <option  value="10">2018</option>
                        <option  value="11">2019</option>
                        <option  value="12">2020</option>
                      </select>
        </div>
        <div class="box-header">
          <h3 style="color:red;font-weight:bold;" class="box-title">Builder Information</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label for="txtBlName"><span style="color:red;">*</span>Name :</label>
            <input type="text" name="txtBlName" value="a" id="txtBlName" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtBlAddress"><span style="color:red;">*</span>Address :</label>
            <textarea name="txtBlAddress" id="txtBlAddress" class="form-control">a</textarea>
          </div>
          <div class="form-group">
            <label for="txtBlPhone"><span style="color:red;">*</span>Phone :</label>
            <input type="text" name="txtBlPhone" value="a" id="txtBlPhone" class="form-control" />
          </div>
          <div class="form-group">
            <label for="Prsnttxtarea">Building Image :</label>
            <img class="form-control" src="<?php echo WEB_URL?>img/no_image.jpg" style="height:100px;width:100px;" id="output"/>
            <input type="hidden" name="img_exist" value="" />
          </div>
          <div class="form-group"> <span class="btn btn-file btn btn-primary">Upload Image            <input type="file" name="uploaded_file" onchange="loadFile(event)" />
            </span> </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Save Information"/>
          </div>
        </div>
      </form>
     
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtBName").val() == ''){
		alert("Name is Required !!!");
		$("#txtBName").focus();
		return false;
	}
	else if($("#txtBAddress").val() == ''){
		alert("Address is Required !!!");
		$("#txtBAddress").focus();
		return false;
	}
	else if($("#txtBSecurityGuardMobile").val() == ''){
		alert("Security Guard Number is Required !!!");
		$("#txtBSecurityGuardMobile").focus();
		return false;
	}
	else if($("#txtBSecrataryMobile").val() == ''){
		alert("Secratary Number is Required !!!");
		$("#txtBSecrataryMobile").focus();
		return false;
	}
	else if($("#txtBModeratorMobile").val() == ''){
		alert("Moderator Number is Required !!!");
		$("#txtBModeratorMobile").focus();
		return false;
	}
	else if($("#txtBMakeYear").val() == ''){
		alert("Year is Required !!!");
		$("#txtBMakeYear").focus();
		return false;
	}
	else if($("#txtBlName").val() == ''){
		alert("Builder Name is Required !!!");
		$("#txtBlName").focus();
		return false;
	}
	else if($("#txtBlAddress").val() == ''){
		alert("Builder Address is Required !!!");
		$("#txtBlAddress").focus();
		return false;
	}
	else if($("#txtBlPhone").val() == ''){
		alert("Builder Phone is Required !!!");
		$("#txtBlPhone").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
