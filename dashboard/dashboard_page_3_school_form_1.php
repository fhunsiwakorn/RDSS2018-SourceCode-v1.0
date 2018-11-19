<?php

if(isset($_POST['btn-submit-add']))
{   
     ///สร้างรหัสโรงเรียน
     $table  = 'tbl_school';
    $data_gen_id = random_password(20);
    $school_name = strip_tags($_POST['school_name']);
    $school_applicant_name = strip_tags($_POST['school_applicant_name']);
    $school_booknumber = strip_tags($_POST['school_booknumber']);
    $school_email = strip_tags($_POST['school_email']);
    $school_website = strip_tags($_POST['school_website']);
    $school_facebook = strip_tags($_POST['school_facebook']);
    $school_lineID = strip_tags($_POST['school_lineID']);
    $school_phone = strip_tags($_POST['school_phone']);
    $school_fax = strip_tags($_POST['school_fax']);
    $school_address = strip_tags($_POST['school_address']);
    $province_id = strip_tags($_POST['province_id']);
    $amphur_id = strip_tags($_POST['amphur_id']);
    $district_id = strip_tags($_POST['district_id']);
    $zipcode_id = strip_tags($_POST['zipcode_id']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
    $fields = [
      'data_gen_id' => $data_gen_id,
      'school_name' => $school_name,
      'school_applicant_name' => $school_applicant_name,
      'school_booknumber' => $school_booknumber,
      'school_email' => $school_email,
      'school_website' => $school_website,
      'school_facebook' => $school_facebook,
      'school_lineID' => $school_lineID,
      'school_phone' => $school_phone,
      'school_fax' => $school_fax,
      'school_address' => $school_address,
      'province_id' => $province_id,
      'amphur_id' => $amphur_id,
      'district_id' => $district_id,
      'zipcode_id' => $zipcode_id,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date
      
  ];
  
  try {
  
      /*
       * Have used the word 'object' as I could not see the actual 
       * class name.
       */
      $sql_process->insert($table, $fields);
  
  }catch(ErrorException $exception) {
  
       $exception->getMessage();  // Should be handled with a proper error message.
  
  }

    echo "<script>";
    echo "location.href = '?option=school-form-step-2&data_gen=$data_gen_id&success'";
    echo "</script>";
}
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
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนโรงเรียน
    <small>จัดการข้อมูลโรงเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=school-data">ทะเบียนโรงเรียน</a></li>
  <li class="active">ขั้นตอนที่ 1 แบบฟอร์มเพิ่มโรงเรียน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">ขั้นตอนที่ 1 แบบฟอร์มเพิ่มโรงเรียน</h3>
              
            </div>
            <div class="box-body">
            <form method="post">
              <div class="row">
                <div class="col-xs-6">
                <label >ชื่อโรงเรียน</label> <label style="color:red;">*</label>         
                  <input type="text" class="form-control" name="school_name" id="school_name" required placeholder="กรอกชื่อโรงเรียน">
                </div>
                <div class="col-xs-6">
                <label >ชื่อผู้ขอจัดตั้งโรงเรียน</label>  <label style="color:red;">*</label>        
                  <input type="text" class="form-control" name="school_applicant_name" id="school_applicant_name" required placeholder="กรอกชื่อผู้ขอจัดตั้งโรงเรียน">
                </div>
                <div class="col-xs-6">
                <label >เลขที่หนังสือรับรอง</label>  <label style="color:red;">*</label>        
                  <input type="text" class="form-control" name="school_booknumber" id="school_booknumber" required placeholder="กรอกหนังสือรับรอง">
                </div>
                <div class="col-xs-6">
                <label >อีเมล</label>   <label style="color:red;">*</label>       
                  <input type="email" class="form-control" name="school_email" id="school_email" required placeholder="กรอกอีเมล">
                </div>
                <div class="col-xs-6">
                <label >เว็บไซต์</label>          
                  <input type="text" class="form-control" name="school_website" id="school_website"  placeholder="กรอกเว็บไซต์">
                </div>
                <div class="col-xs-6">
                <label >facebook</label>          
                  <input type="text" class="form-control" name="school_facebook" id="school_facebook"  placeholder="กรอก facebook">
                </div>
                <div class="col-xs-6">
                <label >LINE ID</label>          
                  <input type="text" class="form-control" name="school_lineID" id="school_lineID"  placeholder="กรอก LINE ID">
                </div>
                <div class="col-xs-6">
                <label >โทร</label> <label style="color:red;">*</label>         
                  <input type="text" class="form-control" name="school_phone" id="school_phone" maxlength="10" required placeholder="กรอกเบอร์โทร">
                </div> 
                <div class="col-xs-6">
                <label >แฟกต์</label>          
                  <input type="text" class="form-control" name="school_fax" id="school_fax" maxlength="10"  placeholder="กรอกแฟกต์">
                </div> 
                <div class="col-xs-6">
                <label >ที่ตั้ง</label>   <label style="color:red;">*</label>       
                  <input type="text" class="form-control" name="school_address" id="school_address" required placeholder="กรอกที่ตั้ง">
                </div>
                <div class="col-xs-6">         
                <label>เลือกจังหวัด</label> <label style="color:red;">*</label>
                <span id="province_id">
                <select class="form-control" required >
                <option value="" >- เลือกจังหวัด -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกอำเภอ</label> <label style="color:red;">*</label>
                <span id="amphur_id">
                <select class="form-control" required >
                <option value="" >- เลือกอำเภอ -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกตำบล</label> <label style="color:red;">*</label>
                <span id="district_id">
                <select class="form-control" required >
                <option value="" >- เลือกตำบล -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกไปรษณีย์</label> <label style="color:red;">*</label>
                <span id="zipcode_id">
                <select class="form-control" required >
                <option value="" >- เลือกไปรษณีย์ -</option>
                </select>
                </span>
                </div>
                        
                <div class="form-group">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-add" class="btn btn-primary">ขั้นตอนถัดไป</button></center>
                </div>    
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


</section>
<!-- /.content -->
</div>