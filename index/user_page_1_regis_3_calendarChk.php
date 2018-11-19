<?php
require_once("../config/dbl_config.php");
require_once('../class/class_register.php');
require_once('../class/class_q_general.php');
require_once("../library/general_funtion.php");
$qGeneral = new Q_gen();
$regis_tmp_list = new register_process();
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){

    
    //  vehicle_type_allow อนุญาตให้เปิดสอนได้หลายคนในเวลาเดียวกัน 1=ได้ ,0=ไม่ได้ 
    $vehicle_type_allow = strip_tags($_POST['vehicle_type_allow']);
    $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
    $rst_temp_code = strip_tags($_POST['rst_temp_code']);
    $title = strip_tags($_POST['title']);
    $start = strip_tags($_POST['start']);
    $end = strip_tags($_POST['end']);
    $trainer_id = strip_tags($_POST['trainer_id']);
    $course_group_subject_auto = strip_tags($_POST['course_group_subject_auto']);
    $sum_hour = strip_tags($_POST['sum_hour']); //เวลาปฏิบัติของหลักสูตร
    $sum_hour2 = strip_tags($_POST['sum_hour2']); //เวลารวม tmp ใน calendar 
    $crt_by = strip_tags($_POST['crt_by']);
    $crt_date=date("Y-m-d H:i:s"); 

    //ถ้า course_group_subject_auto=1 คือเป็นการ กำหนดรายวิชาบังคับ จังกำหนดให้   school_id=0 เพราะเป็นหลักสูตรกลาง    
    if($course_group_subject_auto==1){$Value_SchoolID=0; }else{ $Value_SchoolID=$school_id; }
    ///
    $rst_temp_code_post = $rst_temp_code;	
    $stmt = $qGeneral->runQuery("SELECT
    tbl_register_temp.rst_temp_date_calendar,
    tbl_register_temp.course_group_id,
    tbl_register_temp.course_data_id,
    tbl_register_temp.trainer_id, 
    tbl_register_temp.school_id, 
    tbl_register_temp.rst_temp_code
    FROM 
    tbl_register_temp 
    WHERE
    tbl_register_temp.rst_temp_code=:rst_temp_code_param");
    $stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_post));
    $dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร
    $school_id=$dataRow["school_id"];
    $course_data_id=$dataRow["course_data_id"];
    //
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
///คำนวณ หาช่วงเวลาที่ได้จาก event 
$calDate=TimeDiff("$times_ex","$times_ex2");
///ตรวจสอบเวลาจาก form และคำนวนว่ามีเท่าไร สามารถเพิ่มได้หรือไม่ถ้าเกินค่าชั่วโมงที่อยูในฐานข้อมูล
$calDate2=$sum_hour2 + $calDate;


 ///ตรวจสอบช่วงเวลาเรียนซ้อนกันและไม่สามารถลงเรียนได้ใน temp
