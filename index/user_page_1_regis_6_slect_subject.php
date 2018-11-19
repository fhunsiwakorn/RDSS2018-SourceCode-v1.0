
<?php
$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.course_data_id,
tbl_register_temp.rst_temp_code,
tbl_course_data.course_data_name,
tbl_course_data.course_data_theory_hour
FROM
tbl_register_temp,
tbl_course_data
WHERE
tbl_register_temp.course_data_id=tbl_course_data.course_data_id AND
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param AND
tbl_register_temp.ip_pc=:ip_pc_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id,":ip_pc_param"=>$ipaddress));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร
$rst_temp_date_calendar=$dataRow["rst_temp_date_calendar"];
$course_data_theory_hour=$dataRow["course_data_theory_hour"];

require ("user_page_1_regis_6_slect_subject_logChk.php");

// if(isset($_GET['success'])){
//     echo "<script>";
//     echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
//     echo "</script>";
// }


      

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
      <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 6 : ตารางอบรมภาคทฤษฏี</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">   
    <div class="col-xs-12">
        <center>
        <h4>หลักสูตร :<span style="color:#3F48CC;"><?=$dataRow["course_data_name"]?></span>
        </h4>
        </center>

    </div>
    <div class="col-xs-12">
<!-- <label>เรียนภาคทฤษฏี (อบรม)</label> -->
    <form method="post" id="form_add_sub"  name="form_add_sub" >
    <input type="hidden" name="rst_temp_code" value="<?=$dataRow['rst_temp_code']?>"/>
    <input type="hidden" name="type_one" />
    <table id="example5" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>รหัสวิชา</th>
        <th>ชื่อรายวิชา</th>
        <th>ประเภทวิชา</th>
        <th>ระยะเวลา (ช.ม.)</th>
        <th>วันเวลาที่เลือก</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_subject_in_course.subject_data_id,
tbl_subject_data.subject_data_code,
tbl_subject_data.subject_data_name,
tbl_subject_in_course.time_study,
tbl_master_type_study.type_study_name
FROM
tbl_subject_in_course ,
tbl_subject_data ,
tbl_master_type_study
WHERE
tbl_subject_in_course.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_in_course.course_data_id =:course_data_id_param AND
tbl_subject_data.type_study_id ='1' AND
tbl_subject_data.is_delete='1'

ORDER BY
tbl_subject_in_course.subject_in_course_id ASC
");
// $qg->execute();
$qg->execute(array(":course_data_id_param"=>$dataRow['course_data_id']));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;


?>
      <tr>
 <td align="center">
<?=$num_gen?>

</td>
        <td><?=$rowGen->subject_data_code?> </td>
        <td><?=$rowGen->subject_data_name?></td>
        <td align="center" ><?=$rowGen->type_study_name?></td>
        <td align="center" ><?=$rowGen->time_study?></td>
        <td>
        <select name="st_id[]" id="st_id" class="form-control" required style="width: 100%;">
       <option value="">--เลือกวัน--</option>
       <?php
       $n=0;

