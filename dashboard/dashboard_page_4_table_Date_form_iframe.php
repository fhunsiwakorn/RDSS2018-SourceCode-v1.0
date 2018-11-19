<?php
$table="tbl_exam_schedule";
$table2="tbl_exam_schedule_trainer";
require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");
require_once('../class/class_query.php');
$sql_process = new function_query();
 $crt_by=$_GET['crt_by'];
 $crt_date=date("Y-m-d H:i:s");
 
 if(isset($_GET['type_study_id']) && isset($_GET['esd_start_time']) && isset($_GET['esd_end_time']) &&
 isset($_GET['esd_date']) && isset($_GET['school_id']) && isset($_GET['school_id'])  && isset($_GET['btn-submit-add'])) {
    $type_study_id = strip_tags($_GET['type_study_id']); 
    $esd_start_time = strip_tags($_GET['esd_start_time']);
    $esd_end_time = strip_tags($_GET['esd_end_time']);
    $esd_time_total=TimeDiff("$esd_start_time","$esd_end_time"); //คำนวนหาระยะเวลาว่าตรงกันกับชั่วโมงรายวิชาที่กำหนดหรือไม่
    $vehicle_type_id = strip_tags($_GET['vehicle_type_id']);
    $countX=count($_GET['trainer_id']);
    $school_id = strip_tags($_GET['school_id']);

    $esd_date = $_GET['esd_date'];
    $arraySt_date = explode(",",$esd_date); 
    $count = count($arraySt_date);

    
    for($i=0;$i<$count;$i++){
      $esd_code = random_password(10);
        $esd_date_format = $arraySt_date[$i];//วันที่   
      $format_date=DatetoYMD($esd_date_format); 

      $total_data =$sql_process->rowsQuery("SELECT tbl_exam_schedule.esd_id FROM tbl_exam_schedule 
      WHERE
     ( tbl_exam_schedule.type_study_id ='$type_study_id' AND
      tbl_exam_schedule.vehicle_type_id = '$vehicle_type_id' AND  
      tbl_exam_schedule.school_id = '$school_id' AND
      tbl_exam_schedule.esd_date ='$format_date' AND
      tbl_exam_schedule.esd_start_time BETWEEN '$esd_start_time' AND '$esd_end_time') OR
      ( tbl_exam_schedule.type_study_id ='$type_study_id' AND
      tbl_exam_schedule.vehicle_type_id = '$vehicle_type_id' AND  
      tbl_exam_schedule.school_id = '$school_id' AND
      tbl_exam_schedule.esd_date ='$format_date' AND
      tbl_exam_schedule.esd_end_time BETWEEN '$esd_start_time' AND '$esd_end_time') "); 

      if($total_data<=0){
      // $sql_process->add_exam_schedule($type_study_id,$esd_start_time,$esd_end_time,$esd_time_total,$format_date,$esd_code,$vehicle_type_id,$school_id,$crt_by,$crt_date);
   
      $fields = [
        'type_study_id' => $type_study_id,
        'esd_start_time' => $esd_start_time,
        'esd_end_time' => $esd_end_time,
        'esd_time_total' => $esd_time_total,
        'esd_date' => $format_date,
        'vehicle_type_id' => $vehicle_type_id,
        'esd_code' => $esd_code,
        'school_id' => $school_id,
        'crt_by' => $crt_by,
        'crt_date' => $crt_date
    ];
    try {
    
        /*
         * Have used the word 'object' as I could not see the actual 
         * class name.
         */
        $sql_process->insert($table, $fields);
      
      }catch(ErrorException $exception) {
      
         $exception->getMessage();  // Should be handled with a proper error message.
      
      }
      for($x=0;$x<$countX;$x++){
        //   เพิ่มครู
        $trainer_id=$_GET['trainer_id'][$x];
        // $sql_process->add_exam_schedule_trainer($trainer_id,$type_study_id,$vehicle_type_id,$esd_code,$school_id);
        
      
        $fields2 = [
          'trainer_id' => $trainer_id,
          'type_study_id' => $type_study_id,
          'vehicle_type_id' => $vehicle_type_id,
          'esd_code' => $esd_code,
          'school_id' => $school_id
      ];
      try {
      
          /*
           * Have used the word 'object' as I could not see the actual 
           * class name.
           */
          $sql_process->insert($table2, $fields2);
        
        }catch(ErrorException $exception) {
        
           $exception->getMessage();  // Should be handled with a proper error message.
        
        }


        }
      }

    }

// echo $esd_date."ssss";
    echo "<script>";
    echo "location.href = 'dashboard_page_4_table_Date_form_iframe.php?crt_by=$crt_by&success'";
    echo "</script>";
 }  


 
$type_study_id = isset($_GET['type_study_id']) ? $_GET['type_study_id'] : NULL; 
$esd_start_time = isset($_GET['esd_start_time']) ? $_GET['esd_start_time'] : NULL; 
$esd_end_time = isset($_GET['esd_end_time']) ? $_GET['esd_end_time'] : NULL; 
$esd_date = isset($_GET['esd_date']) ? $_GET['esd_date'] : NULL; 
$vehicle_type_id = isset($_GET['school_id']) ? $_GET['vehicle_type_id'] : NULL; 
$school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$name_system?></title>
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
  <script src="../plugins/sweetalert_master/sweetalert.min.js"></script>
  <link rel="stylesheet" tpe="text/css" href="../plugins/sweetalert_master/sweetalert.css">

</head>

<body>
<form  method="get" name="form_add"id="form_add">
<input type="hidden" class="form-control" name="crt_by" id="crt_by" value="<?=$crt_by?>">
<?php 
 if(isset($_GET['success'])){  ?>
<div class="alert alert-success alert-dismissible">
                <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                <h4><i class="icon fa fa-check"></i> บันทึกข้อมูลตารางสอบใบอนุญาตขับขี่เรียบร้อย !</h4>
                กรุณากดปุ่มกากบาทด้านขวาบนสุด เพื่อปิดหน้าต่างนี้...
               
              </div>
 <?php  } ?>
<div class="row">
<div class="col-xs-12">
                  <label>วันที่</label> <label style="color:red;">*</label>
                  <input type="text" name="esd_date"  value="<?=$esd_date?>"  class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepickerX" required readonly placeholder="คลิ๊กเพื่อแสดงปฏิทิน">
                  <!-- <input type="text" class="form-control" name="income_text" id="income_text" required placeholder="กรอกรายได้"> -->
                </div>    
                <div class="col-xs-12">
                <label>ปรเภทการเรียน</label> <label style="color:red;">*</label>
                   <select class="form-control" name="type_study_id"  >
                   <?php
                 $qa = $sql_process->runQuery(
                 "SELECT
                 tbl_master_type_study.type_study_id,
                 tbl_master_type_study.type_study_name
                 FROM
                 tbl_master_type_study
                 WHERE
                 tbl_master_type_study.type_study_status='1' AND
                 tbl_master_type_study.is_delete='1'
                 ORDER BY
                 tbl_master_type_study.type_study_id  ASC");
                 $qa->execute();
                 while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowA->type_study_id'>$rowA->type_study_name</option>";
                 echo"<option value='$rowA->type_study_id'";
                 if ($type_study_id == $rowA->type_study_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowA->type_study_name</option>\n";
                 }
                 ?>           
                    </select>
                </div>

                   <div class="col-xs-6">
                  <label for="exampleInputEmail1">เวลาเริ่ม</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="esd_start_time" id="esd_start_time" value="<?=$esd_start_time?>" required placeholder="เวลาเริ่ม">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">เวลาสิ้นสุด</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="esd_end_time" id="esd_end_time"  value="<?=$esd_end_time?>"  required placeholder="เวลาสิ้นสุด">
                </div>  

                 <div class="col-xs-6">
                   <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type_id" id="vehicle_type_id" >
                   <?php
                 $qa2= $sql_process->runQuery(
                 "SELECT
                 tbl_master_vehicle_type.vehicle_type_id,
                 tbl_master_vehicle_type.vehicle_type_name
                 FROM
                 tbl_master_vehicle_type
                 WHERE
                 tbl_master_vehicle_type.vehicle_type_status='1' AND
                 tbl_master_vehicle_type.is_delete='1'
                 ORDER BY
                 tbl_master_vehicle_type.vehicle_type_id  ASC");
                 $qa2->execute();
                 while($rowB= $qa2->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
                 echo"<option value='$rowB->vehicle_type_id'";
                 if ($vehicle_type_id == $rowB->vehicle_type_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowB->vehicle_type_name</option>\n";
                 }
                 ?>           
                    </select>
                </div> 
                <div class="col-xs-6">

                   <label>โรงเรียน</label> <label style="color:red;">*</label>
                   <select class="form-control select2" style="width: 100%;" name="school_id"   onchange="submit();">
                  <option>--เลือกโรงเรียน--</option>
                   <?php
                 $qa3 = $sql_process->runQuery(
                 "SELECT
                 tbl_school.school_id,
                 tbl_school.school_name
                 FROM
                 tbl_school 
                 WHERE
                 tbl_school.is_delete='1'          
                 ORDER BY
                 tbl_school.school_id  ASC");
                 $qa3->execute();
                 while($rowC= $qa3->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowC->school_id'";
                 if ($school_id == $rowC->school_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowC->school_name</option>\n";
                 
                 }
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-12">

                   <label>ผู้ดำเนินการ </label>
                   <select   <select class="form-control select2" multiple="multiple" name="trainer_id[]" style="width: 100%;">>
                  <?php

$stm= $sql_process->runQuery(
    "SELECT
     tbl_trainer_data.trainer_id,
     tbl_trainer_data.trainer_firstname_th,
     tbl_trainer_data.trainer_lastname_th
     FROM
     tbl_trainer_data 
     WHERE 
     tbl_trainer_data.is_delete='1'  AND
     tbl_trainer_data.trainer_status='1'  AND
     school_id='$school_id' 
     ORDER BY
     trainer_id");
    $stm->execute();
    while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
      echo "<option value='$rs->trainer_id'>$rs->trainer_firstname_th $rs->trainer_lastname_th </option>";   
 
    }
    ?>

                 </select>
                 </div>  
                 <div class="col-xs-12">
                 </br>
                 </hr>
                 <button type="sumbit" name="btn-submit-add" class="btn btn-primary btn-block">บันทึกข้อมูล</button>
                </div>  
                </div>  
                </form>

                <!-- jQuery 3 -->
                <?php require_once("js.php"); ?>
</body>
</html>
