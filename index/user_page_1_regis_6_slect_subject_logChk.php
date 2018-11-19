<?php
require_once('../class/class_register.php');
$regis_tmp_list = new register_process();
if(isset($_POST['type_one'])) {

   // $st_date=$_POST['st_date'];
//    $st_id = strip_tags($_POST['st_id']);
   $num_code = random_password(15);
   $crt_by=$_SESSION['userSession']; 
   $crt_date=date("Y-m-d H:i:s"); 
      // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
   $page_step='7';
   $rst_temp_code = strip_tags($_POST['rst_temp_code']);
   $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$page_step'   WHERE rst_temp_code='$rst_temp_code'");
   $type_study_id=1; ///ทฤษฏี
      ///ลบข้อมูลเก่าทิ้งและเพิ่มใหม่
      $sql_process->fastQuery("DELETE FROM tbl_register_temp_class_schedule  WHERE rst_temp_code='$rst_temp_code' AND type_study_id='1'");

   $count=count($_POST['st_id']);

   for($i=0;$i<$count;$i++){
    $st_id = $_POST['st_id'][$i];
$stmtSu = $sql_process->runQuery("SELECT 
  tbl_subject_theory.st_id,
  tbl_subject_theory.subject_data_id,
  tbl_subject_theory.vehicle_type_id,
  tbl_subject_theory.st_hour,
  tbl_subject_theory.st_start_time,
  tbl_subject_theory.st_end_time,
  tbl_subject_theory.st_date,
  tbl_subject_theory.trainer_id
   FROM tbl_subject_theory 
   WHERE tbl_subject_theory.st_id=:st_id_param AND tbl_subject_theory.school_id = :school_id_param");
$stmtSu->execute(array(":st_id_param"=>$st_id,":school_id_param"=>$school_id));
$dataRowSub=$stmtSu->fetch(PDO::FETCH_ASSOC);
$subject_data_id=$dataRowSub['subject_data_id'];
$vehicle_type_id=$dataRowSub['vehicle_type_id'];
$trainer_id=$dataRowSub['trainer_id'];
$st_date=$dataRowSub['st_date'];
$st_start_time=$dataRowSub['st_start_time'];
$st_end_time=$dataRowSub['st_end_time'];
$rmcs_start_date="$st_date $st_start_time";
$rmcs_date_end="$st_date $st_end_time";
$st_hour=$dataRowSub['st_hour'];
$regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$st_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
   }
   echo "<script>";
   echo "location.href = '?option=main'";
   echo "</script>";
  //  echo "<script>";
  //  echo "location.href = '?option=regis-step-6&sccode=$rst_temp_code'";
  //  echo "</script>";

}





if(isset($_POST['type_two'])) {
    // $st_date=$_POST['st_date'];
    $st_date = strip_tags($_POST['st_date']);
    $num_code = random_password(15);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
       // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
    $page_step='7';
    $rst_temp_code = strip_tags($_POST['rst_temp_code']);
    $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$page_step'   WHERE rst_temp_code='$rst_temp_code'");
    $type_study_id=1; ///ทฤษฏี
      ///ลบข้อมูลเก่าทิ้งและเพิ่มใหม่
  $sql_process->fastQuery("DELETE FROM tbl_register_temp_class_schedule  WHERE rst_temp_code='$rst_temp_code' AND type_study_id='1'");
  
    $qaZ = $sql_process->runQuery(
      "SELECT 
  tbl_subject_theory.st_id,
  tbl_subject_theory.subject_data_id,
  tbl_subject_theory.vehicle_type_id,
  tbl_subject_theory.st_hour,
  tbl_subject_theory.st_start_time,
  tbl_subject_theory.st_end_time,
  tbl_subject_theory.st_date,
  tbl_subject_theory.trainer_id
      FROM
      tbl_subject_theory
      WHERE
      tbl_subject_theory.school_id = :school_id_param AND
      tbl_subject_theory.st_date=:st_date_param
      ORDER BY
      tbl_subject_theory.st_id ASC
      ");
      // $qa7->execute();
      $qaZ->execute(array(":school_id_param"=>$school_id,":st_date_param"=>$st_date));
      while($rowZ= $qaZ->fetch(PDO::FETCH_OBJ)) {
        $subject_data_id=$rowZ->subject_data_id;
        $vehicle_type_id=$rowZ->vehicle_type_id;
        $trainer_id=$rowZ->trainer_id;
        $rmcs_start_date="$rowZ->st_date $rowZ->st_start_time";
        $rmcs_date_end="$rowZ->st_date $rowZ->st_end_time";
        $rmcs_hour=$rowZ->st_hour;
        $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
      }
     echo "<script>";
     echo "location.href = '?option=main'";
     echo "</script>";
    //  echo "<script>";
    //  echo "location.href = '?option=regis-step-6&sccode=$rst_temp_code'";
    //  echo "</script>";
    }

 