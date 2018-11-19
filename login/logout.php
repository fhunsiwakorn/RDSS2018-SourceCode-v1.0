<?php
	require_once('../config/dbl_config.php');
	require_once('../login/session.php');
	require_once('../class/class_user.php');
	$user_logout = new USER();

	if($user_logout->is_loggedin()!="")
	{	
		if($_SESSION['user_status']=='1'){  ///ถ้าสำหรับเจ้าหน้าที่ ADMIN ใหญ๋
			$user_logout->redirect('../dashboard');
		}elseif($_SESSION['user_status']=='2'){ ////เจ้าหน้าที่ผู้ใช้งาน
			$user_logout->redirect('../index');  
		} 
		
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('../login/');
	}
