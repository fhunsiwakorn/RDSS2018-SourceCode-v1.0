<?php
  $table="tbl_dlt_data";
if(isset($_POST['btn-submit-add']))
{   
    $transportation_office_id = strip_tags($_POST['transportation_office_id']);
    $transportation_office_name = strip_tags($_POST['transportation_office_name']);
    $province_id = strip_tags($_POST['province_id']);
    $amphur_id = strip_tags($_POST['amphur_id']);
    $trans_status = strip_tags($_POST['trans_status']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
  

    $fields = [
      'transportation_office_id' => $transportation_office_id,
      'transportation_office_name' => $transportation_office_name,
      'province_id' => $province_id,
      'amphur_id' => $amphur_id,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date,
      'trans_status' => $trans_status
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
    echo "location.href = '?option=DLT-data&success'";
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
  สำนักงานขนส่งจังหวัด
    <small>จัดการข้อมูลสำนักงานขนส่งจังหวัด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=DLT-form">สำนักงานขนส่งจังหวัด</a></li>
  <li class="active">แบบฟอร์มเพิ่มสำนักงานขนส่งจังหวัด</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">สำนักงานขนส่งจังหวัด</h3>
              
            </div>
            <div class="box-body">
            <form method="post">
              <div class="row">

                <div class="col-xs-6">
                <label >รหัสสำนักงานขนส่ง</label> <label style="color:red;">*</label>         
                  <input type="text" class="form-control" name="transportation_office_id" id="transportation_office_id" required placeholder="รหัสสำนักงานขนส่ง">
                </div>

                <div class="col-xs-6">
                <label >ชื่อสำนักงานขนส่ง</label>  <label style="color:red;">*</label>        
                  <input type="text" class="form-control" name="transportation_office_name" id="transportation_office_name" required placeholder="ชื่อสำนักงานขนส่ง">
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
                   <label>สถานะการใช้งาน</label>
                   <select name="trans_status" id="trans_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>
                 </select>
                </div>     

                 
                <div class="col-xs-12">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button></center>
                   	
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