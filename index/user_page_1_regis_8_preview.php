
<?php


$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt= $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_id,
tbl_register_temp.rst_temp_code,
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.vehicle_type_id,
tbl_register_temp.course_group_id,
tbl_register_temp.course_data_id,
tbl_register_temp.trainer_id,
tbl_register_temp.vegicle_data_id,
tbl_register_temp.branch_id,
tbl_register_temp.school_id,
tbl_register_temp.transportation_id,
tbl_register_temp.ip_pc,
tbl_register_temp.page_step,
tbl_register_temp.crt_by,
tbl_register_temp.crt_date,
tbl_register_temp.upd_date,
tbl_master_vehicle_type.vehicle_type_name,
tbl_course_group.course_group_name,
tbl_course_data.course_data_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_register_temp.crt_date
FROM
tbl_register_temp ,
tbl_master_vehicle_type ,
tbl_course_group ,
tbl_course_data ,
tbl_trainer_data
WHERE
tbl_register_temp.course_group_id = tbl_course_group.course_group_id AND
tbl_register_temp.course_data_id = tbl_course_data.course_data_id AND
tbl_register_temp.trainer_id = tbl_trainer_data.trainer_id AND
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร
$rst_temp_date_calendar=$dataRow["rst_temp_date_calendar"];

 require_once('user_page_1_regis_8_chk_temp.php');

if(isset($_GET['success'])){
  echo "<script>";
  echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
  echo "</script>";
}

$stmt23 = $qGeneral->runQuery("SELECT tbl_location_province.province_name,tbl_vegicle_data.license_plate,tbl_vegicle_data.vegicle_brand FROM tbl_vegicle_data,tbl_location_province WHERE  tbl_vegicle_data.province_id = tbl_location_province.province_id AND tbl_vegicle_data.vegicle_data_id=:vegicle_data_id_param");
$stmt23->execute(array(":vegicle_data_id_param"=>$dataRow["vegicle_data_id"]));
$dataRow23=$stmt23->fetch(PDO::FETCH_ASSOC);

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

<div class="row">
<div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">สรุปรายการทั้งหมด</h3>

              
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<!-- <label style="color:blue;">ข้อมูลกำหนดการ</label> -->

      <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                 <tr>
                  <td  style="width: 150px"><b>หลักสูตร</b></td>
                  <td><?=$dataRow["course_data_name"]?></td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>ประเภทหลักสูตร</b></td>
                  <td><?=$dataRow["vehicle_type_name"]?></td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>กลุ่มหลักสูตร</b></td>
                  <td><?=$dataRow["course_group_name"]?>
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>ครู</b> </td>
                  <td><?=$dataRow["trainer_firstname_th"]?> <?=$dataRow["trainer_lastname_th"]?></td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>ยานพาหนะ</b> </td>
                  <td><?=$dataRow23["vegicle_brand"]?> <?=$dataRow23["license_plate"]?> <?=$dataRow23["province_name"]?></td> 
                </tr>
                <tr> 
                  <td style="width: 150px"><b>ตารางเรียนขับรถ</b></td>
                  <td>
                  <?php
  $num_gen1='0';

