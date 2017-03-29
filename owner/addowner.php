<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_owner.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$o_name = '';
$o_email = '';
$o_contact = '';
$o_pre_address = '';
$o_per_address = '';
$o_nid = '';
$o_password = '';
$owner_unit = '';
$branch_id = '';
$title = $_data['add_new_owner'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_owner_successfully'];
$form_url = WEB_URL . "owner/addowner.php";
$id="";
$hdnid="0";
$image_own = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$rowx_unit = array();

if(isset($_POST['txtOwnerName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
	$o_password = $_POST['txtPassword'];
	$image_url = uploadImage();
	$sql = "INSERT INTO tbl_add_owner(o_name,o_email, o_contact, o_pre_address,o_per_address,o_nid,o_password,image,branch_id) values('$_POST[txtOwnerName]','$_POST[txtOwnerEmail]','$_POST[txtOwnerContact]','$_POST[txtOwnerPreAddress]','$_POST[txtOwnerPerAddress]','$_POST[txtOwnerNID]','$o_password','$image_url','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($sql,$conn);
	 $last_id = mysqli_insert_id();
	  if(isset($_POST['ChkOwnerUnit'])){   /*if open */
		foreach ($_POST['ChkOwnerUnit'] as $value) {   /*foreach open */
			$sql_unit="INSERT INTO `tbl_add_owner_unit_relation`(owner_id,unit_id) VALUES($last_id,$value)";
			mysqli_query($sql_unit,$conn);	 
		}  /* foreach close */
	  }  /* if close */
	  else {
			echo "No results";  
	  }

	mysqli_close($conn);
	$url = WEB_URL . 'owner/ownerlist.php?m=add';
	header("Location: $url");
	
}
else{
	$image_url = uploadImage();
	if($image_url == ''){
		$image_url = $_POST['img_exist'];
	}
	$sql = "UPDATE `tbl_add_owner` SET `o_name`='".$_POST['txtOwnerName']."',`o_email`='".$_POST['txtOwnerEmail']."',`o_password`='".$_POST['txtPassword']."',`o_contact`='".$_POST['txtOwnerContact']."',`o_pre_address`='".$_POST['txtOwnerPreAddress']."',`o_per_address`='".$_POST['txtOwnerPerAddress']."',`o_nid`='".$_POST['txtOwnerNID']."',`image`='".$image_url."' WHERE ownid='".$_GET['id']."'";
	mysqli_query($sql,$conn);
	if(isset($_POST['ChkOwnerUnit'])){  /* if open */
		$sql_unit= "DELETE FROM `tbl_add_owner_unit_relation` WHERE owner_id = ".$_GET['id'];
		mysqli_query($sql_unit,$conn);
		foreach ($_POST['ChkOwnerUnit'] as $value) {  /* foreach open */
			$sql_unit="INSERT INTO `tbl_add_owner_unit_relation`(owner_id,unit_id) VALUES('$_GET[id]',$value)";
			mysqli_query($sql_unit,$conn);
		}  /* foreach close */
	  } /* if close */
	  else {
			$sql_unit= "DELETE FROM `tbl_add_owner_unit_relation` WHERE owner_id = ".$_GET['id'];
			mysqli_query($sql_unit,$conn); 
	  }
	$url = WEB_URL . 'owner/ownerlist.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query("SELECT * FROM tbl_add_owner where ownid = '" . $_GET['id'] . "'",$conn);
	while($row = mysql_fetch_array($result)){
		
		$o_name = $row['o_name'];
		$o_email = $row['o_email'];
		$o_contact = $row['o_contact'];
		$o_pre_address = $row['o_pre_address'];
		$o_per_address = $row['o_per_address'];
		$o_password = $row['o_password'];
		$o_nid = $row['o_nid'];
		if($row['image'] != ''){
			$image_own = WEB_URL . 'img/upload/' . $row['image'];
			$img_track = $row['image'];
		}
		$hdnid = $_GET['id'];
		$title = 'Update Owner';
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_owner_successfully'];
		$form_url = WEB_URL . "owner/addowner.php?id=".$_GET['id'];
	}
	$result_unit = mysqli_query("SELECT unit_id FROM tbl_add_owner_unit_relation where owner_id = '" . $_GET['id'] . "'",$conn);
	while($row_unit = mysql_fetch_array($result_unit)){
		array_push($rowx_unit,$row_unit['unit_id']);
	}
	//mysql_close($conn);

}
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
  <h1><?php echo $_data['add_new_owner'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_owner_information_breadcam'];?></li>
    <li class="active"><?php echo $_data['add_new_owner_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>owner/ownerlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_owner_entry_form'];?></h3>
      </div>

      <form onSubmit="return validateMe();" action="<?php echo WEB_URL; ?>owner/addowner.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtOwnerName"><span class="errorStar">*</span>Owner Name :</label>
            <input type="text" name="txtOwnerName" value="" id="txtOwnerName" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtOwnerEmail"><span class="errorStar">*</span>Email  :</label>
            <input type="text" name="txtOwnerEmail" value="" id="txtOwnerEmail" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtPassword"><span class="errorStar">*</span>Password :</label>
            <input type="text" name="txtPassword" value="" id="txtPassword" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtOwnerContact"><span class="errorStar">*</span>Contact :</label>
            <input type="text" name="txtOwnerContact" value="" id="txtOwnerContact" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtOwnerPreAddress"><span class="errorStar">*</span>Present Address :</label>
            <textarea name="txtOwnerPreAddress" id="txtOwnerPreAddress" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="txtOwnerPerAddress"><span class="errorStar">*</span>Permanent Address :</label>
            <textarea name="txtOwnerPerAddress" id="txtOwnerPerAddress" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="txtOwnerNID"><span class="errorStar">*</span>NID(National ID) :</label>
            <input type="text" name="txtOwnerNID" value="" id="txtOwnerNID" class="form-control" />
          </div>
          <div class="form-group">
            <label for="ChkOwnerUnit">Owenr Unit :</label>
            <div style="height:100px;border:solid 1px #ccc;overflow:auto">
                            <div style="margin-left:.7%;">
                <label>
                <input class="" type="checkbox"  value="1" name="ChkOwnerUnit[]" id="ChkOwnerUnit[]" />
                3&nbsp;(2) </label>
              </div>
                            <div style="margin-left:.7%;">
                <label>
                <input class="" type="checkbox"  value="2" name="ChkOwnerUnit[]" id="ChkOwnerUnit[]" />
                56&nbsp;(2) </label>
              </div>
                            <div style="margin-left:.7%;">
                <label>
                <input class="" type="checkbox"  value="3" name="ChkOwnerUnit[]" id="ChkOwnerUnit[]" />
                602&nbsp;(2) </label>
              </div>
                          </div>
          </div>
          <div class="form-group">
            <label for="Prsnttxtarea">Preview :</label>
            <img class="form-control" src="<?php echo WEB_URL; ?>img/no_image.jpg" style="height:100px;width:100px;" id="output"/>
            <input type="hidden" name="img_exist" value="" />
          </div>
          <div class="form-group"> <span class="btn btn-file btn btn-primary">Upload Image            <input type="file" name="uploaded_file" onchange="loadFile(event)" />
            </span> </div>
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
	if($("#txtOwnerName").val() == ''){
		alert("Owner Name Required !!!");
		$("#txtOwnerName").focus();
		return false;
	}
	else if($("#txtOwnerEmail").val() == ''){
		alert("Email Required !!!");
		$("#txtOwnerEmail").focus();
		return false;
	}
	else if($("#txtPassword").val() == ''){
		alert("Password Required !!!");
		$("#txtPassword").focus();
		return false;
	}
	else if($("#txtOwnerContact").val() == ''){
		alert("Contact Number Required !!!");
		$("#txtOwnerContact").focus();
		return false;
	}
	else if($("#txtOwnerPreAddress").val() == ''){
		alert("Present Address Required !!!");
		$("#txtOwnerPreAddress").focus();
		return false;
	}
	else if($("#txtOwnerPerAddress").val() == ''){
		alert("Permanent Address Required !!!");
		$("#txtOwnerPerAddress").focus();
		return false;
	}
	else if($("#txtOwnerNID").val() == ''){
		alert("NID Required !!!");
		$("#txtOwnerNID").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
