<?php include('../header_owner.php')?>

<?php
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Owner </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>o_dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Owner</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"><a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>o_dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div>
    <div class="box box-info">
      <!-- /.box-header -->
      <div class="box-body">
        <?php
				$result = mysqli_query($conn, "Select * from tbl_add_owner where ownid = '" . (int)$_SESSION['objLogin']['ownid'] . "' order by ownid desc");
				if($row = mysqli_fetch_array($result)){
					
					$image = WEB_URL . 'img/no_image.jpg';	
		if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
			$image = WEB_URL . 'img/upload/' . $row['image'];
		}
					
					 ?>
          <div class="modal-content">
            <div class="modal-header orange_header">
              <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
              <h3 class="modal-title">Owner Details</h3>
            </div>
            <div class="modal-body model_view" align="center">&nbsp;
              <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
              <div class="model_title"><?php echo $row['o_name']; ?></div>
            </div>
            <div class="modal-body">
              <h3 style="text-decoration:underline;">Personal Infromation</h3>
              <div class="row">
                <div class="col-xs-12"> <b>Name :</b> <?php echo $row['o_name']; ?><br/>
                  <b>Email :</b> <?php echo $row['o_email']; ?><br/>
                  <b>Contact :</b> <?php echo $row['o_contact']; ?><br/>
				  <b>Present Address :</b> <?php echo $row['o_pre_address']; ?><br/>
                  <b>Permanent Address :</b> <?php echo $row['o_per_address']; ?><br/>
                </div>
                 <div class="col-xs-12"> <b>NID :</b> <?php echo $row['o_nid']; ?><br/>
                  <b>Room No:</b> <?php echo $row['nr_nurse_room']; ?><br/>
                  <b>Start Time:</b> <?php echo $row['duty_start_time']; ?>&nbsp;<?php echo $row['duty_start_am_pm']; ?><br/>
                  <b>End Time:</b> <?php echo $row['duty_end_time']; ?>&nbsp;<?php echo $row['duty_end_am_pm']; ?> </div>
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
