<?php
if(isset($_POST['btn-submit-add']))
{
    $subject_data_id = strip_tags($_POST['subject_data_id']);
    $subject_data_code = strip_tags($_POST['subject_data_code']);
    $subject_data_name = strip_tags($_POST['subject_data_name']);
    $type_study_id = strip_tags($_POST['type_study_id']);
    $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
    $type_subject_id = strip_tags($_POST['type_subject_id']);
    $force_hour = strip_tags($_POST['force_hour']);
    $school_id = strip_tags($_POST['school_id']);
  $upd_by=$_SESSION['userSession'];
  $subject_data_status = strip_tags($_POST['subject_data_status']);


  $table  = 'tbl_subject_data';
  $fields = [
    'subject_data_code' => $subject_data_code,
    'subject_data_name' => $subject_data_name,
    'type_study_id' => $type_study_id,
    'vehicle_type_id' => $vehicle_type_id,
    'type_subject_id' => $type_subject_id,
    'force_hour' => $force_hour,
    'school_id' => $school_id,
    'subject_data_status' => $subject_data_status,
    'upd_by' => $upd_by
];
$Where=['subject_data_id' => $subject_data_id];
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
    echo "location.href = '?option=subject-data-edit&sue=$subject_data_id&success'";
    echo "</script>";

}
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
if(isset($_GET['error'])){
  echo "<script>";
  echo 'swal("Error !", "ชั่วโมงเวลาเกินหรือครบตามหลักสูตรแล้ว !", "error")';
  echo "</script>";
}
$subject_data_id_get = $_GET['sue'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_subject_data WHERE subject_data_id=:subject_data_id_param");
$stmt->execute(array(":subject_data_id_param"=>$subject_data_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
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
  <li><a href="?option=subject-data">ข้อมูลรายวิชา</a></li>
  <li class="active">แก้ไขรายวิชา</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">แก้ไขรายวิชา</h3>
              
            </div>
            <div class="box-body">
            <form method="post"  id="form_add" name="form_add">
            <input type="hidden" name="subject_data_id" id="subject_data_id" value="<?=$_GET['sue']?>" >
            <div class="row">
            <div class="col-xs-6">
            <label>ปรเภทการเรียน</label> <label style="color:red;">*</label>
            <select class="form-control" name="type_study_id"  >
            <?php
          $qa = $qGeneral->runQuery(
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
        //   echo "<option value='$rowA->type_study_id'>$rowA->type_study_name</option>";
          echo"<option value='$rowA->type_study_id'";
          if ($dataRow['type_study_id'] == $rowA->type_study_id)
          {
            echo "SELECTED";
          }
          echo ">$rowA->type_study_name</option>\n";
          }
          ?>           
             </select>
         </div> 
         <div class="col-xs-6">
            <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
            <select class="form-control" name="vehicle_type_id" id="vehicle_type_id" >
            <?php
          $qa2= $qGeneral->runQuery(
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
        // /  echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
          echo"<option value='$rowB->vehicle_type_id'";
          if ($dataRow['vehicle_type_id'] == $rowB->vehicle_type_id)
          {
            echo "SELECTED";
          }
          echo ">$rowB->vehicle_type_name</option>\n";
        }
          ?>           
             </select>
         </div> 
       <div class="col-xs-6">
           <label for="exampleInputEmail1">รหัสวิชา</label> <label style="color:red;">*</label>
         
           <input type="text" class="form-control" name="subject_data_code" id="subject_data_code" value="<?=$dataRow['subject_data_code']?>" required placeholder="กรอกรายวิชา">
         </div> 
         <div class="col-xs-6">
           <label for="exampleInputEmail1">รายวิชา</label> <label style="color:red;">*</label>
         
           <input type="text" class="form-control" name="subject_data_name" id="subject_data_name"  value="<?=$dataRow['subject_data_name']?>" required placeholder="กรอกชื่อรายวิชา">
         </div>  
         <div class="col-xs-6">

            <label>ประเภทรายวิชา</label> <label style="color:red;">*</label>
            <select class="form-control" name="type_subject_id"  >
            <?php
          $qaC = $qGeneral->runQuery(
          "SELECT
          tbl_master_type_subject.type_subject_id,
          tbl_master_type_subject.type_subject_name
          FROM
          tbl_master_type_subject
          WHERE
          tbl_master_type_subject.type_subject_status='1' AND
          tbl_master_type_subject.is_delete='1'
          ORDER BY
          tbl_master_type_subject.type_subject_id  ASC");
          $qaC->execute();
          while($rowC= $qaC->fetch(PDO::FETCH_OBJ)) {
         // echo "<option value='$rowC->type_subject_id'>$rowC->type_subject_name</option>";
          echo"<option value='$rowC->type_subject_id'";
          if ($dataRow['type_subject_id'] == $rowC->type_subject_id)
          {
            echo "SELECTED";
          }
          echo ">$rowC->type_subject_name</option>\n";
        }
          ?>
          
             </select>
         </div>  
     
         <div class="col-xs-6">
           <label for="exampleInputEmail1">ชั่วโมงเรียน </label> <label style="color:red;">*</label>
         
           <input autocomplete="off" maxlength="2" type="number" class="form-control" name="force_hour" id="force_hour"  value="<?=$dataRow['force_hour']?>" required >
         </div>
       
         <div class="col-xs-6">

            <label>โรงเรียน</label> 
            <!-- <label style="color:red;">*</label> -->
            <select class="form-control select2" style="width: 100%;" name="school_id" id="school_id" >
            <option value="0">-- วิชาพื้นฐานสำหรับทุกโรงเรียน --</option>
            <?php
          $qaD = $qGeneral->runQuery(
          "SELECT
          tbl_school.school_id,
          tbl_school.school_name
          FROM
          tbl_school
         WHERE  tbl_school.is_delete='1'
          ORDER BY
          tbl_school.school_id  ASC");
          $qaD->execute();
          while($rowD= $qaD->fetch(PDO::FETCH_OBJ)) {
        //   echo "<option value='$rowC->school_id'>$rowC->school_name</option>";
          echo"<option value='$rowD->school_id'";
          if ($dataRow['school_id'] == $rowD->school_id)
          {
            echo "SELECTED";
          }
          echo ">$rowD->school_name</option>\n";
          }
          ?>
          
             </select>
         </div>  
         <div class="col-xs-6">

            <label>สถานะการใช้งาน</label>
            <select name="subject_data_status" id="subject_data_status"  class="form-control">
            <option <?php if($dataRow['subject_data_status']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
            <option <?php if($dataRow['subject_data_status']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>

          </select>

         </div>  
               
                
                <div class="form-group">
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