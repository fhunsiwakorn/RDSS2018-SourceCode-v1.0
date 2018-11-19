<?php

require_once ('dashboard_page_5_student_form_logChk.php');
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
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
              req.open("GET", "../library/localtion.php?data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         
         window.onLoad=dochange('province_id', -1);
      
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
  ทะเบียนนักเรียน
    <small>จัดการข้อมูลนักเรียนทั้งหมด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=student-form">ทะเบียนนักเรียน</a></li>
  <li class="active">แบบฟอร์มเพิ่มนักเรียน</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แบบฟอร์มเพิ่มนักเรียน</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
   
<form enctype="multipart/form-data" method="post"   runat="server" name="student_add" id="student_add">

    <div class="col-xs-12">
<ul class="gallery">
<input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" id="imageupload">
<li><img  src="../images/images_system/default-avatarv9899025.gif" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
<a href="#" data-toggle="tooltip" title="คลิ๊กเพื่ออัพโหลดรูปภาพ" name="uploadbutton" onclick="imageupload.click()"><span class="photo"></span></a></li>
  </ul>
  </div>

  <div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลส่วนตัว</label>
<hr>
</div>

  <div class="col-xs-4">
<label>ประเภทผู้สมัคร</label>  <label style="color:red;">*</label> 
  <select name="student_type_register" id="student_type_register"  class="form-control" required>
  <option value="1">ไทย</option>
  <option value="2">ต่างชาติ</option>
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
                 echo "<option value='$rowA->nationality_id'>$rowA->nationality_name</option>";
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
                 echo "<option value='$rowB->country_id'>$rowB->country_name</option>";
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
                 echo "<option value='$rowD->title_name'>$rowD->title_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
  <div class="col-xs-4">
<label >ชื่อจริง</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" name="student_firstname_th" id="student_firstname_th" required placeholder="ชื่อจริง">
</div>
<div class="col-xs-4">
<label >นามสกุล</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" name="student_lastname_th" id="student_lastname_th" required placeholder="นามสกุล">
</div>

<div class="col-xs-4">

<label>Title</label>   <label style="color:red;">*</label> 
                  
<select class="form-control" style="width: 100%;" name="title_name_eng" id="title_name_eng" required>
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
                 echo "<option value='$rowE->title_name'>$rowE->title_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
  <div class="col-xs-4">
<label >Firstname</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" name="student_firstnam_eng" id="student_firstnam_eng" required placeholder="Firstname">
</div>
<div class="col-xs-4">
<label >Lastname</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" name="student_lastname_eng" id="student_lastname_eng" required placeholder="Lastname">
</div>

<div class="col-xs-4">
<label >เลขบัตรประชาชน</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" name="student_ID_card" id="student_ID_card" required placeholder="เลขบัตรประชาชน" data-inputmask='"mask": "9999999999999"' data-mask>
</div>

<div class="col-xs-4">
<label >Passport</label>         
<input type="text" class="form-control" name="student_Passport" id="student_Passport"  placeholder="Passport">
</div>

<div class="col-xs-4">
<label >วันเกิด</label> <label style="color:red;">*</label>         
<input type="text"class="form-control pull-right"  name="student_birthday" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  placeholder="วันเกิด" >
<!-- <input type="text"class="form-control pull-right"  name="student_Passport" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepicker"  placeholder="วันเกิด" > -->
</div>

<div class="col-xs-4">
<label >อีเมล</label>         
<input type="text" class="form-control" name="student_email" id="student_email"  placeholder="อีเมล">
</div>

<div class="col-xs-4">
<label >ไอดี LINE</label>         
<input type="text" class="form-control" name="student_line" id="student_line"  placeholder="ไอดี LINE">
</div>

<div class="col-xs-4">
<label >เบอร์โทรศัพท์</label>    <label style="color:red;">*</label>      
<input type="text" class="form-control" name="student_phone" id="student_phone" required  placeholder="เบอร์โทรศัพท์" data-inputmask='"mask": "9999999999"' data-mask>
</div>


<div class="col-xs-12">
<br>
<label style="color:blue;">ข้อมูลที่อยู่</label>
<hr>
</div>
<div class="col-xs-4">
<label >ที่อยู่</label>    <label style="color:red;">*</label>      
<input type="text" class="form-control" name="student_address" id="student_address" required   placeholder="ที่อยู่">
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
                 echo "<option value='$rowI->school_id'>$rowI->school_name</option>";
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
<label >ความพิการ</label>    
<input type="text" class="form-control" name="student_disability" id="student_disability"   placeholder="ความพิการ">
</div>

<div class="col-xs-4">
<label >โรคประจำตัว</label> 
<input type="text" class="form-control" name="student_congenital_disease" id="student_congenital_disease"    placeholder="โรคประจำตัว">
</div>

<div class="col-xs-4">

<label>อาชีพ</label> 
                  
<select class="form-control select2" style="width: 100%;" name="career_id" id="career_id">
<option value="">-- เลือกอาชีพ --</option>
<?php
$qa5 = $qGeneral->runQuery(
"SELECT
tbl_master_career.career_id,
tbl_master_career.career_name
FROM
tbl_master_career
WHERE
tbl_master_career.career_status = '1' AND
tbl_master_career.is_delete = '1' 
ORDER BY
tbl_master_career.career_id ASC");
                 $qa5->execute();
                 while($rowF= $qa5->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowF->career_id'>$rowF->career_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  


<div class="col-xs-4">

<label>รายได้</label> 
                  
<select class="form-control select2" style="width: 100%;" name="income_id" id="income_id" >
<option value="">-- เลือกรายได้ --</option>
<?php
$qa6 = $qGeneral->runQuery(
"SELECT
tbl_master_income.income_id,
tbl_master_income.income_text
FROM
tbl_master_income
WHERE
tbl_master_income.income_status = '1' AND
tbl_master_income.is_delete = '1' 
ORDER BY
tbl_master_income.income_id ASC");
                 $qa6->execute();
                 while($rowG= $qa6->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowG->income_id'>$rowG->income_text</option>";
                 }
                 ?>
                 
                    </select>
                </div> 

   
<div class="col-xs-4">
<label >ชื่อผู้ที่สามารถติดต่อได้</label> 
<input type="text" class="form-control" name="memer_contact" id="memer_contact"    placeholder="ชื่อผู้ที่สามารถติดต่อได้">
</div>
<div class="col-xs-4">
<label >เบอร์ผู้ที่สามารถติดต่อได้</label> 
<input type="text" class="form-control" name="memer_contact_phone" id="memer_contact_phone"    placeholder="เบอร์ผู้ที่สามารถติดต่อได้" data-inputmask='"mask": "9999999999"' data-mask>
</div>

<div class="col-xs-12">

<label>เหตุผลที่มาเรียน</label> 
                  
<select multiple  class="form-control" style="width: 100%;" name="reason_id" id="reason_id" >
<!-- <option value="">-- เลือกเหตุผลที่มาเรียน --</option> -->
<?php
$row_num=0;
$qa7 = $qGeneral->runQuery(
"SELECT
tbl_master_reason.reason_id,
tbl_master_reason.reason_text
FROM
tbl_master_reason
WHERE
tbl_master_reason.reason_status = '1' AND
tbl_master_reason.is_delete = '1' 
ORDER BY
tbl_master_reason.reason_id ASC");
                 $qa7->execute();
                 while($rowH= $qa7->fetch(PDO::FETCH_OBJ)) {
                  $row_num++;
                 echo "<option value='$rowH->reason_id'>$row_num.) $rowH->reason_text</option>";
                 }
                 ?>
                 
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