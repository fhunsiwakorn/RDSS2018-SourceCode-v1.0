<?php
session_start();
require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");
require_once('../class/class_user.php');
$login = new USER();

if($login->is_loggedin()!="")
{
  // $login->redirect('../dashboard');
  if($_SESSION['user_status']=='1'){  ///ถ้าสำหรับเจ้าหน้าที่ ADMIN ใหญ๋
    $login->redirect('../dashboard');
  }elseif($_SESSION['user_status']=='2' || $_SESSION['user_status']=='3'){ ////เจ้าหน้าที่ผู้ใช้งาน
    $login->redirect('../index');  
  } 
}

if(isset($_POST['btn-submit']))
{

  $verify_get_code=sha1(md5(md5($_POST['get_input'])));
  $get_token=strip_tags(trim($_POST['get_token']));
  if($verify_get_code==$get_token){
  $username = strip_tags(trim($_POST['loginname']));
  $user_email = strip_tags(trim($_POST['loginname']));
  $usermail = strip_tags(trim($_POST['loginname']));
	$password = strip_tags(trim($_POST['loginpass']));

	if($login->doLogin($username,$user_email,$password))
	{
		if($_SESSION['user_status']=='1'){   ///ถ้าสำหรับเจ้าหน้าที่ ADMIN ใหญ๋
			$login->redirect('../dashboard');
		}elseif ($_SESSION['user_status']=='2' || $_SESSION['user_status']=='3') {  ///เจ้าหน้าที่ผู้ใช้งาน
			$login->redirect('../index');
		}

	}
	else
	{
		$alert_login_con="ท่านกรอกข้อมูลไม่ถูกต้อง";
  }
}

}
$get_code = random_password(15);
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$name_system?></title>
<script src="../plugins/SlidingLoginForm/login.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/SlidingLoginForm/login.css">
<script src="../plugins/sweetalert_master/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/sweetalert_master/sweetalert.css">
<link rel="stylesheet" href="../fonts/thsarabunnew.css" />
  <link rel="stylesheet" href="../fonts/style_font.css" />
</head>
<body>
<div id="error">
<?php  if(isset($alert_login_con))
    {
      ?>
      <script>
       swal("<?=$alert_login_con?>", "ปิดหน้าต่างนี้!", "error");
      </script>
  <?php } ?>
 </div>
<div id="back">
  <div class="backRight"></div>
  <div class="backLeft"></div>
</div>

<div id="slideBox">
  <div class="topLayer">
  
    <div class="right">
      <div class="content">
        <h2>เข้าสู่ระบบ</h2>
        <form method="post">
  <input type="hidden" name="get_input" value="<?=$get_code?>"  /> 
  <input type="hidden" name="get_token" value="<?php echo sha1(md5(md5($get_code))); ?>"  />   
<!-- <script language="JavaScript">
document.onkeydown = chkEvent 
function chkEvent(e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode; //*** for IE ***//
	else if (e) keycode = e.which; //*** for Firefox ***//
	if(keycode==13)
	{
		return false;
	}
}
</script> -->
          <div class="form-group">
            <!-- <label for="username"  class="form-label">Username</label> -->
            <input type="text" name="loginname" id="loginname"  style="font-size: 18px;" placeholder="User Name หรือ E-mail"  required autocomplete="off"/>
          </div>
          <div class="form-group">
            <!-- <label for="username" class="form-label">Password</label> -->
            <input type="password" name="loginpass" id="loginname" style="font-size: 18px;"  placeholder="Password" required autocomplete="off" />
          </div>
          <button   name="btn-submit" id="login" type="submit">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Inspiration from: http://ertekinn.com/loginsignup/-->


</body>
</html>
