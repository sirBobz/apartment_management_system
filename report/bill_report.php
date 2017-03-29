<?php
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_bill_report.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$bill_date =  "";
$month_id = "";
$xyear = "";
$button_text = $_data['submit'];

if(isset($_GET['bill_date'])){
	$bill_date = $_GET['bill_date'];
}
if(isset($_GET['mid'])){
	$month_id = $_GET['mid'];
}
if(isset($_GET['xyear'])){
	$xyear = $_GET['xyear'];
}
?>

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/report.php"><?php echo $_data['text_2'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/bill_report.php"><?php echo $_data['text_1'];?></a></li>
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
            <label for="ddlVDate"><?php echo $_data['text_4'];?> :</label>
            <select name="ddlVDate" id="ddlVDate" class="form-control">
              <option value="">--<?php echo $_data['text_4'];?>--</option>
              <?php 
			  $result_floor = mysqli_query($conn, "SELECT * FROM tbl_add_bill order by bill_id ASC");
					while($row_floor = mysqli_fetch_array($result_floor)){?>
              <option <?php if($bill_date == $row_floor['bill_date']){echo 'selected';}?> value="<?php echo $row_floor['bill_date'];?>"><?php echo $row_floor['bill_date'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlMonth"><?php echo $_data['text_5'];?> :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--<?php echo $_data['text_5'];?>--</option>
              <?php 
				  	$result_month = mysqli_query($conn, "SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlYear"><?php echo $_data['text_6'];?> :</label>
            <select name="ddlYear" id="ddlYear" class="form-control">
              <option value="">--<?php echo $_data['text_6'];?>--</option>
              <?php 
				  	$result_month = mysqli_query($conn, "SELECT * FROM tbl_add_year_setup order by y_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($xyear == $row_month['y_id']){echo 'selected';}?> value="<?php echo $row_month['y_id'];?>"><?php echo $row_month['xyear'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="button" onclick="getVisitorsInfo()" value="<?php echo $button_text;?>" class="btn btn-success"/>
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
	function getVisitorsInfo(){
		var bill_date = $("#ddlVDate").val();
		var month_id = $("#ddlMonth").val();
		var xyear = $("#ddlYear").val();
		
		if(bill_date != '' && month_id != '' && xyear != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info.php?vid=' + bill_date + '&mid=' + month_id + '&yid=' + xyear,'_blank');
		}
		else if(bill_date != '' && month_id != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_date_month.php?vid=' + bill_date + '&mid=' + month_id,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(month_id != '' && xyear != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_month_year.php?mid=' + month_id + '&yid=' + xyear,'_blank');
		}
		else if(bill_date != '' && xyear != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_date_year.php?vid=' + bill_date + '&yid=' + xyear,'_blank');
		}
		else if(bill_date != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_date.php?vid=' + bill_date,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(month_id != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_month.php?mid=' + month_id,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(xyear != ''){
			window.open('<?php echo WEB_URL;?>report/bill_info_year.php?yid=' + xyear,'_blank');
			//alert('Please select all 3 fields');
		}
		else{
			alert('Please select at least one or more fields');
		}
	}
</script>

<?php include('../footer.php'); ?>
