<?php 
include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_owner_list.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$sqlx= "DELETE FROM `tbl_add_owner` WHERE ownid = ".$_GET['id'];
	mysqli_query($sqlx,$conn); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['added_owner_successfully'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['update_owner_successfully'];
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['owner_list'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_owner_information_breadcam'];?></li>
	<li class="active"><?php echo $_data['owner_list'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i><?php echo $_data['delete_text'];?> !</h4>
      <?php echo $_data['delete_owner_information'];?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i><?php echo $_data['success'];?>!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>owner/addowner.php" data-original-title="<?php echo $_data['add_new_owner_breadcam'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['owner_list'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['add_new_form_field_text_9'];?></th>
              <th><?php echo $_data['add_new_form_field_text_1'];?></th>
              <th><?php echo $_data['add_new_form_field_text_2'];?></th>
              <th><?php echo $_data['add_new_form_field_text_4'];?></th>
              <th><?php echo $_data['add_new_form_field_text_5'];?></th>
              <th><?php echo $_data['add_new_form_field_text_8'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
				$result = mysqli_query($conn, "Select * from tbl_add_owner where branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . " order by ownid desc");
				while($row = mysqli_fetch_array($result)){
					$image = WEB_URL . 'img/no_image.jpg';	
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['image'];
					}
				
				?>
            <tr>
              <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><?php echo $row['o_name']; ?></td>
              <td><?php echo $row['o_email']; ?></td>
              <td><?php echo $row['o_contact']; ?></td>
              <td><?php echo $row['o_pre_address']; ?></td>
              <td><?php
				 $i=1;
				 $result_sp = mysqli_query($conn, "Select u.unit_no from tbl_add_owner_unit_relation owr inner join tbl_add_unit u on owr.unit_id = u.uid where owr.owner_id = '". $row['ownid'] . "' order by u.unit_no ASC");
				while($row_sp = mysqli_fetch_array($result_sp)){
					echo '<div align="left">' . $i . ') ' .$row_sp['unit_no'].'</div>';
					$i++;
				}
		  	  ?>
              </td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['ownid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>owner/addowner.php?id=<?php echo $row['ownid']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteOwner(<?php echo $row['ownid']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                <div id="nurse_view_<?php echo $row['ownid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo $_data['owner_details'];?></h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div> <img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;;  ?>" /> </div>
                        <div class="model_title"><?php echo $row['o_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-6"> <b><?php echo $_data['add_new_form_field_text_1'];?> :</b> <?php echo $row['o_name']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_2'];?> :</b> <?php echo $row['o_email']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_3'];?> :</b> <?php echo $row['o_password']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_4'];?> :</b> <?php echo $row['o_contact']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_5'];?> :</b> <?php echo $row['o_pre_address']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_6'];?> :</b> <?php echo $row['o_per_address']; ?><br/>
                            <b><?php echo $_data['add_new_form_field_text_7'];?> :</b> <?php echo $row['o_nid']; ?><br/>
                          </div>
                          <div class="col-xs-6"> <b><?php echo $_data['add_new_form_field_text_8'];?> :</b>
                            <?php
				 $i=1;
				 $result_sp = mysql_query("Select u.unit_no from tbl_add_owner_unit_relation owr inner join tbl_add_unit u on owr.unit_id = u.uid where owr.owner_id = '". $row['ownid'] . "' order by u.unit_no ASC",$conn);
				while($row_sp = mysql_fetch_array($result_sp)){
					echo '<div align="left">' . $i . ') ' .$row_sp['unit_no'].'</div>';
					$i++;
				}
		  	  ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                </div></td>
            </tr>
            <?php } mysqli_close($conn); ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<script type="text/javascript">
function deleteOwner(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Owner ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>owner/ownerlist.php?id=' + Id;
	}
  }
  
  $( document ).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
</script>
<?php include('../footer.php'); ?>
