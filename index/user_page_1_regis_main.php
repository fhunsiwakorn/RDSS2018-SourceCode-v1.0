<?php
$stmtMAX = $sql_process->runQuery("SELECT
tbl_register_temp.ip_pc,
tbl_register_temp.page_step,
tbl_register_temp.rst_temp_code,
tbl_register_temp.trainer_id
FROM
tbl_register_temp
WHERE
tbl_register_temp.ip_pc='$ipaddress' AND
tbl_register_temp.school_id=:school_id_param
ORDER BY
tbl_register_temp.upd_date DESC");
$stmtMAX->execute(array(":school_id_param"=>$school_id));
$total_MAX=$stmtMAX->rowCount();
$dataRowMAX=$stmtMAX->fetch(PDO::FETCH_ASSOC);
$page_stepMAX=$dataRowMAX['page_step'];
$trainer_idmx=$dataRowMAX['trainer_id'];
$rst_temp_code_max=$dataRowMAX['rst_temp_code'];
if($total_MAX<=0){
    include ("user_page_1_regis_1.php");
   }else{
   switch($page_stepMAX) {
   case '1': include ("user_page_1_regis_1_update.php");
   break;
   case '2' : include ("user_page_1_regis_2.php");
   break;
   case '3' : include ("user_page_1_regis_3.php");
   break; 
   case '4' : include ("user_page_1_regis_4_student.php");
   break; 
   case '5' : include ("user_page_1_regis_5_add_doc.php");
   break;
   case '6' : include ("user_page_1_regis_6_slect_subject.php");
   break;  
   case '7' : include ("user_page_1_regis_7_Exam_schedule_main.php");
   break; 
   case '8' : include ("user_page_1_regis_8_preview.php");
   break;   
   default : include ("user_page_1_regis_1.php");
    }
   }