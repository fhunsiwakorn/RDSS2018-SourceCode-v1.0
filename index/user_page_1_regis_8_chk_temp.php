<?php

// $get_code = random_password(10);
// $timex=time();
require_once('../class/class_register.php');
$regis_tmp_list = new register_process();
$crt_by=$_SESSION['userSession']; 
$upd_by=$_SESSION['userSession']; 
$crt_date=date("Y-m-d H:i:s"); 
$student_code = random_password(20);
// ตรวจสอบว่าเพิ่มข้อมูลนักเรียนหรือยัง
// $total_data =$sql_process->rowsQuery("SELECT tbl_student_data.student_id FROM tbl_student_data WHERE tbl_student_data.rst_temp_code ='$rst_temp_code_get'");
$stmta = $sql_process->runQuery("SELECT student_id FROM tbl_student_data WHERE register_code=:rst_temp_code_param");
$stmta->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
$dataRowa=$stmta->fetch(PDO::FETCH_ASSOC);
$total_data=$stmta->rowCount();
///คำสั่งคิวรี่ข้อมูลนักเรียนในตาราง temp เพื่อบันทึกข้อมูลในตารางหลักของนักเรียน
$stmtb = $sql_process->runQuery("SELECT * FROM tbl_register_temp_student WHERE rst_temp_code=:rst_temp_code_param");
$stmtb->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
$dataRowb=$stmtb->fetch(PDO::FETCH_ASSOC);
$table="tbl_student_data";
if($total_data<=0){
  
    // $student_list->add_student($dataRowb['student_type_register'],$dataRowb['student_img'],$dataRowb['student_finger_print'],$dataRowb['title_name_th'],$dataRowb['student_firstname_th'],$dataRowb['student_lastname_th'],
    // $dataRowb['title_name_eng'],$dataRowb['student_firstnam_eng'],$dataRowb['student_lastname_eng'],$dataRowb['student_ID_card'],$dataRowb['student_Passport'],$dataRowb['nationality_id'],$dataRowb['country_id'],$dataRowb['student_birthday'],$dataRowb['student_age'],
    // $dataRowb['student_email'],$dataRowb['student_line'],$dataRowb['student_phone'],$dataRowb['student_disability'],$dataRowb['student_address'],$dataRowb['province_id'],$dataRowb['amphur_id'],$dataRowb['district_id'],$dataRowb['zipcode_id'],$dataRowb['student_congenital_disease'],
    // $dataRowb['career_id'],$dataRowb['income_id'],$dataRowb['reason_id'],$dataRowb['memer_contact'],$dataRowb['memer_contact_phone'],$school_id,$crt_by,$crt_date,$rst_temp_code_get);

    $fields = [
      'student_type_register' => $dataRowb['student_type_register'],
      'student_img' => $dataRowb['student_img'],
      'student_finger_print' => $dataRowb['student_finger_print'],
      'title_name_th' =>$dataRowb['title_name_th'],
      'student_firstname_th' => $dataRowb['student_firstname_th'],
      'student_lastname_th' => $dataRowb['student_lastname_th'],
      'title_name_eng' => $dataRowb['title_name_eng'],
      'student_firstnam_eng' => $dataRowb['student_firstnam_eng'],
      'student_lastname_eng' => $dataRowb['student_lastname_eng'],
      'student_ID_card' =>$dataRowb['student_ID_card'],
      'student_Passport' => $dataRowb['student_Passport'],
      'nationality_id' => $dataRowb['nationality_id'],
      'country_id' => $dataRowb['country_id'],
      'student_birthday' => $dataRowb['student_birthday'],
      'student_age' => $dataRowb['student_age'],
      'student_email' =>$dataRowb['student_email'],
      'student_line' => $dataRowb['student_line'],
      'student_phone' => $dataRowb['student_phone'],
      'student_disability' =>$dataRowb['student_disability'],
      'student_address' => $dataRowb['student_address'],
      'province_id' =>$dataRowb['province_id'],
      'amphur_id' => $dataRowb['amphur_id'],
      'district_id' => $dataRowb['district_id'],
      'zipcode_id' =>$dataRowb['zipcode_id'],
      'student_congenital_disease' => $dataRowb['student_congenital_disease'],
      'career_id' => $dataRowb['career_id'],
      'income_id' =>$dataRowb['income_id'],
      'reason_id' => $dataRowb['reason_id'],
      'memer_contact' =>$dataRowb['memer_contact'],
      'memer_contact_phone' => $dataRowb['memer_contact_phone'],
      'school_id' => $school_id,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date,
      'register_code' => $rst_temp_code_get,
      'student_code' => $student_code
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

  }else{

    // $student_list->edit_student($dataRowa['student_id'],$dataRowb['student_type_register'],$dataRowb['student_img'],$dataRowb['student_finger_print'],$dataRowb['title_name_th'],$dataRowb['student_firstname_th'],$dataRowb['student_lastname_th'],
    // $dataRowb['title_name_eng'],$dataRowb['student_firstnam_eng'],$dataRowb['student_lastname_eng'],$dataRowb['student_ID_card'],$dataRowb['student_Passport'],$dataRowb['nationality_id'],$dataRowb['country_id'],$dataRowb['student_birthday'],$dataRowb['student_age'],
    // $dataRowb['student_email'],$dataRowb['student_line'],$dataRowb['student_phone'],$dataRowb['student_disability'],$dataRowb['student_address'],$dataRowb['province_id'],$dataRowb['amphur_id'],$dataRowb['district_id'],$dataRowb['zipcode_id'],$dataRowb['student_congenital_disease'],
    // $dataRowb['career_id'],$dataRowb['income_id'],$dataRowb['reason_id'],$dataRowb['memer_contact'],$dataRowb['memer_contact_phone'],$school_id,$crt_by);

    $fields = [
      'student_type_register' => $dataRowb['student_type_register'],
      'student_img' => $dataRowb['student_img'],
      'student_finger_print' => $dataRowb['student_finger_print'],
      'title_name_th' =>$dataRowb['title_name_th'],
      'student_firstname_th' => $dataRowb['student_firstname_th'],
      'student_lastname_th' => $dataRowb['student_lastname_th'],
      'title_name_eng' => $dataRowb['title_name_eng'],
      'student_firstnam_eng' => $dataRowb['student_firstnam_eng'],
      'student_lastname_eng' => $dataRowb['student_lastname_eng'],
      'student_ID_card' =>$dataRowb['student_ID_card'],
      'student_Passport' => $dataRowb['student_Passport'],
      'nationality_id' => $dataRowb['nationality_id'],
      'country_id' => $dataRowb['country_id'],
      'student_birthday' => $dataRowb['student_birthday'],
      'student_age' => $dataRowb['student_age'],
      'student_email' =>$dataRowb['student_email'],
      'student_line' => $dataRowb['student_line'],
      'student_phone' => $dataRowb['student_phone'],
      'student_disability' =>$dataRowb['student_disability'],
      'student_address' => $dataRowb['student_address'],
      'province_id' =>$dataRowb['province_id'],
      'amphur_id' => $dataRowb['amphur_id'],
      'district_id' => $dataRowb['district_id'],
      'zipcode_id' =>$dataRowb['zipcode_id'],
      'student_congenital_disease' => $dataRowb['student_congenital_disease'],
      'career_id' => $dataRowb['career_id'],
      'income_id' =>$dataRowb['income_id'],
      'reason_id' => $dataRowb['reason_id'],
      'memer_contact' =>$dataRowb['memer_contact'],
      'memer_contact_phone' => $dataRowb['memer_contact_phone'],
      'school_id' => $school_id,
      'upd_by' => $upd_by
  ];
  $Where=['register_code' => $rst_temp_code_get];
  try {
  
      /*
       * Have used the word 'object' as I could not see the actual 
       * class name.
       */
      $sql_process->update($table, $fields,$Where);
    
    }catch(ErrorException $exception) {
    
       $exception->getMessage();  // Should be handled with a proper error message.
    
    }

}


   // $school_id และ branch_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
   //ตรวจสอบว่าการสมัครครั้งนี้มีการบันทึกข้อมูลลงแล้วหรือไม่
$total_chk_regis =$sql_process->rowsQuery("SELECT tbl_register_main.register_code FROM tbl_register_main WHERE tbl_register_main.register_code ='$rst_temp_code_get'");
if(isset($_GET['Chktemp']) && $total_chk_regis <=0) {
    $yearx=date("Y");
    $monthx=date("m");
    $dayx=date("d");
    $fulldate=date("Y-m-d");
    $stmtu = $sql_process->runQuery("SELECT Max(rm_number) AS rm_number FROM tbl_register_main WHERE 
    YEAR(crt_date) ='$yearx' AND
    MONTH(crt_date) ='$monthx' AND
    DAY(crt_date) ='$dayx' AND
    school_id=:school_id_param");
    $stmtu->execute(array(":school_id_param"=>$school_id));
    $dataRowu=$stmtu->fetch(PDO::FETCH_ASSOC);
    $total_data_regis=$stmtu->rowCount();
    if($total_data_regis>=1 && !empty($dataRowu['rm_number']) ){
      $exRegis= explode("-",$dataRowu['rm_number']);
      $setRegis=$exRegis[3]+1;
      $setRegisx=sprintf("%04d",$setRegis);
      $rm_number="$fulldate-$setRegisx";
    }else{
      $rm_number="$fulldate-0001";
    }
    // echo "<center>".$rm_number."</center>";


    $student_id=$dataRowa['student_id'];
    $course_data_id=$dataRow["course_data_id"]; 
    $vehicle_type_id=$dataRow["vehicle_type_id"]; 
    $vegicle_data_id=$dataRow["vegicle_data_id"]; 
    $rm_date=date("Y-m-d");
    $rm_pay_status="RS";
    $rm_source="WI";
    $rm_status="NR";
    $testing_result="NP";
    $complete_date="0000-00-00";
    $transportation_id=$dataRow['transportation_id'];
    $regis_tmp_list->register_main($rm_number,$student_id,$course_data_id,$rm_date,$rm_pay_status,$rm_source,$rm_status,$testing_result,$complete_date,$school_id,$branch_id,$vegicle_data_id,$transportation_id,$crt_by,$crt_date,$rst_temp_code_get); 
    
// บันทึกตารางเรียนภาคปฏิบัติและภาคทฤษฎี

$quary_1 = $sql_process->runQuery(
  "SELECT
  tbl_register_temp_class_schedule.rmcs_id,
  tbl_register_temp_class_schedule.subject_data_id,
  tbl_register_temp_class_schedule.vehicle_type_id,
  tbl_register_temp_class_schedule.type_study_id,
  tbl_register_temp_class_schedule.trainer_id,
  tbl_register_temp_class_schedule.rmcs_start_date,
  tbl_register_temp_class_schedule.rmcs_date_end,
  tbl_register_temp_class_schedule.rmcs_hour,
  tbl_register_temp_class_schedule.school_id,
  tbl_register_temp_class_schedule.crt_by,
  tbl_register_temp_class_schedule.crt_date,
  tbl_register_temp_class_schedule.upd_by,
  tbl_register_temp_class_schedule.upd_date,
  tbl_register_temp_class_schedule.num_code,
  tbl_register_temp_class_schedule.rst_temp_code
  FROM
  tbl_register_temp_class_schedule
  WHERE
  tbl_register_temp_class_schedule.rst_temp_code =:rst_temp_code_param
  ORDER BY
  tbl_register_temp_class_schedule.rmcs_id ASC
  ");
  $quary_1->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
  while($rowGen_1= $quary_1->fetch(PDO::FETCH_OBJ)) {
    $regis_tmp_list->register_main_class_schedule($rowGen_1->subject_data_id,$rowGen_1->vehicle_type_id,$rowGen_1->type_study_id,$rowGen_1->trainer_id,$rowGen_1->rmcs_start_date,$rowGen_1->rmcs_date_end,$rowGen_1->rmcs_hour,$rowGen_1->school_id,$rowGen_1->crt_by,$rowGen_1->crt_date,$rowGen_1->num_code,$rowGen_1->rst_temp_code);
  
  }
   ///บันทึกตารางสอบ
   $quary_2 = $sql_process->runQuery(
    "SELECT
tbl_register_temp_exam_schedule.rtes_id,
tbl_register_temp_exam_schedule.esd_id,
tbl_register_temp_exam_schedule.type_study_id,
tbl_register_temp_exam_schedule.school_id,
tbl_register_temp_exam_schedule.rst_temp_code
FROM
tbl_register_temp_exam_schedule
WHERE
tbl_register_temp_exam_schedule.rst_temp_code =:rst_temp_code_param
    ORDER BY
    tbl_register_temp_exam_schedule.rtes_id ASC
    ");
    $quary_2->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
    while($rowGen_2= $quary_2->fetch(PDO::FETCH_OBJ)) {
      $regis_tmp_list->register_main_exam_schedule($rowGen_2->esd_id,$rowGen_2->type_study_id,$rowGen_2->school_id,$rowGen_2->rst_temp_code);
    
    }
    
  // บันทึกเอกสาร
  $quary_3 = $sql_process->runQuery(
    "SELECT
tbl_register_temp_doc.rtd_id,
tbl_register_temp_doc.doc_id,
tbl_register_temp_doc.doc_detail,
tbl_register_temp_doc.doc_sent,
tbl_register_temp_doc.school_id,
tbl_register_temp_doc.rst_temp_code
FROM
tbl_register_temp_doc
WHERE
tbl_register_temp_doc.rst_temp_code =:rst_temp_code_param
    ORDER BY
    tbl_register_temp_doc.rtd_id ASC
    ");
    $quary_3->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
    while($rowGen_3= $quary_3->fetch(PDO::FETCH_OBJ)) {
      $regis_tmp_list->register_main_doc($rowGen_3->doc_id,$rowGen_3->doc_detail,$rowGen_3->doc_sent,$rowGen_3->school_id,$rowGen_3->rst_temp_code);  
    }

 


    ////Clear TEMP ทั้งหมด
    // $sql_process->fastQuery("DELETE FROM tbl_register_temp  WHERE rst_temp_code='$rst_temp_code_get'");
    // $sql_process->fastQuery("DELETE FROM tbl_register_temp_class_schedule  WHERE rst_temp_code='$rst_temp_code_get'");
    // $sql_process->fastQuery("DELETE FROM tbl_register_temp_doc  WHERE rst_temp_code='$rst_temp_code_get'");
    // $sql_process->fastQuery("DELETE FROM tbl_register_temp_exam_schedule  WHERE rst_temp_code='$rst_temp_code_get'");
    // $sql_process->fastQuery("DELETE FROM tbl_register_temp_student  WHERE rst_temp_code='$rst_temp_code_get'");
 
    // echo "<script>";
    // echo "location.href = '?option=regis-step-8&sccode=$rst_temp_code_get&success'";
    // echo "</script>";
    echo "<script>";
    echo "location.href = '?option=main'";
    echo "</script>";
  }

  if(isset($_GET['Cleartemp'])) {
    $rst_temp_code=$_GET['sccode'];
////Clear TEMP ทั้งหมด
    $sql_process->fastQuery("DELETE FROM tbl_register_temp  WHERE rst_temp_code='$rst_temp_code'");
    $sql_process->fastQuery("DELETE FROM tbl_register_temp_class_schedule  WHERE rst_temp_code='$rst_temp_code'");
    $sql_process->fastQuery("DELETE FROM tbl_register_temp_doc  WHERE rst_temp_code='$rst_temp_code'");
    $sql_process->fastQuery("DELETE FROM tbl_register_temp_exam_schedule  WHERE rst_temp_code='$rst_temp_code'");
    $sql_process->fastQuery("DELETE FROM tbl_register_temp_student  WHERE rst_temp_code='$rst_temp_code'");


// $sql_process->fastQuery("DELETE
// FROM
// tbl_register_temp ,
// tbl_register_temp_class_schedule ,
// tbl_register_temp_doc ,
// tbl_register_temp_exam_schedule ,
// tbl_register_temp_student
// WHERE
// tbl_register_temp.rst_temp_code = tbl_register_temp_class_schedule.rst_temp_code AND
// tbl_register_temp.rst_temp_code = tbl_register_temp_doc.rst_temp_code AND
// tbl_register_temp.rst_temp_code = tbl_register_temp_class_schedule.rst_temp_code AND
// tbl_register_temp.rst_temp_code = tbl_register_temp_exam_schedule.rst_temp_code AND
// tbl_register_temp.rst_temp_code = tbl_register_temp_student.rst_temp_code AND
// tbl_register_temp.ip_pc = '$ipaddress'");
  echo "<script>";
  echo "location.href = '?option=Payment&registerCode=$rst_temp_code'";
  echo "</script>";
  }
