<?php 
include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
	$name ='';
	$email = '';
	$password = '';
	$branch_id = '';
	$bname = '';
	$button_text = "Save Information";
	$form_url = WEB_URL . "setting/admin.php";
	$hval = 0;
	
	if(isset($_POST['txtAdminName'])){
		if($_POST['hdnSpid'] == '0'){		
			$sql="INSERT INTO `tbl_add_admin`(`name`,`email`,`password`,`branch_id`) VALUES ('$_POST[txtAdminName]','$_POST[txtAdminEmail]','$_POST[txtAdminPassword]','$_POST[ddlBranch]')";	
			mysqli_query($sql, $conn);
			mysql_close($conn);
		    $url = WEB_URL . 'setting/admin.php?m=add';
		    header("Location: $url");
		}
		else{		
			$sql_update="UPDATE `tbl_add_admin` set name = '".$_POST['txtAdminName']."',email = '".$_POST['txtAdminEmail']."',password = '".$_POST['txtAdminPassword']."',branch_id = '".$_POST['ddlBranch']."' where aid= '" . (int)$_POST['hdnSpid'] . "'";	
			mysqli_query($sql_update, $conn);
			mysqli_close($conn);
		    $url = WEB_URL . 'setting/admin.php?m=up';
		    header("Location: $url");
			/*echo "<script>alert('Update Successfully');</script>";*/
		}
	}
	
	if(isset($_GET['spid']) && $_GET['spid'] != ''){
		$result = mysqli_query($conn, "SELECT *,a.added_date as p_added_date,b.branch_name from tbl_add_admin a inner join tblbranch b on b.branch_id = a.branch_id where a.aid= '" . (int)$_GET['spid'] . "'");
		
		if($row = mysqli_fetch_array($result)){
		 	$name = $row['name'];
			$email = $row['email'];
			$password = $row['password'];
			$branch_id = $row['branch_id'];
			$bname = $row['branch_name'];
			$button_text = "Update Information";
			$form_url = WEB_URL . "setting/admin.php?id=".$_GET['spid'];
			$hval = $row['aid'];
		}
			
	}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Admin Setup </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?php echo WEB_URL?>setting/setting.php">Settings</a></li>
    <li class="active">Admin Setup</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/setting.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title">Admin Setup Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtAdminName">Name :</label>
            <input type="text" name="txtAdminName" id="txtAdminName" value="<?php echo $name; ?>" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtAdminEmail">Email :</label>
            <input type="text" name="txtAdminEmail" id="txtAdminEmail" value="<?php echo $email; ?>" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtAdminPassword">Password :</label>
            <input type="password" name="txtAdminPassword" value="<?php echo $password; ?>" id="txtAdminPassword" class="form-control" />
          </div>
          <div class="form-group">
            <label for="ddlBranch">Branch :</label>
            <select name="ddlBranch" id="ddlBranch" class="form-control">
              <option value="">--Select--</option>
              <?php
						$result_page = mysqli_query("SELECT * FROM tblbranch order by branch_name ASC" );
						while($row_page = mysqli_fetch_array($result_page)){
							if($branch_id  == $row_page['branch_id']){
								echo '<option selected="selected" value="'.$row_page['branch_id'].'">'.$row_page['branch_name'].'</option>';
							}
							else{
								echo '<option value="'.$row_page['branch_id'].'">'.$row_page['branch_name'].'</option>';
							}
						}
						//mysql_close($link); 
						?>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $button_text; ?>"/>
            &nbsp;
            <input type="reset" onClick="javascript:window.location.href='<?php echo WEB_URL; ?>setting/admin.php';" name="btnReset" id="btnReset" value="Reset" class="btn btn-primary"/>
          </div>
        </div>
        <input type="hidden" name="hdnSpid" value="<?php echo $hval; ?>"/>
      </form>
      <h4 style="text-align:center; color:red;">Please Reset First Before Insert</h4>
      <!-- /.box-body -->
      <?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
 if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
		$sqlx= "DELETE FROM `tbl_add_admin` WHERE aid = ".$_GET['delid'];
		mysqli_query($sqlx,$link); 
		$delinfo = 'block';
	}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added Admin Information Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Admin Information Successfully";
}
?>
      <!-- Main content -->
      <section class="content">
      <!-- Full Width boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
            Deleted Admin Information Successfully. </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Admin List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Branch</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($conn, "SELECT *,a.added_date as p_addted_date,b.branch_name from tbl_add_admin a inner join tblbranch b on b.branch_id = a.branch_id order by a.aid DESC");
				while($row = mysqli_fetch_array($result)){
					$phpdate = strtotime( $row['p_addted_date'] );
                 	$date = date( 'd/m/Y H:i:s', $phpdate ); ?>
                  <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#employee_view_<?php echo $row['aid']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>configuration/admin.php?spid=<?php echo $row['aid']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onclick="deleteAdmin(<?php echo $row['aid']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                      <div id="employee_view_<?php echo $row['aid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header orange_header">
                            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                            <h3 class="modal-title">Admin Details</h3>
                          </div>
                          <div class="modal-body model_view" align="center">&nbsp;
                            <div>
                              <!--<img class="photo_img_round" style="width:100px;height:100px;" src="<?php //echo $image;  ?>" />-->
                            </div>
                            <div class="model_title"><?php echo $row['name']; ?></div>
                          </div>
                          <div class="modal-body">
                            <h3 style="text-decoration:underline;">Details Infromation</h3>
                            <div class="row">
                              <div class="col-xs-12"> <b>Name:</b> <?php echo $row['name']; ?><br/>
                                <b>Email:</b> <?php echo $row['email']; ?><br/>
                                <b>Branch:</b> <?php echo $row['branch_name']; ?><br/>
                              </div>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                      </div></td>
                  </tr>
                  <?php } mysql_close($link); ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Branch</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
  function deleteAdmin(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Admin ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL;?>setting/admin.php?delid=' + Id;
	}
  }
  </script>
<?php include('../footer.php'); ?>
