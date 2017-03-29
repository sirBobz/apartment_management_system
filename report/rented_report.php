<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_report.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$r_status =  "";
$button_text=$_data['submit'];

if(isset($_GET['ddlRStatus'])){
	$r_status = $_GET['ddlRStatus'];
}
?>

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['text_1'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/rented_report.php"><?php echo $_data['text_2'];?></a></li>
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
            <label for="ddlRStatus"><?php echo $_data['text_4'];?> :</label>
            <select name="ddlRStatus" id="ddlRStatus" class="form-control">
              <option value="">--<?php echo $_data['text_5'];?> --</option>
              <option value="0">Expired</option>
              <option value="1">Active</option>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="button" onclick="getRentedInfo()" value="<?php echo $button_text;?>" class="btn btn-success"/>
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
	function getRentedInfo(){
		var r_status = $("#ddlRStatus").val();
		
		if(r_status != ''){
			window.open('<?php echo WEB_URL;?>report/rented_info.php?rsid=' + r_status,'_blank');
		}
		else{
			alert('Please select at least one or more fields');
		}
	}
</script>

<?php include('../footer.php'); ?>
