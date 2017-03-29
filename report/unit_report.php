<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_unit_report.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$status =  "";
$button_text = $_data['submit'];

if(isset($_GET['ddlUStatus'])){
	$status = $_GET['ddlUStatus'];
}
?>

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/unit_report.php"><?php echo $_data['text_2'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>report/report.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_3'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
		  <div class="form-group">
            <label for="ddlUStatus"><?php echo $_data['text_4'];?> :</label>
            <select name="ddlUStatus" id="ddlUStatus" class="form-control">
              <option value="">--<?php echo $_data['text_5'];?> --</option>
              <option value="0">Available</option>
              <option value="1">Booked</option>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="button" onclick="getUnitInfo()" value="<?php echo $button_text;?>" class="btn btn-success"/>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->

<script type="text/javascript">
	function getUnitInfo(){
		var status = $("#ddlUStatus").val();
		
		if(status != ''){
			window.open('<?php echo WEB_URL;?>report/unit_status_info.php?usid=' + status,'_blank');
		}
		else{
			alert('Please select at least one or more fields');
		}
	}
</script>

<?php include('../footer.php'); ?>
