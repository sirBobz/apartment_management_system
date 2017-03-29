<?php
include("config.php");
// if(!isset($_SESSION['objLogin'])){
// 	header("Location: " . WEB_URL . "logout.php");
// 	die();
// }
$msg = 'none';
$sql = '';
$xMsg = "No information Found";
if(isset($_POST['username']) && $_POST['username'] != ''){
	$password = '';
	if($_POST['ddlLoginType'] == '1'){
		//here for admin
		$sql= mysqli_query($conn, "SELECT * FROM tbl_add_admin WHERE email = '".make_safe($_POST['username'])."'");
		$password = 'password';
	}
	else if($_POST['ddlLoginType'] == '2'){
		//here for teacher
		$sql= mysqli_query($conn,"SELECT * FROM tbl_add_owner WHERE o_email = '".make_safe($_POST['username'])."'");
		$password = 'o_password';
	}
	else if($_POST['ddlLoginType'] == '3'){
		//here for student
		$sql= mysqli_query($conn,"SELECT * FROM tbl_add_employee WHERE e_email = '".make_safe($_POST['username'])."'");
		$password = 'e_password';
	}
	else if($_POST['ddlLoginType'] == '4'){
		//here for parent
		$sql= mysqli_query($conn,"SELECT * FROM tbl_add_rent WHERE r_email = '".make_safe($_POST['username'])."'");
		$password = 'r_password';
	}
	if($row = mysqli_fetch_array($sql)){
		//here success
		$xMsg = 'Check your Email Address for login details';
		$msg = 'block';
		//now send and email to user
		$result_s_arr = mysqli_query($conn,"Select * from tbl_add_admin");
		if($row_arr = mysqli_fetch_array($result_s_arr)){
			$to = trim($_POST['username']);
			$subject = $row_arr['email'] . ' User Login Details';
			$headers = "From: " . strip_tags($row_arr['email']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($row_arr['email']) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = '<html><body>';
			$message .= '<center><h2>User Login Information</h2></center>';
			$message .= '<center><div>Username: '.$_POST['username'].'</div></center>';
			$message .= '<center><div>Password: '.$row[$password].'</div></center>';
			$message .= '<center><div> <a href="index.php">Login</a> </div></center>';
			$message .= '</body></html>';
			echo $message;
			die();
			mail($to, $subject, $message, $headers);
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
	$dbname = "Test";
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
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<!-- <link href="assets/css/custom.css" rel="stylesheet" />
 --><!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
  <br/><br/><br/><br/>
  <div class="row text-center ">
    <div class="col-md-4 col-md-offset-4"><br/>
      <div class="panel panel-success">
      <div class="panel-heading">Apartment Management System</div>
      </div>
  </div>
  <br/>
  <div class="row ">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
      <div style="margin-bottom:8px;padding-top:2px;width:100%;height:25px;background:#E52740;color:#fff; display:<?php echo $msg; ?>" align="center"><?php echo $xMsg; ?></div>
      <div class="panel panel-default" id="loginBox">
        <div class="panel-heading"> <strong> Forget Your Password </strong> </div>
        <div class="panel-body">
          <form onSubmit="return validationForm();" role="form" id="form" method="post">
            <br />
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Your Email Address " />
            </div>
            <div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
              <select name="ddlLoginType" id="ddlLoginType" class="form-control">
                <option value="-1">-- Select --</option>
                <option value="1">Admin</option>
                <option value="2">Owner</option>
                <option value="3">Employee</option>
                <option value="4">Renter</option>
              </select>
            </div>
            <div class="form-group">
              <button style="width:100%;" type="submit" id="login" class="btn btn-primary">Submit</button>
            </div>
            <div class="form-group"> <a style="width:100%;" type="submit" id="login" class="btn btn-success" href="<?php echo WEB_URL;?>index.php">Back To Login</a> </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function validationForm(){
	if($("#username").val() == ''){
		alert("Valid Email Required !!!");
		$("#username").focus();
		return false;
	}
	else if($("#ddlLoginType").val() == '-1'){
		alert("Select Login Type !!!");
		return false;
	}
	else{
		return true;
	}
}
</script>
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
