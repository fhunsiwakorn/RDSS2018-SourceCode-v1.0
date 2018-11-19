<?php
require_once('dashboard_page_6_trainer_form_logChk.php');
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$trainer_id_get = $_GET['etnr'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_trainer_data WHERE trainer_id=:trainer_id_param");
$stmt->execute(array(":trainer_id_param"=>$trainer_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $trainer_img=$dataRow["trainer_img"];
    if(!empty($trainer_img)){
    $tr_image ="../images/images_trainer/"."$trainer_img";
    }else{
    $tr_image = "../images/images_system/default-avatarv9899025.gif";
    }
?>
<script language=Javascript>
function Inint_AJAX() {
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
};

function dochange(src, val) {
     var req = Inint_AJAX();
     req.onreadystatechange = function () {
          if (req.readyState==4) {
               if (req.status==200) {
                    document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
               }
          }
     };
     req.open("GET", "../library/localtion.php?province_idE=<?=$dataRow['province_id']?>&amphur_idE=<?=$dataRow['amphur_id']?>&district_idE=<?=$dataRow['district_id']?>&zipcode_idE=<?=$dataRow['zipcode_id']?>&data="+src+"&val="+val); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
     req.send(null); //ส่งค่า
}

window.onLoad=dochange('province_id', -1);
window.onLoad=dochange('amphur_id', -1);
window.onLoad=dochange('district_id', -1);
window.onLoad=dochange('zipcode_id', -1);

</script>

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
  ทะเบียนครูฝึก
    <small>จัดการข้อมูลครูฝึกทั้งหมด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=trainer-data">ทะเบียนครูฝึก</a></li>
  <li class="active">แบบฟอร์มแก้ไขข้อมูลครูฝึก</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แบบฟอร์มแก้ไขข้อมูลครูฝึก</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
   
<form enctype="multipart/form-data" method="post"   runat="server" name="student_add" id="student_add">
<input type="hidden" name="trainer_id" value="<?=$_GET['etnr']?>"/>
<input type="hidden" name="trainer_img" value="<?=$dataRow['trainer_img']?>"/>
    <div class="col-xs-12">
<ul class="gallery">
<input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" id="imageupload">
<li><img  src="<?=$tr_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
<a href="#" data-toggle="tooltip" title="คลิ๊กเพื่ออัพโหลดรูปภาพ" name="uploadbutton" onclick="imageupload.click()"><span class="photo"></span></a></li>
  </ul>
  </div>

  <div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลส่วนตัว</label>
<hr>
</div>

  <div class="col-xs-4">
<label>ประเภทครูฝึก</label>  <label style="color:red;">*</label> 
<select class="form-control" style="width: 100%;" name="trainer_type_id" id="trainer_type_id" required>

<?php
$qa = $qGeneral->runQuery(
"SELECT
tbl_master_type_trainer.trainer_type_id,
tbl_master_type_trainer.trainer_type_name
FROM
tbl_master_type_trainer
WHERE
tbl_master_type_trainer.trainer_type_status = '1' AND
tbl_master_type_trainer.is_delete = '1' 
ORDER BY
tbl_master_type_trainer.trainer_type_id ASC");
$qa->execute();
while($row= $qa->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$row->trainer_type_id'";
if ($dataRow['trainer_type_id'] == $row->trainer_type_id)
{
  echo "SELECTED";
}
echo ">$row->trainer_type_name</option>\n";
}

?>
                 
</select>
</div>

<div class="col-xs-4">

<label>สัญชาติ</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" name="nationality_id" id="nationality_id" required>
<?php
$qa1 = $qGeneral->runQuery(
"SELECT
tbl_master_nationality.nationality_id,
tbl_master_nationality.nationality_name
FROM
tbl_master_nationality
WHERE
tbl_master_nationality.nationality_status = '1' AND
tbl_master_nationality.is_delete = '1' 
ORDER BY
tbl_master_nationality.nationality_id ASC");
$qa1->execute();
while($rowA= $qa1->fetch(PDO::FETCH_OBJ)) {
    echo"<option value='$rowA->nationality_id'";
    if ($dataRow['nationality_id'] == $rowA->nationality_id)
    {
      echo "SELECTED";
    }
    echo ">$rowA->nationality_name</option>\n";
                 }
                 ?>
                 
</select>
</div> 


<div class="col-xs-4">

<label>ประเทศ</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" name="country_id" id="country_id" required>
<?php
$qa2 = $qGeneral->runQuery(
"SELECT
tbl_master_country.country_id,
tbl_master_country.country_name
FROM
tbl_master_country
WHERE
tbl_master_country.country_status = '1' AND
tbl_master_country.is_delete = '1' 
ORDER BY
tbl_master_country.country_id ASC");
$qa2->execute();
while($rowB= $qa2->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowB->country_id'";
if ($dataRow['country_id'] == $rowB->country_id)
{
echo "SELECTED";
}
echo ">$rowB->country_name</option>\n";
}
                 ?>
                 
</select>
</div> 

  <div class="col-xs-4">

<label>คำนำหน้า</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" name="title_name_th" id="title_name_th" required>
<?php
$qa3 = $qGeneral->runQuery(
"SELECT
tbl_master_titlename.title_id,
tbl_master_titlename.title_name
FROM
tbl_master_titlename
WHERE
tbl_master_titlename.title_status = '1' AND
tbl_master_titlename.is_delete = '1' AND
tbl_master_titlename.language_status = '1'
ORDER BY
tbl_master_titlename.title_id ASC");
$qa3->execute();
while($rowD= $qa3->fetch(PDO::FETCH_OBJ)) {
    echo"<option value='$rowD->title_name'";
    if ($dataRow['title_name_th'] == $rowD->title_name)
    {
      echo "SELECTED";
    }
    echo ">$rowD->title_name</option>\n";
}
                 ?>
                 
                    </select>
                </div>  
  <div class="col-xs-4">
<label >ชื่อจริง</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_firstname_th']?>" name="trainer_firstname_th" id="trainer_firstname_th" required placeholder="ชื่อจริง">
</div>
<div class="col-xs-4">
<label >นามสกุล</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_lastname_th']?>" name="trainer_lastname_th" id="trainer_lastname_th" required placeholder="นามสกุล">
</div>

<div class="col-xs-4">

<label>Title</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" value="<?=$dataRow['title_name_eng']?>" name="title_name_eng" id="title_name_eng" required>
<?php
$qa4 = $qGeneral->runQuery(
"SELECT
tbl_master_titlename.title_id,
tbl_master_titlename.title_name
FROM
tbl_master_titlename
WHERE
tbl_master_titlename.title_status = '1' AND
tbl_master_titlename.is_delete = '1' AND
tbl_master_titlename.language_status = '2'
ORDER BY
tbl_master_titlename.title_id ASC");
$qa4->execute();
while($rowE= $qa4->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowE->title_name'";
if ($dataRow['title_name_eng'] == $rowE->title_name)
{
echo "SELECTED";
}
echo ">$rowE->title_name</option>\n";
                 }
                 ?>
                 
                    </select>
                </div>  
  <div class="col-xs-4">
<label >Firstname</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_firstnam_eng']?>" name="trainer_firstnam_eng" id="trainer_firstnam_eng" required placeholder="Firstname">
</div>
<div class="col-xs-4">
<label >Lastname</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_lastname_eng']?>" name="trainer_lastname_eng" id="trainer_lastname_eng" required placeholder="Lastname">
</div>

<div class="col-xs-4">
<label >เลขบัตรประชาชน</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_card']?>"  name="trainer_card" id="trainer_card" required placeholder="เลขบัตรประชาชน" data-inputmask='"mask": "9999999999999"' data-mask>
</div>

<div class="col-xs-4">
<label >วันออกบัตร</label>        
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_card_Issue_date']);?>" name="trainer_card_Issue_date" id="trainer_card_Issue_date"  placeholder="วันออกบัตร" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันหมดอายุ   </label>   
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_card_expired']);?>"  name="trainer_card_expired" id="trainer_card_expired"  placeholder="วันหมดอายุ" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >Passport</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_Passport']?>"  name="trainer_Passport" id="trainer_Passport"  placeholder="Passport">
</div>

<div class="col-xs-4">
<label >วันออกบัตร</label>      
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_Passport_Issue_date']);?>" name="trainer_Passport_Issue_date" id="trainer_Passport_Issue_date"  placeholder="วันออกบัตร" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันหมดอายุ </label>     
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_Passport_card_expired']);?>" name="trainer_Passport_card_expired" id="trainer_Passport_card_expired"  placeholder="วันหมดอายุ" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันเกิด</label> <label style="color:red;">*</label>        
<input type="text"class="form-control pull-right"  value="<?php echo DatetoDMY($dataRow['trainer_birthday']);?>" name="trainer_birthday" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  placeholder="วันเกิด" >
<!-- <input type="text"class="form-control pull-right"  name="student_Passport" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepicker"  placeholder="วันเกิด" > -->
</div>

<div class="col-xs-4">
<label >อีเมล</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_email']?>" name="trainer_email" id="trainer_email"  placeholder="อีเมล">
</div>

<div class="col-xs-4">
<label >ไอดี LINE</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_line']?>" name="trainer_line" id="trainer_line"  placeholder="ไอดี LINE">
</div>

<div class="col-xs-4">
<label >เบอร์โทรศัพท์</label>    <label style="color:red;">*</label>      
<input type="text" class="form-control"  value="<?=$dataRow['trainer_phone']?>" name="trainer_phone" id="trainer_phone" required  placeholder="เบอร์โทรศัพท์" data-inputmask='"mask": "9999999999"' data-mask>
</div>

<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลใบอนุญาต</label>
<hr>
</div>


<div class="col-xs-4">
<label >รหัสครูฝึกประเภทจักรยานยนต์</label> 
<input type="text" class="form-control" value="<?=$dataRow['trainer_code_motorcycle']?>"  name="trainer_code_motorcycle" id="trainer_code_motorcycle" required placeholder="รหัสครูฝึกประเภทจักรยานยนต์">
</div>

<div class="col-xs-4">
<label >วันออกบัตร</label> 
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_motorcycle_Issue_date']);?>" name="trainer_code_motorcycle_Issue_date" id="trainer_code_motorcycle_Issue_date"  placeholder="วันออกบัตร" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันหมดอายุ </label>           
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_motorcycle_card_expired']);?>" name="trainer_code_motorcycle_card_expired" id="trainer_code_motorcycle_card_expired"  placeholder="วันหมดอายุ" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >รหัสครูฝึกประเภทรถยนต์</label>         
<input type="text" class="form-control" value="<?=$dataRow['trainer_code_car']?>" name="trainer_code_car" id="trainer_code_car"  placeholder="รหัสครูฝึกประเภทรถยนต์">
</div>

<div class="col-xs-4">
<label >วันออกบัตร</label>       
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_car_Issue_date']);?>" name="trainer_code_car_Issue_date" id="trainer_code_car_Issue_date"  placeholder="วันออกบัตร" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันหมดอายุ </label>       
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_car_card_expired']);?>" name="trainer_code_car_card_expired" id="trainer_code_car_card_expired"  placeholder="วันหมดอายุ" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >รหัสครูฝึกประเภทรถว่าด้วยกฏหมายขนส่งทางบก </label>     
<input type="text" class="form-control" value="<?=$dataRow['trainer_code_land_transport']?>" name="trainer_code_land_transport" id="trainer_code_land_transport"  placeholder="รหัสครูฝึกประเภทรถว่าด้วยกฏหมายขนส่งทางบก">
</div>

<div class="col-xs-4">
<label >วันออกบัตร</label>   
      
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_land_transport_Issue_date']);?>" name="trainer_code_land_transport_Issue_date" id="trainer_code_land_transport_Issue_date"  placeholder="วันออกบัตร" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>

<div class="col-xs-4">
<label >วันหมดอายุ </label>        
<input type="text" class="form-control" value="<?php echo DatetoDMY($dataRow['trainer_code_land_transport_card_expired']);?>"  name="trainer_code_land_transport_card_expired" id="trainer_code_land_transport_card_expired"  placeholder="วันหมดอายุ" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
</div>


<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลที่อยู่</label>
<hr>
</div>
<div class="col-xs-4">
<label >ที่อยู่</label>    <label style="color:red;">*</label>      
<input type="text" value="<?=$dataRow['trainer_address']?>" class="form-control" name="trainer_address" id="trainer_address" required   placeholder="ที่อยู่">
</div>

<div class="col-xs-4">         
                <label>เลือกจังหวัด</label> <label style="color:red;">*</label>
                <span id="province_id">
                <select class="form-control" required >
                <option value="" >- เลือกจังหวัด -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-4">
                <label>เลือกอำเภอ</label> <label style="color:red;">*</label>
                <span id="amphur_id">
                <select class="form-control" required >
                <option value="" >- เลือกอำเภอ -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-4">
                <label>เลือกตำบล</label> <label style="color:red;">*</label>
                <span id="district_id">
                <select class="form-control" required >
                <option value="" >- เลือกตำบล -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-4">
                <label>เลือกไปรษณีย์</label> <label style="color:red;">*</label>
                <span id="zipcode_id">
                <select class="form-control" required >
                <option value="" >- เลือกไปรษณีย์ -</option>
                </select>
                </span>
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
    echo"<option value='$rowI->school_id'";
    if ($dataRow['school_id'] == $rowI->school_id)
    {
      echo "SELECTED";
    }
    echo ">$rowI->school_name</option>\n";
}
                 ?>
                 
                    </select>
                </div> 


<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลอื่นๆ</label>
<hr>
</div>

<div class="col-xs-4">

<label>ประเภทการสอน</label> <label style="color:red;">*</label> 
                  
<select class="form-control select2" style="width: 100%;" name="teach_type_id" id="teach_type_id">
<?php
$qa5 = $qGeneral->runQuery(
"SELECT
tbl_master_type_teach.teach_type_id,
tbl_master_type_teach.teach_type_name
FROM
tbl_master_type_teach
WHERE
tbl_master_type_teach.teach_type_status = '1' AND
tbl_master_type_teach.is_delete = '1' 
ORDER BY
tbl_master_type_teach.teach_type_id ASC");
$qa5->execute();
while($rowF= $qa5->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowF->teach_type_id'";
if ($dataRow['school_id'] == $rowF->teach_type_id)
{
  echo "SELECTED";
}
echo ">$rowF->teach_type_name</option>\n";
                 }
                 ?>
                 
                    </select>
                </div> 

<div class="col-xs-12">
<br>
<label style="color:blue;"></label>
<hr>
</div>
                <div class="col-xs-4">
                   <label>สถานะการใช้งาน</label>
                   <select name="trainer_status" id="trainer_status"  class="form-control">
                   <option <?php if($dataRow['trainer_status']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($dataRow['trainer_status']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
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