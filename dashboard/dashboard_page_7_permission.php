<?php
$table="tbl_program_permission";
if(isset($_POST['btn-submit-add'])) {
    $code_delete=strtotime(date("Y-m-d H:i:s")); //เอาไว้เปรียบเทียบในตารางว่ามีการเลือกchekbox เพื่อบันทึกข้อมูลหรือไม่ ถ้าโค้ดไม่ตรงในตารางให้ลบข้อมูลทันที
    $user_group_id = strip_tags($_POST['user_group_id']);
    $school_id	 = strip_tags($_POST['school_id']);
    if(isset($_POST['ADDpermission_id'])){
      $count=count($_POST['ADDpermission_id']);
    }else{
      $count=0;
    } 
    
    for($i=0;$i<$count;$i++){
     $ADDpermission_id = $_POST['ADDpermission_id'][$i];
     $arrayID = explode(".",$ADDpermission_id);
     $grp_id = $arrayID[0];//grp_id
     $prog_id = $arrayID[1];//prog_id
$fields = [
  'user_group_id' => $user_group_id,
  'grp_id' => $grp_id,
  'prog_id' => $prog_id,
  'code_delete' => $code_delete,
  'page_number_grp_id' => $grp_id,
  'page_number_prog_id' => $i,
  'school_id' => $school_id

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
    // ลบรายการที่ไม่ถูกเลือก
$sql_process->fastQuery("DELETE FROM tbl_program_permission   WHERE user_group_id='$user_group_id' AND code_delete!='$code_delete' AND school_id='$school_id'");
      echo "<script>";
      echo "location.href = '?option=permission&success'";
      echo "</script>";


    }

if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
// ถ้ามีค่า POST หรือ GET ส่งมาจากการค้นหา
if(isset($_POST['school_id'])){
  $school_id =$_POST['school_id'];
}elseif(isset($_GET['scd'])){
  $school_id =$_GET['scd'];
}else{
  $school_id=NULL;
}

if(isset($_POST['user_group_id'])){
  $user_group_id =$_POST['user_group_id'];
}elseif(isset($_GET['ugd'])){
  $user_group_id =$_GET['ugd'];
}else{
  $user_group_id=NULL;
}
// $school_id = isset($_POST['school_id']) ? $_POST['school_id'] : NULL; 
// $user_group_id = isset($_POST['user_group_id']) ? $_POST['user_group_id'] : NULL; 
$grp_id = isset($_GET['grp']) ? $_GET['grp'] : NULL;
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
        req.open("GET", "../library/school_and_branch_2.php?school_id=<?=$school_id?>&user_group_id=<?=$user_group_id?>&data="+src+"&val="+val); //สร้าง connection
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
        req.send(null); //ส่งค่า
   }
   
   window.onLoad=dochange('school_id', -1);
   window.onLoad=dochange('user_group_id', -1);

</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ทะเบียนเจ้าหน้าที่
  <small>จัดการข้อมูลตั้งต้น </small>
</h1>
<ol class="breadcrumb">
<li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<li ><a href="?option=permission">ทะเบียนเจ้าหน้าที่</a></li>
<li class="active">กำหนดสิทธิ์การใช้โปรแกรม</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">กำหนดสิทธิ์การใช้โปรแกรม</h3><br>
      <!-- <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div> -->

    <div class="box-body">
<form method="post" name="search_list" id="search_list">
<!-- <input type="hidden" name="option" id="option" value="permission"> -->

<div class="form-group"> 
<label>โรงเรียน</label>   <label style="color:red;">*</label> 
<span id="school_id">
<select class="form-control" required >
<option value="" >- เลือกโรงเรียน -</option>
</select>
</span>
</div>             

<div class="form-group"> 
<label>กลุ่มผู้ใช้งาน</label>   <label style="color:red;">*</label> 
<span id="user_group_id">
<select class="form-control" required >
<option value="" >- เลือกกลุ่มผู้ใช้งาน -</option>
</select>
</span>
</div>  
<div class="form-group"> 
<center>
<!-- <button type="submit"  name="search" class="btn btn-success">แสดงรายการ</button>  -->
 
<div class="btn-group">
<button type="submit" name="list_permissrion" class="btn btn-success">แสดงรายการและกำหนดสิทธิ์</button>
<button type="submit" name="defrag_main" class="btn btn-success">จัดเรียงเมนูหลัก</button>
<!-- <button type="submit" name="defrag_smll" class="btn btn-success">จัดเรียงเมนูย่อย</button> -->
<div class="btn-group">
<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
จัดเรียงเมนูย่อย     <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                        <?php

  $num_gen='0';

$qg = $sql_process->runQuery(
"SELECT DISTINCT
tbl_program_permission.grp_id,
tbl_program_group.gp_name
FROM
tbl_program_permission ,
tbl_program_group
WHERE
tbl_program_permission.grp_id = tbl_program_group.grp_id AND
tbl_program_permission.school_id =:school_id_param AND
tbl_program_permission.user_group_id =:user_group_id_param
ORDER BY
tbl_program_permission.page_number_grp_id ASC
");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id,":user_group_id_param"=>$user_group_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>
                          <li><a href="?option=permission&scd=<?=$school_id?>&ugd=<?=$user_group_id?>&grp=<?=$rowGen->grp_id?>"><?=$rowGen->gp_name?></a></li>
<?php } ?>
                        </ul>
                      </div>
</div>
</center>
</div>  
</form>

<?php
// ตารางข้อมูลที่ได้จากการค้นหา
if(isset($_POST['list_permissrion']) && isset($_POST['user_group_id']) && !empty($_POST['user_group_id']) && isset($_POST['school_id']) && !empty($_POST['school_id']) || isset($_POST['btn-submit-add'])){
require ("dashboard_page_7_permission_table.php");
}
if(isset($_POST['defrag_main']) && isset($_POST['user_group_id']) && !empty($_POST['user_group_id']) && isset($_POST['school_id']) && !empty($_POST['school_id'])){ 
  // จัดเรียงเมนูหลัก
echo "<iframe  style='width:100%; height:1200px ;  border:thin; background-color:#fff' src='dashboard_page_7_permission_sort_menu_1.php?user_group_id=$user_group_id&school_id=$school_id'></iframe>";
}

if(isset($_GET['grp']) && !empty($_GET['grp']) && !isset($_POST['list_permissrion']) && !isset($_POST['defrag_main'])){ 
  // จัดเรียงเมนูหลัก
echo "<iframe  style='width:100%; height:1200px ;  border:thin; background-color:#fff' src='dashboard_page_7_permission_sort_menu_2.php?user_group_id=$user_group_id&grp_id=$grp_id&school_id=$school_id'></iframe>";
}
?>





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