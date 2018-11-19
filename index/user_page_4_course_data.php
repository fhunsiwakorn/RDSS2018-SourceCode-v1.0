<?php
///เฉพาะ กำหนดวิชาเรียนตามระเบียบกรมขนส่งทางบก
$search_school = isset($_GET['search_school']) ? $_GET['search_school'] : $school_id; 
require_once('user_page_4_process_subject_in_course.php');
if(isset($_POST['btn-submit-add']))
{
$table  = 'tbl_course_data';
$table2  = 'tbl_course_price';
$course_data_code = strip_tags($_POST['course_data_code']);
$course_data_name = strip_tags($_POST['course_data_name']);
$course_group_id = strip_tags($_POST['course_group_id']);
$vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
$course_data_theory_hour = strip_tags($_POST['course_data_theory_hour']);
$course_data_practice_hour = strip_tags($_POST['course_data_practice_hour']);
$course_data_total_hour = strip_tags($_POST['course_data_total_hour']);
// $school_id = strip_tags($_POST['school_id']);
$course_data_status = strip_tags($_POST['course_data_status']);
$course_code = random_password(20);
$crt_by=$_SESSION['userSession']; 
$crt_date=date("Y-m-d H:i:s"); 


$fields = [
  'course_data_code' => $course_data_code,
  'course_data_name' => $course_data_name,
  'course_group_id' => $course_group_id,
  'vehicle_type_id' => $vehicle_type_id,
  'course_data_theory_hour' => $course_data_theory_hour,
  'course_data_practice_hour' => $course_data_practice_hour,
  'course_data_total_hour' => $course_data_total_hour,
  'school_id' => $school_id,
  'crt_by' => $crt_by,
  'crt_date' => $crt_date,
  'course_data_status' => $course_data_status,
  'course_code' => $course_code
  
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
/////ราคาหลักสูตร
if(isset($_POST['cp_price']) && !empty($_POST['cp_price'])){
  $cp_price = strip_tags($_POST['cp_price']);
  $fields2=['cp_price' => $cp_price,'course_code' => $course_code,'school_id' => $school_id];
  
try {

  /*
   * Have used the word 'object' as I could not see the actual 
   * class name.
   */

  $sql_process->insert($table2, $fields2);

}catch(ErrorException $exception) {

   $exception->getMessage();  // Should be handled with a proper error message.

  }
}

echo "<script>";
echo "location.href = '?option=UAJDPLCUTKIIHA&success'";
echo "</script>";
}


if(isset($_POST['cp_price_update']) && !empty($_POST['cp_price_update'])){
  $cp_price = strip_tags($_POST['cp_price_update']);
  $course_code = strip_tags($_POST['course_code']);
  $count_chk=$sql_process->rowsQuery("SELECT tbl_course_price.course_code FROM tbl_course_price WHERE course_code='$course_code'  AND school_id='$school_id'");
 if($count_chk <=0){
  $sql_process->fastQuery("INSERT INTO  tbl_course_price (cp_price,course_code,school_id) VALUES ('$cp_price','$course_code','$school_id')");
 }else{
  $sql_process->fastQuery("UPDATE tbl_course_price SET cp_price='$cp_price'   WHERE course_code='$course_code'  AND school_id='$school_id'");
 }
  

echo "<script>";
echo "location.href = '?option=UAJDPLCUTKIIHA&success'";
echo "</script>";
}

if(isset($_POST['DELcourse_data_id'])) {
  $count=count($_POST['DELcourse_data_id']);
  for($i=0;$i<$count;$i++){
   $course_data_id = $_POST['DELcourse_data_id'][$i];

   
   $table  = 'tbl_course_data';
   $fields = [
       'is_delete' => 0
   ];
   $Where=['course_data_id' => $course_data_id];
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
   echo "location.href = '?option=course-data&success'";
   echo "</script>";
    }
  }
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
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

<script language="JavaScript">
function cloaseModal(event)
{
  window.location.reload();
}
</script>   

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
  <li><a href="?option=<?=$_GET["option"]?>">ทะเบียนหลักสูตร</a></li>
  <li class="active">ข้อมูลหลักสูตร</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลหลักสูตร</h3>

      <br>
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
                <button type="button"   class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูลหลักสูตร</h4> 
              </div>
              
              <div class="modal-body">        
              <form  method="post" name="form_add" id="form_add">

<div class="row">
              <div class="col-xs-6">
                  <label for="exampleInputEmail1">รหัสหลักสูตร</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" name="course_data_code" id="course_data_code" required placeholder="กรอกรหัสหลักสูตร">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ชื่อหลักสูตร</label> <label style="color:red;">*</label>
                
                  <input type="text"  class="form-control" name="course_data_name" id="course_data_name" required placeholder="กรอกชื่อหลักสูตร">
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
                 tbl_course_group.course_group_subject_auto='0' AND
                 tbl_course_group.is_delete ='1'
                 ORDER BY
                 tbl_course_group.course_group_id  ASC");
                 $qa->execute();
                 while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
             echo "<option value='$rowA->course_group_id'>$rowA->course_group_name</option>";
           
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
             echo "<option value='$rowB->vehicle_type_id'>$rowB->vehicle_type_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนทฤษฎี </label> <label style="color:red;">*</label>
                
                  <input OnKeyPress="return chkNumber(this)"  autocomplete="off" maxlength="2" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" class="form-control" name="course_data_theory_hour" id="course_data_theory_hour" onchang="plus()" onkeyup='plus()' required >
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนปฏิบัติ</label> <label style="color:red;">*</label>
                
                  <input  OnKeyPress="return chkNumber(this)" autocomplete="off" maxlength="2" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" class="form-control" name="course_data_practice_hour" id="course_data_practice_hour"  onchang="plus()" onkeyup='plus()'  required >
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">จำนวนชั่วโมงเรียนรวม</label> <label style="color:red;">*</label>
                
                  <input OnKeyPress="return chkNumber(this)"     autocomplete="off" maxlength="3" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);"  OnKeyPress="return chkNumber(this)" class="form-control" name="course_data_total_hour" id="course_data_total_hour"    required>
                </div>
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ราคา</label>
                
                  <input OnKeyPress="return chkNumber(this)"  autocomplete="off" maxlength="10" type="text" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);"  class="form-control" name="cp_price" id="cp_price"  >
                </div>
              
                <div class="col-xs-6">

                   <label>สถานะการใช้งาน</label>
                   <select name="course_data_status" id="course_data_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>

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
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button> -->
                <!-- <button type="button"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button> -->
              </div>
             
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
     <!--END-MODAL  -->
    <div class="box-body"> 
    
    <table width="100%" class="table table-bordered">
  <tbody>
    <tr>
      <!-- <td>   
      <img id="myImg"  src="../images/images_system/transfer-1.png"   width="30" height="30" > หมายถึง <label style="color:blue;">กำหนดวิชาเรียนตามระเบียบกรมขนส่งทางบก</label>
     </td> -->
      <td>
      <img id="myImg"  src="../images/images_system/analytics-42.png"   width="30" height="30" > หมายถึง <label style="color:blue;">กำหนดรายวิชาในหลักสูตร</label>
      </td>
      <td>
      <img id="myImg"  src="../images/images_system/like-flat-icon-png-25.png"   width="30" height="30" > หมายถึง <label style="color:blue;">กำหนดรายวิชาเรียบร้อยแล้ว</label>
      </td>
      <td>
      <img id="myImg"  src="../images/images_system/sign-warning-icon.png"   width="30" height="30" > หมายถึง <label style="color:blue;">รายวิชายังไม่พร้อม</label>
      </td>
    </tr>
  </tbody>
