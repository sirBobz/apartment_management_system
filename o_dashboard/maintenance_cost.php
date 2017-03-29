<?php include('../header_owner.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_maintenence_cost.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $_data['text_1'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>o_dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"><a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>o_dashboard.php" data-original-title="<?php echo $_data['owner_dashboard'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_1'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['text_2'];?></th>
              <th><?php echo $_data['text_3'];?></th>
              <th><?php echo $_data['text_4'];?></th>
              <th><?php echo $_data['text_5'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
        <?php
				$result = mysqli_query($conn, "Select * from tbl_add_maintenance_cost order by mcid desc");
				while($row = mysqli_fetch_array($result)){?>
            <tr>
            <td><?php echo $row['m_title']; ?></td>
            <td><?php echo $row['m_date']; ?></td>
            <td><?php echo $row['m_amount'].' '.CURRENCY; ?></td>
			<td><?php echo $row['m_details']; ?></td>
            <td>
            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#nurse_view_<?php echo $row['mcid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a>
            <div id="nurse_view_<?php echo $row['mcid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header orange_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title"><?php echo $_data['text_6'];?></h3>
                  </div>
                  <div class="modal-body model_view" align="center">&nbsp;
                    <div><!--<img class="photo_img_round" style="width:100px;height:100px;" src="<?php //echo $event_image;  ?>" />--></div>
                    <div class="model_title"><?php echo $row['m_title']; ?></div>
                  </div>
				  <div class="modal-body">
                    <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                    <div class="row">
                      <div class="col-xs-12"> 
					    <b><?php echo $_data['text_2'];?> :</b> <?php echo $row['m_title']; ?><br/>
                        <b><?php echo $_data['text_3'];?> :</b> <?php echo $row['m_date']; ?><br/>
                        <b><?php echo $_data['text_4'];?> :</b> <?php echo $row['m_amount'].' '.CURRENCY; ?><br/>
                        <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['m_details']; ?><br/>
                      </div>
                    </div>
                  </div>
				  
                </div>
                <!-- /.modal-content -->
              </div>
            </div>
            </td>
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
function deleteMaintenanceCost(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Maintenance Cost ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php?id=' + Id;
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
