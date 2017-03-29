<?php include('../header.php')?>
<?php
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_bill_list.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$sqlx= "DELETE FROM `tbl_add_bill` WHERE bill_id = ".$_GET['id'];
	mysqli_query($sqlx,$link); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = "Added Bill Information Successfully";
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = "Updated Bill Information Successfully";
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_2'];?></li>
	<li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?> !</h4>
      <?php echo $_data['text_17'];?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bill/add_bill.php" data-original-title="<?php echo $_data['text_3'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_1'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['text_5'];?></th>
              <th><?php echo $_data['text_7'];?></th>
              <th><?php echo $_data['text_8'];?></th>
              <th><?php echo $_data['text_10'];?></th>
              <th><?php echo $_data['text_12'];?></th>
              <th><?php echo $_data['text_13'];?></th>
              <th><?php echo $_data['text_14'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
				$result = mysqli_query($conn, "Select *,bt.bill_type as bt_type,m.month_name,y.xyear,bt.bt_id from tbl_add_bill b inner join tbl_add_bill_type bt on bt.bt_id = b.bill_type inner join tbl_add_month_setup m on m.m_id = b.bill_month inner join tbl_add_year_setup y on y.y_id = b.bill_year where b.branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . " order by b.bill_id asc");
				while($row = mysqli_fetch_array($result)){?>
            <tr>
              <td><?php echo $row['bt_type']; ?></td>
              <td><?php echo $row['bill_date']; ?></td>
              <td><?php echo $row['month_name']; ?></td>
              <td><?php echo $row['xyear']; ?></td>
              <?php if($currency_position == 'left') { ?>
          	  <td><?php echo $global_currency.$row['total_amount']; ?></td>
          	  <?php } else { ?>
          	  <td><?php echo $row['total_amount'].$global_currency; ?></h3>
          	  <?php } ?>
              <td><?php echo $row['deposit_bank_name']; ?></td>
              <td><?php echo $row['bill_details']; ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['bill_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>bill/add_bill.php?id=<?php echo $row['bill_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteBill(<?php echo $row['bill_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                <div id="nurse_view_<?php echo $row['bill_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo $_data['text_1_1'];?></h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div><!--<img style="width:200px;height:200px;border-radius:200px;" src="<?php //echo $image;  ?>" />--></div>
                        <div class="model_title"><?php echo $row['bill_type']; ?></div>
                      </div>
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-12"> <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['bt_type']; ?><br/>
                            <b><?php echo $_data['text_7'];?> :</b> <?php echo $row['bill_date']; ?><br/>
                            <b><?php echo $_data['text_8'];?> :</b> <?php echo $row['month_name']; ?><br/>
                            <b><?php echo $_data['text_10'];?> :</b> <?php echo $row['xyear']; ?><br/>
                            <b><?php echo $_data['text_12'];?> :</b> <?php if($currency_position == 'left') {echo $global_currency.$row['total_amount'];}else { echo $row['total_amount'].$global_currency;}?><br/>
                            <b><?php echo $_data['text_13'];?> :</b> <?php echo $row['deposit_bank_name']; ?><br/>
                            <b><?php echo $_data['text_14'];?> :</b> <?php echo $row['bill_details']; ?><br/>
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
function deleteBill(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Bill ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>bill/bill_list.php?id=' + Id;
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
