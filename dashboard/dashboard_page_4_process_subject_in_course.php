<?php

// คำอธิบาย
// tbl_subject_data.type_subject_id = '1'  คือ 1 มาจาก 
// ตาราง tbl_type_subject ที่มี type_subject_id=1 นั่นคือ การเรียนวิชาบังคับโดยกรม
// tbl_subject_data.school_id = '0' ใช้สำหรับโรงเรียนทั้งหมด
if(isset($_GET['course']) && !empty($_GET['course']))
{
    $table  = 'tbl_subject_in_course';
 $course_data_id = strip_tags($_GET['course']);
 $course_group_id = strip_tags($_GET['group']);
 $vehicle_type_id = strip_tags($_GET['vehicle_type']);
 $school_id = strip_tags($_GET['school']);
 $crt_by=$_SESSION['userSession'];
 $crt_date=date("Y-m-d H:i:s");
 $qs = $sql_process->runQuery(
 "SELECT
tbl_subject_data.subject_data_id,
tbl_subject_data.force_hour
FROM
tbl_subject_data
WHERE
tbl_subject_data.subject_data_status = '1' AND
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.school_id =:school_id_param AND
tbl_subject_data.type_subject_id = '1' AND
tbl_subject_data.vehicle_type_id = :vehicle_type_id_param
ORDER BY
tbl_subject_data.subject_data_id ASC
 ");
//  $qs->execute(); 
 $qs->execute(array(":vehicle_type_id_param"=>$vehicle_type_id,":school_id_param"=>$school_id));
 while($rowSubject= $qs->fetch(PDO::FETCH_OBJ)) {
  $subject_data_id= $rowSubject->subject_data_id;
  $time_study= $rowSubject->force_hour;
//  $sql_process->process_a($subject_data_id,$course_data_id,$time_study,$school_id,$crt_by,$crt_date);

 $fields = [
    'subject_data_id' => $subject_data_id,
    'course_data_id' => $course_data_id,
    'time_study' => $time_study,
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

 }
//  SET =1 เพื่อแสดงการกำหนดรายวิชาเรียบร้อยแล้ว
// $course_success='1';
 $sql_process->fastQuery("UPDATE tbl_course_data SET course_success='1'   WHERE course_data_id='$course_data_id'");
 echo "<script>";
 echo "location.href = '?option=course-data&success'";
 echo "</script>";
}
?>