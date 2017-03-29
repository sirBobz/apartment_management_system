<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_employee_salary_setup.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}

	$emp_name ='';
	$designation = '';
	$month_id ='';
	$amount ='0.00';
	$issue_date = '';
	$branch_id = '';
	$button_text = $_data['save_button_text'];
	$form_url = WEB_URL . "setting/employee_salary_setup.php";

	$hval = 0;
	
	$station_logo = WEB_URL . 'img/no_image.jpg';
	$img_track = '';

if(isset($_POST['ddlEmpName'])){
		if($_POST['hdnSpid'] == '0'){
		$year = date('Y');
	$sql="INSERT INTO `tbl_add_employee_salary_setup`(`emp_name`,`designation`,`month_id`,`xyear`,`amount`,`issue_date`,`branch_id`) VALUES ('$_POST[ddlEmpName]','$_POST[hdnDesg]','$_POST[ddlEmpMonth]',$year,'$_POST[txtEmpAmount]','$_POST[txtEmpIssueDate]','" . $_SESSION['objLogin']['branch_id'] . "')";	
			mysqli_query($sql, $conn);
			mysqli_close($conn);
		    $url = WEB_URL . 'setting/employee_salary_setup.php?m=add';
		    header("Location: $url");
		}
else{
	
	$sql_update="UPDATE `tbl_add_employee_salary_setup` set emp_name = '$_POST[ddlEmpName]',`designation`='".$_POST['hdnDesg']."',`month_id`='".$_POST['ddlEmpMonth']."',`amount`='".$_POST['txtEmpAmount']."',`issue_date`='".$_POST['txtEmpIssueDate']."' where emp_id= '" . (int)$_POST['hdnSpid'] . "'";	
			mysql_query($sql_update, $conn);
			mysql_close($conn);
		    $url = WEB_URL . 'setting/employee_salary_setup.php?m=up';
		    header("Location: $url");
			/*echo "<script>alert('Update Successfully');</script>";*/
		}

$success = "block";
}

