<?php
ob_start();
session_start();
include("../config.php");
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
$lang_code_global = "English";
$global_currency = "$";
$currency_position = "left";
$currency_sep = ".";

$query_ams_settings = mysqli_query($conn, "SELECT * FROM tbl_settings");
while($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){
	$lang_code_global = $row_query_ams_core['lang_code'];
	$global_currency = $row_query_ams_core['currency'];
	$currency_position = $row_query_ams_core['currency_position'];
	$currency_sep = $row_query_ams_core['currency_seperator'];
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_renter_info.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Apartment Management System</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.4 -->
<link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome Icons -->
<link href="<?php echo WEB_URL; ?>dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo WEB_URL; ?>dist/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo WEB_URL; ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins 
 folder instead of downloading all of them to reduce the load. -->
<link href="<?php echo WEB_URL; ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck for checkboxes and radio inputs -->
<link href="<?php echo WEB_URL; ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- jQuery 2.1.4 -->
<script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo WEB_URL; ?>dist/js/printThis.js"></script>
<script src="<?php echo WEB_URL; ?>dist/js/common.js"></script>
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section class="content">
<!-- Main content -->
<div id="printable">
  <div align="center" style="margin:50px;">
    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 style="text-decoration:underline;font-weight:bold;color:orange" class="box-title"><?php echo $_data['text_1'];?></h3>
          </div>
          <div class="box-body">
            <table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
               <tr>
              <th>Image</th>
              <th><?php echo $_data['text_5'];?></th>
              <th><?php echo $_data['text_6'];?></th>
              <th><?php echo $_data['text_7'];?></th>
              <th><?php echo $_data['text_8'];?></th>
              <th><?php echo $_data['text_14'];?></th>
              <th><?php echo $_data['text_9'];?></th>
              <th><?php echo $_data['text_10'];?></th>
              <th><?php echo $_data['text_11'];?></th>
              <th><?php echo $_data['text_12'];?></th>
              <th><?php echo $_data['text_13'];?></th>
              <th><?php echo $_data['text_15'];?></th>
            </tr>
              </thead>
              <tbody>
            <?php
			$result = mysqli_query($conn, "Select *,f.floor_no as ffloor,u.unit_no from tbl_add_rent r inner join tbl_add_floor f on f.fid = r.r_floor_no inner join tbl_add_unit u on u.uid = r.r_unit_no where r.r_status='".$_GET['rsid']."' and r.branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "'");
				while($row = mysqli_fetch_array($result)){
				$image = WEB_URL . 'img/no_image.jpg';	
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['image'];
					}
				?>
                <tr>
                    <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                    <td><?php echo $row['r_name']; ?></td>
                    <td><?php echo $row['r_email']; ?></td>
                    <td><?php echo $row['r_contact']; ?></td>
                    <td><?php echo $row['r_address']; ?></td>
                    <td><?php echo $row['r_nid']; ?></td>
                    <td><?php echo $row['ffloor']; ?></td>
                    <td><?php echo $row['unit_no']; ?></td>
                    <?php if($currency_position == 'left') { ?>
                    <td><?php echo $global_currency.$row['r_advance']; ?></td>
                    <?php } else { ?>
                    <td><?php echo $row['r_advance'].$global_currency; ?></h3>
                    <?php } ?>
                    <?php if($currency_position == 'left') { ?>
                    <td><?php echo $global_currency.$row['r_rent_pm']; ?></td>
                    <?php } else { ?>
                    <td><?php echo $row['r_rent_pm'].$global_currency; ?></h3>
                    <?php } ?>
                    <td><?php echo $row['r_date']; ?></td>
                    <td><?php if($row['r_status'] == '1'){echo $_data['text_17'];} else{echo $_data['text_18'];}?></td>
                </tr>
                <?php } mysqli_close($conn); ?>
              </tbody>
              <!--<tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
              </tfoot>-->
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
<div align="center"><a class="btn btn-primary btn_save" onClick="javascript:printContent('printable','Visitors Report');" href="javascript:void(0);"><?php echo $_data['text_16'];?></a></div>
</body>
</html>
