<?php
require_once('dashboard_page_8_vehicle_form_logChk.php');
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}

?>

<!-- PRIVIEW PICTURE -->
<script language=Javascript>
           function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
      </script>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนยานพาหนะ
  <small>จัดการข้อมูลยานพาหนะ</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=vehicle-form">ทะเบียนยานพาหนะ</a></li>
  <li class="active">แบบฟอร์มเพิ่มข้อมูลยานพาหนะ</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แบบฟอร์มเพิ่มข้อมูลยานพาหนะ</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
   
<form enctype="multipart/form-data" method="post"   runat="server" id="frmMain" name="frmMain">

    <div class="col-xs-12">
<ul class="gallery">
<input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" id="imageupload">
<li><img  src="../images/images_system/default_image.png" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
<a href="#" data-toggle="tooltip" title="คลิ๊กเพื่ออัพโหลดรูปภาพ" name="uploadbutton" onclick="imageupload.click()"><span class="photo"></span></a></li>
  </ul>
  </div>

  <div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลรถ</label>
<hr>
</div>

  <div class="col-xs-4">

<label>ประเภทรถ</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" name="vehicle_type_id" id="vehicle_type_id" required>
<?php
$qa4 = $qGeneral->runQuery(
"SELECT
tbl_master_vehicle_type.vehicle_type_id,
tbl_master_vehicle_type.vehicle_type_name
FROM
tbl_master_vehicle_type
WHERE
tbl_master_vehicle_type.vehicle_type_status = '1' AND
tbl_master_vehicle_type.is_delete = '1'
ORDER BY
tbl_master_vehicle_type.vehicle_type_id ASC");
                 $qa4->execute();
                 while($rowE= $qa4->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowE->vehicle_type_id'>$rowE->vehicle_type_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
   

<div class="col-xs-4">
<label >หมายเลขประจำ/ทะเบียนรถ </label> <label style="color:red;">*</label>         
<input type="text" class="form-control"  name="license_plate" id="license_plate" required placeholder="หมายเลขประจำ/ทะเบียนรถ ">
</div>

<div class="col-xs-4">

<label>จังหวัดของทะเบียนรถ</label>   <label style="color:red;">*</label> 
                  
<select   class="form-control select2" style="width: 100%;" name="province_id" id="province_id" required>
<option value="">--เลือกจังหวัด--</option>
<?php
$qa5 = $qGeneral->runQuery(
"SELECT
tbl_location_province.province_name,
tbl_location_province.province_id
FROM
tbl_location_province
WHERE
tbl_location_province.province_status = '1' AND
tbl_location_province.is_delete = '1'
ORDER BY
tbl_location_province.province_name ASC
");
$qa5->execute();
while($rowS= $qa5->fetch(PDO::FETCH_OBJ)) {
echo "<option value='$rowS->province_id'>$rowS->province_name</option>";
                 }
                 ?>
                 
                    </select>
                </div> 
<div class="col-xs-4">
<label >ยี่ห้อรถ/ชื่อเรียก </label> <label style="color:red;">*</label>         
<input type="text" class="form-control"  name="vegicle_brand" id="vegicle_brand" required placeholder="ยี่ห้อรถ/ชื่อเรียก">
</div>

<div class="col-xs-4">
<label>ประเภทเกียร์ </label>
<select name="gear_type" id="gear_type"  class="form-control">
<option  value="1">Auto</option>
<option  value="0">Manual</option>
</select>      
</div> 
<div class="col-xs-4">
<label >สี    </label>  
<input type="text" class="form-control" name="vegicle_color" id="vegicle_color"  placeholder="สี">
</div>

<div class="col-xs-4">
<label >เลขตัวรถ    </label>  
<input type="text" class="form-control" name="vegicle_number" id="vegicle_number"  placeholder="เลขตัวรถ">
</div>

<div class="col-xs-4">
<label >เลขเครื่องยนต์    </label>  
<input type="text" class="form-control" name="machine_number" id="machine_number"  placeholder="เลขเครื่องยนต์">
</div>

<div class="col-xs-4">
<label >วันสิ้นภาษี</label>  
<input type="text" class="form-control" name="tax_day_end" id="tax_day_end"  placeholder="วันสิ้นภาษี" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันที่เริ่มนำมาใช้งาน</label>  
<input type="text" class="form-control" name="vegicle_day_start" id="vegicle_day_start"  placeholder="วันที่เริ่มนำมาใช้งาน" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>


<div class="col-xs-6">
<div class="form-group">
<label>พลังงานที่ใช้</label>  <label style="color:red;font-size:12px;">เลือกไม่เกิน 3 ประเภท</label>
<select name="user_energy[]" id="user_energy"  class="form-control select2"  multiple="multiple" data-placeholder="" style="width: 100%;">
<?php
$qa7 = $qGeneral->runQuery(
"SELECT
tbl_master_type_energy.type_energy_name
FROM
tbl_master_type_energy
WHERE
tbl_master_type_energy.is_delete = '1' 
ORDER BY
tbl_master_type_energy.type_energy_id ASC");
$qa7->execute();
while($rowK= $qa7->fetch(PDO::FETCH_OBJ)) {
echo "<option value='$rowK->type_energy_name'>$rowK->type_energy_name</option>";
                 }
?>
               
</select> 
</div>      
</div> 

<div class="col-xs-12">
<br>
<label style="color:blue;">สังกัดโรงเรียน</label>
<hr>
</div>

<div class="col-xs-4">

<label>โรงเรียน</label>   <label style="color:red;">*</label> 
                  
<select   class="form-control select2" style="width: 100%;" name="school_id" id="school_id" required>
<?php
$qa8 = $qGeneral->runQuery(
"SELECT
tbl_school.school_id,
tbl_school.school_name
FROM
tbl_school
WHERE
tbl_school.is_delete = '1' 
ORDER BY
tbl_school.school_id ASC");
$qa8->execute();
while($rowI= $qa8->fetch(PDO::FETCH_OBJ)) {
echo "<option value='$rowI->school_id'>$rowI->school_name</option>";
                 }
?>
                 
                    </select>
                </div> 

<div class="col-xs-12">
<br>
<!-- <label style="color:blue;">สังกัดโรงเรียน</label> -->
<hr>
</div>

                <div class="col-xs-4">
                   <label>สถานะการใช้งาน</label>
                   <select name="vegicle_status" id="vegicle_status"  class="form-control">
                   <option  value="1">เปิด</option>
                   <option  value="0">ปิด</option>
                 </select>      
              </div> 


  <div class="col-xs-12">
<label ></label>     
<br>
<center><button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button></center>
</div>                 
</form>

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