//        $stmt2 = $qGeneral->runQuery("SELECT rmcs_start_date,rmcs_date_end FROM tbl_register_temp_class_schedule WHERE rst_temp_code=:rst_temp_code_param");
//        $stmt2->execute(array(":rst_temp_code_param"=>$rst_temp_code));
//        $dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
// $rmcs_start_datex=$dataRow2['rmcs_start_date'];
// $rmcs_date_endx=$dataRow2['rmcs_date_end'];
$month_tho=date("m");
$year_tho=date("Y");
     $qa1 = $sql_process->runQuery(
     "SELECT
      tbl_subject_theory.st_id,
     tbl_subject_theory.subject_data_id,
     tbl_subject_theory.vehicle_type_id,
     tbl_subject_theory.st_hour,
     tbl_subject_theory.st_start_time,
     tbl_subject_theory.st_end_time,
     tbl_subject_theory.st_date,
     tbl_subject_theory.is_delete,
     tbl_subject_theory.crt_by,
     tbl_subject_theory.crt_date,
     tbl_subject_theory.upd_by,
     tbl_subject_theory.upd_date,
     tbl_subject_theory.st_id
     FROM
     tbl_subject_theory
     WHERE 
     tbl_subject_theory.subject_data_id=:subject_data_id_param AND
     tbl_subject_theory.school_id=:school_id_param
     HAVING
     MONTH(tbl_subject_theory.st_date) >= '$month_tho' AND YEAR(tbl_subject_theory.st_date) >= '$year_tho'
     ORDER BY
     tbl_subject_theory.st_date ASC
     ");
     $qa1->execute(array(":subject_data_id_param"=>$rowGen->subject_data_id,":school_id_param"=>$school_id));
      while($rowA= $qa1->fetch(PDO::FETCH_OBJ)) {
       $n++;
$date_date_start="$rowA->st_date $rowA->st_start_time";
$date_date_end="$rowA->st_date $rowA->st_end_time";

       echo '<option value="'.$rowA->st_id.'">';
       echo DateThai($rowA->st_date)."&nbsp;".$rowA->st_start_time."-".$rowA->st_end_time;
       echo "</option>";

      //  echo"<option value='$rowA->st_id'";
      //  if ($rmcs_start_datex == $date_date_start && $rmcs_date_endx==$date_date_end)
      //  {
      //    echo "SELECTED";
      //  }
      //  echo ">";
      //  echo  DateThai($rowA->st_date)."&nbsp;".$rowA->st_start_time."-".$rowA->st_end_time;
      //  echo "</option>\n";
        ?>
       
      <?php } ?>  

  </select>
        </td>     
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
         <th>ลำดับ</th>
        <th>รหัสวิชา</th>
        <th>ชื่อรายวิชา</th>
        <th>ประเภทวิชา</th>
        <th>ระยะเวลา (ช.ม.)</th>
        <th>วันเวลาที่เลือก</th>
      </tr>
      </tfoot>
    </table>

      <div class="col-xs-12">
<label ></label>     
<br>
<center>
<button type="button"   class="btn btn-success" data-toggle="modal" data-target="#modal-default">ตารางสำหรับอบรมวันเดียว</button>
<button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกตารางเรียนภาคทฤษฏี</button></center>
</div>  
    </form>
</div>

<div class="col-xs-12">
<br><hr>
<label>
<span style="color:#424ef4;">
ตารางเรียนภาคทฤษฏีที่ได้เลือกแล้ว
</span>
</label>
<div class="box-body table-responsive no-padding">
<table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ลำดับ</th>
                  <th>รหัสวิชา</th>
                  <th>ชื่อรายวิชา</th>
                  <th >ประเภทวิชา</th>
                  <th >ระยะเวลา(ช.ม.)</th>
                  <th >วันที่</th>
                  <th >ครูฝึก</th>
                </tr>
                <?php
$num_gen2='0';
$qgz= $sql_process->runQuery(
"SELECT
tbl_register_temp_class_schedule.rmcs_id,
tbl_register_temp_class_schedule.subject_data_id,
tbl_register_temp_class_schedule.rmcs_start_date,
tbl_register_temp_class_schedule.rmcs_date_end,
tbl_register_temp_class_schedule.rmcs_hour,
tbl_register_temp_class_schedule.crt_by,
tbl_register_temp_class_schedule.crt_date,
tbl_register_temp_class_schedule.upd_by,
tbl_register_temp_class_schedule.upd_date,
tbl_register_temp_class_schedule.num_code,
tbl_register_temp_class_schedule.rst_temp_code,
tbl_subject_data.subject_data_name,
tbl_subject_data.subject_data_code,
tbl_master_type_study.type_study_name,
tbl_master_vehicle_type.vehicle_type_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th
FROM
tbl_register_temp_class_schedule ,
tbl_subject_data ,
tbl_master_type_study ,
tbl_master_vehicle_type ,
tbl_trainer_data
WHERE
tbl_register_temp_class_schedule.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_register_temp_class_schedule.trainer_id = tbl_trainer_data.trainer_id AND
tbl_register_temp_class_schedule.rst_temp_code=:rst_temp_code_param  AND
tbl_register_temp_class_schedule.type_study_id='1'  AND
tbl_subject_data.is_delete='1'

ORDER BY
tbl_register_temp_class_schedule.rmcs_start_date ASC

");
// $qg->execute();
$qgz->execute(array(":rst_temp_code_param"=>$rst_temp_code));
while($rowGen2= $qgz->fetch(PDO::FETCH_OBJ)) {
$num_gen2++;

?>
                <tr>
                  <td><?=$num_gen2?></td>
                  <td><?=$rowGen2->subject_data_code?> </td>
                  <td><?=$rowGen2->subject_data_name?> </td>
                  <td><?=$rowGen2->type_study_name?></td>
                  <td align="center"><?=$rowGen2->rmcs_hour?></td>
                  <td><?php echo DateThai_2($rowGen2->rmcs_start_date);?> ถึง <?php echo DateThai_2($rowGen2->rmcs_date_end);?></td>        
                  <td><?=$rowGen2->trainer_firstname_th?> <?=$rowGen2->trainer_lastname_th?></td>
                </tr>
<?php } ?>
              </table>
              </div>

<div class="col-xs-12">
<?php 
$total_data =$sql_process->rowsQuery("SELECT tbl_register_temp_class_schedule.rst_temp_code FROM tbl_register_temp_class_schedule WHERE tbl_register_temp_class_schedule.rst_temp_code ='$rst_temp_code' AND tbl_register_temp_class_schedule.type_study_id='1'");
?>
<br><br>
<button type="button" class="btn btn-success btn-block" <?php if($total_data<=0){echo "disabled";}?> onclick="window.location.href='?option=main&cst=<?=$rst_temp_code?>&setstep=7'">ขั้นตอนถัดไป</button>
<br><br>
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


 <!--MODAL  -->
 
 <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ตารางสำหรับอบรมวันเดียว  </h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <input type="hidden" name="rst_temp_code" value="<?=$dataRow['rst_temp_code']?>"/>
              <input type="hidden" name="type_two" />
              <div class="modal-body">          
              <div class="form-group">
        
<!-- <label>ตารางสำหรับอบรมวันเดียว</label> -->

<select multiple  class="form-control" style="width: 100%;" name="st_date" id="st_date" >
<?php
// $course_data_theory_hour;
$qa7 = $sql_process->runQuery(
"SELECT  
tbl_subject_theory.st_date
FROM
tbl_subject_theory,
tbl_subject_in_course
WHERE
tbl_subject_theory.school_id = :school_id_param AND
tbl_subject_in_course.subject_data_id = tbl_subject_theory.subject_data_id AND
tbl_subject_theory.is_delete = '1' AND
tbl_subject_in_course.course_data_id =:course_data_id_param 
GROUP BY
tbl_subject_theory.st_date

HAVING
MONTH(tbl_subject_theory.st_date) >= '$month_tho' AND YEAR(tbl_subject_theory.st_date) >= '$year_tho'
-- HAVING
-- Sum(tbl_subject_theory.st_hour)>='$course_data_theory_hour'

ORDER BY
tbl_subject_theory.st_date ASC
");
// $qa7->execute();
$qa7->execute(array(":school_id_param"=>$school_id,":course_data_id_param"=>$dataRow['course_data_id']));
while($rowH= $qa7->fetch(PDO::FETCH_OBJ)) {
  $row_num++;
$format_date=DateThai($rowH->st_date);

$stmt44 = $sql_process->runQuery("SELECT SUM(tbl_subject_theory.st_hour) AS st_hour FROM tbl_subject_theory,tbl_subject_in_course WHERE 
tbl_subject_theory.st_date=:st_date AND tbl_subject_in_course.subject_data_id = tbl_subject_theory.subject_data_id AND
tbl_subject_theory.is_delete = '1' AND tbl_subject_in_course.course_data_id =:course_data_id_param 
");
$stmt44->execute(array(":st_date"=>$rowH->st_date,":course_data_id_param"=>$dataRow['course_data_id']));
$dataRow44=$stmt44->fetch(PDO::FETCH_ASSOC);

if($dataRow44['st_hour'] >= $course_data_theory_hour){
  echo"<option value='$rowH->st_date'";
  echo ">$row_num.) "; 
  echo $format_date;
  echo "</option>\n";
}else{
  break;
}
 

}
                 ?>
                 
                    </select>
</div>
                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button>
              </div>
              </form>
              </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
 
     <!--END-MODAL  -->