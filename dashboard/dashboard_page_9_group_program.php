<?php
$table="tbl_program_group";
if(isset($_POST['btn-submit-add']))
{
  if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
  {
  $newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/image_program/");
  }else{
  $newimage=$_POST['vehicle_img'];
  } 
  $grp_icon = $newimage;    
  $gp_name = strip_tags($_POST['gp_name']);
  $grp_status = strip_tags($_POST['grp_status']);
  $crt_by=$_SESSION['userSession']; 
  $crt_date=date("Y-m-d H:i:s");

  $fields = [
    'grp_icon' => $grp_icon,
    'gp_name' => $gp_name,
    'crt_by' => $crt_by,
    'crt_date' => $crt_date,
    'grp_status' => $grp_status
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

    echo "<script>";
    echo "location.href = '?option=group-program&success'";
    echo "</script>";


  
}
if(isset($_POST['btn-submit-edit']))
{
  if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
{
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/image_program/");
$del_img_file=delfile($_POST['grp_icon'],"../images/image_program/");
}else{
$newimage=$_POST['grp_icon'];
}
 
    $grp_id = strip_tags($_POST['grp_id']);
    $grp_icon = $newimage;    
    $gp_name = strip_tags($_POST['gp_name_edit']);
    $grp_status = strip_tags($_POST['grp_status_edit']);
$upd_by=$_SESSION['userSession'];
$fields = [
  'grp_icon' => $grp_icon,
  'gp_name' => $gp_name,
  'upd_by' => $upd_by,
  'grp_status' => $grp_status
];
$Where=['grp_id' => $grp_id];
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
echo "location.href = '?option=group-program&success'";
echo "</script>";
     
} 
if(isset($_POST['DELgrp_id'])) {
  $count=count($_POST['DELgrp_id']);
  for($i=0;$i<$count;$i++){
   $grp_id = $_POST['DELgrp_id'][$i];
 
   $fields = [
    'is_delete' => 0
  ];
  $Where=['grp_id' => $grp_id];
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
   echo "location.href = '?option=group-program&success'";
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
<script language=Javascript>
           function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
      </script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  จัดการโปรแกรม
    <small>จัดการข้อมูลหมวดหมู่และโปรแกรม</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=group-program">จัดการโปรแกรม</a></li>
  <li class="active">หมวดหมู่โปรแกรม</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">หมวดหมู่โปรแกรม</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ" > <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    <!--MODAL  -->
    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">หมวดหมู่โปรแกรม</h4>
              </div>
              <form  method="post" name="form_add"id="form_add" enctype="multipart/form-data"   runat="server">
              <div class="modal-body">      
              <div class="form-group">
                  <label for="exampleInputEmail1">ไอคอนโปรแกรม</label>                
                  <input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"  required  style="display:none" >
                <br>
                  <img  src="../images/images_system/noimage.gif" alt="เพิ่มเฉพาะรูปภาพ !" id="blah"  width="128" height="128"/>             
                </div>      
                <div class="form-group">
            <button type="button" class="btn btn-default"  name="uploadbutton" onclick="imageupload.click()">
            <i class="glyphicon glyphicon-folder-open"></i> &nbsp;&nbsp;อัพโหลดรูปภาพ</button>
                </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">หมวดหมู่โปรแกรม</label>                
                  <input type="text" class="form-control" name="gp_name" id="gp_name" required placeholder="กรอกหมวดหมู่โปรแกรม">
                </div>    
                <div class="form-group">
                   <label>สถานะการใช้งาน</label>
                   <select name="grp_status" id="grp_status"  class="form-control">
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
    <form method="post" id="form_del"  name="form_del" enctype="multipart/form-data"   runat="server">
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
        <th>ไอคอน</th>
        <th>หมวดหมู่โปรแกรม</th>
        <th>สถานะ</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>แก้ไข</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_program_group.grp_id,
tbl_program_group.grp_icon,
tbl_program_group.gp_name,
tbl_program_group.crt_by,
tbl_program_group.crt_date,
tbl_program_group.upd_by,
tbl_program_group.upd_date,
tbl_program_group.grp_status,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_program_group ,
tbl_user
WHERE
tbl_program_group.crt_by = tbl_user.user_id AND
tbl_program_group.is_delete ='1'
ORDER BY
tbl_program_group.grp_id ASC
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
<input type="checkbox"  name="DELgrp_id[]" id="pNUM"  value="<?=$rowGen->grp_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
 <!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td align="center"> <img  src="../images/image_program/<?=$rowGen->grp_icon?>" alt="<?=$rowGen->grp_icon?>" width="30" height="30"/>
        </td>
        <td ><?=$rowGen->gp_name?></td>
        <td align="center" >
            <?php
            if($rowGen->grp_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->grp_status=='0') {
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
    <script language=Javascript>
           function readURL<?=$num_gen?>(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah<?=$num_gen?>').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
      </script>
          <form  method="post" name="form_<?=$num_gen?>"id="form_<?=$num_gen?>">
              <input type="hidden" class="form-control"  name="grp_id" value="<?=$rowGen->grp_id?>" required/>
              <input type="hidden" class="form-control"  name="grp_icon" value="<?=$rowGen->grp_icon?>" required/>
                 <label for="exampleInputEmail1">ไอคอนโปรแกรม</label> 
                 <br>
                 <input type="file" name="imageupload" id="imageupload<?=$num_gen?>" onchange="readURL<?=$num_gen?>(this);"    style="display:none" >
                 <img  src="../images/image_program/<?=$rowGen->grp_icon?>" alt="เพิ่มเฉพาะรูปภาพ !" id="blah<?=$num_gen?>"  width="128" height="128"/>             
                 <br><br>
                 <button type="button" class="btn btn-default"  name="uploadbutton" onclick="imageupload<?=$num_gen?>.click()">
            <i class="glyphicon glyphicon-folder-open"></i> &nbsp;&nbsp;อัพโหลดรูปภาพ</button>
            <br>
                  <label for="exampleInputEmail1">กลุ่มโปรแกรม</label>
                  <input type="text" class="form-control"  style="width:100%;"  name="gp_name_edit" value="<?=$rowGen->gp_name?>" placeholder="กรอกกลุ่มโปรแกรม" required>     
                  <label>สถานะการใช้งาน</label>
                   <select name="grp_status_edit" id="grp_status_edit" style="width:100%;"  class="form-control">
                   <option <?php if($rowGen->grp_status=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($rowGen->grp_status=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
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
      <th>ไอคอน</th>
      <th>หมวดหมู่โปรแกรม</th>
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