if(isset($_GET['spid']) && $_GET['spid'] != ''){
		$result_location = mysqli_query($conn, "SELECT * FROM tbl_add_employee_salary_setup where emp_id= '" . (int)$_GET['spid'] . "' and branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "'");
		if($row = mysqli_fetch_array($result_location)){
		 	$emp_name = $row['emp_name'];
			$designation = $row['designation'];
			$month_id = $row['month_id'];
			$amount = $row['amount'];
			$issue_date = $row['issue_date'];
			$button_text = $_data['update_button_text'];
			$form_url = WEB_URL . "setting/employee_salary_setup.php?id=".$_GET['spid'];
			$hval = $row['emp_id'];
		}
			
	}
	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['text_1'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>setting/setting.php"><?php echo $_data['setting'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/setting.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_2'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
        <div class="form-group">
            <label for="ddlEmpName"><?php echo $_data['text_3'];?> :</label>
            <select onchange="getDesgInfo(this.value)" name="ddlEmpName" id="ddlEmpName" class="form-control">
              <option value="">--<?php echo $_data['text_4'];?>--</option>
              <?php 
				  	$result_emp = mysql_query("SELECT * FROM tbl_add_employee order by eid ASC",$link);
					while($row_emp = mysql_fetch_array($result_emp)){?>
              <option <?php if($emp_name == $row_emp['eid']){echo 'selected';}?> value="<?php echo $row_emp['eid'];?>"><?php echo $row_emp['e_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtEmpDesignation"><?php echo $_data['text_5'];?> :</label>
            <input readonly="readonly" type="text" name="txtEmpDesignation" value="<?php echo $designation;?>" id="txtEmpDesignation" class="form-control" />
              <input type="hidden" id="hdnDesg" name="hdnDesg" value="<?php echo $designation;?>" />
          </div>
          <div class="form-group">
            <label for="ddlEmpMonth"><?php echo $_data['text_6'];?> :</label>
            <select name="ddlEmpMonth" id="ddlEmpMonth" class="form-control">
              <option value="">--<?php echo $_data['text_6'];?>--</option>
              <?php 
			  $result_month = mysqli_query($conn, "SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtEmpAmount"><?php echo $_data['text_7'];?> :</label>
            <div class="input-group">
            <input type="text" name="txtEmpAmount" value="<?php echo $amount;?>" id="txtEmpAmount" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtEmpIssueDate"><?php echo $_data['text_8'];?> :</label>
            <input type="text" name="txtEmpIssueDate" value="<?php echo $issue_date;?>" id="txtEmpIssueDate" class="form-control datepicker" />
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $button_text; ?>"/>
			&nbsp;
            <input type="reset" onClick="javascript:window.location.href='<?php echo WEB_URL; ?>setting/employee_salary_setup.php';" name="btnReset" id="btnReset" value="<?php echo $_data['reset'];?>" class="btn btn-primary"/>
          </div>
        </div>
        <input type="hidden" name="hdnSpid" value="<?php echo $hval; ?>"/>
      </form>
      <h4 style="text-align:center; color:red;"><?php echo $_data['reset_text'];?></h4>
      <!-- /.box-body -->
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
 if(isset($_GET['delid']) && $_GET['delid'] != '' && $_GET['delid'] > 0){
		$sqlx= "DELETE FROM `tbl_add_employee_salary_setup` WHERE emp_id = ".$_GET['delid'];
		mysql_query($sqlx,$link); 
		$delinfo = 'block';
	}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['text_9'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['text_10'];
}
?>      
      <!-- Main content -->
      <section class="content">
      <!-- Full Width boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?> !</h4>
            <?php echo $_data['text_11'];?> </div>
          <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
            <?php echo $msg; ?> </div>
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><?php echo $_data['text_12'];?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th><?php echo $_data['text_3'];?></th>
					<th><?php echo $_data['text_5'];?></th>
                    <th><?php echo $_data['text_6'];?></th>
                    <th><?php echo $_data['text_7'];?></th>
                    <th><?php echo $_data['text_8'];?></th>
                    <th><?php echo $_data['action_text'];?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$result = mysqli_query($conn, "SELECT *,e.e_name,m.month_name FROM tbl_add_employee_salary_setup es inner join tbl_add_employee e on es.emp_name = e.eid inner join tbl_add_month_setup m on m.m_id = es.month_id where es.branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . " order by es.emp_id ASC ");
				while($row = mysqli_fetch_array($result)){?>
                  <tr>
					<td><?php echo $row['e_name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['month_name']; ?></td>
                    <?php if($currency_position == 'left') { ?>
                    <td><?php echo $global_currency.$row['amount']; ?></td>
                    <?php } else { ?>
                    <td><?php echo $row['amount'].$global_currency; ?></h3>
                    <?php } ?>
                    <td><?php echo $row['issue_date']; ?></td>
                    <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#employee_view_<?php echo $row['emp_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>setting/employee_salary_setup.php?spid=<?php echo $row['emp_id']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onclick="deleteEmployeeSalary(<?php echo $row['emp_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                      <div id="employee_view_<?php echo $row['emp_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header orange_header">
                              <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                              <h3 class="modal-title"><?php echo $_data['text_12'];?></h3>
                            </div>
                            <div class="modal-body model_view" align="center">&nbsp;
                              <div><!--<img class="photo_img_round" style="width:100px;height:100px;" src="<?php //echo $station_logo;  ?>" />--></div>
                              <div class="model_title"><?php echo $row['e_name']; ?></div>
                            </div>
                            <div class="modal-body">
                              <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                              <div class="row">
                                <div class="col-xs-12"> <b><?php echo $_data['text_13'];?> :</b> <?php echo $row['e_name']; ?><br/>
                                <b><?php echo $_data['text_14'];?> :</b> <?php echo $row['e_email']; ?><br/>
                                <b><?php echo $_data['text_15'];?> :</b> <?php echo $row['e_contact']; ?><br/>
                                <b><?php echo $_data['text_5'];?> :</b> <?php echo $row['designation']; ?><br/>
                                <b><?php echo $_data['text_6'];?> :</b> <?php echo $row['month_name']; ?><br/>
                                <b><?php echo $_data['text_7'];?> :</b> <?php if($currency_position == 'left') {echo $global_currency.$row['amount'];}else { echo $row['amount'].$global_currency;}?><br/>
                                <b><?php echo $_data['text_8'];?> :</b> <?php echo $row['issue_date']; ?><br/>
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
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
  function deleteEmployeeSalary(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Employee Salary ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL;?>setting/employee_salary_setup.php?delid=' + Id;
	}
  }
  </script>

<?php include('../footer.php'); ?>
