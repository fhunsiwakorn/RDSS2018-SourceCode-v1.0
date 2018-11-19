
<?php
$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.trainer_id,
tbl_course_data.course_data_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_register_temp.rst_temp_code
FROM
tbl_register_temp ,
tbl_course_data ,
tbl_trainer_data
WHERE
tbl_register_temp.course_data_id = tbl_course_data.course_data_id AND
tbl_register_temp.trainer_id = tbl_trainer_data.trainer_id AND
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param AND
tbl_register_temp.ip_pc=:ip_pc_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id,":ip_pc_param"=>$ipaddress));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร

//สำหรับอัพเดทตาม Dropdown เดือน/ปี
if(isset($_POST['rst_temp_code']))
{
     // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
    // $branch_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
 
  $day_regis = date("d");
  $month_regis = strip_tags($_POST['month_regis']);
  $year_regis = strip_tags($_POST['year_regis']);
  $rst_temp_code = strip_tags($_POST['rst_temp_code']);
  // $ipaddress อยู่ที่หน้า index.php
  $rst_temp_date_calendar="$year_regis-$month_regis-$day_regis";
  $page_step=2; //ขั้นตอนที่ 2

  $table  = 'tbl_register_temp';
  $fields = [
      'rst_temp_date_calendar' => $rst_temp_date_calendar,
      'page_step' => $page_step
  ];
  $Where=['rst_temp_code' => $rst_temp_code];
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
echo "location.href = '?option=main'";
echo "</script>";
    // echo "<script>";
    // echo "location.href = '?option=regis-step-2&sccode=$rst_temp_code'";
    // echo "</script>";
      
}
//สำหรับอัพเดทตาม ปฏิทิน
if(isset($_GET['setdate']))
{
     // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
    // $branch_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
  $rst_temp_code = strip_tags($_GET['sccode']);
  $rst_temp_date_calendar = strip_tags($_GET['setdate']);
  // $ipaddress อยู่ที่หน้า index.php
  $page_step=3; //ขั้นตอนที่ 3
  $table  = 'tbl_register_temp';
  $fields = [
    'rst_temp_date_calendar' => $rst_temp_date_calendar,
    'page_step' => $page_step
  ];
  $Where=['rst_temp_code' => $rst_temp_code];
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
echo "location.href = '?option=main'";
echo "</script>";
    // echo "<script>";
    // echo "location.href = '?option=regis-step-3&sccode=$rst_temp_code'";
    // echo "</script>";
      
}
 
// if(isset($_GET['success'])){
//     echo "<script>";
//     echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
//     echo "</script>";
// }

$today=date("d");
$thismonth=date("m");
$thisyear=date("Y");
$thisfullday=date("Y-m-d");
//วันที่จาก tbl_register_temp สำหรับแสดงปฏิทิน
$arraydate = explode("-",$dataRow["rst_temp_date_calendar"]);
$year_explode= $arraydate[0];//ปี
$month_explode= $arraydate[1];//เดือน
?>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    สมัครเรียน
    <!-- <small>แสดงรายงานข้อมูลเบื้องต้น</small> -->
  </h1>
  <ol class="breadcrumb">
  <?php require ("user_page_1_step.php"); ?>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 2</h3>

      <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
<!-- ปรับเปลี่ยนวันปฏิทิน -->
<form method="post" >
<input type="hidden" name="rst_temp_code" id="rst_temp_code" value="<?=$rst_temp_code?>"/>
    <div class="col-xs-6">  
<!-- <label >เดือน</label> <label style="color:red;">*</label>          -->
<select name="month_regis" id="month_regis" class="form-control" required onchange="submit();">
  <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม");?>
  <?php for($i=0; $i<sizeof($month); $i++) {
   $i2=$i+1;
// echo '<option value="'.$i2.'">'.$month[$i].'</option>';

echo"<option value='$i2'";
if ($month_explode == $i2)
{
  echo "SELECTED";
}
echo ">$month[$i]</option>\n";
    }
  ?>
</select>
     </div>

 <div class="col-xs-6">
<!-- <label >ปี</label> <label style="color:red;">*</label>          -->
<select name="year_regis" id="year_regis" class="form-control" required onchange="submit();">
<option value="" >--เลือกปี--</option>
<?php
for($i=2014;$i<=2050;$i++){
$i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
$yt=$i2+543; //ปีไทย
// echo '<option value="'.$i2.'">'.$yt.'</option>';
echo"<option value='$i2'";
if ($year_explode == $i2)
{
  echo "SELECTED";
}
echo ">$yt</option>\n";

  }
  ?>
</select>
     </div>
     </form>


      </div>
    </div>
    <div class="box-body">
    <div class="row">   
    <div class="col-xs-12">
    <b>
    หลักสูตร : <?=$dataRow["course_data_name"]?> ครูฝึก : <?=$dataRow["trainer_firstname_th"]?> <?=$dataRow["trainer_lastname_th"]?>
    </b>
    </div>
    <div class="col-xs-12">
    <?php include ("table_detail_color.html"); ?>

