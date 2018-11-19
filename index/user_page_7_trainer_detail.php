<?php
$trainer_code_get = $_GET['etnr'];	
$stmt = $qGeneral->runQuery("SELECT
tbl_trainer_data.trainer_id,
tbl_trainer_data.trainer_img,
tbl_trainer_data.trainer_finger_print,
tbl_trainer_data.title_name_th,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_trainer_data.title_name_eng,
tbl_trainer_data.trainer_firstnam_eng,
tbl_trainer_data.trainer_lastname_eng,
tbl_trainer_data.trainer_card,
tbl_trainer_data.trainer_card_Issue_date,
tbl_trainer_data.trainer_card_expired,
tbl_trainer_data.trainer_Passport,
tbl_trainer_data.trainer_Passport_Issue_date,
tbl_trainer_data.trainer_Passport_card_expired,
tbl_trainer_data.trainer_code_motorcycle,
tbl_trainer_data.trainer_code_motorcycle_Issue_date,
tbl_trainer_data.trainer_code_motorcycle_card_expired,
tbl_trainer_data.trainer_code_car,
tbl_trainer_data.trainer_code_car_Issue_date,
tbl_trainer_data.trainer_code_car_card_expired,
tbl_trainer_data.trainer_code_land_transport,
tbl_trainer_data.trainer_code_land_transport_Issue_date,
tbl_trainer_data.trainer_code_land_transport_card_expired,
tbl_trainer_data.trainer_birthday,
tbl_trainer_data.trainer_age,
tbl_trainer_data.trainer_email,
tbl_trainer_data.trainer_line,
tbl_trainer_data.trainer_phone,
tbl_trainer_data.trainer_address,
tbl_trainer_data.school_id,
tbl_trainer_data.crt_by,
tbl_trainer_data.crt_date,
tbl_trainer_data.upd_by,
tbl_trainer_data.upd_date,
tbl_master_nationality.nationality_name,
tbl_master_country.country_name,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode,
tbl_master_type_trainer.trainer_type_name,
tbl_master_type_teach.teach_type_name,
tbl_school.school_name
FROM
tbl_trainer_data ,
tbl_master_nationality ,
tbl_master_country ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode ,
tbl_master_type_trainer ,
tbl_master_type_teach ,
tbl_school
WHERE
tbl_trainer_data.nationality_id = tbl_master_nationality.nationality_id AND
tbl_trainer_data.country_id = tbl_master_country.country_id AND
tbl_trainer_data.province_id = tbl_location_province.province_id AND
tbl_trainer_data.amphur_id = tbl_location_amphur.amphur_id AND
tbl_trainer_data.district_id = tbl_location_district.district_id AND
tbl_trainer_data.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_trainer_data.trainer_type_id = tbl_master_type_trainer.trainer_type_id AND
tbl_trainer_data.teach_type_id = tbl_master_type_teach.teach_type_id AND
tbl_trainer_data.school_id = tbl_school.school_id AND
tbl_trainer_data.trainer_code = :trainer_code_param");
$stmt->execute(array(":trainer_code_param"=>$trainer_code_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $trainer_img=$dataRow["trainer_img"];
    if(!empty($trainer_img) ){
    $trn_image ="../images/images_trainer/"."$trainer_img";
    }else{
    $trn_image = "../images/images_system/default-avatarv9899025.gif";
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
ทะเบียนครูฝึก
<small>จัดการข้อมูลครูฝึกทั้งหมด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=FS1KQBSUYBBTE90">ทะเบียนครูฝึก</a></li>
  <li class="active">รายละเอียดข้อมูลครูฝึก</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">รายละเอียดข้อมูลครูฝึก</h3>

      <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
          <button type="button" onclick="window.location.href='?option=trainer-data-edit&etnr=<?=$trainer_code_get?>'" class="btn btn-warning" data-toggle="tooltip" title="แก้ไข">
        แก้ไข
        </button> 
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
    <div class="col-xs-12">
    <ul class="gallery">
    <li><img  src="<?=$trn_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
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
<td width="150">ประเภทครูฝึก</td>
<td>: <?=$dataRow['trainer_type_name']?>
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
<td>: <?=$dataRow['title_name_th']?><?=$dataRow['trainer_firstname_th']?>  <?=$dataRow['trainer_lastname_th']?>          
</td>              
</tr>
</tr>
<tr>
<td width="150">Fullname</td>
<td>: <?=$dataRow['title_name_eng']?><?=$dataRow['trainer_firstnam_eng']?>  <?=$dataRow['trainer_lastname_eng']?>
</td>          
</tr>
<tr>
<td width="150">เลขบัตรประชาชน</td>
<td>: <?=$dataRow['trainer_card']?> วันที่ออกบัตร <?php echo DateThai($dataRow['trainer_card_Issue_date']);?> วันหมดอายุ <?php echo DateThai($dataRow['trainer_card_expired']);?>
</td>          
</tr>
<tr>
<td width="150">Passport</td>
<td>: <?=$dataRow['trainer_Passport']?> วันที่ออกบัตร <?php echo DateThai($dataRow['trainer_Passport_Issue_date']);?> วันหมดอายุ <?php echo DateThai($dataRow['trainer_Passport_card_expired']);?>
</td>          
</tr>
<tr>
<tr>
<td width="150">วันเกิด</td>
<td>: <?php echo DateThai($dataRow['trainer_birthday']);?>
</td>          
</tr>
<tr>
<td width="150">อายุ</td>
<td>: <?=$dataRow['trainer_age']?>
</td>
<tr>
<td width="150">อีเมล</td>
<td>: <?=$dataRow['trainer_email']?>
</td>
</tr>
<tr>
<td width="150">ไอดี LINE</td>
<td>: <?=$dataRow['trainer_line']?>
</td>
</tr>
<tr>
<td width="150">เบอร์โทรศัพท์</td>
<td>: <?=$dataRow['trainer_phone']?>
</td>
</tr>
</table>
</div>

<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลใบอนุญาต</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="200">รหัสครูฝึกประเภทจักรยานยนต์</td>
<td>: <?=$dataRow['trainer_code_motorcycle']?> วันที่ออกบัตร <?php echo DateThai($dataRow['trainer_code_motorcycle_Issue_date']);?> วันหมดอายุ <?php echo DateThai($dataRow['trainer_code_motorcycle_card_expired']);?>
</td>          
</tr>
<tr>
<td width="200">รหัสครูฝึกประเภทรถยนต์</td>
<td>: <?=$dataRow['trainer_code_car']?> วันที่ออกบัตร <?php echo DateThai($dataRow['trainer_code_car_Issue_date']);?> วันหมดอายุ <?php echo DateThai($dataRow['trainer_code_car_card_expired']);?>
</td>          
</tr>
<tr>
<td width="200">รหัสครูฝึกประเภทรถว่าด้วยกฏหมายขนส่งทางบก</td>
<td>: <?=$dataRow['trainer_code_land_transport']?> วันที่ออกบัตร <?php echo DateThai($dataRow['trainer_code_land_transport_Issue_date']);?> วันหมดอายุ <?php echo DateThai($dataRow['trainer_code_land_transport_card_expired']);?>
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
    echo "&nbsp".$dataRow['trainer_address']."&nbsp";
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
<label style="color:blue;">ข้อมูลอื่นๆ</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">ประเภทการสอน</td>
<td>: <?=$dataRow['teach_type_name']?>
</td>          
</tr>
</table>
</div>

<hr>
<div class="col-xs-12">
<?php
$crt_by = $dataRow['crt_by'];	
$stmtD = $qGeneral->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmtD->execute(array(":user_id_param"=>$crt_by));
$dataRowD=$stmtD->fetch(PDO::FETCH_ASSOC);
$upd_by = $dataRow['upd_by'];	
$stmtE = $qGeneral->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param2");
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