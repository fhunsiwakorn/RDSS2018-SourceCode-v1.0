<?php
$vegicle_data_id_get = $_GET['evgdt'];	
$stmt = $sql_process->runQuery("SELECT
tbl_vegicle_data.vehicle_img,
tbl_vegicle_data.license_plate,
tbl_vegicle_data.vegicle_brand,
tbl_vegicle_data.gear_type,
tbl_vegicle_data.vegicle_color,
tbl_vegicle_data.vegicle_number,
tbl_vegicle_data.machine_number,
tbl_vegicle_data.user_energy,
tbl_vegicle_data.tax_day_end,
tbl_vegicle_data.vegicle_day_start,
tbl_vegicle_data.crt_by,
tbl_vegicle_data.crt_date,
tbl_vegicle_data.upd_by,
tbl_vegicle_data.upd_date,
tbl_vegicle_data.vegicle_status,
tbl_vegicle_data.is_delete,
tbl_master_vehicle_type.vehicle_type_name,
tbl_location_province.province_name,
tbl_school.school_name
FROM
tbl_vegicle_data ,
tbl_master_vehicle_type ,
tbl_location_province ,
tbl_school
WHERE
tbl_vegicle_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_vegicle_data.province_id = tbl_location_province.province_id AND
tbl_vegicle_data.school_id = tbl_school.school_id AND
tbl_vegicle_data.school_id = :school_id_param AND
tbl_vegicle_data.vegicle_data_id =:vegicle_data_id_param
");
$stmt->execute(array(":vegicle_data_id_param"=>$vegicle_data_id_get,":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $vehicle_img=$dataRow["vehicle_img"];
    if(!empty($vehicle_img) ){
    $vehicle_image ="../images/image_vehicle/"."$vehicle_img";
    }else{
    $vehicle_image = "../images/images_system/default_image.png";
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
ทะเบียนยานพาหนะ
<small>จัดการข้อมูลยานพาหนะ</small>
</h1>
<ol class="breadcrumb">
<li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<li ><a href="?option=CPECWU2RK3A9P8T">ทะเบียนยานพาหนะ</a></li>
<li class="active">รายละเอียดยานพาหนะ</li>
</ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">รายละเอียดยานพาหนะ</h3>

      <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
          <button type="button" onclick="window.location.href='?option=VehicleEdit&evgdt=<?=$vegicle_data_id_get?>'" class="btn btn-warning" data-toggle="tooltip" title="แก้ไข">
        แก้ไข
        </button> 
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
    <div class="col-xs-12">
    <ul class="gallery">
    <li><img  src="<?=$vehicle_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
   </li>
      </ul>
      </div>
   
  <div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลรถ</label>
<hr>
</div>

<div class="col-xs-12">
<table class="table table-condensed">
<tr>
<td width="150">ประเภทรถ</td>
<td>: <?=$dataRow['vehicle_type_name']?>
</td>          
</tr>
<tr>
<tr>
<td width="150">หมายเลขประจำ/ทะเบียนรถ</td>
<td>: <?=$dataRow['license_plate']?>
</td>          
</tr>
<tr>
<td width="150">จังหวัดของทะเบียนรถ</td>
<td>: <?=$dataRow['province_name']?>

</td>
<tr>
<td width="150">ยี่ห้อรถ/ชื่อเรียก</td>
<td>: <?=$dataRow['vegicle_brand']?>
</td>              
</tr>
</tr>
<tr>
<td width="150">ประเภทเกียร์</td>
<td>: <?php
if($dataRow['gear_type']=='1'){
echo "Auto";
}elseif($dataRow['gear_type']=='2'){
echo "Manual";
}
?>
</td>          
</tr>
<tr>
<td width="150">สี</td>
<td>: <?=$dataRow['vegicle_color']?>
</td>          
</tr>
<tr>
<td width="150">เลขตัวรถ</td>
<td>: <?=$dataRow['vegicle_number']?>
</td>          
</tr>
<tr>
<td width="150">เลขเครื่องยนต์</td>
<td>: <?=$dataRow['machine_number']?>
</td>          
</tr>
<tr>
<tr>
<td width="150">วันสิ้นภาษี</td>
<td>: <?php echo DateThai($dataRow['tax_day_end']);?>
</td>          
</tr>
<tr>
<td width="150">วันที่เริ่มนำมาใช้งาน</td>
<td>: <?php echo DateThai($dataRow['vegicle_day_start']);?>
</td>
<tr>
<td width="150">พลังงานที่ใช้</td>
<td>: <?=$dataRow['user_energy']?>
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