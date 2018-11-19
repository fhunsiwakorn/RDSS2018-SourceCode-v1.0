<?php
require_once('../class/class_masterdata_location.php');
$zipcode_list = new location_data();
if(isset($_POST['btn-submit-edit']))
{ 
  $zipcode_id= strip_tags($_POST['zipcode_idED']);
  $province_id= strip_tags($_POST['province_id']);
  $amphur_id = strip_tags($_POST['amphur_id']);
  $district_id = strip_tags($_POST['district_id']);
  $zipcode = strip_tags($_POST['zipcode']);
  $upd_by=$_SESSION['userSession'];  
  $zipcode_status = strip_tags($_POST['zipcode_status']);
$zipcode_list->edit_zipcode($zipcode_id,$province_id,$amphur_id,$district_id,$zipcode,$upd_by,$zipcode_status);
  echo "<script>";
  echo "location.href = '?option=zipcode-edit&ezd=$zipcode_id&success'";
  echo "</script>";
}

if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$zipcode_id_get = $_GET['ezd'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_location_zipcode WHERE zipcode_id=:zipcode_id_param");
$stmt->execute(array(":zipcode_id_param"=>$zipcode_id_get));
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
     req.open("GET", "../library/localtion.php?province_idE=<?=$dataRow['province_id']?>&amphur_idE=<?=$dataRow['amphur_id']?>&district_idE=<?=$dataRow['district_id']?>&data="+src+"&val="+val); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
     req.send(null); //ส่งค่า
}

window.onLoad=dochange('province_id', -1);
window.onLoad=dochange('amphur_id', -1);
window.onLoad=dochange('district_id', -1);

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
  <li ><a href="?option=zipcode">ข้อมูลตั้งต้น</a></li>
  <li ><a href="?option=zipcode">ไปรษณีย์</a></li>
  <li class="active">แก้ไขไปรษณีย์</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แก้ไขไปรษณีย์ </h3><br>
    <div class="box-body">
    <form  method="post" name="form_edit" id="form_edit">
    <input type="hidden" class="form-control" value="<?=$_GET['ezd']?>" name="zipcode_idED" id="zipcode_idED" required>
              <div class="modal-body">   
                  <div class="form-group">
                  <label for="exampleInputEmail1">ไปรษณีย์</label>
                  <input type="text" class="form-control" name="zipcode"  value="<?=$dataRow['zipcode']?>"  id="zipcode" required placeholder="กรอกไปรษณีย์">
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
                <label>เลือกตำบล</label>
                <span id="district_id">
                <select class="form-control" required >
                <option value="" >- เลือกตำบล -</option>
                </select>
                </span>
                </div>    
              
              <div class="form-group">
                <label>สถานะการใช้งาน</label>
                   <select name="zipcode_status" id="zipcode_status" style="width:100%;"  class="form-control">
                   <option <?php if($dataRow['zipcode_status']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($dataRow['zipcode_status']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
                  </select>
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