<?php

require_once("../config/dbl_config.php");
require_once('../class/class_user.php');
require_once("../login/session.php");
require_once("../login/select_data_profile.php");
require_once("../library/general_funtion.php");

if($_SESSION['user_status']!='1'){
  echo "<script>";
  echo "location.href = '../login/logout.php?logout=true'";
  echo "</script>";
}
  ///คิวรี่ข้อมูลทั่วไป
  require_once('../class/class_q_general.php');
  $qGeneral = new Q_gen();
  
  require_once('../class/class_query.php');
  $sql_process = new function_query();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$name_system?></title>
  <link rel="shortcut icon"   type="image/png"  href="../images/images_system/ID2.jpg" />
  <link rel="stylesheet" href="../fonts/thsarabunnew.css" />
  <link rel="stylesheet" href="../fonts/style_font.css" />
 <!-- Tell the browser to be responsive to screen width -->
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- Bootstrap 3.3.7 -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/css/bootstrap.min.css">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/font-awesome/css/font-awesome.min.css">
 <!-- Ionicons -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/Ionicons/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
 <!-- Select2 -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/select2/dist/css/select2.min.css">
 <!-- DataTables -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/dist/css/AdminLTE.min.css">
 <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
 <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
 

 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
 <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->
  <link rel="stylesheet" href="../plugins/checkboxes.css">
  <link rel="stylesheet" href="../plugins/image_circle.css">
  <script src="../plugins/sweetalert_master/sweetalert.min.js"></script>
  <link rel="stylesheet" tpe="text/css" href="../plugins/sweetalert_master/sweetalert.css">
  <script type="text/javascript" src="../plugins/ckeditor/ckeditor.js"></script>
  <!-- Autocomplete -->
  <script type="text/javascript" src="../plugins/autocomplete/autocomplete.js"></script>  
<link rel="stylesheet" href="../plugins/autocomplete/autocomplete.css"  type="text/css"/>  
<link href="../plugins/crop_img.css" rel="stylesheet">

<!-- ตัดคำ -->
<style type="text/css"> 
.cutword
{
white-space:nowrap; 
width:250px; 
overflow:hidden;
border:1px solid #0000;
text-overflow:ellipsis;
}
</style>
</head>
<body class="hold-transition skin-yellow-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="?option=main" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <img src='../images/images_system/idklever.jpg' style="width:150px; height:45px">
      <!-- <span class="logo-mini"  style="color:#fff;font-size: 24px;"><b><p class="thsarabunnew"><?=$name_system?></p></b></span> -->
      <!-- logo for regular state and mobile devices -->
      <!-- <span class="logo-lg"  style="color:#fff;font-size: 24px;"><b><p class="thsarabunnew"><?=$name_system?></p></b></span> -->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        &nbsp;
        <span class="username" style="font-size:18px;font-weight: bold"><?=$name_system?></span>
      </a>
  
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
									<?php require_once("../login/accout_profile.php"); ?>
					</li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  <script language="JavaScript" type="text/javascript">

				function sivamtime() {
				 now=new Date();
				 d=now.getDate();
				 m=now.getMonth() + 1;
				 y=now.getFullYear() + 543;
				 hour=now.getHours();
				 min=now.getMinutes();
				 sec=now.getSeconds();

				if (min<=9) { min="0"+min; }
				if (sec<=9) { sec="0"+sec; }
				if (hour<=9) { hour="0"+hour; }

				time = d + "/" + m + "/" + y + "  " + hour + ":" + min + ":" + sec ;

				if (document.getElementById) { theTime.innerHTML = time; }
				else if (document.layers) {
				document.layers.theTime.document.write(time);
				document.layers.theTime.document.close(); }

				setTimeout("sivamtime()", 1000);
				}
				window.onload = sivamtime;
				// -->
				</script>
        
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="../plugins/AdminLTE-2.4.0-rc/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
          <img src="<?=$pathuserimg?>"  class="circle" alt="User Image" style='height:50px;width:50px'>
				</div>
        <div class="pull-left info">
          <p><?=$profileRow['user_firstname']?> <?=$profileRow['user_lastname']?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> กำลังใช้งาน</a>
        </div>
        
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="ค้นหา..." >
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
    
       
	
		
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <center><span id="theTime"></span></center>
        <li class="header">เมนูการใช้งาน</li>
        <?php require_once("menu.php"); ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>  


 <?php require_once("../library/js.php"); ?>



  
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <!--GET PAGE  -->
  <?php require_once("get_page.php"); ?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b><?=$version?></b>
    </div>
    <strong>Copyright &copy; 2017 <a href="http://www.iddriver.com" target="_blank">ID Driver </a></strong> 

  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->




</body>
</html>
