<?php
$table="tbl_exam_schedule";
$table2="tbl_exam_schedule_trainer";
 if(isset($_POST['type_study_id']) && isset($_POST['esd_start_time']) && isset($_POST['esd_end_time']) &&
 isset($_POST['esd_date'])   && isset($_POST['btn-submit-add'])) {
    $esd_id = strip_tags($_POST['esd_id']); 
    $esd_code = strip_tags($_POST['esd_code']); 
    $type_study_id = strip_tags($_POST['type_study_id']); 
    $esd_start_time = strip_tags($_POST['esd_start_time']);
    $esd_end_time = strip_tags($_POST['esd_end_time']);
    $esd_date = DatetoYMD($_POST['esd_date']);
    $esd_time_total=TimeDiff("$esd_start_time","$esd_end_time"); //คำนวนหาระยะเวลาว่าตรงกันกับชั่วโมงรายวิชาที่กำหนดหรือไม่
    $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
    $countX=count($_POST['trainer_id']);
    // $school_id = strip_tags($_POST['school_id']);
    $upd_by=$_SESSION['userSession'];

  ///ลบข้อมูลเก่าทิ้งและเพิ่มใหม่
$sql_process->fastQuery("DELETE FROM tbl_exam_schedule_trainer WHERE esd_code='$esd_code'");

  $fields = [
    'type_study_id' => $type_study_id,
    'esd_start_time' => $esd_start_time,
    'esd_end_time' => $esd_end_time,
    'esd_time_total' => $esd_time_total,
    'esd_date' => $esd_date,
    'vehicle_type_id' => $vehicle_type_id,
    'school_id' => $school_id,
    'upd_by' => $upd_by
];
$Where=['esd_code' => $esd_code];
try {

    /*
     * Have used the word 'object' as I could not see the actual 
     * class name.
     */
  $sql_process->update($table, $fields,$Where);
  
  }catch(ErrorException $exception) {
  
     $exception->getMessage();  // Should be handled with a proper error message.
  
  }

  for($x=0;$x<$countX;$x++){
    //   เพิ่มครู
    $trainer_id=$_POST['trainer_id'][$x];
    $fields2 = [
      'trainer_id' => $trainer_id,
      'type_study_id' => $type_study_id,
      'vehicle_type_id' => $vehicle_type_id,
      'esd_code' => $esd_code,
      'school_id' => $school_id
  ];
  try {
  
      /*
       * Have used the word 'object' as I could not see the actual 
       * class name.
       */
      $sql_process->insert($table2, $fields2);
    
    }catch(ErrorException $exception) {
    
       $exception->getMessage();  // Should be handled with a proper error message.
    
    }

    }
    echo "<script>";
    echo "location.href = '?option=permission-Date-edit&pdid=$esd_id&success'";
    echo "</script>";

}

if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}

