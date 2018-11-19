<?php
require_once('../class/class_masterdata_general.php');
$teach_list = new masterdata_general();
if(isset($_POST['btn-submit-add']))
{

  $trainer_type_name = strip_tags($_POST['trainer_type_name']);
  $trainer_type_status = strip_tags($_POST['trainer_type_status']);
  $crt_by=$_SESSION['userSession']; 
  $crt_date=date("Y-m-d H:i:s");
  $teach_list->add_trainer_type($trainer_type_name,$crt_by,$crt_date,$trainer_type_status);
    echo "<script>";
    echo "location.href = '?option=trainer-type&success'";
    echo "</script>";
}
if(isset($_POST['btn-submit-edit']))
{
    $trainer_type_id = strip_tags($_POST['trainer_type_id']);
    $trainer_type_name = strip_tags($_POST['trainer_type_name_edit']);
    $trainer_type_status = strip_tags($_POST['trainer_type_status_edit']);
    $upd_by=$_SESSION['userSession'];
    $teach_list->edit_trainer_type($trainer_type_id,$trainer_type_name,$upd_by,$trainer_type_status);
    echo "<script>";
    echo "location.href = '?option=trainer-type&success'";
    echo "</script>";
} 
if(isset($_POST['DELtrainer_type_id'])) {
  $count=count($_POST['DELtrainer_type_id']);
  for($i=0;$i<$count;$i++){
   $trainer_type_id = $_POST['DELtrainer_type_id'];
   $teach_list->delete_trainer_type($trainer_type_id[$i]);
   echo "<script>";
   echo "location.href = '?option=trainer-type&success'";
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
  <li ><a href="?option=trainer-type">ข้อมูลตั้งต้น</a></li>
  <li class="active">ประเภทครูฝึก</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ประเภทครูฝึก</h3><br>
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
                <h4 class="modal-title">ประเภทครูฝึก</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">          
              <div class="form-group">
                  <label for="exampleInputEmail1">ประเภทครูฝึก</label>
                
                  <input type="text" class="form-control" name="trainer_type_name" id="trainer_type_name" required placeholder="กรอกประเภทครูฝึก">
                </div>    
                <div class="form-group">

                   <label>สถานะการใช้งาน</label>
                   <select name="trainer_type_status" id="trainer_type_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>

                 </select>

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
        <th>ประเภทครูฝึก</th>
        <th>สถานะ</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>แก้ไข</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $teach_list->runQuery(
"SELECT
tbl_master_type_trainer.trainer_type_id,
tbl_master_type_trainer.trainer_type_name,
tbl_master_type_trainer.crt_by,
tbl_master_type_trainer.crt_date,
tbl_master_type_trainer.upd_by,
tbl_master_type_trainer.upd_date,
tbl_master_type_trainer.trainer_type_status,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_master_type_trainer ,
tbl_user
WHERE
tbl_master_type_trainer.crt_by = tbl_user.user_id AND
tbl_master_type_trainer.is_delete ='1'
ORDER BY
tbl_master_type_trainer.trainer_type_id ASC

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
<input type="checkbox"  name="DELtrainer_type_id[]" id="pNUM"  value="<?=$rowGen->trainer_type_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
 <!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->trainer_type_name?></td>
        <td align="center" >
            <?php
            if($rowGen->trainer_type_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->trainer_type_status=='0') {
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
              <input type="hidden" class="form-control"  name="trainer_type_id" value="<?=$rowGen->trainer_type_id?>"required>
                  <label for="exampleInputEmail1">ประเภทครูฝึก</label>
                  <input type="text" class="form-control"  style="width:100%;"  name="trainer_type_name_edit" value="<?=$rowGen->trainer_type_name?>" placeholder="กรอกประเภทครูฝึก" required>
                
                  <label>สถานะการใช้งาน</label>
                   <select name="trainer_type_status_edit" id="trainer_type_status_edit" style="width:100%;"  class="form-control">
                   <option <?php if($rowGen->trainer_type_status=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($rowGen->trainer_type_status=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
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
      <th>ประเภทครูฝึก</th>
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