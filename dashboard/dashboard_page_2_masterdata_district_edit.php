<?php
require_once('../class/class_masterdata_location.php');
$district_list = new location_data();
if(isset($_POST['btn-submit-edit']))
{
  $district_id= strip_tags($_POST['district_idED']);
  $district_code = strip_tags($_POST['district_code']);
  $district_name = strip_tags($_POST['district_name']);
  $amphur_id = strip_tags($_POST['amphur_id']);
  $province_id = strip_tags($_POST['province_id']);
  $upd_by=$_SESSION['userSession'];  
  $district_status = strip_tags($_POST['district_status']);
$district_list->edit_district($district_id,$district_code,$district_name,$amphur_id,$province_id,$upd_by,$district_status);
  echo "<script>";
  echo "location.href = '?option=district-edit&edd=$district_id&success'";
  echo "</script>";
}

if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$district_id_get = $_GET['edd'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_location_district WHERE district_id=:district_id_param");
$stmt->execute(array(":district_id_param"=>$district_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
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
     req.open("GET", "../library/localtion.php?province_idE=<?=$dataRow['province_id']?>&amphur_idE=<?=$dataRow['amphur_id']?>&data="+src+"&val="+val); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
     req.send(null); //ส่งค่า
}

window.onLoad=dochange('province_id', -1);
window.onLoad=dochange('amphur_id', -1);


</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ข้อมูลตั้งต้น
    <small>จัดการข้อมูลตั้งต้น</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=district">ข้อมูลตั้งต้น</a></li>
  <li ><a href="?option=district">ตำบล</a></li>
  <li class="active">แก้ไขตำบล</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แก้ไขตำบล</h3><br>
    <div class="box-body">
    <form  method="post" name="form_edit" id="form_edit">
    <input type="hidden" class="form-control" value="<?=$_GET['edd']?>" name="district_idED" id="district_idED" required>
              <div class="modal-body">   
              <div class="form-group">
                  <label for="exampleInputEmail1">รหัสตำบล</label>
                  <input type="text" class="form-control" maxlength="6" value="<?=$dataRow['district_code']?>" name="district_code" id="district_code" required placeholder="รหัสตำบล">
                  </div>
                  <div class="form-group">
                  <label for="exampleInputEmail1">ตำบล</label>
                  <input type="text" class="form-control" name="district_name"  value="<?=$dataRow['district_name']?>"  id="district_name" required placeholder="กรอกตำบล">
             </div>      
         
                <div class="form-group">
                <label>เลือกจังหวัด</label>
                <span id="province_id">
                <select class="form-control" required >
                <option value="" >- เลือกจังหวัด -</option>
                </select>
                </span>
                </div>   
                <div class="form-group">
                <label>เลือกอำเภอ</label>
                <span id="amphur_id">
                <select class="form-control" required >
                <option value="">- เลือกอำเภอ -</option>
                </select>
                </span>
                </div>  
                <div class="form-group">
                <label>สถานะการใช้งาน</label>
                   <select name="district_status" id="district_status" style="width:100%;"  class="form-control">
                   <option <?php if($dataRow['district_status']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($dataRow['district_status']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
                  </select>
                </div>    
              </div>  
              <div class="form-group">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกข้อมูล</button></center>
                </div>    
</form>
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

