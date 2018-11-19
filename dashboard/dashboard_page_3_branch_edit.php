<?php

if(isset($_POST['btn-submit-edit']))
{
  $branch_id = strip_tags($_POST['branch_id']);
  $branch_name = strip_tags($_POST['branch_name']);
  $branch_number = isset($_POST['branch_number']) ? $_POST['branch_number'] : false; 
  $branch_address = strip_tags($_POST['branch_address']);
  $province_id = strip_tags($_POST['province_id']);
  $amphur_id = strip_tags($_POST['amphur_id']);
  $district_id = strip_tags($_POST['district_id']);
  $zipcode_id = strip_tags($_POST['zipcode_id']);
  $school_id = strip_tags($_POST['school_id']);
  $upd_by=$_SESSION['userSession'];
  $branch_status = strip_tags($_POST['branch_status']);

  $fields = [
    'branch_name' => $branch_name,
    'branch_number' => $branch_number,
    'branch_address' => $branch_address,
    'province_id' => $province_id,
    'amphur_id' => $amphur_id,
    'district_id' => $district_id,
    'zipcode_id' => $zipcode_id,
    'school_id' => $school_id,
    'upd_by' => $upd_by,
    'branch_status' => $branch_status
  ];
  $Where=['branch_id' => $branch_id];
  try {
  
    /*
     * Have used the word 'object' as I could not see the actual 
     * class name.
     */
    $sql_process->update($table, $fields,$Where);
  
  }catch(ErrorException $exception) {
  
     $exception->getMessage();  // Should be handled with a proper error message.
  
  }

  
  echo "<script>";
    echo "location.href = '?option=branch-data-edit&ebra=$branch_id&success'";
    echo "</script>";
}
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$branch_id_get = $_GET['ebra'];	
$stmt = $sql_process->runQuery("SELECT * FROM tbl_branch WHERE branch_id=:branch_id_param");
$stmt->execute(array(":branch_id_param"=>$branch_id_get));
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
              req.open("GET", "../library/localtion.php?province_idE=<?=$dataRow['province_id']?>&amphur_idE=<?=$dataRow['amphur_id']?>&district_idE=<?=$dataRow['district_id']?>&zipcode_idE=<?=$dataRow['zipcode_id']?>&data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         
         window.onLoad=dochange('province_id', -1);
         window.onLoad=dochange('amphur_id', -1);
         window.onLoad=dochange('district_id', -1);
         window.onLoad=dochange('zipcode_id', -1);
      
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
<li><a href="?option=branch-data"><i class="fa fa-dashboard"></i> ข้อมูลสาขา</a></li>
<li class="active">แก้ไขข้อมูลสาขา</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">แก้ไขข้อมูลสาขา</h3>
              
            </div>
            <div class="box-body">
            <form method="post"  id="form_add" name="form_add">
            <input type="hidden" name="branch_id" id="branch_id" value="<?=$_GET['ebra']?>" >
            <div class="row">
            <div class="col-xs-6">
            <label for="exampleInputEmail1">ชื่อสาขา/สำนักงาน</label> <label style="color:red;">*</label>
          
            <input type="text" class="form-control" value="<?=$dataRow['branch_name']?>" name="branch_name" id="branch_name" required placeholder="กรอกชื่อสาขา/สำนักงาน">
          </div> 
          <div class="col-xs-6">
            <label for="exampleInputEmail1">เลขที่สาขา/สาขาที่</label>
          
            <input type="text" class="form-control" value="<?=$dataRow['branch_number']?>" name="branch_number" id="branch_number"  placeholder="กรอกเลขที่สาขา/สาขาที่">
          </div>  
          <div class="col-xs-6">
            <label for="exampleInputEmail1">ที่ตั้ง</label> <label style="color:red;">*</label>
          
            <input type="text" class="form-control" value="<?=$dataRow['branch_address']?>" name="branch_address" id="branch_address" required placeholder="กรอกที่ตั้ง">
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
    
          <div class="col-xs-6">

             <label>โรงเรียน</label> <label style="color:red;">*</label>
             <select class="form-control select2" style="width: 100%;" name="school_id"  required>
             <?php
           $qa3 = $sql_process->runQuery(
           "SELECT
           tbl_school.school_id,
           tbl_school.school_name
           FROM
           tbl_school 
           WHERE
           tbl_school.is_delete='1'          
           ORDER BY
           tbl_school.school_id  ASC");
           $qa3->execute();
           while($rowC= $qa3->fetch(PDO::FETCH_OBJ)) {
           echo"<option value='$rowC->school_id'";
           if ($dataRow['school_id'] == $rowC->school_id)
           {
             echo "SELECTED";
           }
           echo ">$rowC->school_name</option>\n";
           }
           ?>
           
              </select>
          </div>  
          <div class="col-xs-6">

             <label>สถานะการใช้งาน</label>
             <select name="branch_status" id="branch_status"  class="form-control">
             <option <?php if($dataRow['branch_status']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
             <option <?php if($dataRow['branch_status']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>

           </select>

          </div>  
                
                <div class="col-xs-12">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกข้อมูล</button></center>
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