<?php
if(isset($_POST['DELschool_id'])) {
  $count=count($_POST['DELschool_id']);
  for($i=0;$i<$count;$i++){
   $school_id = $_POST['DELschool_id'][$i];
   $table  = 'tbl_school';
    $fields = [
        'is_delete' => 0
    ];
    $Where=['school_id' => $school_id];
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
   echo "location.href = '?option=school-data&success'";
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

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนโรงเรียน
    <small>จัดการข้อมูลโรงเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li class="active">ข้อมูลโรงเรียน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลโรงเรียน</h3>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
     <!--EDIT-MODAL  -->
    <div class="box-body">
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
        <th>โรงเรียน</th>
        <th>ชื่อผู้ขอจัดตั้งโรงเรียน</th>
        <th>เลขที่หนังสือรับรอง</th>
        <th>อีเมล</th>
        <th width="150">จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_school.school_id,
tbl_school.school_name,
tbl_school.school_applicant_name,
tbl_school.school_booknumber,
tbl_school.school_email,
tbl_school.crt_by,
tbl_school.crt_date,
tbl_school.upd_by,
tbl_school.upd_date,
tbl_user.user_firstname,
tbl_user.user_lastname 
FROM
tbl_school ,
tbl_user
WHERE
tbl_school.crt_by = tbl_user.user_id AND
tbl_school.is_delete='1'
ORDER BY
tbl_school.school_id ASC
");
$qg->execute();
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;

?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELschool_id[]" id="pNUM"  value="<?=$rowGen->school_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->school_name?></td>
        <td><?=$rowGen->school_applicant_name?></td>
        <td><?=$rowGen->school_booknumber?></td>
        <td><?=$rowGen->school_email?></td>
        <td>
        <div class="btn-group" >
        <button type="button" onclick="window.location.href='?option=school-detail&edc=<?=$rowGen->school_id?>'" class="btn btn-default" data-toggle="tooltip" title="รายละเอียด">
        <img id="myImg"  src="../images/images_system/company-adress.png"  width="30" height="30" >
        </button> 
        <button type="button" onclick="window.location.href='?option=school-edit&edc=<?=$rowGen->school_id?>'" class="btn btn-default" data-toggle="tooltip" title="แก้ไข">
        <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" >
        </button> 
       
        <button type="button" onclick="window.location.href='?option=school-logo&edc=<?=$rowGen->school_id?>'" class="btn btn-default" data-toggle="tooltip" title="โลโก้โรงเรียน">
        <img id="myImg"  src="../images/images_system/photo-album-icon-png-14.png"  width="30" height="30" >
        </button> 
        </div>  
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>โรงเรียน</th>
      <th>ชื่อผู้ขอจัดตั้งโรงเรียน</th>
      <th>เลขที่หนังสือรับรอง</th>
      <th>อีเมล</th>
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