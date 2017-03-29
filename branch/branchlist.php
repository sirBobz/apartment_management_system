<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_branch_list.php');
if(!isset($_SESSION['objLogin']) && $_SESSION['login_type'] == "5"){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
 if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
		$sqlx= "DELETE FROM `tblbranch` WHERE branch_id = ".$_GET['id'];
		mysqli_query($sqlx,$conn); 
		$delinfo = 'block';
	}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['text_11'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['text_12'];
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $_data['text_14'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>/dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['text_12'];?></a></li>
    <li class="active"><?php echo $_data['text_14'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?>!</h4>
      <?php echo $_data['text_13'];?> </div>
    <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?>!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>branch/addbranch.php" data-original-title="<?php echo $_data['success'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['text_17'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_14'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['text_4'];?></th>
              <th><?php echo $_data['text_5'];?></th>
              <th><?php echo $_data['text_6'];?></th>
              <th><?php echo $_data['text_7'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
          	$result = mysqli_query($conn, "Select * from tblbranch order by branch_id desc");
				while($row = mysqli_fetch_array($result)){ ?>
            <tr>
              <td><?php echo $row['branch_name']; ?></td>
              <td><?php echo $row['b_email']; ?></td>
              <td><?php echo $row['b_contact_no']; ?></td>
              <td><?php echo $row['b_address']; ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#employee_view_<?php echo $row['branch_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>branch/addbranch.php?id=<?php echo $row['branch_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onclick="deleteBranch(<?php echo $row['branch_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                <div id="employee_view_<?php echo $row['branch_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo $_data['text_16'];?></h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div><!--<img class="photo_img_round" style="width:100px;height:100px;" src="<?php //echo $image;  ?>" />--></div>
                        <div class="model_title"><?php echo $row['branch_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-12"> <b><?php echo $_data['text_4'];?> : </b> <?php echo $row['branch_name']; ?><br/>
                            <b><?php echo $_data['text_5'];?> : </b> <?php echo $row['b_email']; ?><br/>
                            <b><?php echo $_data['text_6'];?> : </b> <?php echo $row['b_contact_no']; ?><br/>
                            <b><?php echo $_data['text_7'];?> : </b> <?php echo $row['b_address']; ?><br/> </div>
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
  function deleteBranch(Id){
  	var iAnswer = confirm("Are you sure you want to delete this branch ?");
	if(iAnswer){
		window.location = 'branchlist.php?id=' + Id;
	}
  }
  </script>
<?php include('../footer.php'); ?>
