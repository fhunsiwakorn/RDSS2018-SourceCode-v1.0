
<?php
$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $qGeneral->runQuery("SELECT
tbl_register_temp.rst_temp_id,
tbl_register_temp.rst_temp_code,
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.vehicle_type_id,
tbl_register_temp.course_group_id,
tbl_register_temp.course_data_id,
tbl_register_temp.trainer_id,
tbl_register_temp.branch_id,
tbl_register_temp.school_id,
tbl_register_temp.transportation_id,
tbl_course_data.course_data_name,
tbl_register_temp.rst_temp_code
FROM
tbl_register_temp ,
tbl_course_data
WHERE
tbl_register_temp.course_data_id = tbl_course_data.course_data_id AND
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param AND
tbl_register_temp.ip_pc=:ip_pc_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id,":ip_pc_param"=>$ipaddress));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร

$today=date("d");
$thismonth=date("m");
$thisyear=date("Y");
//วันที่จาก tbl_register_temp สำหรับแสดงปฏิทิน
$arraydate = explode("-",$dataRow["rst_temp_date_calendar"]);
$year_explode= $arraydate[0];//ปี
$month_explode= $arraydate[1];//เดือน

//UPDATE
if(isset($_POST['btn-submit-add']))
{
     // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
    // $branch_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
  $rst_temp_code = strip_tags($_POST['rst_temp_code']);
  $day_regis = date("d");
  $month_regis = strip_tags($_POST['month_regis']);
  $year_regis = strip_tags($_POST['year_regis']);
  $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
  $course_group_id = strip_tags($_POST['course_group_id']);
  $course_data_id = strip_tags($_POST['course_data_id']);

    // error_reporting(E_ALL & ~E_NOTICE);
    $arrayid = explode(".",$course_group_id);
    $id_1 = $arrayid[0];// course_group_id
    $id_2 = $arrayid[1];// vehicle_type_id
    $id_3 = $arrayid[1];// course_group_subject_auto

  $trainer_id = isset($_POST['trainer_id']) ? $_POST['trainer_id'] : false; 
  $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : false; 
  $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : false; 
  // $ipaddress อยู่ที่หน้า index.php
  $rst_temp_date_calendar="$year_regis-$month_regis-$day_regis";
  $page_step=2; //ขั้นตอนที่ 2
  // $regis_tmp_list->update_regis_tmp_1($rst_temp_code,$day_format,$vehicle_type_id,$course_group_id,$course_data_id,$trainer_id);
  
  $table  = 'tbl_register_temp';
  $fields = [
    'rst_temp_date_calendar' => $rst_temp_date_calendar,
    'vehicle_type_id' => $vehicle_type_id,
    'course_group_id' => $id_1,
    'course_data_id' => $course_data_id,
    'trainer_id' => $trainer_id,
    'start_time' => $start_time,
    'end_time' => $end_time,
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
$sql_process->fastQuery("DELETE FROM tbl_register_temp_class_schedule  WHERE rst_temp_code='$rst_temp_code' AND type_study_id='2'");
// $sql_process->fastQuery("UPDATE tbl_course_data SET course_success='1'   WHERE course_data_id='$course_data_id' AND school_id='$school_id'");
$sql_process->fastQuery("UPDATE tbl_register_temp SET vegicle_data_id='0'   WHERE rst_temp_code='$rst_temp_code'");
echo "<script>";
echo "location.href = '?option=main'";
echo "</script>";
  
  // echo "<script>";
  //   echo "location.href = '?option=regis-step-2&sccode=$rst_temp_code'";
  //   echo "</script>";
      
}
?>
<script language=Javascript>
         function Inint_AJAX() {
            try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
            try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
            try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
            alert("XMLHttpRequest not supported");
            return null;
         };

         function dochange(src, val) {
              var req = Inint_AJAX();
              req.onreadystatechange = function () {
                   if (req.readyState==4) {
                        if (req.status==200) {
                             document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
                        }
                   }
              };
              req.open("GET", "../library/for_register_step1.php?school_id=<?=$school_id?>&vehicle_type_id=<?=$dataRow["vehicle_type_id"]?>&course_group_id=<?=$dataRow["course_group_id"]?>&course_data_id=<?=$dataRow["course_data_id"]?>&data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         window.onLoad=dochange('select_trnORtime', -1);
         window.onLoad=dochange('vehicle_type_id', <?=$dataRow["vehicle_type_id"]?>);
         window.onLoad=dochange('course_group_id', <?=$dataRow["course_group_id"]?>);
         window.onLoad=dochange('course_data_id', <?=$dataRow["course_data_id"]?>);
     </script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    สมัครเรียน
    <!-- <small>แสดงรายงานข้อมูลเบื้องต้น</small> -->
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <!-- <li><a href="?option=main"><i class="glyphicon glyphicon-pushpin"></i> ขั้นตอนที่ 1</a></li> -->
  <li class="active">ขั้นตอนที่ 1</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

 
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 1</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">
    <form method="post">

    <input type="hidden" name="rst_temp_code" id="rst_temp_code" value="<?=$rst_temp_code?>"/>
    <div class="col-xs-4">
<label >ประเภทรถ</label> <label style="color:red;">*</label>         
<span id="vehicle_type_id">
<select class="form-control" required >
<option value="" >- ประเภทรถ -</option>
</select>
</span>
     </div>

     <div class="col-xs-4">
<label >กลุ่มหลักสูตร</label> <label style="color:red;">*</label>         
<span id="course_group_id">
<select class="form-control" required >
<option value="" >- กลุ่มหลักสูตร -</option>
</select>
</span>
     </div>

     <div class="col-xs-4">
<label >เลือกหลักสูตร</label> <label style="color:red;">*</label>         
<span id="course_data_id">
<select class="form-control" required >
<option value="" >- เลือกหลักสูตร -</option>
</select>
</span>
     </div>
  

<div class="col-xs-2">
<label >เดือน</label> <label style="color:red;">*</label>         
<select name="month_regis" id="month_regis" class="form-control" required >
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

 <div class="col-xs-2">
<label >ปี</label> <label style="color:red;">*</label>         
<select name="year_regis" id="year_regis" class="form-control" required >
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

     <div class="col-xs-4">
<label >ช่วงเวลาหรือครู</label> <label style="color:red;">*</label>         
<span id="select_trnORtime">
<select class="form-control" required >
<option value="" >- เลือกช่วงเวลาหรือครู -</option>
</select>
</span>
     </div>

     <span id="setType"> 
     <div class="col-xs-4"> 
     <label >#</label> <label style="color:red;">*</label> 
     <select class="form-control" required >
<option value="" >- ---- -</option>
</select>
</div>
     </span>
    
     <div class="col-xs-12">
     <br><hr><br>
     <button type="submit" name="btn-submit-add" class="btn btn-primary btn-block btn-flat">ขั้นตอนถัดไป <i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></button>
     </div>
     </form>

<div class="col-xs-12">

<?php
 //echo "<iframe  style='width:100%; height:1000px ;  border:thin; background-color:#fff' src='user_page_1_calendar.php'></iframe>";
?>
</div>
</div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      ...
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
</div>