$Chktemp = $qGeneral->rowsQuery("SELECT
tbl_register_temp_class_schedule.rmcs_id
FROM
tbl_register_temp_class_schedule
WHERE
(
tbl_register_temp_class_schedule.type_study_id='2' AND      
tbl_register_temp_class_schedule.trainer_id='$trainer_id' AND
DATE(tbl_register_temp_class_schedule.rmcs_start_date) = '$date_ex'  AND 
TIME(tbl_register_temp_class_schedule.rmcs_start_date) BETWEEN '$times_ex' AND '$times_ex2') 
OR
(tbl_register_temp_class_schedule.type_study_id='2' AND
tbl_register_temp_class_schedule.trainer_id='$trainer_id' AND
DATE(tbl_register_temp_class_schedule.rmcs_date_end) = '$date_ex'  AND 
TIME(tbl_register_temp_class_schedule.rmcs_date_end) BETWEEN '$times_ex' AND '$times_ex2' AND
TIME(tbl_register_temp_class_schedule.rmcs_date_end) > '$times_ex')
OR
(tbl_register_temp_class_schedule.type_study_id='2' AND
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
    $server=$_SERVER['HTTP_REFERER'];
    // die ('Erreur execute');
    echo "<font color='#ED1C24' size='5'> **Error : เลือกช่วงเวลาไม่ถูกต้อง !! </font>";
    echo "<meta http-equiv='refresh' content='2 ;url=$server'>" ;
    echo "<br>";
    echo "<center>";
    echo "<img src='../images/images_system/loader0.gif'>";
    echo "<br>";
    echo "<font color='#3F48CC'> ระบบกำลังเตรียมปฏิทินการลงเวลาเรียนเพื่อทำรายการใหม่ กรุณารอซักครู่........ </font>";
    echo "</center>";
}elseif($date_ex != $date_ex2){
    $server=$_SERVER['HTTP_REFERER'];
    echo "<font color='#ED1C24' size='5'> **Error : เลือกช่วงเวลาไม่ถูกต้อง !! </font>";
    echo "<meta http-equiv='refresh' content='2 ;url=$server'>" ;
    echo "<br>";
    echo "<center>";
    echo "<img src='../images/images_system/loader0.gif'>";
    echo "<br>";
    echo "<font color='#3F48CC'> ระบบกำลังเตรียมปฏิทินการลงเวลาเรียนเพื่อทำรายการใหม่ กรุณารอซักครู่........ </font>";
    echo "</center>";
}elseif($calDate2 > $sum_hour){
    $server=$_SERVER['HTTP_REFERER'];
    echo "<font color='#ED1C24' size='5'> **Error : เลือกชั่วโมงเกินกำหนด !! </font>";
    echo "<meta http-equiv='refresh' content='2 ;url=$server'>" ;
    echo "<br>";
    echo "<center>";
    echo "<img src='../images/images_system/loader0.gif'>";
    echo "<br>";
    echo "<font color='#3F48CC'> ระบบกำลังเตรียมปฏิทินการลงเวลาเรียนเพื่อทำรายการใหม่ กรุณารอซักครู่........ </font>";
    echo "</center>";
}else{
  
    
 
    $type_study_id=2; /// คือภาคปฏิบัติ
    $rmcs_start_date=$start;
    $rmcs_date_end=$end;
    $rmcs_hour=$calDate;
    $num_code = random_password(15);
    $qa8 = $qGeneral->runQuery(
        "SELECT
        tbl_subject_data.subject_data_id,
        tbl_subject_in_course.time_study
        FROM
        tbl_subject_in_course ,
        tbl_subject_data
        WHERE
        tbl_subject_in_course.subject_data_id = tbl_subject_data.subject_data_id AND
        tbl_subject_data.type_study_id = '$type_study_id' AND  
        tbl_subject_in_course.course_data_id = '$course_data_id' AND
        tbl_subject_in_course.school_id='$Value_SchoolID'
        ORDER BY
        tbl_subject_data.subject_data_id ASC");
            $qa8->execute();
            // $rowI= $qa8->fetch(PDO::FETCH_OBJ);
            while($rowI= $qa8->fetch(PDO::FETCH_OBJ)) { 
                $subject_data_id=$rowI->subject_data_id;
                $time_study=$rowI->time_study; ///ชั่วโมงเรียน
                            ////คำสั่งตรวจสอบรายวิชาว่าครบตามชั่วโมงหรือไม่แล้วนำมาเปรียบเทียบ
$stmtl = $qGeneral->runQuery("SELECT Sum(rmcs_hour) AS rmcs_hour FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param AND subject_data_id='$subject_data_id'");
$stmtl->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRowl=$stmtl->fetch(PDO::FETCH_ASSOC);
// $rmcs_hourX = $dataRowl['rmcs_hour'] ? $dataRowl['rmcs_hour'] : 1;
$rmcs_hourX = $dataRowl['rmcs_hour'];

////หาวันที่ล่าสุดที่เพิ่มว่ามีหรือไม่
$total_dataW =$qGeneral->rowsQuery("SELECT subject_data_id FROM tbl_register_temp_class_schedule WHERE  num_code='$num_code' AND rst_temp_code='$rst_temp_code'");  //AND rmcs_start_date='$rmcs_start_date'

                
                  $total_sub =$qGeneral->rowsQuery("SELECT subject_data_id FROM tbl_register_temp_class_schedule WHERE subject_data_id='$subject_data_id' AND rst_temp_code='$rst_temp_code'");
                    // $total_data2 =$qGeneral->rowsQuery("SELECT subject_data_id FROM tbl_register_temp_class_schedule WHERE num_code='$num_code' AND rst_temp_code='$rst_temp_code'");
                // ถ้าช่วงเวลาทีได้จากform มีค่ามากกว่าเวลาเรียน ให้ใส่เวลาเรียน

if($rmcs_hourX != $time_study || $rmcs_hourX < $time_study){
    if($total_sub <=0){ ////ถ้าการเลือกครั้งนี้ไม่มีรายวิชาเดิมอยู่

        if($rmcs_hour >= $time_study && $total_dataW <=0){    ///ถ้าเวลาจาก form มากกว่า ชั่วโมงเรียน และการเลือกครั้งนี้ไม่มีรายวิชานี้อยู่ใน temp
            $date_end0 = date ("Y-m-d H:i:s", strtotime("+$time_study hour", strtotime($rmcs_start_date)));
           $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$date_end0,$time_study,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
        }elseif($rmcs_hour < $time_study && $total_dataW <=0){  ///ถ้าเวลาจาก form น้อยกว่า ชั่วโมงเรียน และการเลือกครั้งนี้ไม่มีรายวิชานี้อยู่ใน temp
            $date_end0 = date ("Y-m-d H:i:s", strtotime("+$rmcs_hour hour", strtotime($rmcs_start_date)));
            $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$date_end0,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
        }elseif($rmcs_hour >= $time_study && $total_dataW >=1){ //ถ้าเวลาจาก form มากกว่า ชั่วโมงเรียน และการเลือกครั้งนี้มีรายวิชานี้อยู่ใน temp
                $stmtE = $qGeneral->runQuery("SELECT MAX(rmcs_date_end) AS  rmcs_date_end, SUM(rmcs_hour) AS rmcs_hour  FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param AND num_code='$num_code'");
                $stmtE->execute(array(":rst_temp_code_param"=>$rst_temp_code));
                $dataRowE=$stmtE->fetch(PDO::FETCH_ASSOC);
                $rmcs_date_endE=$dataRowE['rmcs_date_end']; 
                $rmcs_hour_sum=$dataRowE['rmcs_hour']; 
                $time_cut=$rmcs_hour-$rmcs_hour_sum; ///เวลาที่เหลือจาก form event
               
                if($time_cut >= $time_study){ 
                    $date_endA = date ("Y-m-d H:i:s", strtotime("+$time_study hour", strtotime($rmcs_date_endE)));
                    $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_date_endE,$date_endA,$time_study,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);   
                }else{
                    $date_endA = date ("Y-m-d H:i:s", strtotime("+$time_cut hour", strtotime($rmcs_date_endE)));
                   $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_date_endE,$date_endA,$time_cut,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);   
                }

               
        }elseif($rmcs_hour < $time_study && $total_dataW >=1){ //ถ้าเวลาจาก form น้อยกว่า ชั่วโมงเรียน และการเลือกครั้งนี้มีรายวิชานี้อยู่ใน temp
            $stmtE = $qGeneral->runQuery("SELECT MAX(rmcs_date_end) AS  rmcs_date_end FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param AND num_code='$num_code'");
            $stmtE->execute(array(":rst_temp_code_param"=>$rst_temp_code));
            $dataRowE=$stmtE->fetch(PDO::FETCH_ASSOC);
            $rmcs_date_endE=$dataRowE['rmcs_date_end']; 
            $date_endA = date ("Y-m-d H:i:s", strtotime("+$rmcs_hour hour", strtotime($rmcs_date_endE)));
            $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_date_endE,$date_endA,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);

        }

    }else{

        $subject_cut= $time_study-$rmcs_hourX; ////เวลารายวิชา และเวลาที่เพิ่มยังไม่ครบใน temp 
        if($rmcs_hour >= $subject_cut){
            $date_end0 = date ("Y-m-d H:i:s", strtotime("+$subject_cut hour", strtotime($rmcs_start_date)));
            $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$date_end0,$subject_cut,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
        } elseif($rmcs_hour < $subject_cut){
            $date_end0 = date ("Y-m-d H:i:s", strtotime("+$rmcs_hour hour", strtotime($rmcs_start_date)));
            $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$date_end0,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
        }
       

    }



}

                // if($rmcs_hour >= $time_study && $rmcs_hourX < $time_study && $total_dataW<=0 ){
                //     if($time_study<1){
                //         $numtime=30;
                //         $date_end0 = date ("Y-m-d H:i:s", strtotime("+$numtime minute", strtotime($rmcs_start_date)));
                //     }else{
                //         $date_end0 = date ("Y-m-d H:i:s", strtotime("+$time_study hour", strtotime($rmcs_start_date)));
                //     }
                //     // $date_end0 = date ("Y-m-d H:i:s", strtotime("+$time_study hour", strtotime($rmcs_start_date)));
                //     $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$date_end0,$time_study,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
               
                //     ///ถ้าจำนวนชั่วโมงทั้งหมดของรายวิชานั้นๆยังไม่ครบกำหนดจำนวนชั่วโมงของรายวิชาที่กำหนดไว้
                // }elseif($rmcs_hour >= $time_study && $rmcs_hourX < $time_study && $total_dataW>0 ){
                //     $stmtE = $qGeneral->runQuery("SELECT MAX(rmcs_date_end) AS  rmcs_date_end FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param AND num_code='$num_code'");
                //     $stmtE->execute(array(":rst_temp_code_param"=>$rst_temp_code));
                //     $dataRowE=$stmtE->fetch(PDO::FETCH_ASSOC);
                //     $rmcs_date_endE=$dataRowE['rmcs_date_end'];    
                //         if($time_study<1){
                //             $numtime=30;
                //             $date_endA = date ("Y-m-d H:i:s", strtotime("+$numtime minute", strtotime($rmcs_date_endE)));
                //         }else{
                //             $date_endA = date ("Y-m-d H:i:s", strtotime("+$time_study hour", strtotime($rmcs_date_endE)));
                //         }
                //     $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_date_endE,$date_endA,$time_study,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
                // }
            
                // elseif($rmcs_hourX < $time_study ){
                //     $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);
                // }
                // $regis_tmp_list->register_temp_class_schedule($subject_data_id,$vehicle_type_id,$type_study_id,$trainer_id,$rmcs_start_date,$rmcs_date_end,$rmcs_hour,$school_id,$crt_by,$crt_date,$num_code,$rst_temp_code);


                ///ถ้าจำชั่วโมงทั้งหมดที่ได้จากการเพิ่มตารางเรียนในแต่ละครั้งพอดีกับจำนวนชั่วโมงหรือช่วงเวลาที่เพิ่มจาก form
                $stmtk = $qGeneral->runQuery("SELECT Sum(rmcs_hour) AS rmcs_hour FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param AND num_code='$num_code'");
                $stmtk->execute(array(":rst_temp_code_param"=>$rst_temp_code));
                $dataRowk=$stmtk->fetch(PDO::FETCH_ASSOC);
                $rmcs_hourY=$dataRowk['rmcs_hour'];

                if($rmcs_hourY >= $calDate){
                        break;
                }
            }
        
            // }


    header('Location: '.$_SERVER['HTTP_REFERER']);
}
    
   
}
// echo $Chktemp."<br>";
// echo $year_ex."<br>";
//  echo $date_ex."<br>";
//  echo $date_ex2."<br>";
//  header('Location: '.$_SERVER['HTTP_REFERER']);

?>
