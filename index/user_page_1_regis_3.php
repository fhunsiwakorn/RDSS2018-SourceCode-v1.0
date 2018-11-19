
<?php

$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_date_calendar,
tbl_course_data.course_data_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_register_temp.rst_temp_code,
tbl_register_temp.vegicle_data_id,
tbl_register_temp.course_data_id
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
$course_data_id=$dataRow["course_data_id"];
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}

if(isset($_POST['vegicle_data_id_post']) && !empty($_POST['vegicle_data_id_post']))
{
  $vegicle_data_id = strip_tags($_POST['vegicle_data_id_post']);
  //ตรวจสอบว่ามีการเพิ่มตารางเรียนมากกว่า 1 หรือไม่
  $total_data =$sql_process->rowsQuery("SELECT tbl_register_temp_class_schedule.rst_temp_code FROM tbl_register_temp_class_schedule WHERE tbl_register_temp_class_schedule.rst_temp_code='$rst_temp_code' AND tbl_register_temp_class_schedule.type_study_id='2'");
  $total_data2 =$sql_process->rowsQuery("SELECT tbl_register_temp_student.rst_temp_code FROM tbl_register_temp_student WHERE tbl_register_temp_student.rst_temp_code='$rst_temp_code'");
  if($total_data >='1'){
    $rst_temp_date_calendar =$dataRow["rst_temp_date_calendar"] ;
 
    // $ipaddress อยู่ที่หน้า index.php
    $page_step='4';
    $sql_process->fastQuery("UPDATE tbl_register_temp SET vegicle_data_id='$vegicle_data_id' , page_step='$page_step'  WHERE rst_temp_code='$rst_temp_code'");
    if($total_data2<=0){
      ///เพิ่มได้เพียงแถวเดียว
      // $regis_tmp_list->add_regis_tmp_student($rst_temp_code);
       $sql_process->fastQuery("INSERT INTO tbl_register_temp_student(rst_temp_code) VALUES ('$rst_temp_code') ");
    }
    echo "<script>";
    echo "location.href = '?option=main'";
    echo "</script>";
      // echo "<script>";
      // echo "location.href = '?option=regis-step-4&sccode=$rst_temp_code'";
      // echo "</script>";
 }else{
  echo "<script>";
  echo 'swal("Error !", "กรุณาทำรายการเลือกช่วงเวลาเรียน ก่อนจะทำรายการถัดไป !", "error")';
  echo "</script>";
 }
      
}
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
      <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 3</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
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

<div class="col-xs-12">
<nav aria-label="...">
  <ul class="pager">
    <li class="previous"><a href="?option=?option=main&cst=<?=$rst_temp_code?>&setstep=2"><span aria-hidden="true">&larr;</span> ขั้นตอนก่อนหน้านี้</a></li>
    <!-- <li class="next"><a href="?option=?option=main&Chkstep4">ขั้นตอนถัดไป <span aria-hidden="true">&rarr;</span></a></li> -->
    <script>
    $(function() {
      $("#refresh").click(function(evt) {
         $("#randomdiv").load("user_page_1_regis_3_1.php?school_id=<?=$school_id?>&register_code=<?=$rst_temp_code_get?>&vegicle_data_id=<?=$dataRow['vegicle_data_id']?>")
         evt.preventDefault();
      })
    })
</script>

    <li class="next"><a href="#"  id="refresh" data-toggle="modal" data-target="#modal-default">ขั้นตอนถัดไป <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav>
</div>
<!-- <div class="col-xs-6">
     <button type="button"  class="btn btn-warning btn-block btn-flat" onclick="window.location.href='?option=regis-step-2&sccode=<?=$rst_temp_code?>'" ><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i> ขั้นตอนก่อนหน้านี้</button>
     </div>
     <div class="col-xs-6">
     <button type="button" name="btn-submit-add" onclick="window.location.href='?option=regis-step-3&sccode=<?=$rst_temp_code?>&Chkstep4'"  class="btn btn-primary btn-block btn-flat">ขั้นตอนถัดไป <i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></button>
     </div> -->
<div class="col-xs-12">
<iframe  style="width:100%; height:550px ;  border:thin; background-color:#fff" src="user_page_1_regis_3_calendar.php?rst_temp_code=<?=$rst_temp_code?>"></iframe>
</div>

<div class="col-xs-12">
<label style="color:red;">  รายวิชาที่จะต้องเรียน  </label>
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
$qg2 = $sql_process->runQuery(
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
tbl_course_data.course_data_id = :course_data_id_param AND
tbl_subject_data.type_study_id = '2' AND  
tbl_subject_in_course.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_in_course.course_data_id = tbl_course_data.course_data_id AND
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id  
ORDER BY
tbl_subject_in_course.subject_in_course_id ASC

");

$qg2->execute(array(":course_data_id_param"=>$course_data_id));
while($rowGen= $qg2->fetch(PDO::FETCH_OBJ)) {
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

<div class="modal fade" id="modal-default">
<div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เลือกยานพาหนะ (ระบบค้นหารถอัตโนมัติ)</h4>
              </div>
              <div class="modal-body">
           
<!-- <a id="refresh" href="#">click</a> -->

      
             <form method="post" name="add_vegicle_data" id="add_vegicle_data">
             <div id='randomdiv'>  
             
    </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
              </div>
              </form>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
