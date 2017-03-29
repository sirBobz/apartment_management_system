<?php
	session_start();
	include("../config.php");
	if(isset($_SESSION['objLogin'])){
		if(isset($_POST['token']) && $_POST['token'] == 'getunitinfo'){
			$html = '<option value="">--Select Unit--</option>';
			if(isset($_POST['floor_no']) && (int)$_POST['floor_no'] > 0){
				$unit_no = '';
				$result = mysqli_query($conn, "SELECT * from tbl_add_unit where floor_no = '" . (int)$_POST['floor_no'] . "' and status = 0 order by unit_no asc");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['uid'].'">'.$rows['unit_no'] . '</option>';
				}
				echo $html;
				die();
			}
			echo '';
			die();
		}
		else if(isset($_POST['token']) && $_POST['token'] == 'getbookedunit'){
			$html = '<option value="">--Select Unit--</option>';
			if(isset($_POST['floor_no']) && (int)$_POST['floor_no'] > 0){
				$unit_no = '';
				$result = mysqli_query($conn,"SELECT * from tbl_add_unit where floor_no = '" . (int)$_POST['floor_no'] . "' and status = 1 order by unit_no asc");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['uid'].'">'.$rows['unit_no'] . '</option>';
				}
				echo $html;
				die();
			}
			echo '';
			die();
		}
		else if(isset($_POST['token']) && $_POST['token'] == 'getunitinforeport'){
			$html = '<option value="">--Select Unit--</option>';
			if(isset($_POST['floor_no']) && (int)$_POST['floor_no'] > 0){
				$unit_no = '';
				$result = mysqli_query($conn,"SELECT * from tbl_add_unit where floor_no = '" . (int)$_POST['floor_no'] . "' order by unit_no asc");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['uid'].'">'.$rows['unit_no'] . '</option>';
				}
				echo $html;
				die();
			}
			echo '';
			die();
		}
		else if(isset($_POST['token']) && $_POST['token'] == 'getRentInfo'){
			$html = array(
				'rid'	=> '0',
				'name'	=> '',
				'fair'	=> '0.00'
			);
			if(isset($_POST['floor_id']) && (int)$_POST['floor_id'] > 0 && isset($_POST['unit_id']) && (int)$_POST['unit_id'] > 0){
				$result = mysqli_query($conn,"SELECT * from tbl_add_rent where r_floor_no = '" . (int)$_POST['floor_id'] . "' and r_unit_no = '" . (int)$_POST['unit_id'] . "' and r_status = 1");
				if($rows = mysqli_fetch_array($result)){
					$html = array(
						'rid'	=> $rows['rid'],
						'name'	=> $rows['r_name'],
						'fair'	=> $rows['r_rent_pm']
					);
				}
			}
			echo json_encode($html);
			die();
		}
		else if(isset($_POST['token']) && $_POST['token'] == 'getOwnerInfo'){
			$html = array(
				'ownid'	=> '0',
				'name'	=> ''
			);
			if(isset($_POST['unit_id']) && (int)$_POST['unit_id'] > 0){
				$result = mysqli_query($conn,"SELECT * from tbl_add_owner_unit_relation ur inner join tbl_add_owner ao on ao.ownid = ur.owner_id where ur.unit_id  = '" . (int)$_POST['unit_id'] . "'");
				if($rows = mysqli_fetch_array($result)){
					$html = array(
						'ownid'	=> $rows['owner_id'],
						'name'	=> $rows['o_name']
					);
				}
			}
			echo json_encode($html);
			die();
		}
		else if(isset($_POST['token']) && $_POST['token'] == 'getDesgInfo'){
			$html = '';
			if(isset($_POST['emp_id']) && (int)$_POST['emp_id'] > 0){
				$result_emp = mysqli_query($conn,"SELECT *,mt.member_type from tbl_add_employee e inner join tbl_add_member_type mt on mt.member_id = e.e_designation where eid = '" . (int)$_POST['emp_id'] . "'");
				if($row_emp = mysqli_fetch_array($result_emp)){
					$html = $row_emp['member_type'];
				}
			}
			echo $html;
			die();
		}				
	}
	else{
		echo '-99';
		die();
	}
?>
