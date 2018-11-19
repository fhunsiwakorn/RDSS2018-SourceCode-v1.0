<?php
require_once('user_page_3_vehicle_form_logChk.php');
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$vegicle_data_id_get = $_GET['evgdt'];	
$stmt = $sql_process->runQuery("SELECT * FROM tbl_vegicle_data WHERE vegicle_data_id=:vegicle_data_id_param AND school_id = :school_id_param ");
$stmt->execute(array(":vegicle_data_id_param"=>$vegicle_data_id_get,":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $vehicle_img=$dataRow["vehicle_img"];
    if(!empty($vehicle_img)){
    $vehicle_image ="../images/image_vehicle/"."$vehicle_img";
    }else{
    $vehicle_image = "../images/images_system/default_image.png";
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
  ข้อมูลยานพาหนะ
  <small>จัดการข้อมูลยานพาหนะ</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=CPECWU2RK3A9P8T">ข้อมูลยานพาหนะ</a></li>
  <li class="active">แบบฟอร์มแก้ไขยานพาหนะ</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แบบฟอร์มแก้ไขยานพาหนะ</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
   
<form enctype="multipart/form-data" method="post"   runat="server" id="frmMain" name="frmMain">
<input type="hidden" id="vegicle_data_id" name="vegicle_data_id" value="<?=$_GET['evgdt']?>" />
<input type="hidden" id="vehicle_img" name="vehicle_img" value="<?=$dataRow['vehicle_img']?>" />
<!-- สำหรับไม่มีการแก้ข้อมูล user_energy ให้ส่ง user_energy2 ไปแทน -->
<input type="hidden" id="user_energy2" name="user_energy2" value="<?=$dataRow['user_energy']?>" /> 
<div class="col-xs-12">
<ul class="gallery">
<input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" id="imageupload">
<li><img  src="<?=$vehicle_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
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
$qa4 = $sql_process->runQuery(
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
echo"<option value='$rowE->vehicle_type_id'";
if ($dataRow['vehicle_type_id'] == $rowE->vehicle_type_id)
{
  echo "SELECTED";
}
echo ">$rowE->vehicle_type_name</option>\n";
}
                 ?>
                 
                    </select>
                </div>  
   

<div class="col-xs-4">
<label >หมายเลขประจำ/ทะเบียนรถ </label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['license_plate']?>" name="license_plate" id="license_plate" required placeholder="หมายเลขประจำ/ทะเบียนรถ ">
</div>

<div class="col-xs-4">

<label>จังหวัดของทะเบียนรถ</label>   <label style="color:red;">*</label> 
                  
<select   class="form-control select2" style="width: 100%;" name="province_id" id="province_id" required>
<option value="">--เลือกจังหวัด--</option>
<?php
$qa5 = $sql_process->runQuery(
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
echo"<option value='$rowS->province_id'";
if ($dataRow['province_id'] == $rowS->province_id)
{
  echo "SELECTED";
}
echo ">$rowS->province_name</option>\n";
                 }
                 ?>
                 
                    </select>
                </div> 
<div class="col-xs-4">
<label >ยี่ห้อรถ/ชื่อเรียก </label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['vegicle_brand']?>" name="vegicle_brand" id="vegicle_brand" required placeholder="ยี่ห้อรถ/ชื่อเรียก">
</div>

<div class="col-xs-4">
<label>ประเภทเกียร์ </label>
<select name="gear_type" id="gear_type"  class="form-control">
<option <?php if($dataRow['gear_type']=='1'){echo "SELECTED";} ?> value="1">Auto</option>
<option <?php if($dataRow['gear_type']=='0'){echo "SELECTED";} ?>  value="0">Manual</option>
</select>      
</div> 
<div class="col-xs-4">
<label >สี    </label>  
<input type="text" class="form-control" value="<?=$dataRow['vegicle_color']?>" name="vegicle_color" id="vegicle_color"  placeholder="สี">
</div>

<div class="col-xs-4">
<label >เลขตัวรถ    </label>  
<input type="text" class="form-control" value="<?=$dataRow['vegicle_number']?>" name="vegicle_number" id="vegicle_number"  placeholder="เลขตัวรถ">
</div>

<div class="col-xs-4">
<label >เลขเครื่องยนต์    </label>  
<input type="text" class="form-control"  value="<?=$dataRow['machine_number']?>"  name="machine_number" id="machine_number"  placeholder="เลขเครื่องยนต์">
</div>

<div class="col-xs-4">
<label >วันสิ้นภาษี</label>  

<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['tax_day_end']);?>" name="tax_day_end" id="tax_day_end"  placeholder="วันสิ้นภาษี" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันที่เริ่มนำมาใช้งาน</label>  

<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['vegicle_day_start']);?>" name="vegicle_day_start" id="vegicle_day_start"  placeholder="วันที่เริ่มนำมาใช้งาน" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>


<div class="col-xs-6">
<div class="form-group">
<label>พลังงานที่ใช้</label>  <label style="color:red;font-size:12px;">เลือกไม่เกิน 3 ประเภท</label>
<select name="user_energy[]" id="user_energy"  class="form-control select2"  multiple="multiple" data-placeholder="<?=$dataRow['user_energy']?>" style="width: 100%;">
<?php
$qa7 = $sql_process->runQuery(
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
<!-- <label style="color:blue;">สังกัดโรงเรียน</label> -->
<hr>
</div>

                <div class="col-xs-4">
                   <label>สถานะการใช้งาน</label>
                   <select name="vegicle_status" id="vegicle_status"  class="form-control">
                   <option <?php if($dataRow['vegicle_status']=='1'){echo "SELECTED";} ?>  value="1">เปิด</option>
                   <option <?php if($dataRow['vegicle_status']=='0'){echo "SELECTED";} ?>  value="0">ปิด</option>
                 </select>      
              </div> 


  <div class="col-xs-12">
<label ></label>     
<br>
<center><button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกข้อมูล</button></center>
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