</div>

<div class="col-xs-9">

<?php
$weekDay = array( 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสฯ', 'ศุกร์', 'เสาร์');
$thaiMon = array( "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน",
      "05" => "พฤษภาคม","06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม",
      "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
//Sun - Sat
// $month = isset($_GET['month']) ? $_GET['month'] : date('m'); //ถ้าส่งค่าเดือนมาใช้ค่าที่ส่งมา ถ้าไม่ส่งมาด้วย ใช้เดือนปัจจุบัน
// $year = isset($_GET['year']) ? $_GET['year'] : date('Y'); //ถ้าส่งค่าปีมาใช้ค่าที่ส่งมา ถ้าไม่ส่งมาด้วย ใช้ปีปัจจุบัน
$month=$month_explode;
$year=$year_explode;

//วันที่
$startDay = $year.'-'.$month."-01";   //วันที่เริ่มต้นของเดือน

$timeDate = strtotime($startDay);   //เปลี่ยนวันที่เป็น timestamp
$lastDay = date("t", $timeDate);   //จำนวนวันของเดือน

$endDay = $year.'-'.$month."-". $lastDay;  //วันที่สุดท้ายของเดือน

$startPoint = date('w', $timeDate);   //จุดเริ่มต้น วันในสัปดาห์

//echo "<br>\$data ";
//print_r($data);
//echo "<hr>";
//echo "<br/>ตำแหน่งของวันที่ $startDay คือ <strong>", $startPoint , " (ตรงกับ วัน" , $weekDay[$startPoint].")</strong>";

$title = "เดือน $thaiMon[$month] <strong>". $startDay. " : ". $endDay."</strong>";
// echo $title;
//ลดเวลาลง 1 เดือน
$prevMonTime = strtotime ( '-1 month' , $timeDate  );
$prevMon = date('m', $prevMonTime);
$prevYear = date('Y', $prevMonTime);
//เพิ่มเวลาขึ้น 1 เดือน
$nextMonTime = strtotime ( '+1 month' , $timeDate  );
$nextMon = date('m', $nextMonTime);
$nextYear = date('Y', $nextMonTime);

echo '<div id="main">';
// echo '<div id="nav">
//   <button class="navLeft" onclick="goTo(\''.$prevMon.'\', \''.$prevYear.'\');"><< เดือนที่แล้ว</button>
//   <div class="title">'.$title.'</div>
//   <button class="navRight" onclick="goTo(\''.$nextMon.'\', \''.$nextYear.'\');">เดือนต่อไป >></button>
//  </div>
//  <div style="clear:both"></div>';
echo "<table id='tb_calendar'  class='table table-bordered'>"; //เปิดตาราง
echo "<tr align='center' style='font-size:18px;'>
  <td><b>อาทิตย์</b></td><td><b>จันทร์</b></td><td><b>อังคาร</b></td><td><b>พุธ</b></td>
  <td><b>พฤหัสฯ</b></td><td><b>ศุกร์</b></td><td><b>เสาร์</b></td>
</tr>";
echo "<tr  style='width:70px; height:120px'>";    //เปิดแถวใหม่


$col = $startPoint;          //ให้นับลำดับคอลัมน์จาก ตำแหน่งของ วันในสับดาห์ 
if($startPoint < 7){         //ถ้าวันอาทิตย์จะเป็น 7
 echo str_repeat("<td> </td>", $startPoint); //สร้างคอลัมน์เปล่า กรณี วันแรกของเดือนไม่ใช่วันอาทิตย์
}

for($i=1; $i <= $lastDay; $i++){ //วนลูป ตั้งแต่วันที่ 1 ถึงวันสุดท้ายของเดือน
  $day_format=sprintf("%02d", $i); //โชว์ 00
 $col++;       //นับจำนวนคอลัมน์ เพื่อนำไปเช็กว่าครบ 7 คอลัมน์รึยัง
 $sday=$year."-".$month."-".$day_format;  //ปี เดือน วัน ที่จะส่งค่าไป
if($sday==$thisfullday){
  $colordaypresent="bgcolor='#F8E2E9'";
}else{
  $colordaypresent="bgcolor='#FFFFFF'";
}
// onMouseOver=this.bgColor='#F39C12' onMouseOut=this.bgColor='#FFFFFF'
 echo "<td align='center' $colordaypresent style='width:75px; height:120px;' >";  //สร้างคอลัมน์ แสดงวันที่ 
 echo "<span style='font-size:30px'>";
 echo "<button type='button' class='btn btn-warning'  onclick=\"window.location.href='?option=main&sccode=$rst_temp_code&setdate=$sday'\" >";
 echo $day_format;
 echo "</button>";
 echo "</span>";
echo "<br>";
// echo "<button type='button' class='btn btn-warning'  onclick=\"window.location.href='?option=main&sccode=$rst_temp_code&Vr=$sday'\" >";
// echo "แสดง";
// echo "</button>";
echo "<br>";
echo "<div  data-toggle='tooltip' style='cursor: pointer;' title='คลิ๊กเพื่อดูรายละเอียดทั้งหมด' onclick=\"window.location.href='?option=main&sccode=$rst_temp_code&Vr=$sday'\">";
$qgqwq = $sql_process->runQuery(
  "SELECT
  tbl_register_main_class_schedule.rmcs_start_date,
  tbl_register_main_class_schedule.rmcs_date_end,
  tbl_register_main_class_schedule.rmcs_hour
  FROM
  tbl_register_main_class_schedule
  WHERE
  tbl_register_main_class_schedule.school_id = :school_id_param AND
  tbl_register_main_class_schedule.trainer_id =:trainer_id_param AND
  tbl_register_main_class_schedule.type_study_id = '2' 
  HAVING
  DATE(tbl_register_main_class_schedule.rmcs_start_date) ='$sday' AND DATE(tbl_register_main_class_schedule.rmcs_date_end)='$sday'
  ORDER BY
  tbl_register_main_class_schedule.rmcs_id ASC
  limit 3
  ");
  // $qgqwr->execute();
  $qgqwq->execute(array(":school_id_param"=>$school_id,":trainer_id_param"=>$dataRow["trainer_id"]));
  while($rowTeaQ= $qgqwq->fetch(PDO::FETCH_OBJ)) {
     echo '<small class="label label-success"  style="width:100%"><i class="fa fa-clock-o"></i> ';
    echo DateTimetotime($rowTeaQ->rmcs_start_date)."-".DateTimetotime($rowTeaQ->rmcs_date_end);
     echo "</small><br>";
  }
echo "</div>";
//  echo "<br>"."$sday";
 echo "</td>";
 if($col % 7 == false){   //ถ้าครบ 7 คอลัมน์ให้ขึ้นบรรทัดใหม่
  echo "</tr><tr>";   //ปิดแถวเดิม และขึ้นแถวใหม่
  $col = 0;     //เริ่มตัวนับคอลัมน์ใหม่
 }
}
if($col < 7){         // ถ้ายังไม่ครบ7 วัน
 echo str_repeat("<td> </td>", 7-$col); //สร้างคอลัมน์ให้ครบตามจำนวนที่ขาด
}
echo '</tr>';  //ปิดแถวสุดท้าย
echo '</table>'; //ปิดตาราง
echo '</div>';

?>
</div>

<div class="col-xs-3">
<div style="height:700px;width:100%;border:solid 2px orange;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
<table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>ช่วงเวลา</th>
                 </tr> 
                 <?php
 if(isset($_GET['Vr'])){
   $fulldate2=$_GET['Vr'];
   $state="DATE(tbl_register_main_class_schedule.rmcs_start_date) ='$fulldate2'";
 }else{
  $state="MONTH(tbl_register_main_class_schedule.rmcs_start_date) = '$month_explode' AND YEAR(tbl_register_main_class_schedule.rmcs_date_end) = '$year_explode'";
 }
$num_gen2='0';
$qgqwr = $sql_process->runQuery(
"SELECT
tbl_register_main_class_schedule.rmcs_id,
tbl_register_main_class_schedule.vehicle_type_id,
tbl_register_main_class_schedule.type_study_id,
tbl_register_main_class_schedule.trainer_id,
tbl_register_main_class_schedule.rmcs_start_date,
tbl_register_main_class_schedule.rmcs_date_end,
tbl_register_main_class_schedule.rmcs_hour
FROM
tbl_register_main_class_schedule
WHERE
tbl_register_main_class_schedule.school_id = :school_id_param AND
tbl_register_main_class_schedule.trainer_id =:trainer_id_param AND
tbl_register_main_class_schedule.type_study_id = '2' AND
$state

ORDER BY
tbl_register_main_class_schedule.rmcs_id ASC
");
// $qgqwr->execute();
$qgqwr->execute(array(":school_id_param"=>$school_id,":trainer_id_param"=>$dataRow["trainer_id"]));
while($rowTea= $qgqwr->fetch(PDO::FETCH_OBJ)) {
$num_gen2++;
$arraydate2 = explode(" ",$rowTea->rmcs_start_date);
$senddate= $arraydate2[0];//ปี
?>
                  <tr>
                  <td><?=$num_gen2?></td>
                  <td>
                  <!-- <a href='?option=<?=$_GET["option"]?>&setdate=<?=$senddate?>&t=<?=$dataRow["trainer_id"]?>&sccode=<?=$rst_temp_code?>'>   -->
                  <?php echo DateThai_2($rowTea->rmcs_start_date)?> -  <?php echo DateThai_2($rowTea->rmcs_date_end)?> 
                  <!-- </a> -->
                  </td>
                </tr>
<?php } ?>
              </table>
              </div>
 </div>


<br>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
</div>
