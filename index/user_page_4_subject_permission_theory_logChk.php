<?php
	// ถ้าจำนวนรายวิชาครบตามที่กำหนดให้ set เป็น 1 (ในแต่ละวัน)
if(isset($_GET['setsubject']) && isset($_GET['topic'])) {
$school_id = strip_tags($_GET['school']);
$vehicle_type_id = strip_tags($_GET['setsubject']);

$qa7 = $sql_process->runQuery(
  "SELECT 
  tbl_subject_theory.st_date
  FROM
  tbl_subject_theory
  WHERE
  tbl_subject_theory.school_id = :school_id_param AND
  tbl_subject_theory.vehicle_type_id =:vehicle_type_id_param
  GROUP BY
tbl_subject_theory.st_date
  ORDER BY
  tbl_subject_theory.st_date DESC
  ");
  // $qa7->execute();
  $qa7->execute(array(":school_id_param"=>$school_id,":vehicle_type_id_param"=>$vehicle_type_id));
  while($rowH= $qa7->fetch(PDO::FETCH_OBJ)) {

///คำนวนหาจำนวนชั่วโมงทั้งหมดของประเภทหลักสูตรตาม vehicle_type_id ในฐานข้อมูลรายวิชา
$stmtCal = $sql_process->runQuery("SELECT
SUM(tbl_subject_data.force_hour) AS force_hour
FROM
tbl_subject_data
WHERE
tbl_subject_data.type_study_id = '1' AND
tbl_subject_data.type_subject_id = '1' AND
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.subject_data_status = '1' AND
tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_data.school_id='0'");
$stmtCal->execute(array(":vehicle_type_id_param"=>$vehicle_type_id));
$calRow=$stmtCal->fetch(PDO::FETCH_ASSOC);
$sumtotal=$calRow['force_hour'];
// $sumtotal = !empty($calRow['force_hour']) ? $calRow['force_hour'] : 1; 

       ///คำนวนหาจำนวนชั่วโมงทั้งหมดของประเภทหลักสูตรตาม vehicle_type_id ในฐานข้อมูลรายวิชาทฤษฎี
$stmtCal2 = $sql_process->runQuery("SELECT
SUM(tbl_subject_theory.st_hour) AS st_hour
FROM
tbl_subject_theory
WHERE
tbl_subject_theory.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_theory.st_date =:st_date_param AND
tbl_subject_theory.success_permiss ='0' AND
tbl_subject_theory.school_id=:school_id_param 
");
$stmtCal2->execute(array(":school_id_param"=>$school_id ,":vehicle_type_id_param"=>$vehicle_type_id,":st_date_param"=>$rowH->st_date));
$calRow2=$stmtCal2->fetch(PDO::FETCH_ASSOC);
$sumtotal2=$calRow2['st_hour'];
// $sumtotal2 = !empty($calRow2['st_hour']) ? $calRow2['st_hour'] : 1; 
// ตรวจสอบจำนวนชั่วโมงของทุกรายวิชาครับยัง ถ้าครบให้ mod==0
$modSubject=$sumtotal%$sumtotal2;
// echo "<center>";
// echo $modSubject."</center>";
// Set เป็น 1 
  if($modSubject ==0){
  // $subject_data_list->set_subject_theory($vehicle_type_id,$rowH->st_date); 
  $sql_process->fastQuery("UPDATE tbl_subject_theory SET success_permiss='1'  WHERE vehicle_type_id='$vehicle_type_id' AND st_date='$rowH->st_date' AND school_id='$school_id'");
    }
  }

}

$st_code = random_password(10);
// กำหนดอบรมทฤษฎีแบบอัตโนมัติ 
if(isset($_POST['form_auto'])) {
  $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
  $st_date = strip_tags($_POST['st_date']);
  $st_start_time = strip_tags($_POST['st_start_time']);
  $st_end_time = strip_tags($_POST['st_end_time']);
  $school_id = strip_tags($_POST['school_id']);
  $trainer_id = strip_tags($_POST['trainer_id']);
  $crt_by=$_SESSION['userSession'];
  $crt_date=date("Y-m-d H:i:s");

$date_success=DatetoYMD($st_date);
///คำนวนหาจำนวนชั่วโมงทั้งหมดของประเภทหลักสูตรตาม vehicle_type_id ในฐานข้อมูลรายวิชา
$stmtCal = $sql_process->runQuery("SELECT
SUM(tbl_subject_data.force_hour) AS force_hour
FROM
tbl_subject_data
WHERE
tbl_subject_data.type_study_id = '1' AND
tbl_subject_data.type_subject_id = '1' AND
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.subject_data_status = '1' AND
tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_data.school_id='0'");
$stmtCal->execute(array(":vehicle_type_id_param"=>$vehicle_type_id));
$calRow=$stmtCal->fetch(PDO::FETCH_ASSOC);
// $sumtotal=$calRow['force_hour'];
$sumtotal = !empty($calRow['force_hour']) ? $calRow['force_hour'] : 1; 
//คำนวนหาจำนวนรายวิชา
// $total_subject =$sql_process->rowsQuery("SELECT tbl_subject_data.subject_data_id FROM tbl_subject_data WHERE tbl_subject_data.vehicle_type_id ='$vehicle_type_id'");


$numg=0;
$qp = $sql_process->runQuery(
  "SELECT
tbl_subject_data.subject_data_id,
tbl_subject_data.force_hour
  FROM
  tbl_subject_data
  WHERE
tbl_subject_data.type_study_id = '1' AND
  tbl_subject_data.type_subject_id = '1' AND
  tbl_subject_data.is_delete = '1' AND
  tbl_subject_data.subject_data_status = '1' AND
  tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
  tbl_subject_data.school_id='0' 
  ORDER BY
  tbl_subject_data.subject_data_id ASC
  ");
  // $qg->execute();
  $qp->execute(array(":vehicle_type_id_param"=>$vehicle_type_id));
  while($rowProcess= $qp->fetch(PDO::FETCH_OBJ)) {
    $numg++;
    $subject_data_id=$rowProcess->subject_data_id;
    $force_hour=$rowProcess->force_hour;
   
////คำสั่งตรวจสอบรายวิชาว่ามีอยู่ในฐานข้อใูลแล้วหรือไม่ ถ้ามีให้หาจำนวนชั่วโมงที่น้อยที่สุด
    $stmt = $sql_process->runQuery("SELECT Min(tbl_subject_theory.st_hour) AS  st_hour ,Sum(tbl_subject_theory.st_hour) AS  st_hour2 FROM tbl_subject_theory WHERE tbl_subject_theory.subject_data_id ='$subject_data_id'");
    $stmt->execute();
    $dataRow=$stmt->fetch(PDO::FETCH_ASSOC);    
    $st_hour=$dataRow['st_hour'];
    $st_hour2=$dataRow['st_hour2']; ///Sum จำนวนชั่วโมงทั้งหมดของรายวิชา
    $newtime=$force_hour-$st_hour;
    ///ตรวจสอบรายวิชาในหลายๆ Record ว่าครบตามจำนวนชั่วโมงที่กำหนดหรือป่าว โดยถ้าครบ mod==0
    $modHour=$st_hour2%$force_hour;

    ///ตรวจสอบว่ามีรายวิชานี้อยู่ในฐานข้อมูลหรือไม่
     $cout_subject =$sql_process->rowsQuery("SELECT tbl_subject_theory.subject_data_id FROM tbl_subject_theory WHERE tbl_subject_theory.subject_data_id ='$subject_data_id'");

     ///คำนวนหาจำนวนชั่วโมงทั้งหมดของประเภทหลักสูตรตาม vehicle_type_id ในฐานข้อมูลรายวิชาทฤษฎี
$stmtCal2 = $sql_process->runQuery("SELECT
SUM(tbl_subject_theory.st_hour) AS st_hour
FROM
tbl_subject_theory
WHERE
tbl_subject_theory.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_theory.school_id=:school_id_param 
");
$stmtCal2->execute(array(":school_id_param"=>$school_id ,":vehicle_type_id_param"=>$vehicle_type_id));
$calRow2=$stmtCal2->fetch(PDO::FETCH_ASSOC);
// $sumtotal2=$calRow2['st_hour'];
$sumtotal2 = !empty($calRow2['st_hour']) ? $calRow2['st_hour'] : 1; 
// ตรวจสอบจำนวนชั่วโมงของทุกรายวิชาครับยัง ถ้าครบให้ mod==0
$modSubject=$sumtotal%$sumtotal2;

  if($numg==1){
    $total_range_timeA=TimeDiff("$st_start_time","$st_end_time");
    $timetox = date ("H:i:s", strtotime("+$force_hour hour", strtotime($st_start_time))); ///ชั่วโมงเรียนของรายวิชา
    $timetoy = date ("H:i:s", strtotime("+$total_range_timeA hour", strtotime($st_start_time)));  ///ชั่วโมงจากช่วงระยะเวลา
    $timetoz = date ("H:i:s", strtotime("+$newtime hour", strtotime($st_start_time)));
    //คำนวนจำนวนเวลาตามช่วงเวลา
     
      if($force_hour <= $total_range_timeA  && $modHour==0 && $modSubject==0 &&  $cout_subject<=0){  
        ///ถ้าจำนวนชั่วโมงยังมีค่าน้อยกว่าช่วงเวลาที่ส่งมาจากฟอร์ม ให้เพิ่มได้ปกติ
        $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_start_time,$timetox,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
      }elseif($force_hour <= $total_range_timeA  && $modHour!=0){
    ///ถ้าจำนวนชั่วโมงในรายวิชานั้นยังไม่ครบ
   $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$newtime,$st_start_time,$timetoz,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
      }
      elseif(($force_hour >= $total_range_timeA && $modHour==0 && $modSubject!=0) || ($force_hour >= $total_range_timeA && $modHour==0 && $modSubject==0)){
          ////ถ้าจำนวนชั่วโมงยังมีค่ามากกว่าช่วงเวลาที่ส่งมาจากฟอร์ม ให้เพิ่มชั่วโมงจากระยะช่วงเวลาไป
      $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$total_range_timeA,$st_start_time,$timetoy,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date); 
      }
      elseif($force_hour <= $total_range_timeA  && $modHour==0 && $modSubject==0 && $cout_subject>=1){
        $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_start_time,$timetox,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
      }elseif($modHour ==0 && $modSubject==0){
        $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_start_time,$timetox,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
      }
     
      
    }
 
    // st_code จะสร้างขึ้นมาในการเพิ่มแต่ละครั้ง
 if($modSubject==0){
 $cond="st_code='$st_code'";
 }else{
  $cond="vehicle_type_id='$vehicle_type_id' OR st_code='$st_code'";
 } 
 
    //หาช่วงเวลาล่าสุด
$stmtx = $sql_process->runQuery("SELECT Max(st_date) as st_date,Min(st_start_time) as st_start_time,Max(st_end_time) as st_end_time FROM tbl_subject_theory WHERE  $cond ");
$stmtx->execute();
$dataRowx=$stmtx->fetch(PDO::FETCH_ASSOC);
$st_start_timex = !empty($dataRowx['st_start_time']) ? $dataRowx['st_start_time'] : $st_start_time; 
// $st_start_timex =  $dataRowx['st_start_time']; 
$st_end_timex = !empty($dataRowx['st_end_time']) ? $dataRowx['st_end_time'] : $st_end_time; 
// $st_end_timex =  $dataRowx['st_end_time']; 
$st_datex = !empty($dataRowx['st_date']) ? $dataRowx['st_date'] : $date_success; 
// $st_datex =  $dataRowx['st_date']; 
//คำนวนจำนวนเวลาตามช่วงเวลา
$total_range_time=TimeDiff("$st_end_timex","$st_end_time");

$timeto2 = date ("H:i:s", strtotime("+$force_hour hour", strtotime($st_end_timex))); ///เวลาล่าสุด
$timeto3 = date ("H:i:s", strtotime("+$total_range_time hour", strtotime($st_end_timex)));
$timeto4 = date ("H:i:s", strtotime("+$newtime hour", strtotime($st_end_timex)));
$timeto5 = date ("H:i:s", strtotime("+$newtime hour", strtotime($st_start_timex)));
$timestamp1=strtotime($st_end_time); ///ช่วงเวลาสิ้นสุดที่กำหนดจาก form 
$timestamp2=strtotime($timeto2);
$timestamp3=strtotime($timeto3);
// $timetox = date ("H:i:s", strtotime("+$force_hour hour", strtotime($st_start_timex))); 


if($numg>1 && $timestamp2 <= $timestamp1 && $total_range_time >= $force_hour && $modHour ==0 && $modSubject==0  && $cout_subject<=0){
 
    $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_end_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
  
}elseif($numg>1 && $timestamp2 <= $timestamp1 && $total_range_time >= $force_hour && $modHour ==0 && $modSubject==0  && $cout_subject>=1){

  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_end_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);

}elseif($numg>1 && $timestamp2 <= $timestamp1 && $total_range_time >= $force_hour && $modHour ==0 && $modSubject!=0  && $cout_subject<=0){
  
  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_end_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}
elseif($numg>1 && $timestamp3 <= $timestamp1 && $total_range_time >0){
//ถ้าจำนวนรายวิชายังไม่ครบชั่วโมง 
if($modHour !=0 && $modSubject!=0){
  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$newtime,$st_end_timex,$timeto4,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}elseif($numg>1 && $force_hour>=$total_range_time){
 $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$total_range_time,$st_end_timex,$timeto3,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}

}elseif($numg>1 &&  $timestamp2 <= $timestamp1 &&  $modHour !=0 && $modSubject!=0){
  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$newtime,$st_start_timex,$timeto5,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}
///เริ่มรายวิชาใหม่
elseif(($numg>1 && $modHour ==0 && $modSubject==0) || ($numg>1 &&  $timestamp2 <= $timestamp1 &&  $modSubject!=0)){
  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_end_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}
elseif($numg>1 && $timestamp2 <= $timestamp1){
  $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_end_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
}

// elseif($cout_subject<=0){
//   $subject_data_list->add_subject_theory($subject_data_id,$vehicle_type_id,$force_hour,$st_start_timex,$timeto2,$date_success,$trainer_id,$school_id,$st_code,$crt_by,$crt_date);
// }
  

//  echo $st_hour;


    }  
    // echo "<script>";
    // echo "location.href = '?option=permission-theory-subjetct&school=$school_id&a=$modSubject&b=$sumtotal&c=$sumtotal2'";
    // echo "</script>";
    echo "<script>";
    echo "location.href = '?option=permission-theory-subjetct&school=$school_id&setsubject=$vehicle_type_id&topic'";
    echo "</script>";

}


// กำหนดอบรมทฤษฎีแบบขั้นสูง
if(isset($_POST['ADDsubject_data_id']) && !empty($_POST['ADDsubject_data_id']) && isset($_POST['st_hour']) && !empty($_POST['st_hour']) && isset($_POST['st_start_time']) &&
isset($_POST['st_end_time']) && isset($_POST['trainer_id']) && !empty($_POST['st_date']) && isset($_POST['st_date'])) {
$count=count($_POST['ADDsubject_data_id']);
$table="tbl_subject_theory";
$option= $_POST['option'];
$crt_by=$_SESSION['userSession'];
$crt_date=date("Y-m-d H:i:s");

  for($i=0;$i<=$count;$i++){
$subject_data_id = $_POST['ADDsubject_data_id'][$i];
$st_date = $_POST['st_date'][$i];
$arraySt_date = explode(",",$st_date); 
$countSt_date = count($arraySt_date);
$st_hour= $_POST['st_hour'][$i];
$st_start_time= $_POST['st_start_time'][$i];
$st_end_time= $_POST['st_end_time'][$i];
$trainer_id= $_POST['trainer_id'][$i];
$Caltime=TimeDiff("$st_start_time","$st_end_time"); //คำนวนหาระยะเวลาว่าตรงกันกับชั่วโมงรายวิชาที่กำหนดหรือไม่

if($Caltime == $st_hour){


    for($x=0;$x<=$countSt_date;$x++){
  // $date_success = $arraySt_date[$x];//วันที่กำหนดอบรม
$st_date2=DatetoYMD($arraySt_date[$x]);
$fields = [
'subject_data_id' => $subject_data_id,
'vehicle_type_id' => $vehicle_type_id,
'st_hour' => $st_hour,
'st_start_time' => $st_start_time,
'st_end_time' => $st_end_time,
'st_date' => $st_date2,
'trainer_id' => $trainer_id,
'school_id' => $school_id,
'st_code' => $st_code,
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

echo "<script>";
    echo "location.href = '?option=$option&success'";
    echo "</script>";
        } //Close for
}else{
  ///ถ้า SET ชุดนี้ไม่สมบุณณ์ซักข้อให้ลบทิ้งทั้งหมด
  $sql_process->fastQuery("DELETE FROM tbl_subject_theory  WHERE st_code='$st_code'");
  $qs=time();
     echo "<script>";
    echo "location.href = '?option=$option&qs=$qs&vehicle_type=$vehicle_type_id&error'";
    echo "</script>";
    // echo "<center>".$Caltime."-".$st_hour."</center>";

} //Close if


    }  //Close for


  }


///แก้ไข
if(isset($_POST['s_update'])) {
  $st_id = strip_tags($_POST['st_id']);
  $st_hour = strip_tags($_POST['st_hour']);
  $st_start_time = strip_tags($_POST['st_start_time']);
  $st_end_time = strip_tags($_POST['st_end_time']);
  $st_date = strip_tags($_POST['st_date']);
  $trainer_id = strip_tags($_POST['trainer_id']);
  $option= $_POST['option'];

  $table  = 'tbl_subject_theory';
$st_date=DatetoYMD($st_date);
$upd_by=$_SESSION['userSession'];

$total_range_timeZ=TimeDiff("$st_start_time","$st_end_time");
if($total_range_timeZ==$st_hour){
// $subject_data_list->update_subject_theory($st_id,$st_hour,$st_start_time,$st_end_time,$date_success,$upd_by);
$fields = [
    'st_id' => $st_id,
    'st_hour' => $st_hour,
    'st_start_time' => $st_start_time,
    'st_end_time' => $st_end_time,
    'st_date' => $st_date,
    'upd_by' => $upd_by
];
$Where=['st_id' => $st_id];
try {

  /*
   * Have used the word 'object' as I could not see the actual 
   * class name.
   */
  $sql_process->update($table, $fields,$Where);

}catch(ErrorException $exception) {

   $exception->getMessage();  // Should be handled with a proper error message.

}
    echo "<script>";
    echo "location.href = '?option=$option&success'";
    echo "</script>";

  }else{
    echo "<script>";
    echo "location.href = '?option=$option&error'";
    echo "</script>";
  }
}

////ลบ
if(isset($_GET['Del'])){

  $st_id = strip_tags($_GET['Del']);
  $school_id = strip_tags($_GET['school']);
  // $sql_process->fastQuery("DELETE FROM tbl_subject_theory  WHERE st_id='$st_id'");
  $sql_process->fastQuery("UPDATE tbl_subject_theory SET is_delete='0'   WHERE st_id='$st_id'");
  echo "<script>";
  echo "location.href = '?option=permission-theory-subjetct&school=$school_id&success'";
  echo "</script>";
}

if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
if(isset($_GET['error'])){
  echo "<script>";
  echo 'swal("Error !", "ระบุข้อมูลไม่ถุกต้อง กรุณาทำรายการใหม่ !", "error")';
  echo "</script>";
}