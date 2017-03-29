<?php
include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$floor_id =  "";
$unit_id = "";
$month_id = "";
$button_text="Submit";

if(isset($_GET['fid'])){
	$floor_id = $_GET['fid'];
}
if(isset($_GET['uid'])){
	$unit_id = $_GET['uid'];
}
if(isset($_GET['mid'])){
	$month_id = $_GET['mid'];
}
?>

<section class="content-header">
  <h1>Owner Collection Report </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="<?php echo WEB_URL?>report/owner_report.php">Report</a></li>
    <li class="active">Owner Collection Report</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>report/report.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title">Owner Collection Report Form</h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
		  <div class="form-group">
            <label for="ddlFloorNo">Select Floor :</label>
            <select onchange="getUnit(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
              <option value="">--Select Floor--</option>
              <?php 
			  $result_floor = mysqli_query($conn, "SELECT * FROM tbl_add_floor order by fid ASC");
					while($row_floor = mysqli_fetch_array($result_floor)){?>
              <option <?php if($floor_id == $row_floor['fid']){echo 'selected';}?> value="<?php echo $row_floor['fid'];?>"><?php echo $row_floor['floor_no'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlUnitNo">Select Unit :</label>
            <select name="ddlUnitNo" id="ddlUnitNo" class="form-control">
              <option value="">--Select Unit--</option>
              <?php 
			  $result_unit = mysqli_query($conn, "SELECT * FROM tbl_add_unit order by uid ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($unit_id == $row_unit['uid']){echo 'selected';}?> value="<?php echo $row_unit['uid'];?>"><?php echo $row_unit['unit_no'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlMonth">Select Month :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--Select Month--</option>
              <?php 
			  $result_month = mysqli_query($conn, "SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group pull-right">
            <input type="button" onclick="getFairInfo()" value="<?php echo $button_text;?>" class="btn btn-success"/>
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
	function getFairInfo(){
		var floor_id = $("#ddlFloorNo").val();
		var unit_id = $("#ddlUnitNo").val();
		var month_id = $("#ddlMonth").val();
		
		if(floor_id != '' && unit_id != '' && month_id != ''){
			//window.location = "<?php //echo WEB_URL;?>report/mark_info.php?cid=" + class_id + '&eid=' + exam_id + '&sbid=' + subject_id;
			window.open('<?php echo WEB_URL;?>report/owner_info_all.php?fid=' + floor_id + '&uid=' + unit_id + '&mid=' + month_id,'_blank');
		}
		else if(floor_id != '' && unit_id != ''){
			window.open('<?php echo WEB_URL;?>report/owner_info_floor_unit.php?fid=' + floor_id + '&uid=' + unit_id,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(floor_id != ''){
			window.open('<?php echo WEB_URL;?>report/owner_info_floor.php?fid=' + floor_id,'_blank');
			//alert('Please select all 3 fields');
		}
		else if(month_id != ''){
			window.open('<?php echo WEB_URL;?>report/owner_info_month.php?mid=' + month_id,'_blank');
			//alert('Please select all 3 fields');
		}
		
		else{
			alert('Please select at least one or more fields');
		}
	}
</script>

<?php include('../footer.php'); ?>