$esd_id_POST = $_GET['pdid'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_exam_schedule WHERE esd_id=:esd_id_param AND school_id=:school_id_param");
$stmt->execute(array(":esd_id_param"=>$esd_id_POST,":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$esd_date = isset($_POST['esd_date']) ? $_POST['esd_date'] : DatetoDMY($dataRow['esd_date']); 
$type_study_id = isset($_POST['type_study_id']) ? $_POST['type_study_id'] : $dataRow['type_study_id']; 
$esd_start_time = isset($_POST['esd_start_time']) ? $_POST['esd_start_time'] : $dataRow['esd_start_time']; 
$esd_end_time = isset($_POST['esd_end_time']) ? $_POST['esd_end_time'] : $dataRow['esd_end_time']; 
$vehicle_type_id = isset($_POST['school_id']) ? $_POST['vehicle_type_id'] : $dataRow['vehicle_type_id']; 
$school_id = isset($_POST['school_id']) ? $_POST['school_id'] : $dataRow['school_id']; 
?>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนหลักสูตร
    <small>จัดการข้อมูลทะเบียนหลักสูตร</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=MS6KUDQC770FJQF">กำหนดตารางสอบใบอนุญาตขับขี่</a></li>
  <li class="active">แก้ไขตารางสอบใบอนุญาตขับขี่</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">กำหนดตารางสอบใบอนุญาตขับขี่</h3>
              
            </div>
            <div class="box-body">
            <form method="post"  id="form_add" name="form_add">
            <input type="hidden" name="esd_id" id="esd_id" value="<?=$esd_id_POST?>" >
            <input type="hidden" name="esd_code" id="esd_code" value="<?=$dataRow['esd_code']?>" >
            <div class="row">
            <div class="col-xs-12">
                  <label>วันที่</label> <label style="color:red;">*</label>
                  <input type="text" name="esd_date"  value="<?=$esd_date?>"  class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepicker" required  placeholder="คลิ๊กเพื่อแสดงปฏิทิน">
                  <!-- <input type="text" class="form-control" name="income_text" id="income_text" required placeholder="กรอกรายได้"> -->
                </div>    
                <div class="col-xs-12">
                <label>ปรเภทการเรียน</label> <label style="color:red;">*</label>
                   <select class="form-control" name="type_study_id"  >
                   <?php
                 $qa = $sql_process->runQuery(
                 "SELECT
                 tbl_master_type_study.type_study_id,
                 tbl_master_type_study.type_study_name
                 FROM
                 tbl_master_type_study
                 WHERE
                 tbl_master_type_study.type_study_status='1' AND
                 tbl_master_type_study.is_delete='1'
                 ORDER BY
                 tbl_master_type_study.type_study_id  ASC");
                 $qa->execute();
                 while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowA->type_study_id'>$rowA->type_study_name</option>";
                 echo"<option value='$rowA->type_study_id'";
                 if ($type_study_id == $rowA->type_study_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowA->type_study_name</option>\n";
                 }
                 ?>           
                    </select>
                </div>

                   <div class="col-xs-6">
                  <label for="exampleInputEmail1">เวลาเริ่ม</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="esd_start_time" id="esd_start_time" value="<?=$esd_start_time?>" required placeholder="เวลาเริ่ม">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">เวลาสิ้นสุด</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="esd_end_time" id="esd_end_time"  value="<?=$esd_end_time?>"  required placeholder="เวลาสิ้นสุด">
                </div>  

                 <div class="col-xs-6">
                   <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type_id" id="vehicle_type_id" >
                   <?php
                 $qa2= $sql_process->runQuery(
                 "SELECT
                 tbl_master_vehicle_type.vehicle_type_id,
                 tbl_master_vehicle_type.vehicle_type_name
                 FROM
                 tbl_master_vehicle_type
                 WHERE
                 tbl_master_vehicle_type.vehicle_type_status='1' AND
                 tbl_master_vehicle_type.is_delete='1'
                 ORDER BY
                 tbl_master_vehicle_type.vehicle_type_id  ASC");
                 $qa2->execute();
                 while($rowB= $qa2->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
                 echo"<option value='$rowB->vehicle_type_id'";
                 if ($vehicle_type_id == $rowB->vehicle_type_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowB->vehicle_type_name</option>\n";
                 }
                 ?>           
                    </select>
                </div> 
              
                <div class="col-xs-12">

                   <label>ผู้ดำเนินการ </label>
                   <select   <select class="form-control select2" multiple="multiple" name="trainer_id[]" style="width: 100%;">>
                  <?php

$stm= $sql_process->runQuery(
    "SELECT
     tbl_trainer_data.trainer_id,
     tbl_trainer_data.trainer_firstname_th,
     tbl_trainer_data.trainer_lastname_th
     FROM
     tbl_trainer_data 
     WHERE 
     tbl_trainer_data.is_delete='1'  AND
     tbl_trainer_data.trainer_status='1'  AND
     school_id='$school_id' 
     ORDER BY
     trainer_id");
    $stm->execute();
    while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
        $stmt2 = $qGeneral->runQuery("SELECT * FROM tbl_exam_schedule_trainer WHERE trainer_id=:trainer_id_param AND esd_code=:esd_code_param AND school_id=:school_id_param");
        $stmt2->execute(array(":trainer_id_param"=>$rs->trainer_id,":esd_code_param"=>$dataRow['esd_code'],":school_id_param"=>$school_id));
        $dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);

    //  echo "<option value='$rs->trainer_id' SELECTED>$rs->trainer_firstname_th $rs->trainer_lastname_th </option>";   
    echo "<option value='$rs->trainer_id'";
    if ($dataRow2['trainer_id'] == $rs->trainer_id)
    {
      echo "SELECTED";
    }
    echo ">$rs->trainer_firstname_th $rs->trainer_lastname_th</option>\n";
    }
    ?>

                 </select>
                 </div>  
               
               
                <div class="col-xs-12">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button></center>
                </div>    
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


</section>
<!-- /.content -->
</div>