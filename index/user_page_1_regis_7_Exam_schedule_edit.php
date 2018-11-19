
<?php

$table="tbl_register_temp_exam_schedule";
$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.vehicle_type_id,
tbl_register_temp.course_data_id,
tbl_register_temp.transportation_id,
tbl_register_temp.rst_temp_code
FROM
tbl_register_temp 
WHERE
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param AND
tbl_register_temp.ip_pc=:ip_pc_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id,":ip_pc_param"=>$ipaddress));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร
$rst_temp_date_calendar=$dataRow["rst_temp_date_calendar"];
$transportation_id=$dataRow['transportation_id'];
///ลบข้อมูลเก่าทิ้งและเพิ่มใหม่
 if(isset($_POST['rst_temp_code']) && isset($_POST['btn-submit'])) {
    $rst_temp_code = strip_tags($_POST['rst_temp_code']);
    ///ลบข้อมูลเก่าทิ้งและเพิ่มใหม่
    $sql_process->fastQuery("DELETE FROM tbl_register_temp_exam_schedule  WHERE rst_temp_code='$rst_temp_code'");

// บันทึก สำนักงานขนส่งจังหวัด
$transportation_id2 = strip_tags($_POST['transportation_id']);
$sql_process->fastQuery("UPDATE  tbl_register_temp SET transportation_id='$transportation_id2' WHERE rst_temp_code='$rst_temp_code'");

}
// ภาคทฤษฎี
if(isset($_POST['esd_id']) && isset($_POST['btn-submit'])) {
 
  $count=count($_POST['esd_id']);
     // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
     $page_step='8';
     $rst_temp_code = strip_tags($_POST['rst_temp_code']);
     $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$page_step'   WHERE rst_temp_code='$rst_temp_code'");
 
 

//คำสั่งหา type_study_id
for($i=0;$i<$count;$i++){
    $esd_id=$_POST['esd_id'][$i];
$stmta = $sql_process->runQuery("SELECT type_study_id FROM tbl_exam_schedule WHERE esd_id=:esd_id_param");
$stmta->execute(array(":esd_id_param"=>$esd_id));
$dataRowA=$stmta->fetch(PDO::FETCH_ASSOC);
$type_study_id=$dataRowA['type_study_id'];

$fields = [
  'esd_id' => $esd_id,
  'type_study_id' => $type_study_id,
  'school_id' => $school_id,
  'rst_temp_code' => $rst_temp_code
];

try {

  /*
   * Have used the word 'object' as I could not see the actual 
   * class name.
   */
  $sql_process->insert($table,$fields);

}catch(ErrorException $exception) {

   $exception->getMessage();  // Should be handled with a proper error message.

}



} 
   
  }

