<?php
ob_start();
session_start();
define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__))) . '/');
if(!file_exists("config.php")){
	header("Location: install/index.php");
	die();
}
include(DIR_APPLICATION."config.php");
$msg = 'none';
$sql = '';
if(isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
	if($_POST['ddlLoginType'] == '1'){
		$sql= ("SELECT *,b.branch_name FROM tbl_add_admin aa left join tblbranch b on b.branch_id = aa.branch_id WHERE aa.email = '".make_safe($_POST['username'])."' and aa.password = '".make_safe($_POST['password'])."'");
		$sql = mysqli_query($conn,$sql);
	}
	if($_POST['ddlLoginType'] == '2'){
		$sql= ("SELECT *,b.branch_name FROM tbl_add_owner o left join tblbranch b on b.branch_id = o.branch_id WHERE o.o_email = '".make_safe($_POST['username'])."' and o.o_password = '".make_safe($_POST['password'])."'");
		$sql = mysqli_query($conn,$sql);
	}
	if($_POST['ddlLoginType'] == '3'){
		$sql= ("SELECT *,b.branch_name FROM tbl_add_employee e left join tblbranch b on b.branch_id = e.branch_id WHERE e.e_email = '".make_safe($_POST['username'])."' and e.e_password = '".make_safe($_POST['password'])."'");
		$sql = mysqli_query($conn,$sql);
	}
	if($_POST['ddlLoginType'] == '4'){
		$sql= ("SELECT *,b.branch_name FROM tbl_add_rent ad left join tblbranch b on b.branch_id = ad.branch_id WHERE ad.r_email = '".make_safe($_POST['username'])."' and ad.r_password = '".make_safe($_POST['password'])."'");
		$sql = mysqli_query($conn,$sql);
	}
	if($_POST['ddlLoginType'] == '5'){
		$sql= ("SELECT *,(select branch_name from tblbranch where branch_id = $_POST[ddlBranch]) as branch_name FROM tblsuper_admin WHERE email = '".make_safe($_POST['username'])."' and password = '".make_safe($_POST['password'])."'");
		$sql = mysqli_query($conn,$sql);
	}
	if($row = mysqli_fetch_array($sql)){
		//here success
		if($_POST['ddlLoginType'] == '5'){
			$arr = array(
				'user_id'		=> $row['user_id'],
				'name'			=> $row['name'],
				'email'			=> $row['email'],
				'password'		=> $row['password'],
				'branch_id'		=> $_POST['ddlBranch'],
				'branch_name'	=> $row['branch_name'],
				'added_date'	=> $row['added_date']
			);
			$_SESSION['objLogin'] = $arr;
		}
		else{
			$_SESSION['objLogin'] = $row;
		}
		
		$_SESSION['login_type'] = $_POST['ddlLoginType'];
		
		if($_POST['ddlLoginType'] == '1' || $_POST['ddlLoginType'] == '5'){
			header("Location: dashboard.php");
			die();
		}
		else if($_POST['ddlLoginType'] == '2'){
			header("Location: o_dashboard.php");
			die();
		}
		else if($_POST['ddlLoginType'] == '3'){
			header("Location: e_dashboard.php");
			die();
		}
		else if($_POST['ddlLoginType'] == '4'){
			header("Location: t_dashboard.php");
			die();
		}
	}
	else{
		$msg = 'block';
	}
	
}
function make_safe($variable) 
{   $servername = "127.0.0.1";
	$username = "root";
	$password = "ub435!";
	$dbname = "ams_Db";
	   // Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	   // Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
   $variable = strip_tags(( trim($variable)));
   $variable = mysqli_real_escape_string($conn, $variable);
   return $variable; 
   $conn->close;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Demo</title>
<!-- BOOTSTRAP STYLES-->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<!-- <link href="assets/css/custom.css" rel="stylesheet" /> -->
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />


</head>
<body>
<div class="container"> <br/>
  <br/>
  <br/>
  <div class="row text-center">
    <div class="col-md-4 col-md-offset-4"><br/>
      <div class="panel panel-success">
      <div class="panel-heading">Apartment Management System</div>
      </div>
  </div>
  <br/>
  <div class="row ">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
      <div style="margin-bottom:8px;padding-top:2px;width:100%;height:25px;background:#E52740;color:#fff; display:<?php echo $msg; ?>" class="alert alert-danger" align="center">Access Denied!</div>

                          
      <div class="panel panel-success" style="background: #d0d3d4" id="loginBox">
        <div class="panel-heading"> <strong> Enter Login Details </strong> </div>
        <div class="panel-body">
          <form onSubmit="return validationForm();" role="form" id="form" method="post">
            <br />
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-envelope"  ></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Your Email" />
            </div>
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
              <input type="password" name="password" id="password" class="form-control"  placeholder="Your Password" />
            </div>
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
              <select name="ddlLoginType" onChange="mewhat(this.value);" id="ddlLoginType" class="form-control">
                <option value="">--Select User Type--</option>
                <option value="1">Admin</option>
                <option value="2">Owner</option>
                <option value="3">Employee</option>
                <option value="4">Renter</option>
                <option value="5">Super Admin</option>
              </select>
            </div>
             <div id="x_branch" style="display:none;" class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-plus"  ></i></span>
              <select class="form-control" name="ddlBranch" id="ddlBranch">
              <option value="">--Select Branch--</option>
              <?php 
				  	$sql = ("SELECT * FROM tblbranch order by branch_name ASC");
				  	$result_branch = mysqli_query($conn,$sql);
					while($row_branch = mysqli_fetch_array($result_branch)){?>
              <option value="<?php echo $row_branch['branch_id'];?>"><?php echo $row_branch['branch_name'];?></option>
              <?php } ?>
            </select>
            </div>
            <div class="form-group">
              <label class="checkbox-inline"> </label>
              <span class="pull-right"> <a href="<?php echo WEB_URL;?>forgetpassword.php" >Forget password ? </a> </span> </div>
            <hr />
            <div align="center">
              <button style="width:100%;" type="submit" id="login" class="btn btn-primary"><i class="fa fa-user"  ></i>&nbsp;Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
function validationForm(){
	if($("#username").val() == ''){
		alert("Email Required !!!");
		$("#username").focus();
		return false;
	}
	else if(!validateEmail($("#username").val())){
		alert("Valid Email Required !!!");
		$("#username").focus();
		return false;
	}
	else if($("#password").val() == ''){
		alert("Password Required !!!");
		$("#password").focus();
		return false;
	}
	else if($("#ddlLoginType").val() == ''){
		alert("Select User Type !!!");
		return false;
	}
	else{
		return true;
	}
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function mewhat(val){
	if(val != ''){
		if(val == '5'){
			$("#x_branch").show();
		}
		else{
			$("#x_branch").hide();
		}
	}
	else{
		$("#x_branch").hide();
	}
}
</script>
</body>
</html>
