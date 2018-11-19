<?php

$total_data2 =$sql_process->rowsQuery("SELECT tbl_register_temp_exam_schedule.rtes_id FROM tbl_register_temp_exam_schedule WHERE tbl_register_temp_exam_schedule.rst_temp_code ='$rst_temp_code_max'");
if($total_data2<=0){
    include ("user_page_1_regis_7_Exam_schedule.php");
}else{
    include ("user_page_1_regis_7_Exam_schedule_edit.php");
}