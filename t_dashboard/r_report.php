<?php include('../header_ten.php'); ?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_r_report.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$month_id = "";
$xyear = '';
$button_text=$_data['submit'];

if(isset($_GET['mid'])){
	$month_id = $_GET['mid'];
}
if(isset($_GET['xyear'])){
	$yid = $_GET['xyear'];
}
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
?>

<section class="content-header">
  <h1><?php echo $_data['text_1'];?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>t_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>t_dashboard.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_2'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php  ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="ddlMonth"><?php echo $_data['text_3'];?> :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--<?php echo $_data['text_3'];?>--</option>
              <?php 
			  $result_month = mysqli_query($conn,"SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
           <div class="form-group">
            <label for="ddlYear"><?php echo $_data['text_4'];?> :</label>
            <select name="ddlYear" id="ddlYear" class="form-control">
              <option value="">--<?php echo $_data['text_4'];?>--</option>
              <?php 
				  	$result_month = mysqli_query($conn,"SELECT * FROM tbl_add_year_setup order by y_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($xyear == $row_month['xyear']){echo 'selected';}?> value="<?php echo $row_month['xyear'];?>"><?php echo $row_month['xyear'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="button" onClick="getFairInfo()" value="<?php echo $button_text;?>" class="btn btn-success"/>
          </div>
        </div>
        <input type="hidden" value="<?php ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->

<script type="text/javascript">
	function getFairInfo(){
		var month_id = $("#ddlMonth").val();
		var xyear = $("#ddlYear").val();
		
		if(month_id != '' && xyear != ''){
			window.open('<?php echo WEB_URL;?>t_dashboard/r_all_info.php?mid=' + month_id + '&yid=' + xyear,'_blank');
		}
		else if(month_id != ''){
			window.open('<?php echo WEB_URL;?>t_dashboard/r_info_month.php?mid=' + month_id,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(xyear != ''){
			window.open('<?php echo WEB_URL;?>t_dashboard/r_info_year.php?yid=' + xyear,'_blank');
			//alert('Please select all 3 fields');
		}		
		else{
			alert('Please select at least one or more fields');
		}
	}
</script>

<?php include('../footer.php'); ?>
