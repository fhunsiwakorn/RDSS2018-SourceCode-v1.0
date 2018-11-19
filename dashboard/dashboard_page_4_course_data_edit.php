<?php
if(isset($_POST['btn-submit-add']))
{
  $table  = 'tbl_course_data';
  $table2  = 'tbl_course_price';

  $course_code = strip_tags($_POST['course_code']);
  $course_data_code = strip_tags($_POST['course_data_code']);
  $course_data_name = strip_tags($_POST['course_data_name']);
  $course_group_id = strip_tags($_POST['course_group_id']);
  $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
  $course_data_theory_hour = strip_tags($_POST['course_data_theory_hour']);
  $course_data_practice_hour = strip_tags($_POST['course_data_practice_hour']);
  $course_data_total_hour = strip_tags($_POST['course_data_total_hour']);

  $school_id = strip_tags($_POST['school_id']);
  $upd_by=$_SESSION['userSession'];
  $course_data_status = strip_tags($_POST['course_data_status']);

  
  $fields = [
    'course_data_code' => $course_data_code,
    'course_data_name' => $course_data_name,
    'course_group_id' => $course_group_id,
    'vehicle_type_id' => $vehicle_type_id,
    'course_data_theory_hour' => $course_data_theory_hour,
    'course_data_practice_hour' => $course_data_practice_hour,
    'course_data_total_hour' => $course_data_total_hour,
    'school_id' => $school_id,
    'upd_by' => $upd_by,
    'course_data_status' => $course_data_status
 
  ];
  $Where=['course_code' => $course_code];
  try {
  
    /*
     * Have used the word 'object' as I could not see the actual 
     * class name.
     */
    $sql_process->update($table, $fields,$Where);
  
  }catch(ErrorException $exception) {
  
     $exception->getMessage();  // Should be handled with a proper error message.
  
  }

/////ราคาหลักสูตร
if(isset($_POST['cp_price']) && !empty($_POST['cp_price'])){
  $cp_price = strip_tags($_POST['cp_price']);
  $fields2=['cp_price' => $cp_price,'course_code' => $course_code,'school_id' => $school_id];
  $Where2=['course_code' => $course_code,'school_id' => $school_id];
try {

  /*
   * Have used the word 'object' as I could not see the actual 
   * class name.
   */
  $total_data =$sql_process->rowsQuery("SELECT course_code FROM $table2 WHERE course_code='$course_code' AND school_id='$school_id'");
 if($total_data <=0){
  $sql_process->insert($table2, $fields2);
 }else{
  $sql_process->update($table2, $fields2,$Where2); 
 }
 

}catch(ErrorException $exception) {

   $exception->getMessage();  // Should be handled with a proper error message.

  }
}

    echo "<script>";
    echo "location.href = '?option=course-data-edit&coecode=$course_code&success'";
    echo "</script>";
}
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$course_code_get = $_GET['coecode'];	
$stmt = $sql_process->runQuery("SELECT * FROM tbl_course_data WHERE course_code=:course_code_param");
$stmt->execute(array(":course_code_param"=>$course_code_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!-- ////คำนวนหาชัวโมง -->
<script language='javascript' type='text/javascript'>
    function plus(){
   var one = document.form_add.course_data_theory_hour.value;
   var two = document.form_add.course_data_practice_hour.value;
   if(one == "" || two == ""){return false;}
   var three = 0;
   three = Number(one)  + Number(two);
   form_add.course_data_total_hour.value = three;
   }
  </script>

<script language="javascript">
function CheckNum(){
		if (event.keyCode < 48 || event.keyCode > 57){
		      event.returnValue = false;
	    	}
	}
</script>
<script language="JavaScript">
						function chkNumber(ele)
						{
						var vchar = String.fromCharCode(event.keyCode);
						if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
						ele.onKeyPress=vchar;
						}
						</script>
<!-- ป้องกัน Copy Paste -->
 <script type="text/javascript">
function noPaste(event)
{
    var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();
    if (event.ctrlKey && pressedKey == 'v')
    {
        // alert('กรุณากรอกเฉพาะตัวเลข');
        swal("กรุณากรอกเฉพาะตัวเลข !", "ปิดหน้าต่างนี้!", "error");
        return false;
    }
}
 
function noRightClick(event)
{
    if (event.button==2)
    {
        // alert("ไม่อนุญาต!");
        swal("ไม่อนุญาต !", "ปิดหน้าต่างนี้!", "error");
    }
}
</script>   
<!--END ป้องกัน Copy Paste -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนหลักสูตร
    <small>จัดการข้อมูลทะเบียนหลักสูตร</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=course-data">ทะเบียนหลักสูตร</a></li>
  <li class="active">แก้ไขหลักสูตร</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">แก้ไขหลักสูตร</h3>
              
            </div>
            <div class="box-body">
       
            <form  method="post" name="form_add" id="form_add">
<input type="hidden" name="course_code" id="course_code" value="<?=$_GET["coecode"]?>"/>
<div class="row">
              <div class="col-xs-6">
                  <label for="exampleInputEmail1">รหัสหลักสูตร</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" value="<?=$dataRow["course_data_code"]?>" name="course_data_code" id="course_data_code" required placeholder="กรอกรหัสหลักสูตร">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ชื่อหลักสูตร</label> <label style="color:red;">*</label>
                
                  <input type="text"  class="form-control" value="<?=$dataRow["course_data_name"]?>"  name="course_data_name" id="course_data_name" required placeholder="กรอกชื่อหลักสูตร">
                </div>  
                <div class="col-xs-6">

                   <label>กลุ่มหลักสูตร</label> <label style="color:red;">*</label>
                   <select class="form-control" name="course_group_id"  >
                   <option value="">-- เลือกลุ่มหลักสูตร --</option>
                   <?php
                 $qa = $sql_process->runQuery(
                 "SELECT
                 tbl_course_group.course_group_id,
                 tbl_course_group.course_group_name,
                 tbl_course_group.course_group_subject_auto
                 FROM
                 tbl_course_group
                 WHERE
                 tbl_course_group.course_status='1' AND
                 tbl_course_group.is_delete ='1'
                 ORDER BY
                 tbl_course_group.course_group_id  ASC");
                 $qa->execute();
                 while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
            //  echo "<option value='$rowA->course_group_id'>$rowA->course_group_name</option>";

             echo"<option value='$rowA->course_group_id'";
             if ($dataRow['course_group_id'] == $rowA->course_group_id)
             {
               echo "SELECTED";
             }
             echo ">$rowA->course_group_name</option>\n";
              }
           
                 
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-6">

                   <label>ประเภทหลักสูตร</label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type_id"  >
                   <option value="">-- เลือกประเภทหลักสูตร --</option>
                   <?php
                 $qa2 = $sql_process->runQuery(
                 "SELECT
                 tbl_master_vehicle_type.vehicle_type_id,
                 tbl_master_vehicle_type.vehicle_type_name
                
                 FROM
                 tbl_master_vehicle_type
                 WHERE
                 tbl_master_vehicle_type.vehicle_type_status='1' AND
                 tbl_master_vehicle_type.is_delete ='1'
                 ORDER BY
                 tbl_master_vehicle_type.vehicle_type_id  ASC");
                 $qa2->execute();
                 while($rowB= $qa2->fetch(PDO::FETCH_OBJ)) {
            //  echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
             echo"<option value='$rowB->vehicle_type_id'";
             if ($dataRow['vehicle_type_id'] == $rowB->vehicle_type_id)
             {
               echo "SELECTED";
             }
             echo ">$rowB->vehicle_type_name</option>\n";
              }
                 
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนทฤษฎี </label> <label style="color:red;">*</label>
                
                  <input OnKeyPress="return chkNumber(this)" value="<?=$dataRow["course_data_theory_hour"]?>"  autocomplete="off" maxlength="2" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" class="form-control" name="course_data_theory_hour" id="course_data_theory_hour" onchang="plus()" onkeyup='plus()' required >
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนปฏิบัติ</label> <label style="color:red;">*</label>
                
                  <input  OnKeyPress="return chkNumber(this)" autocomplete="off" maxlength="2" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" class="form-control" name="course_data_practice_hour" id="course_data_practice_hour"  value="<?=$dataRow["course_data_practice_hour"]?>"   onchang="plus()" onkeyup='plus()'  required >
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนรวม</label> <label style="color:red;">*</label>
                
                  <input OnKeyPress="return chkNumber(this)"     autocomplete="off" maxlength="3" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);"  OnKeyPress="return chkNumber(this)" class="form-control" name="course_data_total_hour" id="course_data_total_hour"  value="<?=$dataRow["course_data_total_hour"]?>"   required>
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ราคา</label>
                
                  <input OnKeyPress="return chkNumber(this)"  autocomplete="off" maxlength="10" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);"  class="form-control" name="cp_price" id="cp_price" value=""  >
                </div>
                <div class="col-xs-6">

                   <label>โรงเรียน</label>
                   <select class="form-control select2" style="width: 100%;" name="school_id"  >
                   <option value="0">-- หลักสูตรพื้นฐานสำหรับทุกโรงเรียน --</option>
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
                //  echo "<option value='$rowC->school_id'>$rowC->school_name</option>";
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
                   <select name="course_data_status" id="course_data_status"  class="form-control">
                   <option <?php if($dataRow['course_data_status']=='1'){echo "SELECTED";} ?>  value="1">เปิด</option>
                   <option <?php if($dataRow['course_data_status']=='0'){echo "SELECTED";} ?>  value="0">ปิด</option>

                 </select>
                 </div>  
                 <div class="col-xs-12">
                 </br>
                 </hr>
                 <button type="sumbit" name="btn-submit-add" class="btn btn-primary btn-block">บันทึกข้อมูล</button>
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