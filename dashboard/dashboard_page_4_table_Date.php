<?php

$gr_month = isset($_GET['gr_month']) ? $_GET['gr_month'] : date("m"); 
$gr_year = isset($_GET['gr_year']) ? $_GET['gr_year'] : date("Y"); 
$school_id = isset($_GET['school']) ? $_GET['school'] : NULL; 
if(isset($_GET['pidcode'])){

$esd_code=$_GET['pidcode'];
$sql_process->fastQuery("UPDATE tbl_exam_schedule SET is_delete='0'   WHERE esd_code='$esd_code'");
echo "<script>";
echo "location.href = '?option=permission-Date&success'";
echo "</script>";
 
}
if(isset($_GET['success'])){
  echo "<script>";
  echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
  echo "</script>";
}

?>



<script language="JavaScript">
function cloaseModal(event)
{
  window.location.reload();
}
</script>  
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนหลักสูตร 
    <small>กำหนดตารางสอบใบอนุญาตขับขี่</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=permission-Date">ทะเบียนหลักสูตร </a></li>
  <li class="active">กำหนดตารางสอบใบอนุญาตขับขี่</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดตารางสอบใบอนุญาตขับขี่</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <!-- <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button> -->
      </div>
      </div>
    <!--MODAL  -->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" OnClick="cloaseModal()"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">กำหนดตารางสอบใบอนุญาตขับขี่</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">  
              <div class="row">
              <div class="col-xs-12">
              <iframe  style="width:100%; height:500px ;  border:thin; background-color:#fff" src="dashboard_page_4_table_Date_form_iframe.php?crt_by=<?=$_SESSION['userSession']?>"></iframe>
              </div>
            

                   </div>          
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button> -->
                <!-- <button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button> -->
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
     <!--EDIT-MODAL  -->
    <div class="box-body">
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

<br><br>
    <form method="post" id="form_del"  name="form_del" runat="server">
    <table id="example6" class="table table-bordered table-striped">
    <thead>
      <tr>
      <th>ลำดับ</th>
      <th>วันที่</th>
        <th>ประเภทการสอบ</th>
        <th>ประเภทหลักสูตร</th>
        <th>ช่วงเวลาสอบ</th>
        <th>ผู้ดำเนินการสอบ</th>
        <th>โรงเรียน</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_exam_schedule.esd_id,
tbl_exam_schedule.type_study_id,
tbl_exam_schedule.esd_start_time,
tbl_exam_schedule.esd_end_time,
tbl_exam_schedule.esd_time_total,
tbl_exam_schedule.esd_date,
tbl_exam_schedule.vehicle_type_id,
tbl_exam_schedule.esd_code,
tbl_exam_schedule.school_id,
tbl_exam_schedule.crt_by,
tbl_exam_schedule.crt_date,
tbl_exam_schedule.upd_by,
tbl_exam_schedule.upd_date,
tbl_exam_schedule.is_delete,
tbl_master_type_study.type_study_name,
tbl_school.school_name,
tbl_master_vehicle_type.vehicle_type_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_exam_schedule ,
tbl_master_type_study ,
tbl_school ,
tbl_master_vehicle_type ,
tbl_user
WHERE
tbl_exam_schedule.type_study_id = tbl_master_type_study.type_study_id AND
tbl_exam_schedule.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_exam_schedule.school_id = tbl_school.school_id AND
tbl_exam_schedule.school_id =:school_id_param AND
tbl_exam_schedule.crt_by = tbl_user.user_id AND
tbl_exam_schedule.is_delete ='1' AND
MONTH(tbl_exam_schedule.esd_date) = '$gr_month' AND
YEAR(tbl_exam_schedule.esd_date) = '$gr_year'
ORDER BY
tbl_exam_schedule.esd_date DESC
");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
//แก้ไขโดย
$upd_by = $rowGen->upd_by;	
$stmt = $qGeneral->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmt->execute(array(":user_id_param"=>$upd_by));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
      <tr>
      <td><?=$num_gen?></td>
        <td><?php echo DateThai($rowGen->esd_date);?></td>
        <td><?=$rowGen->type_study_name?></td>
        <td><?=$rowGen->vehicle_type_name?></td>
        <td align="center"><?=$rowGen->esd_start_time?> - <?=$rowGen->esd_end_time?></td>
        <td>
        <div  align="center">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-edit-<?=$num_gen?>">
        <img id="myImg"  src="../images/images_system/user_all.png"  width="30" height="30" >
        </button>
  
        </div>
       <!-- Modal EDIT -->
        <div class="modal fade" id="modal-edit-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รายชื่อผู้ดำเนินการสอบ <?php echo DateThai($rowGen->esd_date);?> <?=$rowGen->esd_start_time?> - <?=$rowGen->esd_end_time?></h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">ลำดับ</th>
                  <th>ชื่อ - นามสกุล</th>
                 
                </tr>
              <?php
$trnum=0;
$stm= $qGeneral->runQuery(
  "SELECT
  tbl_trainer_data.title_name_th,
  tbl_trainer_data.trainer_firstname_th,
  tbl_trainer_data.trainer_lastname_th
  FROM
  tbl_exam_schedule_trainer ,
  tbl_trainer_data
  WHERE
  tbl_exam_schedule_trainer.trainer_id = tbl_trainer_data.trainer_id AND
  tbl_exam_schedule_trainer.esd_code = '$rowGen->esd_code' AND
  tbl_exam_schedule_trainer.vehicle_type_id = '$rowGen->vehicle_type_id' AND
  tbl_exam_schedule_trainer.school_id = '$rowGen->school_id'
  ORDER BY
tbl_trainer_data.trainer_firstname_th ASC ");
  $stm->execute();
  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
    $trnum++;
          ?>

                <tr>
                  <td><?=$trnum?></td>
                  <td><?=$rs->title_name_th?><?=$rs->trainer_firstname_th?> <?=$rs->trainer_lastname_th?></td>
               

                </tr>
  <?php } ?>        
             
              </table>



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
             
              </div>
            
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->    
        
        </td>
        <td><?=$rowGen->school_name?></td>
        <td align="center">
                     <div class="btn-group-vertical">
                      <button type="button" class="btn btn-warning" onclick="window.location.href='?option=permission-Date-edit&pdid=<?=$rowGen->esd_id?>'" >แก้ไข</button>
                      <button type="button" class="btn btn-warning" OnClick="move<?=$num_gen?>()">ลบ</button>
                     
                    </div>
                    <script>
                        function move<?=$num_gen?>() {
                          swal({
                            title: "ลบตารางสอบ <?php echo DateThai($rowGen->esd_date);?> <?=$rowGen->esd_start_time?> - <?=$rowGen->esd_end_time?>",
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
                              // swal("บันทึกข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                            location.href = '?option=permission-Date&pidcode=<?=$rowGen->esd_code?>';
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
               </script>
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th>
      <th>วันที่</th>
        <th>ประเภทการสอบ</th>
        <th>ประเภทหลักสูตร</th>
        <th>ช่วงเวลาสอบ</th>
        <th>ผู้ดำเนินการสอบ</th>
        <th>โรงเรียน</th>
        <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>
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