</table>
<br>
<div class="col-xs-4">
<form method="get" name="search_form">
<input type="hidden" name="option" value="<?=$_GET["option"]?>"/>
<select class="form-control select2" style="width: 100%;" name="search_school" id="search_school" onchange="submit();">
<option value="0">-- หลักสูตรพื้นฐาน --</option>
<option value="S" <?php if($search_school =="S" || $search_school==$school_id){ echo "SELECTED";} ?>>-- หลักสูตรโรงเรียน--</option>


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

        <th> รหัสหลักสูตร </th>
        <th>ชื่อหลักสูตร</th>
        <th>กลุ่มหลักสตร</th>
        <th>ประเภทหลักสูตร</th>
        <th>กำหนดรายวิชา</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
if($search_school =="S" || $search_school==$school_id ){ $sc=$school_id;}else{ $sc=$_GET['search_school'];}
$qg = $sql_process->runQuery(
"SELECT
tbl_course_group.course_group_name,
tbl_course_group.course_group_subject_auto,
tbl_course_data.course_data_id,
tbl_course_data.course_data_code,
tbl_course_data.course_data_name,
tbl_course_data.course_group_id,
tbl_course_data.vehicle_type_id,
tbl_course_data.course_data_theory_hour,
tbl_course_data.course_data_practice_hour,
tbl_course_data.course_data_total_hour,
tbl_course_data.school_id,
tbl_course_data.course_success,
tbl_course_data.course_code,
tbl_course_data.crt_by, 
tbl_course_data.crt_date,
tbl_course_data.upd_by,
tbl_course_data.upd_date,
tbl_course_data.course_data_status,
tbl_master_vehicle_type.vehicle_type_name,
tbl_school.school_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_course_data ,
tbl_course_group ,
tbl_master_vehicle_type ,
tbl_school ,
tbl_user 
WHERE 
tbl_course_data.course_group_id = tbl_course_group.course_group_id AND
tbl_course_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_course_data.school_id = tbl_school.school_id AND
tbl_course_data.crt_by = tbl_user.user_id AND
tbl_course_data.is_delete='1'  AND
tbl_course_data.course_data_status='1'  AND
tbl_course_data.school_id=:school_id_param
ORDER BY
tbl_course_data.course_data_id DESC
");
$qg->execute(array(":school_id_param"=>$sc));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
//แก้ไขโดย
$upd_by = $rowGen->upd_by;	
$stmt = $sql_process->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmt->execute(array(":user_id_param"=>$upd_by));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
////
///ตรวจสอบชั่วโมงเรียนว่าเกินตามกำหนดหรือไม่ (ตามประเภทหลักสูตร)
$stmtCal2 = $sql_process->runQuery("SELECT
 SUM(tbl_subject_data.force_hour) AS force_hour
 FROM
 tbl_subject_data
 WHERE
 tbl_subject_data.type_subject_id = '1' AND
 tbl_subject_data.is_delete = '1' AND
 tbl_subject_data.subject_data_status = '1' AND
 tbl_subject_data.vehicle_type_id =:vehicle_type_id_param AND
 tbl_subject_data.school_id=:school_id_param");
$stmtCal2->execute(array(":vehicle_type_id_param"=>$rowGen->vehicle_type_id,":school_id_param"=>$rowGen->school_id));
$calRow2=$stmtCal2->fetch(PDO::FETCH_ASSOC);
$sumtotal=$calRow2['force_hour']; ///ชั่วโมงเรียนทั้งหมด

///ผลรวมชั่วโมงเรียนในหลักสูตร
$sumtotal2=$rowGen->course_data_theory_hour+$rowGen->course_data_practice_hour;

$total_data =$sql_process->rowsQuery("SELECT course_data_id FROM tbl_subject_in_course WHERE course_data_id='$rowGen->course_data_id' AND school_id='$rowGen->school_id'");

///

$stmt2 = $sql_process->runQuery("SELECT tbl_course_price.cp_price FROM tbl_course_price WHERE tbl_course_price.course_code=:course_code_param AND tbl_course_price.school_id=:school_id_param");
$stmt2->execute(array(":course_code_param"=>$rowGen->course_code,":school_id_param"=>$school_id));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);

?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELcourse_data_id[]" id="pNUM"  value="<?=$rowGen->course_data_id?>" <?php if($total_data >=1 || $rowGen->school_id==0){ echo "disabled";}?>>
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->course_data_code?></td>
        <td><div class="cutword" data-toggle="tooltip" title="<?=$rowGen->course_data_name?>"><?=$rowGen->course_data_name?></div></td>
        <td><?=$rowGen->course_group_name?></td>
        <td><?=$rowGen->vehicle_type_name?></td> 
       
      <td align="center">
      <?php
      if($rowGen->course_group_subject_auto=='1'  && $sumtotal >= $sumtotal2 &&  $rowGen->course_success=='0'){ 
        ///ถ้ามีค่าเท่ากับ 1 คือสามารถกำหนดรายวิชาบังคับได้
      ?>
      <button type="button" class="btn btn-default"  OnClick="move2<?=$num_gen?>()" data-toggle="tooltip" title="กำหนดวิชาเรียนตามระเบียบกรมขนส่งทางบก" disabled >
      <img id="myImg"  src="../images/images_system/transfer-1.png"   width="30" height="30" >
      </button> 
      <?php } elseif( $rowGen->course_group_subject_auto=='1' && $sumtotal < $sumtotal2 &&  $rowGen->course_success=='0'){?>
        <button type="button" class="btn btn-default" >
      <img id="myImg"  src="../images/images_system/sign-warning-icon.png"   width="30" height="30" title="รายวิชายังไม่พร้อม">
      </button>
      <?php }elseif($rowGen->course_group_subject_auto=='0' &&  $rowGen->course_success=='0'){ ?>
        <button type="button" class="btn btn-default"  OnClick="chkConfirm<?=$num_gen?>()" data-toggle="tooltip" title="กำหนดรายวิชาในหลักสูตร">
      <img id="myImg"  src="../images/images_system/analytics-42.png"   width="30" height="30" >
      </button> 
      <?php }elseif($rowGen->course_success=='1'){ ?>
        <button type="button" onclick="window.location.href='?option=course-data-detail&cue=<?=$rowGen->course_data_id?>'" class="btn btn-default"  data-toggle="tooltip" title="กำหนดรายวิชาเรียบร้อยแล้ว คลิ๊กเพื่อดูรายละเอียด">
      <img id="myImg"  src="../images/images_system/like-flat-icon-png-25.png"   width="30" height="30" >
      </button> 
    
      <?php } ?>
          <!-- สำหรับกำหนดรายวิชาบังคับกรม -->
                  <script>
                        function move2<?=$num_gen?>() {
                          swal({
                            title: "ยืนยันการกำหนดวิชาเรียนตามระเบียบกรมขนส่งทางบก",
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
                            location.href = '?option=<?=$_GET["option"]?>&course=<?=$rowGen->course_data_id?>&group=<?=$rowGen->course_group_id?>&vehicle_type=<?=$rowGen->vehicle_type_id?>&school=<?=$rowGen->school_id?>';
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
               </script>
          <script language="JavaScript">
	      function chkConfirm<?=$num_gen?>()
          	{
      //  swal('กำหนดรายวิชาในหลักสูตร')
			window.location = '?option=form-course-step1&manageSubject=<?=$rowGen->course_data_id?>';
	          }
</script>
        </td>
          <td align="center" > 
            <?php
            if($rowGen->course_data_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->course_data_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>

          </td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" title="รายละเอียดเพิ่มเติม" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"   data-toggle="modal" data-target="#modal-cp_price-<?=$num_gen?>" >
        ปรับราคา
       
        </button>
        <button type="button" class="btn btn-warning" <?php if($rowGen->school_id==0){ echo "disabled";}?> onclick="window.location.href='?option=course-data-edit&coe=<?=$rowGen->course_code?>'" >
        แก้ไข
        <!-- <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" > -->
        </button>
        </div>
        </div>
       <!-- Modal DETAIL -->
        <div class="modal fade" id="modal-detail-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รายละเอียดเพิ่มเติม หลักสูตร <?=$rowGen->course_data_name?></h4>
              </div>
              <div class="modal-body">
              <table class="table table-condensed">
              <tr>
              <td width="150">รหัสหลักสูตร</td>
              <td>: <?=$rowGen->course_data_code?>
             </td>          
              </tr>
              <tr>
              <td width="150">ชื่อหลักสูตร</td>
              <td>:
              <?=$rowGen->course_data_name?>
              </td>          
              </tr>
              <tr>
              <td width="150">กลุ่มหลักสตร</td>
              <td>: <?=$rowGen->course_group_name; ?>
              </td>          
              </tr>
              <tr>
              <td width="150">ประเภทหลักสูตร</td>
              <td>: 
              <?=$rowGen->vehicle_type_name; ?>
              </td>
              
              </tr>
              <tr>
              <td width="150">จำนวนชั่วโมงเรียนทฤษฎี</td>
              <td>: <?=$rowGen->course_data_theory_hour; ?>
              </td>
              </tr>
              <tr>
              <td width="150">จำนวนชั่วโมงเรียนปฏิบัติ</td>
              <td>: <?=$rowGen->course_data_practice_hour; ?>
              </td>
              </tr>
              <tr>
              <td width="150">จำนวนชั่วโมงเรียนรวม</td>
              <td>: 
              <?=$rowGen->course_data_total_hour; ?>
              </td>
              </tr>
              <tr>
              <td width="150">ราคา</td>
              <td>: 
              <?=$dataRow2['cp_price'];?>
              </td>
              </tr>
              <tr>
              <td width="150">โรงเรียน</td>
              <td>: 
              <?=$rowGen->school_name; ?>
              </td>
              </tr>
              <tr>
              <td width="150">สถานะการใช้งาน</td>
              <td>: 
              <?php
            if($rowGen->course_data_status=='1'){
             // echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
              echo "เปิด";
            }elseif ($rowGen->course_data_status=='0') {
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
        </div>
        <!-- /.modal -->    
        

           <!-- Modal ปรับราคา -->
           <div class="modal fade" id="modal-cp_price-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ปรับราคา หลักสูตร <?=$rowGen->course_data_name?></h4>
              </div>
              <form method="post" name="update_cp_price_<?=$num_gen?>" id="update_cp_price_<?=$num_gen?>">
              <div class="modal-body">
              <input style="width:100%;" autocomplete="off" maxlength="10" type="hidden"    class="form-control" name="course_code" id="course_code" value="<?=$rowGen->course_code?>"  >
                  <input style="width:100%;" autocomplete="off" maxlength="10" type="number"    class="form-control" name="cp_price_update" id="cp_price_update" value="<?=$dataRow2['cp_price']?>"  >
               

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit" class="btn btn-success" name="btn-submit-edit">บันทึกข้อมูล</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        </div>
        <!-- /.ปรับราคา -->    

      
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th> รหัสหลักสูตร </th>
        <th>ชื่อหลักสูตร</th>
        <th>กลุ่มหลักสตร</th>
        <th>ประเภทหลักสูตร</th>
        <th>กำหนดรายวิชา</th>
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