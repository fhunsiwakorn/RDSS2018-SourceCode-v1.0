<?php
require_once("../config/dbl_config.php");
require_once('../class/class_register.php');
require_once('../class/class_q_general.php');
require_once("../library/general_funtion.php");
$qGeneral = new Q_gen();
 $regis_tmp_list = new register_process();

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){

    $id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
    $end = $_POST['Event'][2]; 

    $arrayid= explode(".",$id);
    $rmcs_id = $arrayid[0];//rmcs_id
    $subject_data_id = $arrayid[1];//subject_data_id
//  vehicle_type_allow อนุญาตให้เปิดสอนได้หลายคนในเวลาเดียวกัน 1=ได้ ,0=ไม่ได้ 
$vehicle_type_allow = strip_tags($_GET['vehicle_type_allow']);
$trainer_id = strip_tags($_GET['trainer_id']);
$sum_hour = strip_tags($_GET['sum_hour']); //เวลาปฏิบัติของหลักสูตร
$rst_temp_code = strip_tags($_GET['rst_temp_code']); //รหัสอ้างอิง tmp ใน calendar 

///คัดแยกวันและเวลาออกจากกัน
//วันที่เริ่มต้น
$dateStart=$start;
$DateTimeray = explode(" ", $dateStart);
$date_ex=$DateTimeray[0]; //วันที่ Y-m-d
$times_ex=$DateTimeray[1]; //HH:i:s
$Datearray=explode("-", $date_ex);
$year_ex=$Datearray[0]; //Year
$month_ex=$Datearray[1]; //Month
///วันที่สิ้นสุด
$dateEnd=$end;
$DateTimeray2 = explode(" ", $dateEnd);
$date_ex2=$DateTimeray2[0]; //วันที่ Y-m-d
$times_ex2=$DateTimeray2[1]; //HH:i:s
$Datearray2=explode("-", $date_ex2);
$year_ex2=$Datearray2[0]; //Year
$month_ex2=$Datearray2[1]; //Month

////คำนวนหาชั่วโมงจาก calendar tmp
$stmtCal2 = $qGeneral->runQuery("SELECT
SUM(tbl_register_temp_class_schedule.rmcs_hour) AS rmcs_hour
FROM
tbl_register_temp_class_schedule
WHERE
tbl_register_temp_class_schedule.type_study_id='2' AND  
tbl_register_temp_class_schedule.trainer_id=:trainer_id_param AND  
tbl_register_temp_class_schedule.rmcs_id !=:rmcs_id_param AND
tbl_register_temp_class_schedule.rst_temp_code =:rst_temp_code_param");
$stmtCal2->execute(array(":rmcs_id_param"=>$rmcs_id ,":rst_temp_code_param"=>$rst_temp_code ,":trainer_id_param"=>$trainer_id));
$calRow2=$stmtCal2->fetch(PDO::FETCH_ASSOC);
$sumtotal2=$calRow2['rmcs_hour'];
///คำนวณ หาช่วงเวลาที่ได้จาก event 
$calDate=TimeDiff("$times_ex","$times_ex2"); ///วันที่เดิมที่ได้จากการแก้ไข
$calDateSet=$calDate+$sumtotal2 ; ////$calDate2 + เวลารวม tmp ใน calendar 


////
$stmt2 = $qGeneral->runQuery("SELECT time_study FROM tbl_subject_in_course WHERE  subject_data_id=:subject_data_id");
$stmt2->execute(array(":subject_data_id"=>$subject_data_id));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
$time_study = $dataRow2['time_study'];

///ตรวจสอบช่วงเวลาเรียนซ้อนกันและไม่สามารถลงเรียนได้ใน temp
$Chktemp = $qGeneral->rowsQuery("SELECT
tbl_register_temp_class_schedule.rmcs_id
FROM
tbl_register_temp_class_schedule
WHERE
(tbl_register_temp_class_schedule.type_study_id='2' AND  
tbl_register_temp_class_schedule.rmcs_id !='$rmcs_id' AND
tbl_register_temp_class_schedule.trainer_id='$trainer_id' AND
DATE(tbl_register_temp_class_schedule.rmcs_start_date) = '$date_ex'  AND 
TIME(tbl_register_temp_class_schedule.rmcs_start_date) BETWEEN '$times_ex' AND '$times_ex2') 
OR
(tbl_register_temp_class_schedule.type_study_id='2' AND  
tbl_register_temp_class_schedule.rmcs_id !='$rmcs_id' AND
tbl_register_temp_class_schedule.trainer_id='$trainer_id' AND
DATE(tbl_register_temp_class_schedule.rmcs_date_end) = '$date_ex'  AND 
TIME(tbl_register_temp_class_schedule.rmcs_date_end) BETWEEN '$times_ex' AND '$times_ex2' AND
TIME(tbl_register_temp_class_schedule.rmcs_date_end) > '$times_ex')
OR
(tbl_register_temp_class_schedule.type_study_id='2' AND  
tbl_register_temp_class_schedule.rmcs_id !='$rmcs_id' AND
tbl_register_temp_class_schedule.trainer_id='$trainer_id' AND
DATE(tbl_register_temp_class_schedule.rmcs_date_end) = '$date_ex'  AND 
TIME(tbl_register_temp_class_schedule.rmcs_start_date)<='$times_ex' AND 
TIME(tbl_register_temp_class_schedule.rmcs_date_end)>='$times_ex2')");

 ///ตรวจสอบช่วงเวลาเรียนซ้อนกันและไม่สามารถลงเรียนได้ในตารางเรียนบันทึกขริง
 $Chktemp2 = $qGeneral->rowsQuery("SELECT
 tbl_register_main_class_schedule.rmcs_id
 FROM
 tbl_register_main_class_schedule
 WHERE
 (
tbl_register_main_class_schedule.type_study_id='2' AND      
tbl_register_main_class_schedule.trainer_id='$trainer_id' AND
 DATE(tbl_register_main_class_schedule.rmcs_start_date) = '$date_ex'  AND 
 TIME(tbl_register_main_class_schedule.rmcs_start_date) BETWEEN '$times_ex' AND '$times_ex2') 
 OR
 (tbl_register_main_class_schedule.type_study_id='2' AND
 tbl_register_main_class_schedule.trainer_id='$trainer_id' AND
 DATE(tbl_register_main_class_schedule.rmcs_date_end) = '$date_ex'  AND 
 TIME(tbl_register_main_class_schedule.rmcs_date_end) BETWEEN '$times_ex' AND '$times_ex2' AND
 TIME(tbl_register_main_class_schedule.rmcs_date_end) > '$times_ex')
 OR
 (tbl_register_main_class_schedule.type_study_id='2' AND
 tbl_register_main_class_schedule.trainer_id='$trainer_id' AND
 DATE(tbl_register_main_class_schedule.rmcs_date_end) = '$date_ex'  AND 
 TIME(tbl_register_main_class_schedule.rmcs_start_date)<='$times_ex' AND 
 TIME(tbl_register_main_class_schedule.rmcs_date_end)>='$times_ex2')");

if(($Chktemp>='1' && $vehicle_type_allow=='0') || ($Chktemp2>='1' && $vehicle_type_allow=='0')){ 

    die ('Erreur execute');
}elseif($date_ex != $date_ex2){
    die ('Erreur execute');
}elseif($calDateSet > $sum_hour){
    die ('Erreur execute');
}elseif($calDate > $time_study){
    die ('Erreur execute');
}elseif(DateTimetotime($start) < "05:59:00" ||  DateTimetotime($end) < "05:59:00"){
    die ('Erreur execute');
}
else{


    $regis_tmp_list->update_register_temp_class_schedule($rmcs_id,$start,$end,$calDate);
    die ('OK');
}


// $regis_tmp_list->update_register_temp_class_schedule($id,$start,$end,$calDate);
//  die ('OK');
}
// header('Location: '.$_SERVER['HTTP_REFERER']);



	
?>
