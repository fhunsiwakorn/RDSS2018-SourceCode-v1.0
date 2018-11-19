<?php
$student_id_get = $_GET['estu'];	
$stmt = $sql_process->runQuery("SELECT
tbl_student_data.student_type_register,
tbl_student_data.student_img,
tbl_student_data.student_finger_print,
tbl_student_data.title_name_th,
tbl_student_data.student_firstname_th,
tbl_student_data.student_lastname_th,
tbl_student_data.title_name_eng,
tbl_student_data.student_firstnam_eng,
tbl_student_data.student_lastname_eng,
tbl_student_data.student_ID_card,
tbl_student_data.student_Passport,
tbl_student_data.nationality_id,
tbl_student_data.country_id,
tbl_student_data.student_birthday,
tbl_student_data.student_age,
tbl_student_data.student_email,
tbl_student_data.student_line,
tbl_student_data.student_phone,
tbl_student_data.student_disability,
tbl_student_data.student_address,
tbl_student_data.province_id,
tbl_student_data.amphur_id,
tbl_student_data.district_id,
tbl_student_data.zipcode_id,
tbl_student_data.student_congenital_disease,
tbl_student_data.career_id,
tbl_student_data.income_id,
tbl_student_data.reason_id,
tbl_student_data.memer_contact,
tbl_student_data.memer_contact_phone,
tbl_student_data.school_id,
tbl_student_data.crt_by,
tbl_student_data.crt_date,
tbl_student_data.upd_by,
tbl_student_data.upd_date,
tbl_student_data.is_delete,
tbl_student_data.student_id,
tbl_master_nationality.nationality_name,
tbl_master_country.country_name,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode,
tbl_school.school_name
FROM
tbl_student_data ,
tbl_master_nationality ,
tbl_master_country ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode ,
tbl_school
WHERE
tbl_student_data.nationality_id = tbl_master_nationality.nationality_id AND
tbl_student_data.country_id = tbl_master_country.country_id AND
tbl_student_data.province_id = tbl_location_province.province_id AND
tbl_student_data.amphur_id = tbl_location_amphur.amphur_id AND
tbl_student_data.district_id = tbl_location_district.district_id AND
tbl_student_data.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_student_data.school_id = tbl_school.school_id AND
tbl_student_data.student_id = :student_id_param");
$stmt->execute(array(":student_id_param"=>$student_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $student_img=$dataRow["student_img"];
    if(!empty($student_img) ){
    $stu_image ="../images/images_student/"."$student_img";
    }else{
    $stu_image = "../images/images_system/default-avatarv9899025.gif";
    }
    if(isset($_GET['success'])){
      echo "<script>";
      echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
      echo "</script>";
  }
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนนักเรียน
    <small>จัดการข้อมูลนักเรียนทั้งหมด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=student-data">ทะเบียนนักเรียน</a></li>
  <li class="active">รายละเอียดข้อมูลนักเรียน</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">รายละเอียดข้อมูลนักเรียน</h3>

      <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
          <button type="button" onclick="window.location.href='?option=student-data-edit&estu=<?=$student_id_get?>'" class="btn btn-warning" data-toggle="tooltip" title="แก้ไข">
        แก้ไข
        </button> 
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
    <div class="col-xs-12">
    <ul class="gallery">
    <li><img  src="<?=$stu_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
   </li>
      </ul>
      </div>
   
  <div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลส่วนตัว</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">ประเภทผู้สมัคร</td>
<td>: <?php
if($dataRow['student_type_register']=='1'){
echo "ไทย";
}elseif($dataRow['student_type_register']=='2'){
echo "ต่างชาติ";
}
?>
</td>          
</tr>
<tr>
<tr>
<td width="150">สัญชาติ</td>
<td>: <?=$dataRow['nationality_name']?>
</td>          
</tr>
<tr>
<td width="150">ประเทศ</td>
<td>: <?=$dataRow['country_name']?>

</td>
<tr>
<td width="150">ชื่อ - นามสกุล</td>
<td>: <?=$dataRow['title_name_th']?> <?=$dataRow['student_firstname_th']?>  <?=$dataRow['student_lastname_th']?>          
</td>              
</tr>
</tr>
<tr>
<td width="150">Fullname</td>
<td>: <?=$dataRow['title_name_eng']?> <?=$dataRow['student_firstnam_eng']?>  <?=$dataRow['student_lastname_eng']?>
</td>          
</tr>
<tr>
<td width="150">เลขบัตรประชาชน</td>
<td>: <?=$dataRow['student_ID_card']?>
</td>          
</tr>
<tr>
<td width="150">Passport</td>
<td>: <?=$dataRow['student_Passport']?>
</td>          
</tr>
<tr>
<tr>
<td width="150">วันเกิด</td>
<td>: <?php echo DateThai($dataRow['student_birthday']);?>
</td>          
</tr>
<tr>
<td width="150">อายุ</td>
<td>: <?=$dataRow['student_age']?>
</td>
<tr>
<td width="150">อีเมล</td>
<td>: <?=$dataRow['student_email']?>
</td>
</tr>
<tr>
<td width="150">ไอดี LINE</td>
<td>: <?=$dataRow['student_line']?>
</td>
</tr>
<tr>
<td width="150">เบอร์โทรศัพท์</td>
<td>: <?=$dataRow['student_phone']?>
</td>
</tr>
</table>
</div>
<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลที่อยู่</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">ที่อยู่</td>
<td>: <?php
    echo "&nbsp".$dataRow['student_address']."&nbsp";
    echo "ตำบล"."&nbsp".$dataRow['district_name']."&nbsp";
    echo "อำเภอ"."&nbsp".$dataRow['amphur_name']."&nbsp";
    echo "จังหวัด"."&nbsp".$dataRow['province_name']."&nbsp";
    echo "&nbsp".$dataRow['zipcode']."&nbsp";
?>
</td>          
</tr>
</table>
</div>


<div class="col-xs-12">
<br>
<label style="color:blue;">สังกัดโรงเรียน</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">โรงเรียน</td>
<td>: <?=$dataRow['school_name']?>
</td>          
</tr>
</table>
</div>


<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลอื่นๆ</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">ความพิการ</td>
<td>: <?=$dataRow['student_disability']?>
</td>          
</tr>
<tr>
<td width="150">โรคประจำตัว</td>
<td>: <?=$dataRow['student_congenital_disease']?>
</td>          
</tr>
<tr>
<td width="150">อาชีพ</td>
<td>: <?php
$career_id = $dataRow['career_id'];	
$stmtA = $sql_process->runQuery("SELECT tbl_master_career.career_name FROM tbl_master_career WHERE career_id=:career_id_param");
$stmtA->execute(array(":career_id_param"=>$career_id));
$dataRowA=$stmtA->fetch(PDO::FETCH_ASSOC);
echo $dataRowA['career_name'];
?>
</td>          
</tr>
<tr>
<td width="150">รายได้</td>
<td>: <?php
$income_id = $dataRow['income_id'];	
$stmtB = $sql_process->runQuery("SELECT tbl_master_income.income_text FROM tbl_master_income WHERE income_id=:income_id_param");
$stmtB->execute(array(":income_id_param"=>$income_id));
$dataRowB=$stmtB->fetch(PDO::FETCH_ASSOC);
echo $dataRowB['income_text'];
?>
</td>          
</tr>
<tr>
<td width="150">ชื่อผู้ที่สามารถติดต่อได้</td>
<td>: <?=$dataRow['memer_contact']?>
</td>          
</tr>
<tr>
<td width="150">เบอร์ผู้ที่สามารถติดต่อได้</td>
<td>: <?=$dataRow['memer_contact_phone']?>
</td>          
</tr>
<tr>
<td width="150">เหตุผลที่มาเรียน</td>
<td>: <?php
$reason_id = $dataRow['reason_id'];	
$stmtC = $sql_process->runQuery("SELECT tbl_master_reason.reason_text FROM tbl_master_reason WHERE reason_id=:reason_id_param");
$stmtC->execute(array(":reason_id_param"=>$reason_id));
$dataRowC=$stmtC->fetch(PDO::FETCH_ASSOC);
echo $dataRowC['reason_text'];
?>
</td>          
</tr>
</table>
</div> 

<hr>
<div class="col-xs-12">
<?php
$crt_by = $dataRow['crt_by'];	
$stmtD = $sql_process->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmtD->execute(array(":user_id_param"=>$crt_by));
$dataRowD=$stmtD->fetch(PDO::FETCH_ASSOC);
$upd_by = $dataRow['upd_by'];	
$stmtE = $sql_process->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param2");
$stmtE->execute(array(":user_id_param2"=>$upd_by));
$dataRowE=$stmtE->fetch(PDO::FETCH_ASSOC);
?>
<label>สร้างโดย : </label> <?=$dataRowD["user_firstname"]?> <?=$dataRowD["user_lastname"]?> (<?php echo DateThai_2($dataRow["crt_date"]);?>)<br>
<label>แก้ไขโดย : </label> <?=$dataRowE["user_firstname"]?> <?=$dataRowE["user_lastname"]?> (<?php echo DateThai_2($dataRow["upd_date"]);?>)
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