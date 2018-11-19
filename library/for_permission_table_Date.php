<link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/css/bootstrap.min.css">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/font-awesome/css/font-awesome.min.css">
 <!-- Ionicons -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/Ionicons/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
 <!-- Select2 -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/select2/dist/css/select2.min.css">
 <!-- DataTables -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/dist/css/AdminLTE.min.css">
 <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
 <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/dist/css/skins/_all-skins.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../template/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<?php
    header("content-type: text/html; charset=utf-8");
    header ("Expires: Wed, 21 Aug 2013 13:13:13 GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");

    require_once ("../config/dbl_config.php");
    require_once ('../class/class_q_general.php');
    $qGeneral = new Q_gen();

    $data = $_GET['data'];
    $val = $_GET['val'];
    // $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
    if ($data=='school_id_x') {
              echo "<select name='school_id' onChange=\"dochange('trainer_id', this.value)\" class=\"form-control\" >";
              echo "<option value=''>- เลือกโรงเรียน -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_school
                  WHERE is_delete='1' AND
                  school_id!='0' 
                  ORDER BY
                  school_id  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='$rs->school_id'>$rs->school_name</option>"; 
                 
                    // echo"<option value='$rs->school_id'";
                    // if ($school_id == $rs->school_id)
                    // {
                    //   echo "SELECTED";
                    // }
                    // echo ">$rs->school_name</option>\n";
                
              }
         }elseif ($data=='trainer_id') {
echo "<select name='trainer_id'  class=\"form-control select2\" multiple=\"multiple\" required>";
echo "<option value=''>- เลือกครู / วิทยากร -</option>\n";

               $stm= $qGeneral->runQuery(
                "SELECT
                 tbl_trainer_data.trainer_id,
                 tbl_trainer_data.trainer_firstname_th,
                 tbl_trainer_data.trainer_lastname_th
                 FROM
                 tbl_trainer_data 
                 WHERE 
                 tbl_trainer_data.is_delete='1'  AND
                 tbl_trainer_data.trainer_status='1'  AND
                 school_id='$val' 
                 ORDER BY
                 trainer_id");
                $stm->execute();
                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                  echo "<option value='$rs->trainer_id'>$rs->trainer_firstname_th $rs->trainer_lastname_th </option>";   
             
                }
              }
    
         echo "</select>\n";

?>

<?php require_once("js.php"); ?>