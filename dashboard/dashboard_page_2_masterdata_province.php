<?php
require_once('../class/class_masterdata_location.php');
$province_list = new location_data();
if(isset($_POST['btn-submit-add']))
{ 
    $province_code = strip_tags($_POST['province_code']);
    $province_name = strip_tags($_POST['province_name']);
    $province_status = strip_tags($_POST['province_status']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s");
    $province_list->add_province($province_code,$province_name,$crt_by,$crt_date,$province_status);
    echo "<script>";
    echo "location.href = '?option=province&success'";
    echo "</script>";
}
if(isset($_POST['btn-submit-edit']))
{ 
    $province_id = strip_tags($_POST['province_id']);
    $province_code = strip_tags($_POST['province_code_edit']);
    $province_name = strip_tags($_POST['province_name_edit']);
    $upd_by=$_SESSION['userSession'];
    $province_status = strip_tags($_POST['province_status_edit']);
	$province_list->edit_province($province_id,$province_code,$province_name,$upd_by,$province_status);
    echo "<script>";
    echo "location.href = '?option=province&success'";
    echo "</script>";
}
if(isset($_POST['DELprovince_id'])) {
  $count=count($_POST['DELprovince_id']);
  for($i=0;$i<$count;$i++){
   $province_id = $_POST['DELprovince_id'];
   $province_list->delete_province($province_id[$i]);
   echo "<script>";
   echo "location.href = '?option=province&success'";
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
  ข้อมูลตั้งต้น
    <small>จัดการข้อมูลตั้งต้น</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=province">ข้อมูลตั้งต้น</a></li>
  <li class="active">จังหวัด</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">จังหวัด</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    <!--MODAL  -->
    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มจังหวัด</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">   
              <div class="form-group">
                  <label for="exampleInputEmail1">รหัสจังหวัด</label>
                  <input type="text" class="form-control" maxlength="2" name="province_code" id="province_code" required placeholder="กรอกรหัสจังหวัด">
                </div>      
                  
              <div class="form-group">
                  <label for="exampleInputEmail1">จังหวัด</label>
                  <input type="text" class="form-control" name="province_name" id="province_name" required placeholder="กรอกจังหวัด">
                </div>  
                <div class="form-group">

                   <label>สถานะการใช้งาน</label>
                   <select name="province_status" id="province_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>

                 </select>    
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
        <th>รหัสจังหวัด</th>
        <th>จังหวัด</th>
        <th>สถานะ</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>แก้ไข</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $province_list->runQuery(
"SELECT
tbl_location_province.province_id,
tbl_location_province.province_code,
tbl_location_province.province_name,
tbl_location_province.crt_by,
tbl_location_province.crt_date,
tbl_location_province.upd_by,
tbl_location_province.upd_date,
tbl_location_province.province_status,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_location_province ,
tbl_user
WHERE
tbl_location_province.crt_by = tbl_user.user_id AND
tbl_location_province.is_delete ='1'
ORDER BY
tbl_location_province.province_name ASC
");
$qg->execute();
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
<input type="checkbox"  name="DELprovince_id[]" id="pNUM"  value="<?=$rowGen->province_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
 <!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->province_code?></td>
        <td><?=$rowGen->province_name?></td>
        <td align="center" >
            <?php
            if($rowGen->province_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->province_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>

          </td>
          <td align="center"><?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?><br> (<?php echo DateThai_2($rowGen->crt_date);?>)</td>
          <td align="center"><?=$dataRow["user_firstname"]?> <?=$dataRow["user_lastname"]?> <br> (<?php echo DateThai_2($rowGen->upd_date);?>)</td>
        <td>
        <div  align="center">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-edit-<?=$num_gen?>">
        <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" >
        </button>
  
        </div>
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
              <input type="hidden" class="form-control"  name="province_id" value="<?=$rowGen->province_id?>"required>
              <label for="exampleInputEmail1">รหัสจังหวัด</label>
                  <input type="text" class="form-control"  maxlength="2" style="width:100%;"  name="province_code_edit" id="province_code_edit" value="<?=$rowGen->province_code?>" required placeholder="กรอกรหัสจังหวัด">
                  <label for="exampleInputEmail1">จังหวัด</label>
                  <input type="text" class="form-control"  style="width:100%;"  name="province_name_edit" value="<?=$rowGen->province_name?>" placeholder="กรอกจังหวัด" required>
                  <label>สถานะการใช้งาน</label>
                   <select name="province_status_edit" id="province_status_edit" style="width:100%;"  class="form-control">
                   <option <?php if($rowGen->province_status=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($rowGen->province_status=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
                  </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit" class="btn btn-success" name="btn-submit-edit">บันทึกข้อมูล</button>
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
      <th>#</th>
      <th>รหัสจังหวัด</th>
      <th>จังหวัด</th>
      <th>สถานะ</th>
      <th>สร้างโดย</th>
      <th>แก้ไขโดย</th>
      <th>แก้ไข</th>
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