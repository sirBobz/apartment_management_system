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

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_fund_status.php');
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
                  <th><?php echo $_data['text_2'];?></th>
                  <th><?php echo $_data['text_3'];?></th>
                  <th><?php echo $_data['text_4'];?></th>
                  <th><?php echo $_data['text_5'];?></th>
                  <th><?php echo $_data['text_6'];?></th>
                  <th><?php echo $_data['text_7'];?></th>
                  <th><?php echo $_data['text_8'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php
			$fund_sub_total = 0;
			$result = mysqli_query($conn, "Select *,ow.o_name,ow.image,m.month_name,y.xyear as y_xyear from tbl_add_fund fu inner join tbl_add_owner ow on ow.ownid = fu.owner_id inner join tbl_add_month_setup m on m.m_id = fu.month_id inner join tbl_add_year_setup y on y.y_id = fu.xyear where fu.branch_id = '" . (int)$_SESSION['objLogin']['branch_id'] . "' order by fu.fund_id desc");
			while($row = mysqli_fetch_array($result)){
				$fund_sub_total +=(float)$row['total_amount'];
				$image = WEB_URL . 'img/no_image.jpg';	
				if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
					$image = WEB_URL . 'img/upload/' . $row['image'];
				}
				?>
                <tr>
                  <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                  <td><?php echo $row['f_date']; ?></td>
                  <td><?php echo $row['o_name']; ?></td>
                  <td><?php echo $row['month_name']; ?></td>
                  <td><?php echo $row['y_xyear']; ?></td>
                  <?php if($currency_position == 'left') { ?>
                  <td><?php echo $global_currency.$row['total_amount']; ?></td>
                  <?php } else { ?>
                  <td><?php echo $row['total_amount'].$global_currency; ?></h3>
                  <?php } ?>
                  <td><?php echo $row['purpose']; ?></td>
                </tr>
                <?php } //mysql_close($link); ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th style="color:red;"><?php if($currency_position == 'left'){echo $global_currency.number_format($fund_sub_total, 2, '.', '');}else { echo number_format($fund_sub_total, 2, '.', '').$global_currency;} ?></th>
                  <th>&nbsp;</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div align="center" style="margin:50px;">
    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 style="text-decoration:underline;font-weight:bold;color:orange" class="box-title"><?php echo $_data['text_9'];?></h3>
          </div>
          <div class="box-body">
            <table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th><?php echo $_data['text_10'];?></th>
                  <th><?php echo $_data['text_3'];?></th>
                  <th><?php echo $_data['text_7'];?></th>
                  <th><?php echo $_data['text_11'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php
				$cost_sub_total = 0;
				$result_cost = mysqli_query($conn, "Select * from tbl_add_maintenance_cost order by mcid desc");
				while($row_cost = mysqli_fetch_array($result_cost)){
				$cost_sub_total +=(float)$row_cost['m_amount'];
				?>
              <td><?php echo $row_cost['m_title']; ?></td>
                <td><?php echo $row_cost['m_date']; ?></td>
                <?php if($currency_position == 'left') { ?>
                <td><?php echo $global_currency.$row_cost['m_amount']; ?></td>
                <?php } else { ?>
                <td><?php echo $row_cost['m_amount'].$global_currency; ?></h3>
                <?php } ?>
                <td><?php echo $row_cost['m_details']; ?></td>
              </tr>
              <?php } //mysql_close($link); ?>
              </tbody>
              
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th style="color:red;"><?php if($currency_position == 'left'){echo $global_currency.number_format($cost_sub_total, 2, '.', '');}else { echo number_format($cost_sub_total, 2, '.', '').$global_currency;} ?></th>
                  <th>&nbsp;</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <div align="center" style="margin:50px;">
    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 style="text-decoration:underline;font-weight:bold;color:orange" class="box-title"><?php echo $_data['text_12'];?></h3>
          </div>
          <div class="box-body">
            <table style="font-size:13px;text-align:center" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th style="color:red; font-size:18px; font-weight:bold;"><?php echo $_data['text_12'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php
           $remain_balance = $fund_sub_total - $cost_sub_total;?>
                <tr>
                  <td style="color:red; font-weight:bold; font-size:16px;">
				  <?php if($currency_position == 'left'){echo $global_currency.number_format($remain_balance, 2, '.', '');}else { echo number_format($remain_balance, 2, '.', '').$global_currency;} ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
<div align="center"><a class="btn btn-primary btn_save" onClick="javascript:printContent('printable','Visitors Report');" href="javascript:void(0);"><?php echo $_data['text_13'];?></a></div>
</body>
</html>
