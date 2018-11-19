<?php
$search_school = isset($_GET['search_school']) ? $_GET['search_school'] : 0; 

if(isset($_POST['btn-submit-add']))
{

  $subject_data_code = strip_tags($_POST['subject_data_code']);
  $subject_data_name = strip_tags($_POST['subject_data_name']);
  $type_study_id = strip_tags($_POST['type_study_id']);
  $vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
  $type_subject_id = strip_tags($_POST['type_subject_id']);
  $force_hour = strip_tags($_POST['force_hour']);
  $school_id = strip_tags($_POST['school_id']);
  $crt_by=$_SESSION['userSession'];
  $crt_date=date("Y-m-d H:i:s");
  $subject_data_status = strip_tags($_POST['subject_data_status']);
  $table  = 'tbl_subject_data';
  $fields = [
      'subject_data_code' => $subject_data_code,
      'subject_data_name' => $subject_data_name,
      'type_study_id' => $type_study_id,
      'vehicle_type_id' => $vehicle_type_id,
      'type_subject_id' => $type_subject_id,
      'force_hour' => $force_hour,
      'school_id' => $school_id,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date,
      'subject_data_status' => $subject_data_status
  ];
  
  try {
  
      /*
       * Have used the word 'object' as I could not see the actual 
       * class name.
       */
      $sql_process->insert($table,$fields);
  
  }catch(ErrorException $exception) {
  
       $exception->getMessage();  // Should be handled with a proper error message.
  
  }

  echo "<script>";
   echo "location.href = '?option=subject-data&success'";
   echo "</script>";
}
if(isset($_POST['DELsubject_data_id'])) {
  $count=count($_POST['DELsubject_data_id']);
  $table  = 'tbl_subject_data';
  for($i=0;$i<$count;$i++){
   $subject_data_id = $_POST['DELsubject_data_id'][$i]; 
   $fields = [
    'is_delete' => 0
];
$Where=['subject_data_id' => $subject_data_id];
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
   echo "location.href = '?option=subject-data&success'";
   echo "</script>";
    }
  }
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
if(isset($_GET['error'])){
  echo "<script>";
  echo 'swal("Error !", "ชั่วโมงเวลาเกินหรือครบตามหลักสูตรแล้ว !", "error")';
  echo "</script>";
}


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
<!-- Sumit Form  -->
<script>
function myFunction() {
    document.getElementById("form_del").submit();
}
</script>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ทะเบียนหลักสูตร
  <small>จัดการข้อมูลทะเบียนหลักสูตร</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=subject-data">ทะเบียนหลักสูตร</a></li>
  <li class="active">ข้อมูลรายวิชา</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลรายวิชา</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    <!--MODAL  -->
    <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูลรายวิชา</h4> 
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">          
              <div class="row">
              <div class="col-xs-6">
                   <label>ปรเภทการเรียน</label> <label style="color:red;">*</label>
                   <select class="form-control" name="type_study_id"  >
                   <?php
                 $qa = $qGeneral->runQuery(
                 "SELECT
                 tbl_master_type_study.type_study_id,
                 tbl_master_type_study.type_study_name
                 FROM
                 tbl_master_type_study
                 WHERE
                 tbl_master_type_study.type_study_status='1' AND
                 tbl_master_type_study.is_delete='1'
                 ORDER BY
                 tbl_master_type_study.type_study_id  ASC");
                 $qa->execute();
                 while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowA->type_study_id'>$rowA->type_study_name</option>";
                 }
                 ?>           
                    </select>
                </div> 
                <div class="col-xs-6">
                   <label>ประเภทหลักสูตร  </label> <label style="color:red;">*</label>
                   <select class="form-control" name="vehicle_type_id" id="vehicle_type_id" >
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
                 echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
                 }
                 ?>           
                    </select>
                </div> 
              <div class="col-xs-6">
                  <label for="exampleInputEmail1">รหัสวิชา</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" name="subject_data_code" id="subject_data_code" required placeholder="กรอกรายวิชา">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">รายวิชา</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" name="subject_data_name" id="subject_data_name" required placeholder="กรอกชื่อรายวิชา">
                </div>  
                <div class="col-xs-6">

                   <label>ประเภทรายวิชา</label> <label style="color:red;">*</label>
                   <select class="form-control" name="type_subject_id"  >
                   <?php
                 $qaC = $qGeneral->runQuery(
                 "SELECT
                 tbl_master_type_subject.type_subject_id,
                 tbl_master_type_subject.type_subject_name
                 FROM
                 tbl_master_type_subject
                 WHERE
                 tbl_master_type_subject.type_subject_status='1' AND
                 tbl_master_type_subject.is_delete='1'
                 ORDER BY
                 tbl_master_type_subject.type_subject_id  ASC");
                 $qaC->execute();
                 while($rowC= $qaC->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowC->type_subject_id'>$rowC->type_subject_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
            
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ชั่วโมงเรียน  </label> <label style="color:red;">*</label>
                
                  <input autocomplete="off" maxlength="2" type="number" class="form-control" name="force_hour" id="force_hour"  value="0" required >
                </div>
              
                <div class="col-xs-6">

                   <label>โรงเรียน</label> 
                   <!-- <label style="color:red;">*</label> -->
                   <select class="form-control select2" style="width: 100%;" name="school_id" id="school_id" >
                 <option value="0">-- วิชาพื้นฐานสำหรับทุกโรงเรียน --</option>
                   <?php
                 $qa3 = $qGeneral->runQuery(
                 "SELECT
                 tbl_school.school_id,
                 tbl_school.school_name
                 FROM
                 tbl_school      
                 WHERE  tbl_school.is_delete='1'
                 ORDER BY
                 tbl_school.school_id  ASC");
                 $qa3->execute();
                 while($rowD= $qa3->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowD->school_id'>$rowD->school_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-6">

                   <label>สถานะการใช้งาน</label>
                   <select name="subject_data_status" id="subject_data_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>

                 </select>

                </div>  
                </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button>
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
    <div class="col-xs-4">
<form method="get" name="search_form">
<input type="hidden" name="option" value="<?=$_GET["option"]?>"/>
<select class="form-control select2" style="width: 100%;" name="search_school" id="search_school" onchange="submit();">
<option value="0">-- วิชาพื้นฐานสำหรับทุกโรงเรียน --</option>
<?php
$qas = $qGeneral->runQuery(
"SELECT
tbl_school.school_id,
tbl_school.school_name
FROM
tbl_school      
WHERE  tbl_school.is_delete='1'
ORDER BY
tbl_school.school_id  ASC");
$qas->execute();
while($rowS= $qas->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowS->school_id'";
if ($search_school == $rowS->school_id)
{
  echo "SELECTED";
}
echo ">$rowS->school_name</option>\n";
}
?>

 </select>
 </form>
</div>  
<div class="col-xs-12"><br></div> 

    <br>
    <form method="post" id="form_del"  name="form_del" runat="server">
    <table id="example1" class="table table-bordered table-striped">
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
        <th>ปรเภทการเรียน</th>
        <th>ประเภทรายวิชา</th>
        <th>ประเภทหลักสูตร</th>
        <th>โรงเรียน</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
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
tbl_school.school_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_subject_data ,
tbl_master_type_study ,
tbl_master_vehicle_type ,
tbl_master_type_subject ,
tbl_school ,
tbl_user
WHERE
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_subject_data.type_subject_id = tbl_master_type_subject.type_subject_id AND
tbl_subject_data.school_id = tbl_school.school_id AND
tbl_subject_data.crt_by = tbl_user.user_id AND 
tbl_subject_data.is_delete = '1' AND
tbl_subject_data.school_id=:school_id_param
ORDER BY
tbl_subject_data.subject_data_id DESC
");
$qg->execute(array(":school_id_param"=>$search_school));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
//แก้ไขโดย
$upd_by = $rowGen->upd_by;	
$stmt = $qGeneral->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmt->execute(array(":user_id_param"=>$upd_by));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELsubject_data_id[]" id="pNUM"  value="<?=$rowGen->subject_data_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->subject_data_code?></td>
        <td title="<?=$rowGen->subject_data_name?>"><div class="cutword"><?=$rowGen->subject_data_name?></div></td>
        <td><?=$rowGen->type_study_name?></td>
        <td><?=$rowGen->type_subject_name?></td>
        <td><?=$rowGen->vehicle_type_name?></td>
        <td>
        <?php
        if(!empty($rowGen->school_name)){
          echo $rowGen->school_name;
        }else{
          echo "<center>"."-"."</center>";
        }
        ?>
        
        </td>
        <td align="center" >
            <?php
            if($rowGen->subject_data_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->subject_data_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>

          </td>
        <td>
        <div  align="center">
       
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" title="รายละเอียดเพิ่มเติม" data-toggle="modal" data-target="#modal-edit-<?=$num_gen?>">
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        รายละเอียด
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=subject-data-edit&sue=<?=$rowGen->subject_data_id?>'" >
        <!-- <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" > -->
       แก้ไข
        </button>
        </div>
        </div>
       <!-- Modal DETAIL -->
        <div class="modal fade" id="modal-edit-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รายละเอียดเพิ่มเติม วิชา <?=$rowGen->subject_data_name?></h4>
              </div>
              <div class="modal-body">
              <table class="table table-condensed">
              <tr>
              <td width="150">รหัสวิชา</td>
              <td>: <?=$rowGen->subject_data_code?>
             </td>          
              </tr>
              <tr>
              <td width="150">รายวิชา</td>
              <td>:
              <?=$rowGen->subject_data_name?>
              </td>          
              </tr>
              <tr>
              <td width="150">ปรเภทการเรียน</td>
              <td>: <?=$rowGen->type_study_name; ?>
              </td>          
              </tr>
              <tr>
              <td width="150">ประเภทรายวิชา</td>
              <td>: 
              <?=$rowGen->type_subject_name; ?>
              </td>
              
              </tr>
              <tr>
              <td width="150">จำนวนชั่วโมง</td>
              <td>: <?=$rowGen->force_hour; ?>
              </td>
              </tr>
              <tr>
              <td width="150">โรงเรียน</td>
              <td>: <?=$rowGen->school_name; ?>
              </td>
              </tr>
              <tr>
              <td width="150">สถานะการใช้งาน</td>
              <td>: 
              <?php
            if($rowGen->subject_data_status=='1'){
             // echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
              echo "เปิด";
            }elseif ($rowGen->subject_data_status=='0') {
            //echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            echo "ปิด";
          }
             ?>
             <tr>
              <td width="150">สร้างโดย</td>
              <td>: 
              <?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?>  (<?php echo DateThai_2($rowGen->crt_date);?>)
              </td>
              </tr>
              <tr>
              <td width="150">แก้ไขโดย</td>
              <td>: 
              <?=$dataRow["user_firstname"]?> <?=$dataRow["user_lastname"]?>  (<?php echo DateThai_2($rowGen->upd_date);?>)
              </td>
              </tr>
              </td>
              </tr>
              </tr>
              </table>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <!-- <button type="submit" class="btn btn-success" name="btn-submit-edit">บันทึกข้อมูล</button> -->
              </div>
            
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
      <th>#</th>
      <th> รหัสวิชา </th>
      <th>รายวิชา</th>
      <th>ปรเภทการเรียน</th>
      <th>ประเภทรายวิชา</th>
      <th>ประเภทหลักสูตร</th>
      <th>โรงเรียน</th>
      <th>สถานะ</th>
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