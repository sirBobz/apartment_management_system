<?php include('../header_ten.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_unit_details.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $_data['text_1'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>o_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"><a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>t_dashboard.php" data-original-title="<?php echo $_data['dashboard'];?>"><i class="fa fa-dashboard"></i></a></div>
    <div class="box box-info">
      <!-- /.box-header -->
      <div class="box-body">
        <?php
		$result = mysqli_query($conn, "Select f.floor_no,u.unit_no,u.uid,r.r_name,r.r_email,r.r_contact,r.r_address,r.r_nid,r.r_floor_no,r.r_unit_no,r.r_advance,r.r_rent_pm,r.r_date,r.image as r_image from tbl_add_unit u inner join tbl_add_floor f on f.fid = u.floor_no inner join tbl_add_rent r on r.r_unit_no = u.uid where r.rid = '". (int)$_SESSION['objLogin']['rid'] . "' order by u.uid desc");
				if($row = mysqli_fetch_array($result)){
					$image = WEB_URL . 'img/no_image.jpg';	
		if(file_exists(ROOT_PATH . '/img/upload/' . $row['r_image']) && $row['r_image'] != ''){
			$image = WEB_URL . 'img/upload/' . $row['r_image'];
		}
					
					 ?>
        <div class="modal-content">
          <div class="modal-header orange_header">
            <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
            <h3 class="modal-title"><?php echo $_data['text_1'];?></h3>
          </div>
          <div class="modal-body model_view" align="center">&nbsp;
            <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
            <div class="model_title"><?php echo $row['r_name']; ?></div>
          </div>
          <div class="modal-body">
            <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
            <div class="row">
              <div class="col-xs-6"> <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['r_name']; ?><br/>
                <b><?php echo $_data['text_6'];?> :</b> <?php echo $row['r_email']; ?><br/>
                <b><?php echo $_data['text_7'];?> :</b> <?php echo $row['r_contact']; ?><br/>
                <b><?php echo $_data['text_8'];?> :</b> <?php echo $row['r_address']; ?><br/>
                <b><?php echo $_data['text_14'];?> :</b> <?php echo $row['r_nid']; ?><br/>
              </div>
              <div class="col-xs-6"> <b><?php echo $_data['text_9'];?> :</b> <?php echo $row['floor_no']; ?><br/>
                <b><?php echo $_data['text_10'];?> :</b> <?php echo $row['unit_no']; ?><br/>
                <b><?php echo $_data['text_11'];?> :</b> <?php echo $row['r_advance'].' '.CURRENCY; ?><br/>
                <b><?php echo $_data['text_12'];?> :</b> <?php echo $row['r_rent_pm'].' '.CURRENCY; ?><br/>
                <b><?php echo $_data['text_13'];?> :</b> <?php echo $row['r_date']; ?><br/>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
        <?php } mysqli_close($conn); ?>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