// ภาคปฏิบัติ
if(isset($_POST['esd_idx']) && isset($_POST['btn-submit'])) {
 
    $countx=count($_POST['esd_idx']);
       // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
       $page_step='8';
       $rst_temp_code = strip_tags($_POST['rst_temp_code']);
       $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$page_step'   WHERE rst_temp_code='$rst_temp_code'");
   
  
  //คำสั่งหา type_study_id
  for($x=0;$x<$countx;$x++){
      $esd_idx=$_POST['esd_idx'][$x];
  $stmtb = $sql_process->runQuery("SELECT type_study_id FROM tbl_exam_schedule WHERE esd_id=:esd_id_param");
  $stmtb->execute(array(":esd_id_param"=>$esd_idx));
  $dataRowB=$stmtb->fetch(PDO::FETCH_ASSOC);
  $type_study_idx=$dataRowB['type_study_id'];
  
  $fields = [
    'esd_id' => $esd_idx,
    'type_study_id' => $type_study_idx,
    'school_id' => $school_id,
    'rst_temp_code' => $rst_temp_code
];

try {

    /*
     * Have used the word 'object' as I could not see the actual 
     * class name.
     */
    $sql_process->insert($table,$fields);

}catch(ErrorException $exception) {

     $exception->getMessage();  // Should be handled with a proper error message.

}

  
  } 
     
    }

    if(isset($_POST['btn-submit'])){
        // ภาคทฤษฎี
            $total_data1 =$sql_process->rowsQuery("SELECT tbl_register_temp_exam_schedule.rtes_id FROM tbl_register_temp_exam_schedule WHERE tbl_register_temp_exam_schedule.type_study_id = '1' AND tbl_register_temp_exam_schedule.rst_temp_code ='$rst_temp_code'");
        // ภาคปฏิบัติ
            $total_data2 =$sql_process->rowsQuery("SELECT tbl_register_temp_exam_schedule.rtes_id FROM tbl_register_temp_exam_schedule WHERE tbl_register_temp_exam_schedule.type_study_id = '2' AND tbl_register_temp_exam_schedule.rst_temp_code ='$rst_temp_code'");
        
        if($total_data1 <=0){
            echo "<script>";
            echo 'swal("กำหนดตารางสอบ ภาคทฤษฎี และ ภาคปฏิบัติ ให้ครบถ้วน !", "ปิดหน้าต่างนี้ !", "error")';
            echo "</script>";
        }elseif($total_data2<=0 ){
           echo "<script>";
            echo 'swal("กำหนดตารางสอบ ภาคทฤษฎี และ ภาคปฏิบัติ ให้ครบถ้วน !", "ปิดหน้าต่างนี้ !", "error")';
            echo "</script>";
        }else{
            // echo "<script>";
            // echo "location.href = '?option=regis-step-8&sccode=$rst_temp_code'";
            // echo "</script>";
            echo "<script>";
            echo "location.href = '?option=main'";
            echo "</script>";
        }
     
            
        
        }
        