$qg1 = $sql_process->runQuery(
"SELECT
tbl_register_temp_class_schedule.rmcs_start_date,
tbl_register_temp_class_schedule.rmcs_date_end,
tbl_register_temp_class_schedule.rmcs_hour,
tbl_register_temp_class_schedule.subject_data_id,
tbl_subject_data.subject_data_name
FROM
tbl_register_temp_class_schedule,
tbl_subject_data
WHERE
tbl_subject_data.subject_data_id=tbl_register_temp_class_schedule.subject_data_id AND
tbl_register_temp_class_schedule.type_study_id='2' AND
tbl_register_temp_class_schedule.rst_temp_code=:rst_temp_code_param ");
$qg1->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
while($rowGen1= $qg1->fetch(PDO::FETCH_OBJ)) {
$num_gen1++;

echo" $num_gen1.)"."&nbsp;"."$rowGen1->subject_data_name"."&nbsp;";
echo DateThai_2($rowGen1->rmcs_start_date)."&nbsp;"."-"."&nbsp;".DateThai_2($rowGen1->rmcs_date_end)."&nbsp;";
echo "<b>($rowGen1->rmcs_hour ชั่วโมง)</b>"."<br>";
echo "<br>";
}
?>                
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>ตารางอบรมทฤษฎี</b></td>
                  <td>
                  <?php
  $num_gen2='0';

$qg2 = $sql_process->runQuery(
"SELECT
tbl_register_temp_class_schedule.rmcs_start_date,
tbl_register_temp_class_schedule.rmcs_date_end,
tbl_register_temp_class_schedule.rmcs_hour
FROM
tbl_register_temp_class_schedule
WHERE
tbl_register_temp_class_schedule.type_study_id='1' AND
tbl_register_temp_class_schedule.rst_temp_code=:rst_temp_code_param ");
$qg2->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
while($rowGen2= $qg2->fetch(PDO::FETCH_OBJ)) {
$num_gen2++;

echo" $num_gen2.)"."&nbsp;";
echo DateThai_2($rowGen2->rmcs_start_date)."&nbsp;"."-"."&nbsp;".DateThai_2($rowGen2->rmcs_date_end)."&nbsp;";
echo "<b>($rowGen2->rmcs_hour ชั่วโมง)</b>";
echo "<br>";
}
?>                
            
                  
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>ข้อมูลด้านเอกสาร</b></td>
                  <td>
                  <?php
  $num_gen2='0';

$qg2 = $sql_process->runQuery(
"SELECT
tbl_register_temp_doc.doc_id,
tbl_register_temp_doc.doc_detail,
tbl_register_temp_doc.doc_sent,
tbl_register_temp_doc.school_id,
tbl_document_regis.doc_name,
tbl_document_regis.doc_number_default,
tbl_document_regis.doc_unit
FROM
tbl_register_temp_doc,
tbl_document_regis
WHERE
tbl_register_temp_doc.doc_id = tbl_document_regis.doc_id AND
tbl_register_temp_doc.rst_temp_code=:rst_temp_code_param 
ORDER BY
tbl_register_temp_doc.doc_id ASC
");
$qg2->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
while($rowGen2= $qg2->fetch(PDO::FETCH_OBJ)) {
$num_gen2++;

echo" $num_gen2.)"."&nbsp;";
echo $rowGen2->doc_name."&nbsp;";
echo "<b>"."$rowGen2->doc_sent/$rowGen2->doc_number_default"."&nbsp;"."$rowGen2->doc_unit"."</b>";
echo "<br>";
}
?>                   
                  
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>วันสอบทฤษฎี</b></td>
                  <td>
                  <?php
  $num_gen3='0';

$qg3 = $sql_process->runQuery(
"SELECT
tbl_exam_schedule.esd_start_time,
tbl_exam_schedule.esd_end_time,
tbl_exam_schedule.esd_time_total,
tbl_exam_schedule.esd_date
FROM
tbl_register_temp_exam_schedule ,
tbl_exam_schedule
WHERE
tbl_register_temp_exam_schedule.type_study_id = '1' AND
tbl_register_temp_exam_schedule.rst_temp_code =:rst_temp_code_param AND
tbl_register_temp_exam_schedule.esd_id = tbl_exam_schedule.esd_id
ORDER BY
tbl_exam_schedule.esd_date ASC
");
$qg3->execute(array(":rst_temp_code_param"=>$rst_temp_code_get));
while($rowGen3= $qg3->fetch(PDO::FETCH_OBJ)) {
$num_gen3++;
$datestart1="$rowGen3->esd_date $rowGen3->esd_start_time";
$dateend1="$rowGen3->esd_date $rowGen3->esd_end_time";
echo" $num_gen3.)"."&nbsp;";
echo DateThai_2($datestart1)."&nbsp;"."-"."&nbsp;".DateThai_2($dateend1)."&nbsp;";
echo "<b>(".TimeDiff("$rowGen3->esd_start_time","$rowGen3->esd_end_time")."&nbsp;"."ชั่วโมง)</b>";
echo "<br>";
}
?>                   
                     
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>วันสอบปฏิบัติ</b></td>
                  <td>
                  <?php
  $num_gen4='0';

$qg4 = $sql_process->runQuery(
"SELECT
tbl_exam_schedule.esd_start_time,
tbl_exam_schedule.esd_end_time,
tbl_exam_schedule.esd_time_total,
tbl_exam_schedule.esd_date
FROM
tbl_register_temp_exam_schedule ,
tbl_exam_schedule
WHERE
tbl_register_temp_exam_schedule.type_study_id = '2' AND
tbl_register_temp_exam_schedule.rst_temp_code =:rst_temp_code_param AND
tbl_register_temp_exam_schedule.esd_id = tbl_exam_schedule.esd_id
ORDER BY
tbl_exam_schedule.esd_date ASC
");
$qg4->execute(array(":rst_temp_code_param"=>$rst_temp_code));
while($rowGen4= $qg4->fetch(PDO::FETCH_OBJ)) {
$num_gen4++;
$datestart2="$rowGen4->esd_date $rowGen4->esd_start_time";
$dateend2="$rowGen4->esd_date $rowGen4->esd_end_time";
echo" $num_gen4.)"."&nbsp;";
echo DateThai_2($datestart2)."&nbsp;"."-"."&nbsp;".DateThai_2($dateend2)."&nbsp;";
echo "<b>(".TimeDiff("$rowGen4->esd_start_time","$rowGen4->esd_end_time")."&nbsp;"."ชั่วโมง)</b>";
echo "<br>";
}
?>                                    
                  
                  </td> 
                </tr>
                <tr>
                  <td style="width: 150px"><b>สำนักงานขนส่งจังหวัด</b></td>
                  <td>
                  <?php
        $stmtd = $sql_process->runQuery("SELECT
        tbl_dlt_data.transportation_office_name,
        tbl_location_province.province_name,
        tbl_location_amphur.amphur_name
        FROM
        tbl_register_temp ,
        tbl_dlt_data ,
        tbl_location_province ,
        tbl_location_amphur
        WHERE
        tbl_register_temp.transportation_id = tbl_dlt_data.transportation_id AND
        tbl_dlt_data.province_id = tbl_location_province.province_id AND
        tbl_dlt_data.amphur_id = tbl_location_amphur.amphur_id AND
        tbl_register_temp.rst_temp_code =:rst_temp_code_param 
        ");
        $stmtd->execute(array(":rst_temp_code_param"=>$rst_temp_code));
        $dataRowd=$stmtd->fetch(PDO::FETCH_ASSOC);
        echo $dataRowd["transportation_office_name"]."&nbsp;";
        echo "อำเภอ".$dataRowd["amphur_name"]."&nbsp;";
        echo "จังหวัด".$dataRowd["province_name"]."&nbsp;";
        
                ?>                                    
                  
                  </td> 
                </tr>


              </table>
            </div>

            <!-- <label style="color:blue;">ข้อมูลรายวิชา</label> -->

        </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->




<!-- //แสดงข้อมูลนักเรียนเบื้องต้น -->
<?php
$stmtx = $sql_process->runQuery("SELECT
tbl_register_temp_student.student_id,
tbl_register_temp_student.student_type_register,
tbl_register_temp_student.student_img,
tbl_register_temp_student.student_finger_print,
tbl_register_temp_student.title_name_th,
tbl_register_temp_student.student_firstname_th,
tbl_register_temp_student.student_lastname_th,
tbl_register_temp_student.title_name_eng,
tbl_register_temp_student.student_firstnam_eng,
tbl_register_temp_student.student_lastname_eng,
tbl_register_temp_student.student_ID_card,
tbl_register_temp_student.student_Passport,
tbl_register_temp_student.nationality_id,
tbl_register_temp_student.country_id,
tbl_register_temp_student.student_birthday,
tbl_register_temp_student.student_age,
tbl_register_temp_student.student_email,
tbl_register_temp_student.student_line,
tbl_register_temp_student.student_phone,
tbl_register_temp_student.student_disability,
tbl_register_temp_student.student_address,
tbl_register_temp_student.province_id,
tbl_register_temp_student.amphur_id,
tbl_register_temp_student.district_id,
tbl_register_temp_student.zipcode_id,
tbl_register_temp_student.student_congenital_disease,
tbl_register_temp_student.career_id,
tbl_register_temp_student.income_id,
tbl_register_temp_student.reason_id,
tbl_register_temp_student.memer_contact,
tbl_register_temp_student.memer_contact_phone,
tbl_register_temp_student.school_id,
tbl_register_temp_student.rst_temp_code,
tbl_master_nationality.nationality_name,
tbl_master_country.country_name,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode
FROM
tbl_register_temp_student ,
tbl_master_nationality ,
tbl_master_country ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode
WHERE
tbl_register_temp_student.nationality_id = tbl_master_nationality.nationality_id AND
tbl_register_temp_student.country_id = tbl_master_country.country_id AND
tbl_register_temp_student.province_id = tbl_location_province.province_id AND
tbl_register_temp_student.amphur_id = tbl_location_amphur.amphur_id AND
tbl_register_temp_student.district_id = tbl_location_district.district_id AND
tbl_register_temp_student.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_register_temp_student.school_id =:school_id_param AND
tbl_register_temp_student.rst_temp_code =:rst_temp_code_param
");
$stmtx->execute(array(":rst_temp_code_param"=>$rst_temp_code,":school_id_param"=>$school_id));
$dataRowx=$stmtx->fetch(PDO::FETCH_ASSOC);
  // picture
  $student_img=$dataRowx["student_img"];
  if(!empty($student_img) ){
  $stu_image ="../images/images_student/"."$student_img";
  }else{
  $stu_image = "../images/images_system/user.png";
  }
?>

<div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow-active">
              <h3 class="widget-user-username"><?=$dataRowx['student_firstname_th']?> <?=$dataRowx['student_lastname_th']?></h3>
              <h5 class="widget-user-desc"><?=$dataRowx['student_ID_card']?></h5>
            </div>
            <div class="widget-user-image">
              <img style="width:90px;height:90px" class="img-circle" src="<?=$stu_image?>" alt="<?=$dataRowx['student_firstname_th']?>">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-12 ">
                  <div class="description-block">
                    <label>โทร : <?=$dataRowx['student_phone']?></label>
                    <label>ที่อยู่ : <?=$dataRowx['student_address']?> ตำบล <?=$dataRowx['district_name']?> อำเภอ <?=$dataRowx['amphur_name']?> จังหวัด <?=$dataRowx['province_name']?> <?=$dataRowx['zipcode']?></label>
                    <label>วันที่เริ่มสมัครเรียน : <?php echo DateThai($dataRow["crt_date"]);?> </label>
                    <hr>
                    <label><button type="button" <?php if($total_chk_regis<=0){echo "disabled";}?> class="btn btn-block btn-info btn-lg" onClick="window.open('../report/regis-export?rmc=<?=$rst_temp_code?>','','width=750,height=700'); return false;" data-toggle="tooltip" title="พิมพ์ใบสมัคร"><i class="glyphicon glyphicon-print"></i>  พิมพ์ใบสมัคร</button></label>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
            
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->

<div class="col-md-12"></div>
 <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">
              
              </h3> -->

             
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          
            <center>
            <!-- $total_chk_regis ประกาศไว้ที่ user_page_1_regis_8_chk_temp.php -->
            <!-- <button type="button" <?php if($total_chk_regis>=1){echo "disabled";}?> class="buttonAni" onclick="window.location.href='?option=regis-step-8&sccode=<?=$rst_temp_code?>&Chktemp'" data-toggle="tooltip" title="บันทึกข้อมูล"><i class="glyphicon glyphicon-floppy-disk"></i> บันทึกข้อมูล</button> -->
            <button type="button" <?php if($total_chk_regis>=1){echo "disabled";}?> onclick="window.location.href='?option=<?=$_GET["option"]?>&sccode=<?=$rst_temp_code?>&Chktemp'" class="btn btn-block btn-success btn-flat"  data-toggle="tooltip" title="บันทึกข้อมูล" ><i class="glyphicon glyphicon-floppy-disk"></i> บันทึกข้อมูล</button>
            <!-- <button type="button" class="buttonAni" onclick="window.location.href='?option=regis-step-8&sccode=<?=$rst_temp_code?>'" data-toggle="tooltip" title="ชำระเงิน"><i class="glyphicon glyphicon-shopping-cart"></i> ชำระเงิน</button> -->
         
            </center>
            <br>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

 <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">
              
              </h3> -->

             
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          
            <center>
            <!-- ?option=Payment&sccode=<?=$rst_temp_code?> -->
            <!-- $total_chk_regis ประกาศไว้ที่ user_page_1_regis_8_chk_temp.php -->
            <!-- <button type="button" class="buttonAni" onclick="window.location.href='?option=regis-step-8&sccode=<?=$rst_temp_code?>&Chktemp'" data-toggle="tooltip" title="บันทึกข้อมูล"><i class="glyphicon glyphicon-floppy-disk"></i> บันทึกข้อมูล</button> -->
            <!-- <button  type="button" <?php if($total_chk_regis<=0){echo "disabled";}?> class="buttonAni" onclick="window.location.href='?option=Payment&sccode=<?=$rst_temp_code?>'" data-toggle="tooltip" title="ชำระเงิน" ><i class="glyphicon glyphicon-shopping-cart"></i> ชำระเงิน</button> -->
            <button type="button" <?php if($total_chk_regis<=0){echo "disabled";}?>  onclick="window.location.href='?option=<?=$_GET["option"]?>&sccode=<?=$rst_temp_code?>&Cleartemp'" class="btn btn-block btn-success btn-flat"  data-toggle="tooltip" title="ชำระเงิน" ><i class="glyphicon glyphicon-shopping-cart"></i>  ชำระเงิน </button>
            </center>
            <br>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      
 </div>

</section>
<!-- /.content -->
</div>


