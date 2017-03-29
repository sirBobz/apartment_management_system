<?php include('../header_emp.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_employee_member_details.php');
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $_data['text_1'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>e_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
	<li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>e_dashboard.php" data-original-title="<?php echo $_data['dashboard'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_1'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['image'];?></th>
              <th><?php echo $_data['text_2'];?></th>
              <th><?php echo $_data['text_3'];?></th>
              <th><?php echo $_data['text_4'];?></th>
              <th><?php echo $_data['text_5'];?></th>
              <th><?php echo $_data['text_6'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
				$result = mysqli_query($conn, "Select *,mt.member_type as mt_type from tbl_add_management_committee mc inner join tbl_add_member_type mt on mt.member_id = mc.member_type order by mc_id desc");
				while($row = mysqli_fetch_array($result)){
					$image = WEB_URL . 'img/no_image.jpg';	
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['image'];
					}
				
				?>
            <tr>
              <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><?php echo $row['mc_name']; ?></td>
              <td><?php echo $row['mt_type']; ?></td>
              <td><?php echo $row['mc_email']; ?></td>
              <td><?php echo $row['mc_contact']; ?></td>
              <td><?php echo $row['mc_pre_address']; ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['mc_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a>
                <div id="nurse_view_<?php echo $row['mc_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo $_data['text_7'];?></h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div> <img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;;  ?>" /> </div>
                        <div class="model_title"><?php echo $row['mc_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-6"> <b><?php echo $_data['text_2'];?> :</b> <?php echo $row['mc_name']; ?><br/>
                            <b><?php echo $_data['text_3'];?> :</b> <?php echo $row['mt_type']; ?><br/>
                            <b><?php echo $_data['text_4'];?> :</b> <?php echo $row['mc_email']; ?><br/>
                            <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['mc_contact']; ?><br/>
                            <b><?php echo $_data['text_6'];?> :</b> <?php echo $row['mc_pre_address']; ?><br/>
                            <b><?php echo $_data['text_8'];?> :</b> <?php echo $row['mc_per_address']; ?><br/>
                            <b><?php echo $_data['text_9'];?> :</b> <?php echo $row['mc_nid']; ?><br/>
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
<?php include('../footer.php'); ?>