////คิวรี่วันที่ที่ได้เลือกไปแล้ว
// ภาคทฤษฎี
$stmtt = $sql_process->runQuery("SELECT
tbl_exam_schedule.esd_date
FROM
tbl_register_temp_exam_schedule ,
tbl_exam_schedule
WHERE
tbl_register_temp_exam_schedule.esd_id = tbl_exam_schedule.esd_id AND
tbl_register_temp_exam_schedule.rst_temp_code = :rst_temp_code_param AND
tbl_register_temp_exam_schedule.type_study_id = '1' AND
tbl_register_temp_exam_schedule.school_id = '$school_id'
");

$stmtt->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRowt=$stmtt->fetch(PDO::FETCH_ASSOC);
$convert = $dataRowt['esd_date'];   //รูปแบบการเก็บค่าข้อมูลวันเกิด (19/03/1993)
$arrayconvert = explode("-",$convert); 
$yearA = $arrayconvert[0];//วัน
$monthA = $arrayconvert[1];//เดือน
$dayA = $arrayconvert[2];//ปี       

// ภาคปฏิบัติ
$stmtu = $sql_process->runQuery("SELECT
tbl_exam_schedule.esd_date
FROM
tbl_register_temp_exam_schedule ,
tbl_exam_schedule
WHERE
tbl_register_temp_exam_schedule.esd_id = tbl_exam_schedule.esd_id AND
tbl_register_temp_exam_schedule.rst_temp_code = :rst_temp_code_param AND
tbl_register_temp_exam_schedule.type_study_id = '2' AND
tbl_register_temp_exam_schedule.school_id = '$school_id'
");

$stmtu->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRowu=$stmtu->fetch(PDO::FETCH_ASSOC);
$convertx = $dataRowu['esd_date'];   //รูปแบบการเก็บค่าข้อมูลวันเกิด (19/03/1993)
$arrayconvertx = explode("-",$convertx); 
$yearB = $arrayconvertx[0];//วัน
$monthB = $arrayconvertx[1];//เดือน
$dayB = $arrayconvertx[2];//ปี    


$year_search1 = isset($_POST['year_search1']) ? $_POST['year_search1'] : $yearA;
$month_search1 = isset($_POST['month_search1']) ? $_POST['month_search1'] : $monthA;   
$year_search2 = isset($_POST['year_search2']) ? $_POST['year_search2'] : $yearB;
$month_search2 = isset($_POST['month_search2']) ? $_POST['month_search2'] : $monthB ;    

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
<form method="post" id="form1"  name="form1" >
<input type="hidden" name="rst_temp_code" value="<?=$dataRow['rst_temp_code']?>"/>
<div class="row">
 
<div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 7 : กำหนดตารางสอบ</h3>

              
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12">   
            <center>
              
            <h4>ประเภทหลักสูตร :
<span style="color:#3F48CC;">
<?php
$stmt2 = $sql_process->runQuery("SELECT vehicle_type_name FROM tbl_master_vehicle_type WHERE vehicle_type_id=:vehicle_type_id_param");
$stmt2->execute(array(":vehicle_type_id_param"=>$dataRow['vehicle_type_id']));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
echo $dataRow2["vehicle_type_name"];
?>

</span>

        </h4>
            </center>
        </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


<!-- ภาคทฤษฎี -->
<div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">เลือกวันสอบ : ภาคทฤษฎี</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        
              <div class="form-group">  
<label >เดือน</label> <label style="color:red;">*</label>         
<select   name="month_search1" id="month_search1"   class="form-control select2" required onchange="submit();">
  <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม");?>
  <?php for($i=0; $i<sizeof($month); $i++) {
   $i2=$i+1;
// echo '<option value="'.$i2.'">'.$month[$i].'</option>';

echo"<option value='$i2'";
if ($month_search1 == $i2)
{
  echo "SELECTED";
}
echo ">$month[$i]</option>\n";
    }
  ?>
</select>
     </div>

 <div class="form-group">
<label >ปี</label> <label style="color:red;">*</label>         
<select name="year_search1" id="year_search1"  class="form-control select2" required onchange="submit();">
<option value="" >--เลือกปี--</option>
<?php
for($i=2014;$i<=2050;$i++){
$i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
$yt=$i2+543; //ปีไทย
// echo '<option value="'.$i2.'">'.$yt.'</option>';
echo"<option value='$i2'";
if ($year_search1 == $i2)
{
  echo "SELECTED";
}
echo ">$yt</option>\n";

  }
  ?>
</select>
     </div>

       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->


<div class="col-md-8">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดตารางสอบ : ภาคทฤษฎี</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">   

    <div class="col-xs-12">


    <table  class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>วันที่</th>
        <th>จำนวนผู้เข้าสอบ</th>
        <th>เวลา</th>
        <th>เลือก</th>
      </tr>
      </thead>
      <tbody>
      <?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_exam_schedule.esd_id,
tbl_exam_schedule.type_study_id,
tbl_exam_schedule.esd_start_time,
tbl_exam_schedule.esd_end_time,
tbl_exam_schedule.esd_time_total,
tbl_exam_schedule.esd_date,
tbl_exam_schedule.vehicle_type_id,
tbl_exam_schedule.esd_code,
tbl_exam_schedule.school_id,
tbl_exam_schedule.crt_by,
tbl_exam_schedule.crt_date,
tbl_exam_schedule.upd_by,
tbl_exam_schedule.upd_date,
tbl_exam_schedule.is_delete,
tbl_master_type_study.type_study_name,
tbl_school.school_name,
tbl_master_vehicle_type.vehicle_type_name
FROM
tbl_exam_schedule ,
tbl_master_type_study ,
tbl_school , 
tbl_master_vehicle_type 
WHERE
tbl_exam_schedule.type_study_id = tbl_master_type_study.type_study_id AND
tbl_exam_schedule.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_exam_schedule.school_id = tbl_school.school_id AND
MONTH(tbl_exam_schedule.esd_date) = '$month_search1' AND
YEAR(tbl_exam_schedule.esd_date) = '$year_search1' AND
tbl_exam_schedule.school_id =:school_id_param AND
tbl_exam_schedule.type_study_id ='1'
ORDER BY
tbl_exam_schedule.esd_date DESC

");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;

$stmtf = $sql_process->runQuery("SELECT tbl_register_temp_exam_schedule.esd_id FROM tbl_register_temp_exam_schedule WHERE tbl_register_temp_exam_schedule.type_study_id='1' AND tbl_register_temp_exam_schedule.rst_temp_code=:rst_temp_code_param");
$stmtf->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRowf=$stmtf->fetch(PDO::FETCH_ASSOC);
?>

      <tr>
 <td align="center">
<?=$num_gen?>
</td>
        <td><?php echo DateThai($rowGen->esd_date);?> </td>
        <td align="center" ></td>
        <td align="center" ><?=$rowGen->esd_start_time?> - <?=$rowGen->esd_end_time?></td>
        <td align="center">
        <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="esd_id[]" id="esd_id<?=$num_gen?>" value="<?=$rowGen->esd_id?>" <?php if($dataRowf['esd_id'] ==$rowGen->esd_id){ echo "checked";} ?>>
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
               
            </label>
        </div>
        </td>     
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th>
        <th>วันที่</th>
        <th>จำนวนผู้เข้าสอบ</th>
        <th>เวลา</th>
        <th>เลือก</th>
      </tr>
      </tfoot>
    </table> 
   
</div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      ...
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
</div>
</div>


<!-- ปฏิบัติ -->
<div class="col-md-12"></div>

<div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">เลือกวันสอบ : ภาคปฏิบัติ</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">
      
              <div class="form-group">  
<label >เดือน</label> <label style="color:red;">*</label>         
<select   name="month_search2" id="month_search2"   class="form-control select2" required onchange="submit();">
  <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม");?>
  <?php for($i=0; $i<sizeof($month); $i++) {
   $i2=$i+1;
// echo '<option value="'.$i2.'">'.$month[$i].'</option>';

echo"<option value='$i2'";
if ($month_search2 == $i2)
{
  echo "SELECTED";
}
echo ">$month[$i]</option>\n";
    }
  ?>
</select>
     </div>

 <div class="form-group">
<label >ปี</label> <label style="color:red;">*</label>         
<select name="year_search2" id="year_search2"  class="form-control select2" required onchange="submit();">
<option value="" >--เลือกปี--</option>
<?php
for($i=2014;$i<=2050;$i++){
$i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
$yt=$i2+543; //ปีไทย
// echo '<option value="'.$i2.'">'.$yt.'</option>';
echo"<option value='$i2'";
if ($year_search2 == $i2)
{
  echo "SELECTED";
}
echo ">$yt</option>\n";

  }
  ?>
</select>
     </div>
       
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->


<div class="col-md-8">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดตารางสอบ : ภาคปฏิบัติ</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">   

    <div class="col-xs-12">

    
    <table  class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ลำดับ</th> 
        <th>วันที่</th>
        <th>จำนวนผู้เข้าสอบ</th>
        <th>เวลา</th>
        <th>เลือก</th>
      </tr>
      </thead>
      <tbody>
      <?php
$num_genx='0';
$qgx = $sql_process->runQuery(
"SELECT
tbl_exam_schedule.esd_id,
tbl_exam_schedule.type_study_id,
tbl_exam_schedule.esd_start_time,
tbl_exam_schedule.esd_end_time,
tbl_exam_schedule.esd_time_total,
tbl_exam_schedule.esd_date,
tbl_exam_schedule.vehicle_type_id,
tbl_exam_schedule.esd_code,
tbl_exam_schedule.school_id,
tbl_exam_schedule.crt_by,
tbl_exam_schedule.crt_date,
tbl_exam_schedule.upd_by,
tbl_exam_schedule.upd_date,
tbl_exam_schedule.is_delete,
tbl_master_type_study.type_study_name,
tbl_school.school_name,
tbl_master_vehicle_type.vehicle_type_name
FROM
tbl_exam_schedule ,
tbl_master_type_study ,
tbl_school ,
tbl_master_vehicle_type 
WHERE
tbl_exam_schedule.type_study_id = tbl_master_type_study.type_study_id AND
tbl_exam_schedule.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_exam_schedule.school_id = tbl_school.school_id AND
MONTH(tbl_exam_schedule.esd_date) = '$month_search2' AND
YEAR(tbl_exam_schedule.esd_date) = '$year_search2' AND
tbl_exam_schedule.school_id =:school_id_param AND
tbl_exam_schedule.type_study_id ='2'
ORDER BY
tbl_exam_schedule.esd_date DESC

");
// $qg->execute();
$qgx->execute(array(":school_id_param"=>$school_id));
while($rowGenx= $qgx->fetch(PDO::FETCH_OBJ)) {
$num_genx++;

$stmtg = $sql_process->runQuery("SELECT tbl_register_temp_exam_schedule.esd_id FROM tbl_register_temp_exam_schedule WHERE tbl_register_temp_exam_schedule.type_study_id='2' AND tbl_register_temp_exam_schedule.rst_temp_code=:rst_temp_code_param");
$stmtg->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRowg=$stmtg->fetch(PDO::FETCH_ASSOC);

?>
      <tr>
 <td align="center">
<?=$num_genx?>
</td>
        <td><?php echo DateThai($rowGenx->esd_date);?> </td>
        <td align="center" ></td>
        <td align="center" ><?=$rowGenx->esd_start_time?> - <?=$rowGenx->esd_end_time?></td>
        <td align="center">
        <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="esd_idx[]" id="esd_idx<?=$num_genx?>" value="<?=$rowGenx->esd_id?>" <?php if($dataRowg['esd_id'] == $rowGenx->esd_id){ echo "checked";} ?>>
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
               
            </label> 
        </div>
        </td>     
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th>
        <th>วันที่</th>
        <th>จำนวนผู้เข้าสอบ</th>
        <th>เวลา</th>
        <th>เลือก</th>
      </tr>
      </tfoot>
    </table> 
</div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      ...
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
</div>
</div>



<div class="col-md-12">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">สำนักงานขนส่งจังหวัด</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    

    <div class="col-xs-12">



    </div>
    <!-- /.box-body -->
    <div class="box-footer">
     <label >เลือกสำนักงานขนส่งจังหวัด</label> <label style="color:red;">*</label>         
<select name="transportation_id" id="transportation_id" class="form-control select2" required >
 <option value="">-เลือกสำนักงานขนส่งจังหวัด-</option>
  <?php 
 

  $num_gen='0';
  $qg = $sql_process->runQuery(
  "SELECT
  tbl_dlt_data.transportation_id,
  tbl_dlt_data.transportation_office_id,
  tbl_dlt_data.transportation_office_name,
  tbl_dlt_data.province_id,
  tbl_dlt_data.amphur_id,
  tbl_dlt_data.crt_by,
  tbl_dlt_data.crt_date,
  tbl_dlt_data.upd_by,
  tbl_dlt_data.upd_date,
  tbl_dlt_data.trans_status,
  tbl_dlt_data.is_delete,
  tbl_location_province.province_name,
  tbl_location_amphur.amphur_name,
  tbl_user.user_firstname,
  tbl_user.user_lastname
  FROM
  tbl_dlt_data ,
  tbl_location_province ,
  tbl_location_amphur ,
  tbl_user
  WHERE
  tbl_dlt_data.province_id = tbl_location_province.province_id AND
  tbl_dlt_data.amphur_id = tbl_location_amphur.amphur_id AND
  tbl_dlt_data.crt_by = tbl_user.user_id AND
  tbl_dlt_data.is_delete='1'
  ORDER BY
  tbl_dlt_data.transportation_id DESC
  ");
  $qg->execute();
  while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
  $num_gen++;

echo"<option value='$rowGen->transportation_id'";
if ($transportation_id == $rowGen->transportation_id)
{
  echo "SELECTED";
}
echo ">$rowGen->transportation_office_name อำเภอ $rowGen->amphur_name จังหวัด $rowGen->province_name</option>\n";
    }
  ?>
</select>
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
</div>
</div>


<!-- ปิด form ทั้งหมด -->




 <div class="col-xs-12">
<button type="submit" name="btn-submit"  class="btn btn-success btn-block btn-flat">ขั้นตอนถัดไป</button>

 </div>
      


      
 </div>
 </form>
</section>
<!-- /.content -->
</div>


