<?php
require_once('../class/class_subject.php');
$subject_data_list = new subject_data();
$vehicle_type_id = isset($_GET['vehicle_type']) ? $_GET['vehicle_type'] : NULL; 
$school_id = isset($_GET['school']) ? $_GET['school'] : NULL; 
require_once('dashboard_page_4_subject_permission_theory_logChk.php');
$gr_month = isset($_GET['gr_month']) ? $_GET['gr_month'] : date("m"); 
$gr_year = isset($_GET['gr_year']) ? $_GET['gr_year'] : date("Y"); 
?>

<script language="JavaScript">
var checkflag_d1 = "false";
function checkAll_d1(field)
{
    if (checkflag_d1 == "false") {
        for (i = 0; i < field.length; i++)
       {
             field[i].checked = true;
        }
             checkflag_d1 = "true";
   }
   else
   {
        for (i = 0; i < field.length; i++)
        {
             field[i].checked = false;
        }
             checkflag_d1 = "false";
   }
}
</script>
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
              req.open("GET", "../library/for_permission_theory.php?data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         
         window.onLoad=dochange('school_id_x', -1);
     </script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ทะเบียนหลักสูตร
  <small>กำหนดวันเรียนทฤษฏี</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=permission-theory-subjetct">ทะเบียนหลักสูตร</a></li>
  <li class="active">กำหนดวันเรียนทฤษฏี</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดวันเรียนทฤษฏี</h3><br>
      <div class="box-tools pull-right">

      </div>
    <div class="box-body">
    <div class="nav-tabs-custom">
   
            <ul class="nav nav-tabs">
              <li class="<?php if(empty($_GET['qs'])){ echo "active"; } ?>"><a href="#tab_1" data-toggle="tab">ตารางอบรมทฤษฎี</a></li>
              <li><a href="#tab_2" data-toggle="tab">กำหนดอบรมทฤษฎีแบบอัตโนมัติ</a></li>
              <li class="<?php if(!empty($_GET['qs'])){ echo "active"; } ?>"><a href="#tab_3" data-toggle="tab">กำหนดอบรมทฤษฎีแบบขั้นสูง</a></li>
            </ul>
            <div class="tab-content">
          
              <div class="tab-pane <?php if(empty($_GET['qs'])){ echo "active"; } ?>" id="tab_1">


                   <form method="get">
                       <div class="col-xs-4">
                       
              <label>โรงเรียน</label> <label style="color:red;">*</label>
                   <input type="hidden" name="option" value="<?=$_GET["option"];?>">
                   <select class="form-control select2" onchange='submit();' style="width: 100%;" name="school" id="school_id" required>
                   <option value="">--เลือกโรงเรียน--</option>
                   <?php
                 $qa1 = $qGeneral->runQuery(
                 "SELECT
                 tbl_school.school_id,
                 tbl_school.school_name
                 FROM
                 tbl_school       
                    WHERE
                tbl_school.is_delete='1'    
                 ORDER BY
                 tbl_school.school_id  ASC");
                 $qa1->execute();
                 while($rowN= $qa1->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowD->school_id'>$rowD->school_name</option>";
                echo"<option value='$rowN->school_id'"; 
                if ($school_id == $rowN->school_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowN->school_name</option>\n";

                 }
                 ?>
                    </select>
                    </div>

                    <div class="col-xs-4">
                    <label >เดือน</label> <label style="color:red;">*</label>   
<select name="gr_month" id="gr_month" class="form-control" required onchange="submit();">
  <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม");?>
  <?php for($i=0; $i<sizeof($month); $i++) {
   $i2=$i+1;
// echo '<option value="'.$i2.'">'.$month[$i].'</option>';

echo"<option value='$i2'";
if ($gr_month == $i2)
{
  echo "SELECTED";
}
echo ">$month[$i]</option>\n";
    }
  ?>
</select>
     </div>

 <div class="col-xs-4">
<label >ปี</label> <label style="color:red;">*</label>         
<select name="gr_year" id="gr_year" class="form-control" required onchange="submit();">
<option value="" >--เลือกปี--</option>
<?php
for($i=2014;$i<=2050;$i++){
$i2=sprintf("%02d",$i); // ฟอร์แมตรูปแบบให้เป็น 00
$yt=$i2+543; //ปีไทย
// echo '<option value="'.$i2.'">'.$yt.'</option>';
echo"<option value='$i2'";
if ($gr_year == $i2)
{
  echo "SELECTED";
}
echo ">$yt</option>\n";

  }
  ?>
</select>
</div>
    </form>
                   
                   
                    </br></br>
             
              <table id="example5" class="table table-bordered table-striped">
    <thead>
      <tr>
      <th>ลำดับ </th>         
        <th>วันที่ </th>
        <th>ช่วงเวลา</th>
        <th>ชั่วโมงเรียน</th>
        <th>ประเภทหลักสูตร</th>
        <th>รหัส</th>
        <th>รายวิชา</th>
        <th>วิทยากร</th>
        <th>จัดการ</th>
        
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qx = $subject_data_list->runQuery(
"SELECT
tbl_subject_theory.st_id,
tbl_subject_theory.subject_data_id,
tbl_subject_theory.st_hour,
tbl_subject_theory.st_start_time,
tbl_subject_theory.st_end_time,
tbl_subject_theory.st_date,
tbl_subject_theory.trainer_id,
tbl_subject_theory.school_id,
tbl_subject_theory.st_code,
tbl_subject_theory.crt_by,
tbl_subject_theory.crt_date,
tbl_subject_theory.upd_by,
tbl_subject_theory.upd_date,
tbl_subject_data.subject_data_name,
tbl_subject_data.subject_data_code,
tbl_subject_theory.school_id,
tbl_school.school_name,
tbl_master_vehicle_type.vehicle_type_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th
FROM
tbl_subject_theory , 
tbl_subject_data ,
tbl_school ,
tbl_master_vehicle_type ,
tbl_trainer_data
WHERE
tbl_subject_theory.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_theory.school_id = tbl_school.school_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_subject_theory.trainer_id = tbl_trainer_data.trainer_id AND
tbl_subject_theory.school_id=:school_id_param AND
tbl_subject_theory.is_delete='1' AND
MONTH(tbl_subject_theory.st_date)='$gr_month' AND
YEAR(tbl_subject_theory.st_date)='$gr_year'
ORDER BY
tbl_subject_theory.st_id DESC
"); 

$qx->execute(array(":school_id_param"=>$school_id));
while($rowGenx= $qx->fetch(PDO::FETCH_OBJ)) {
  $num_gen++;
?>
      <tr> 
<td align="center"><?=$num_gen?></td>
        <td><?php echo DateThai($rowGenx->st_date);?></td>
        <td align="center"><?=$rowGenx->st_start_time?> - <?=$rowGenx->st_end_time?></td>
        <td align="center"><?=$rowGenx->st_hour?></td>
        <td><?=$rowGenx->vehicle_type_name?></td>
        <td><?=$rowGenx->subject_data_code?></td>
        <td title="<?=$rowGenx->subject_data_name?>"><div class="cutword"><?=$rowGenx->subject_data_name?></div></td>
        <td><?=$rowGenx->trainer_firstname_th?> <?=$rowGenx->trainer_lastname_th?></td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" title="แก้ไข" data-toggle="modal" data-target="#modal-edit-<?=$num_gen?>">
        แก้ไข
       
        </button>
        <button type="button" class="btn btn-warning"  OnClick="move2<?=$num_gen?>()">
        ลบ
      
        </button>
        </div>
        </div>
        
  <!-- สำหรับกำหนดรายวิชาบังคับกรม -->
  <script>
                        function move2<?=$num_gen?>() {
                          swal({
                            title: "ยืนยันการลบข้อมูล",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ใช่!",
                            cancelButtonText: "ไม่ใช่!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                          },
                          function(isConfirm){
                            if (isConfirm) {
                              swal("บันทึกข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                            location.href = '?option=permission-theory-subjetct&school=<?=$school_id?>&Del=<?=$rowGenx->st_id?>';
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
               </script>
  <!-- Modal EDIT -->
  <div class="modal fade" id="modal-edit-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แก้ไข</h4>
              </div>
              <div class="modal-body">
              <form  method="post" name="form_<?=$num_gen?>"id="form_<?=$num_gen?>">
              <input type="hidden" class="form-control"  name="st_id" value="<?=$rowGenx->st_id?>" required>
              <input type="hidden" class="form-control"  name="school_id" value="<?=$rowGenx->school_id?>" required>
              <label >โรงเรียน</label>
                 <input style="width:100%;" type="text" class="form-control"  readonly  value="<?=$rowGenx->school_name?>">
                
                 <label >ชั่วโมงเรียน</label><label style="color:red;">*</label>
                  <input style="width:100%;"  type="text" class="form-control" name="st_hour" id="st_hour" value="<?=$rowGenx->st_hour?>"  required >

               
                <label >เวลาเริ่ม</label> <label style="color:red;">*</label>
                 <input style="width:100%;" type="time" class="form-control" name="st_start_time" id="st_start_time" value="<?=$rowGenx->st_start_time?>" required >
                  <label >เวลาสิ้นสุด</label><label style="color:red;">*</label>
                  <input style="width:100%;"  type="time" class="form-control" name="st_end_time" id="st_end_time" value="<?=$rowGenx->st_end_time?>"  required >

  <label >วันที่</label> <label style="color:red;">*</label>
<input type="text" style="width:100%;"  name="st_date" value="<?php echo DatetoDMY($rowGenx->st_date); ?>" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepickerUpdate<?=$num_gen?>" required />
                
 <label>วิทยากร </label> <label style="color:red;">*</label> 
 <select class="form-control select2" style="width:100%;" name="trainer_id" id="trainer_id" required>
 <option value="">--เลือกวิทยากร--</option>
       <?php
     $qaT= $qGeneral->runQuery(
     "SELECT
     tbl_trainer_data.trainer_id,
     tbl_trainer_data.trainer_firstname_th,
     tbl_trainer_data.trainer_lastname_th
     FROM
     tbl_trainer_data       
        WHERE
        tbl_trainer_data.is_delete='1'  AND
        tbl_trainer_data.school_id=:school_id_param
     ORDER BY
     tbl_trainer_data.trainer_id  ASC");
    //  $qa4->execute();
     $qaT->execute(array(":school_id_param"=>$school_id));
     while($rowT= $qaT->fetch(PDO::FETCH_OBJ)) {
     echo"<option value='$rowT->trainer_id'";
     if ($rowGenx->trainer_id == $rowT->trainer_id)
     {
       echo "SELECTED";
     }
     echo ">$rowT->trainer_firstname_th $rowT->trainer_lastname_th </option>\n";
     }
     ?>
        </select>

                <script>
 //Date picker
 $('#datepickerUpdate<?=$num_gen?>').datepicker({
      format : "dd/mm/yyyy",
      autoclose: true,
  language: 'th'
    })
</script>
              </div>
              <br>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit" name="s_update" class="btn btn-success" name="btn-submit-edit">บันทึกข้อมูล</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->    

        </td>

      </tr>

<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ </th>         
        <th>วันที่ </th>
        <th>ช่วงเวลา</th>
        <th>ชั่วโมงเรียน</th>
        <th>ประเภทหลักสูตร</th>
        <th>รหัส</th>
        <th>รายวิชา</th>
        <th>วิทยากร</th>
        <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>          


              </div>
              <!-- /.tab-pane -->
              <!-- กำหนดอบรมทฤษฎีแบบอัตโนมัติ -->
              <div class="tab-pane" id="tab_2">
   
              <form method="post">
         <input type="hidden" name="option" value="permission-theory-subjetct">
         <input type="hidden" name="form_auto" value="<?php echo time();?>">
               
         <div class="col-xs-12">
         <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type_id" id="vehicle_type_id" required>
               <option value="">--เลือกประเภทหลักสูตร--</option>
                   <?php
                 $qa0= $qGeneral->runQuery(
                 "SELECT
                 tbl_master_vehicle_type.vehicle_type_id,
                 tbl_master_vehicle_type.vehicle_type_name
                 FROM
                 tbl_master_vehicle_type
                 WHERE
                 tbl_master_vehicle_type.vehicle_type_status='1' AND
                 tbl_master_vehicle_type.is_delete='1'
                 ORDER BY
                 tbl_master_vehicle_type.vehicle_type_id  ASC");
                 $qa0->execute();
                 while($rowY= $qa0->fetch(PDO::FETCH_OBJ)) {
               
                echo"<option value='$rowY->vehicle_type_id'"; 
                if ($vehicle_type_id == $rowY->vehicle_type_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowY->vehicle_type_name</option>\n";

                 }
                 ?>           
                    </select>
                </div> 
       
                <div class="col-xs-4">
                <label >ปฏิทินเริ่มต้น</label> <label style="color:red;">*</label>
                <!-- <input type="text" name="st_date"  class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" placeholder="คลิ๊กเพื่อแสดงปฏิทิน" id="datepickerX" required readonly> -->
                <input type="text" name="st_date"  class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask id="datepicker" required>
                </div>  
                    <div class="col-xs-4">
                  <label >เวลาเริ่ม</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="st_start_time" id="st_start_time" required >
                </div>  
                <div class="col-xs-4">
                  <label >เวลาสิ้นสุด</label> <label style="color:red;">*</label>
                
                  <input type="time" class="form-control" name="st_end_time" id="st_end_time" required >
                </div>  
               
                <div class="col-xs-6">         
                <label>โรงเรียน</label> <label style="color:red;">*</label>

                <span id="school_id_x">
                <select class="form-control" required >
                <option value="" >- เลือกโรงเรียน -</option>
                </select>
                </span>

                </div>
                <div class="col-xs-6">
                <label>เลือกครู / วิทยากร</label> <label style="color:red;">*</label>
                <span id="trainer_id">
                <select class="form-control" required >
                <option value="" >- เลือกครู / วิทยากร -</option>
                </select>
                </span>
                </br></br></br>
                </div>
</br></br>

<button type="submit"  class="btn btn-success btn-block btn-flat">บันทึกข้อมูล</button>
</form>




              </div>
               <!--END กำหนดอบรมทฤษฎีแบบอัตโนมัติ -->
              <!-- /.tab-pane -->
              <div class="tab-pane <?php if(!empty($_GET['qs'])){ echo "active"; } ?>" id="tab_3">
         <form method="get">
         <input type="hidden" name="option" value="permission-theory-subjetct">
         <input type="hidden" name="qs" value="<?php echo time();?>">
                   <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type" id="vehicle_type_id" required>
               <option value="">--เลือกประเภทหลักสูตร--</option>
                   <?php
                 $qa2= $qGeneral->runQuery(
                 "SELECT
                 tbl_master_vehicle_type.vehicle_type_id,
                 tbl_master_vehicle_type.vehicle_type_name
                 FROM
                 tbl_master_vehicle_type
                 WHERE
                 tbl_master_vehicle_type.vehicle_type_status='1' AND
                 tbl_master_vehicle_type.is_delete='1'
                 ORDER BY
                 tbl_master_vehicle_type.vehicle_type_id  ASC");
                 $qa2->execute();
                 while($rowB= $qa2->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
                echo"<option value='$rowB->vehicle_type_id'"; 
                if ($vehicle_type_id == $rowB->vehicle_type_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowB->vehicle_type_name</option>\n";

                 }
                 ?>           
                    </select>

                    <label>โรงเรียน</label> 
                   <label style="color:red;">*</label>
                   <select class="form-control select2" style="width: 100%;" name="school" id="school_id" required>
                   <option value="">--เลือกโรงเรียน--</option>
                   <!-- <option value="0">--สำหรับวิชาบั--</option> -->
                   <?php
                 $qa3 = $qGeneral->runQuery(
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
                 while($rowD= $qa3->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option value='$rowD->school_id'>$rowD->school_name</option>";
                echo"<option value='$rowD->school_id'"; 
                if ($school_id == $rowD->school_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowD->school_name</option>\n";

                 }
                 ?>
                 
                    </select>
</br></br>
<button type="submit"  class="btn btn-warning btn-block btn-flat">ตกลง</button>
</form>
</br></hr></br>

<form method="post" id="form_del"  name="form_del" runat="server">
<input type="hidden" name="school_id_post" value="<?=$school_id?>">
    <label>เลือกรายวิชาที่จะอบรมในวันที่กำหนด</label>
    <div class="box-body table-responsive no-padding">
    <table id="" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>
<div class="checkbox">
<label style="font-size: 1em">
<INPUT type="checkbox" onchange="checkAll_d1(this.form.pNUM)" name="chk_all_user" />
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
</div>
        </th>

        <th> รหัสวิชา </th>
        <th>รายวิชา</th>
        <th>ชั่วโมงเรียน</th>
        <th>ประเภทรายวิชา</th>
        <th>เวลาเริ่ม</th>
        <th>เวลาสิ้นสุด</th>
        <th>วิทยากร</th>
        <th>เลือกวันที่เรียน(ได้หลายวัน)</th>
        
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='-1';
$qg = $subject_data_list->runQuery(
"SELECT
tbl_subject_data.subject_data_id,
tbl_subject_data.subject_data_code,
tbl_subject_data.subject_data_name,
tbl_subject_data.type_study_id,
tbl_subject_data.vehicle_type_id,
tbl_subject_data.type_subject_id,
tbl_subject_data.force_hour,
tbl_subject_data.school_id,
tbl_subject_data.crt_by,
tbl_subject_data.crt_date,
tbl_subject_data.upd_by,
tbl_subject_data.upd_date,
tbl_subject_data.subject_data_status,
tbl_subject_data.is_delete,
tbl_master_type_study.type_study_name,
tbl_master_vehicle_type.vehicle_type_name,
tbl_master_type_subject.type_subject_name,
tbl_school.school_name

FROM
tbl_subject_data ,
tbl_master_type_study ,
tbl_master_vehicle_type ,
tbl_master_type_subject ,
tbl_school 
WHERE
(tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_subject_data.type_subject_id = tbl_master_type_subject.type_subject_id AND
tbl_subject_data.school_id = tbl_school.school_id AND
tbl_subject_data.type_study_id = '1' AND
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.subject_data_status = '1' AND
tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_data.school_id=:school_id_param ) 
 OR
(tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_subject_data.type_subject_id = tbl_master_type_subject.type_subject_id AND
tbl_subject_data.school_id = tbl_school.school_id AND
tbl_subject_data.type_study_id = '1' AND
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.subject_data_status = '1' AND
tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
tbl_subject_data.school_id='0')
ORDER BY
tbl_subject_data.subject_data_id DESC
");
// $qg->execute();
$qg->execute(array(":vehicle_type_id_param"=>$vehicle_type_id,":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;

$st_hour = isset($_POST['st_hour'][$num_gen]) ? $_POST['st_hour'][$num_gen] : $rowGen->force_hour; 
$st_start_time = isset($_POST['st_start_time'][$num_gen]) ? $_POST['st_start_time'][$num_gen] : "06:00:00"; 
$st_end_time = isset($_POST['st_end_time'][$num_gen]) ? $_POST['st_end_time'][$num_gen] : "07:00:00"; 
$trainer_id = isset($_POST['trainer_id'][$num_gen]) ? $_POST['trainer_id'][$num_gen] : NULL; 
$st_date = isset($_POST['st_date'][$num_gen]) ? $_POST['st_date'][$num_gen] : NULL; 
?>

<script type="text/javascript">
function OpenForm<?=$num_gen?>() {
  var ck_dis = document.getElementById('pNUM<?=$num_gen?>');
  if(ck_dis.checked == true){
    document.getElementById("st_hour_<?=$num_gen?>").disabled = false;
    document.getElementById("st_start_time_<?=$num_gen?>").disabled = false;
    document.getElementById("st_end_time_<?=$num_gen?>").disabled = false;
    document.getElementById("trainer_id_<?=$num_gen?>").disabled = false;
    document.getElementById("datepicker<?=$num_gen?>").disabled = false;
  }else{
    document.getElementById("st_hour_<?=$num_gen?>").disabled = true;
    document.getElementById("st_start_time_<?=$num_gen?>").disabled = true;
    document.getElementById("st_end_time_<?=$num_gen?>").disabled = true;
    document.getElementById("trainer_id_<?=$num_gen?>").disabled = true;
    document.getElementById("datepicker<?=$num_gen?>").disabled = true;
  }
}
</script>

      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox" onclick="OpenForm<?=$num_gen?>();" name="ADDsubject_data_id[]" id="pNUM<?=$num_gen?>"  value="<?=$rowGen->subject_data_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>

        <td style="width: 200px"><?=$rowGen->subject_data_code?></td>
        <td ><div class="cutword" data-toggle="tooltip" title="<?=$rowGen->subject_data_name?>"><?=$rowGen->subject_data_name?></div></td>
        <td><input style="width: 100px"  type="number" name="st_hour[]" id="st_hour_<?=$num_gen?>" value="<?=$st_hour?>"  class="form-control" disabled/></td>
        <td><?=$rowGen->type_subject_name?></td>
        <td><input type="time" name="st_start_time[]" id="st_start_time_<?=$num_gen?>" value="<?=$st_start_time?>" class="form-control" disabled/></td>
        <td><input type="time" name="st_end_time[]" id="st_end_time_<?=$num_gen?>" value="<?=$st_end_time?>" class="form-control" disabled/></td>
        <td style="width: 200px">
        <select class="form-control select2" style="width: 200px;font-size:10px;" name="trainer_id[]" id="trainer_id_<?=$num_gen?>" required disabled>
       
                   <?php
                 $qa4= $qGeneral->runQuery(
                 "SELECT
                 tbl_trainer_data.trainer_id,
                 tbl_trainer_data.trainer_firstname_th,
                 tbl_trainer_data.trainer_lastname_th
                 FROM
                 tbl_trainer_data       
                    WHERE
                    tbl_trainer_data.is_delete='1'  AND
                    tbl_trainer_data.school_id=:school_id_param
                 ORDER BY
                 tbl_trainer_data.trainer_id  ASC");
                //  $qa4->execute();
                 $qa4->execute(array(":school_id_param"=>$school_id));
                 while($rowE= $qa4->fetch(PDO::FETCH_OBJ)) {
                //  echo "<option  value='$rowE->trainer_id'>$rowE->trainer_firstname_th $rowE->trainer_lastname_th</option>";
                 echo"<option value='$rowE->trainer_id'";
                 if ($trainer_id == $rowE->trainer_id)
                 {
                   echo "SELECTED";
                 }
                 echo ">$rowE->trainer_firstname_th $rowE->trainer_lastname_th </option>\n";
                 }
                 ?>
            
                    </select>
        
        </td>
        <td align="center" >
   
<input type="text" name="st_date[]" value="<?=$st_date?>"   style="width: 300px" class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepicker<?=$num_gen?>" readonly placeholder="คลิ๊กเพื่อแสดงปฏิทิน" disabled>
<!-- <input type="text" class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  id="datepicker"> -->
          </td>
      
      </tr>
    <script>
     $('#datepicker<?=$num_gen?>').datepicker({
format : "dd/mm/yyyy",
  autoclose: false,
  language: 'th',
  multidate: true
})
    </script>  
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th> รหัสวิชา </th>
      <th>รายวิชา</th>
      <th>ชั่วโมงเรียน</th>
      <th>ประเภทรายวิชา</th>
      <th>เวลาเริ่ม</th>
      <th>เวลาสิ้นสุด</th>
      <th>วิทยากร</th>
      <th>เลือกวันที่เรียน(ได้หลายวัน)</th>
      </tr>
      </tfoot>
    </table>
    </div>
    </br></br>
    <button type="submit"  class="btn btn-success btn-block btn-flat">บันทึกตารางการอบรม</button>
    </form>





              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->



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