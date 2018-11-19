<?php


$course_data_id_get = $_GET['cue'];	
$stmt = $sql_process->runQuery("SELECT
tbl_course_data.course_data_name,
tbl_course_data.course_data_theory_hour,
tbl_course_data.course_data_practice_hour,
tbl_course_data.course_data_total_hour,
tbl_course_group.course_group_name,
tbl_course_data.course_group_id,
tbl_course_data.vehicle_type_id,
tbl_master_vehicle_type.vehicle_type_name,
tbl_course_data.school_id,
tbl_school.school_name
FROM
tbl_course_data ,
tbl_course_group ,
tbl_master_vehicle_type ,
tbl_school
WHERE
tbl_course_data.course_data_id = :course_data_id_param AND
tbl_course_data.course_group_id = tbl_course_group.course_group_id AND
tbl_course_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_course_data.school_id = tbl_school.school_id
");
$stmt->execute(array(":course_data_id_param"=>$course_data_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

///ลบรายวิชาในหลักสูตร
if(isset($_GET['set'])){
  $course_data_id=$_GET['cue'];
  $school_id=$_GET['school'];
  $sql_process->fastQuery("DELETE FROM tbl_subject_in_course WHERE course_data_id='$course_data_id' AND school_id='$school_id'");

   //  SET =0 เพื่อแสดงการลบรายวิชาในหลักสูตรหรือเริ่มกำหนดใหม่
//  $course_success='0';
 $sql_process->fastQuery("UPDATE tbl_course_data SET course_success='0'   WHERE course_data_id='$course_data_id'");
  echo "<script>";
  echo "location.href = '?option=course-data&success'";
  echo "</script>";
}
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
  <li><a href="?option=course-data">ทะเบียนหลักสูตร</a></li>
  <li class="active">รายละเอียดหลักสูตร</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">รายละเอียดหลักสูตร  <?=$dataRow["course_data_name"]?> :: <?=$dataRow["school_name"]?></h3><br>
      <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
          <button type="button" OnClick="move()"  class="btn btn-danger" data-toggle="tooltip" title="ลบวิชาเรียนในหลักสูตร ระบบจะทำการรีเซตหลักสูตรใหม่ และดำเนินการกำหนดรายวิชาใหม่อีกครั้ง">
          ลบวิชาเรียนในหลักสูตร
        </button> 
           <!-- สำหรับกำหนดรายวิชาบังคับกรม -->
           <script>
                        function move() {
                          swal({
                            title: "ยืนยันกาลบวิชาเรียนในหลักสูตร <?=$dataRow["course_data_name"]?>",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ใช่!",
                            cancelButtonText: "ไม่ใช่!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                          },
                          function(isConfirm){
                            if (isConfirm) {
                              // swal("บันทึกข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                            location.href = '?option=course-data-detail&cue=<?=$course_data_id_get?>&school=<?=$dataRow["school_id"]?>&set';
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
               </script>
      </div>
      </div>
    <div class="box-body">
   <label for="">  ภาคทฤษฎี <?=$dataRow["course_data_theory_hour"]?> ชั่วโมง ภาคปฎิบัติ <?=$dataRow["course_data_practice_hour"]?> ชั่วโมง รวมเป็น <?=$dataRow["course_data_total_hour"]?> ชั่วโมง  ประเภทหลักสูตร <?=$dataRow["vehicle_type_name"]?></label>
    <br><br>
    <table id="example5" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>รหัสวิชา </th>
        <th>รายวิชา</th>
        <th>ประเภทรายวิชา</th>
        <th>ชั่วโมงเรียน</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $qGeneral->runQuery(
"SELECT
tbl_subject_in_course.subject_in_course_id,
tbl_subject_in_course.subject_data_id,
tbl_subject_in_course.course_data_id,
tbl_subject_in_course.time_study,
tbl_subject_in_course.school_id,
tbl_subject_data.subject_data_id,
tbl_subject_data.subject_data_name,
tbl_course_data.course_data_id,
tbl_course_data.course_data_name,
tbl_subject_data.subject_data_code,
tbl_master_type_study.type_study_name
FROM
tbl_subject_in_course ,
tbl_subject_data ,
tbl_course_data ,
tbl_master_type_study
WHERE
tbl_course_data.course_data_id = :course_data_id_param2 AND
tbl_subject_in_course.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_in_course.course_data_id = tbl_course_data.course_data_id AND
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id
ORDER BY
tbl_subject_in_course.subject_in_course_id ASC

");

$qg->execute(array(":course_data_id_param2"=>$course_data_id_get));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>

 <tr>
        <td><?=$rowGen->subject_data_code?></td>
        <td><?=$rowGen->subject_data_name?></td>
        <td><?=$rowGen->type_study_name?></td>
        <td align="center" >
        <?=$rowGen->time_study?>
          </td>
      </tr>

<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>รหัสวิชา </th>
      <th>รายวิชา</th>
      <th>ประเภทรายวิชา</th>
      <th>ชั่วโมงเรียน</th>
      </tr>
      </tfoot>
    </table>

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
