
<?php
if(isset($_POST['ADDsubject_data_id']) && isset($_POST['btn-submit-add'])) {

  $course_data_id = strip_tags($_POST['course_data_id']);
//   $school_id = strip_tags($_POST['school_id']);
  $crt_by=$_SESSION['userSession'];
  $crt_date=date("Y-m-d H:i:s");
$count=count($_POST['ADDsubject_data_id']);
$table="tbl_subject_in_course";
for($i=0;$i<$count;$i++){
 $subject_data_id = $_POST['ADDsubject_data_id'][$i];
 $time_study = $_POST['txt'][$i];
$fields = [
'subject_data_id' => $subject_data_id,
'course_data_id' => $course_data_id,
'time_study' => $time_study,
'school_id' => $school_id,
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

  }
//  SET =1 เพื่อแสดงการกำหนดรายวิชาเรียบร้อยแล้ว
$sql_process->fastQuery("UPDATE tbl_course_data SET course_success='1'   WHERE course_data_id='$course_data_id'  AND school_id='$school_id'");
  echo "<script>";
  echo "location.href = '?option=UAJDPLCUTKIIHA&success'";
  echo "</script>";
}
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
$course_data_id_get = $_GET['manageSubject'];	
$stmt = $sql_process->runQuery("SELECT
tbl_course_data.course_data_name,
tbl_course_data.course_data_theory_hour,
tbl_course_data.course_data_practice_hour,
tbl_course_data.course_data_total_hour,
tbl_course_group.course_group_name,
tbl_course_data.course_group_id,
tbl_course_data.vehicle_type_id,
tbl_master_vehicle_type.vehicle_type_name,
tbl_course_data.school_id,
tbl_school.school_name
FROM
tbl_course_data ,
tbl_course_group ,
tbl_master_vehicle_type ,
tbl_school 
WHERE
tbl_course_data.course_data_id = :course_data_id_param AND
tbl_course_data.course_group_id = tbl_course_group.course_group_id AND
tbl_course_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_course_data.school_id = tbl_school.school_id 
"); 
$stmt->execute(array(":course_data_id_param"=>$course_data_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- <script language="JavaScript">
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

</script> -->
<!-- ///คำนวนรายวิชา -->
<script language="JavaScript"> 
   function fncSum()
   {
    var num = '';   
     var sum = 0;
    for(var i=0;i<document.frmprice['txt[]'].length;i++){
     num = document.frmprice['txt[]'][i].value;
     ds=document.frmprice['txt[]'][i].disabled;
     if(num!="" && ds==false){
      sum += parseFloat(num);
     }
    }
    document.frmprice.sumprice.value = sum;         }
  </script>
  <!-- Alert -->
  <script  language="JavaScript" type="text/JavaScript">

      function CheckForm() {

         
       if (document.frmprice.sumprice.value == "0") {
      		// msg = "กรุณากรอก รหัสผ่านเดิม";

      		// alert(msg + "\n\n");
     
       swal("Error", "กรุณากำหนดรายวิชาและจำนวนชั่วโมงให้ตรงตามที่กำหนด !", "error");
  

      		return false;
      	}
      	 
      	var chk1=document.frmprice.sumprice.value;
      	var chk2=document.frmprice.Timeset.value;
      		if (chk1 != chk2) {
      		// msg = "กรอกรหัสผ่านเดิมไม่ถูกต้อง ";

      		// alert(msg + "\n\n");
        
       swal("Error", "กรุณากำหนดรายวิชาและจำนวนชั่วโมงให้ตรงตามที่กำหนด !", "error");
     

      		return false;
      	}
      	return true;
      }
      function openWin(theURL,winName,features) {
       window.open(theURL,winName,'width=350,height=310');
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
  <li><a href="?option=UAJDPLCUTKIIHA">ทะเบียนหลักสูตร</a></li>
  <li class="active">กำหนดข้อมูลรายวิชาในหลักสูตร</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดข้อมูลรายวิชาในหลักสูตร <?=$dataRow["course_data_name"]?> :: <?=$dataRow["school_name"]?></h3><br>
      </div>
    <div class="box-body">
   <label for="">  ภาคทฤษฎี <?=$dataRow["course_data_theory_hour"]?> ชั่วโมง ภาคปฎิบัติ <?=$dataRow["course_data_practice_hour"]?> ชั่วโมง รวมเป็น <?=$dataRow["course_data_total_hour"]?> ชั่วโมง  ประเภทหลักสูตร <?=$dataRow["vehicle_type_name"]?></label>
    <br><br>
    <center><h4><font color="blue">ขั้นตอนที่ 2 กำหนดรายวิชาภาคปฎิบัติ (ให้ครบ <?=$dataRow["course_data_practice_hour"]?> ชั่วโมง)</font> </h4></center>
 
    <form method="post" id="frmprice"  name="frmprice" onsubmit="return CheckForm();">
    <input type="hidden" name="course_data_id" value="<?=$course_data_id_get?>"> 
    <input type="hidden" name="school_id" value="<?=$dataRow['school_id']?>">
    <table id="example5" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>
<!-- <div class="checkbox">
<label style="font-size: 1em">
<INPUT type="checkbox" onchange="checkAll_d1(this.form.pNUM)" name="chk_all_user" />
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
</div> -->
        </th>
        <th>รหัสวิชา </th>
        <th>รายวิชา</th>
        <th>ปรเภทการเรียน</th>
        <th>ประเภทรายวิชา</th>
        <th>ประเภทหลักสูตร</th>
        <th>ชั่วโมงเรียน</th>
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
tbl_subject_data.force_hour,
tbl_subject_data.type_subject_id,
tbl_master_type_study.type_study_name,
tbl_master_vehicle_type.vehicle_type_name,
tbl_master_type_subject.type_subject_name,
tbl_subject_data.school_id,
tbl_school.school_name
FROM
tbl_subject_data ,
tbl_master_type_study ,
tbl_master_vehicle_type ,
tbl_master_type_subject ,
tbl_school
WHERE
tbl_subject_data.type_study_id = tbl_master_type_study.type_study_id AND
tbl_subject_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_subject_data.type_subject_id = tbl_master_type_subject.type_subject_id AND
tbl_subject_data.school_id = tbl_school.school_id AND
tbl_subject_data.type_study_id = '2' AND
tbl_subject_data.vehicle_type_id = :vehicle_type_id_param AND
tbl_subject_data.is_delete ='1' AND
(tbl_subject_data.school_id = :school_id_param OR tbl_subject_data.school_id = :school_id_param2)
ORDER BY
tbl_subject_data.subject_data_id ASC
");
// tbl_subject_data.type_study_id = '2' ID ของภาคปฏิบัติตาราง tbl_subject_data
// $qg->execute();
$qg->execute(array(":vehicle_type_id_param"=>$dataRow['vehicle_type_id'],":school_id_param"=>$dataRow['school_id'],":school_id_param2"=>0));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>

 <tr>
 <script type="text/javascript">
	function ck_enable<?=$num_gen?>(){
		var ck_dis = document.getElementById('pNUM<?=$num_gen?>');
		if(ck_dis.checked == true){
		document.getElementById('txt_disable<?=$num_gen?>').disabled = false;
		}else{
		document.getElementById('txt_disable<?=$num_gen?>').disabled = true;
		}
	}
</script>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="ADDsubject_data_id[]" id="pNUM<?=$num_gen?>" onClick="ck_enable<?=$num_gen?>();fncSum();"   value="<?=$rowGen->subject_data_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->subject_data_code?></td>
        <td><?=$rowGen->subject_data_name?></td>
        <td><?=$rowGen->type_study_name?></td>
        <td><?=$rowGen->type_subject_name?></td>
        <td><?=$rowGen->vehicle_type_name?></td>
        <td align="center" >
        <input class="txt" type="text" name="txt[]" disabled  id="txt_disable<?=$num_gen?>" onkeyup="fncSum();" style="width:60px" value="<?=$rowGen->force_hour?>" />
          </td>
      </tr>

<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>รหัสวิชา </th>
      <th>รายวิชา</th>
      <th>ปรเภทการเรียน</th>
      <th>ประเภทรายวิชา</th>
      <th>ประเภทหลักสูตร</th>
      <th>ชั่วโมงเรียน</th>
      </tr>
      </tfoot>
    </table>


    <center>  
     <input style="width:150px; height:40px;font-size:24px;text-align: center;" name="sumprice" id="sumprice" value="0" readonly> :
     <input type="text" name="Timeset" id="Timeset" style="width:150px; height:40px;font-size:24px;text-align: center;" value="<?=$dataRow["course_data_practice_hour"]?>" readonly >
   </center>
    <hr>
    <center> <button type="submit" name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button></center>
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
