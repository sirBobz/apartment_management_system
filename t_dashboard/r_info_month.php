<?php
ob_start();
session_start();
include("../config.php");
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
$lang_code_global = "English";
$query_ams_settings = mysqli_query($conn, "SELECT * FROM tbl_settings");
if($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){
	$lang_code_global = $row_query_ams_core['lang_code'];
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_r_all_info.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Apartment Management System</title>
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
                  <th><?php echo $_data['text_2'];?></th>
                  <th><?php echo $_data['text_3'];?></th>
                  <th><?php echo $_data['text_4'];?></th>
                  <th><?php echo $_data['text_5'];?></th>
                  <th><?php echo $_data['text_6'];?></th>
                  <th><?php echo $_data['text_7'];?></th>
                  <th><?php echo $_data['text_8'];?></th>
                  <th><?php echo $_data['text_9'];?></th>
                  <th><?php echo $_data['text_10'];?></th>
                  <th><?php echo $_data['text_11'];?></th>
                  <th><?php echo $_data['text_12'];?></th>
                  <th><?php echo $_data['text_13'];?></th>
                  <th><?php echo $_data['text_14'];?></th>
                  <th><?php echo $_data['text_15'];?></th>
                </tr>
              </thead>
              <tbody>
            <?php
				$rent_per_month_sub_total = 0;
				$gas_per_month_sub_total = 0;
				$electric_per_month_sub_total = 0;
				$water_per_month_sub_total = 0;
				$security_per_month_sub_total = 0;
				$utility_per_month_sub_total = 0;
				$other_per_month_sub_total = 0;
				$total_per_month_sub_total = 0;
			$result = mysqli_query($conn, "select *,r.r_name,o.o_name,fl.floor_no,u.unit_no,m.month_name,r.r_unit_no from tbl_add_fair f left join tbl_add_rent r on r.rid = f.rid left join tbl_add_owner o on o.ownid = f.rid inner join tbl_add_floor fl on fl.fid = f.floor_no inner join tbl_add_unit u on u.uid = f.unit_no inner join tbl_add_month_setup m on m.m_id = f.month_id where r.rid = '". (int)$_SESSION['objLogin']['rid'] . "' and f.month_id='".$_GET['mid']."'");
				while($row = mysqli_fetch_array($result)){
				$rent_per_month_sub_total +=(float)$row['rent'];
				$gas_per_month_sub_total +=(float)$row['gas_bill'];
				$electric_per_month_sub_total +=(float)$row['electric_bill'];
				$water_per_month_sub_total +=(float)$row['water_bill'];
				$security_per_month_sub_total +=(float)$row['security_bill'];
				$utility_per_month_sub_total +=(float)$row['utility_bill'];
				$other_per_month_sub_total +=(float)$row['other_bill'];
				$total_per_month_sub_total +=(float)$row['total_rent'];
				?>
                <tr>
                  <td><?php echo $row['issue_date']; ?></td>
                  <td><?php if($row['type']=='Rented'){echo $row['r_name'];} else{echo $row['o_name'];} ?></td>
                  <td><?php echo $row['type']; ?></td>
                  <td><?php echo $row['floor_no']; ?></td>
                  <td><?php echo $row['unit_no']; ?></td>
                  <td><?php echo $row['month_name']; ?></td>
                  <td><?php echo $row['rent'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['gas_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['electric_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['water_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['security_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['utility_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['other_bill'].' '.CURRENCY; ?></td>
                  <td><?php echo $row['total_rent'].' '.CURRENCY; ?></td>
                </tr>
                <?php } mysqli_close($conn); ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th style="color:red;"><?php echo number_format($rent_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($gas_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($electric_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($water_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($security_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($utility_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($other_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                  <th style="color:red;"><?php echo number_format($total_per_month_sub_total, 2, '.', '') . ' ' . CURRENCY; ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
<div align="center"><a class="btn btn-primary btn_save" onClick="javascript:printContent('printable','Fair Collection Report');" href="javascript:void(0);"><?php echo $_data['text_16'];?></a></div>
</body>
</html>
