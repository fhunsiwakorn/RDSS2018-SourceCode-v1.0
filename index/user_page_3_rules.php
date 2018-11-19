<?php

if(isset($_POST['btn-submit-add']))
{

  $rules_text = strip_tags($_POST['rules_text']);
  $rules_status = strip_tags($_POST['rules_status']);
  $crt_by=$_SESSION['userSession']; 
  $crt_date=date("Y-m-d H:i:s");
  $table  = 'tbl_rules';
  $fields = [
      'rules_text' => $rules_text,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date,
      'rules_status' => $rules_status,
      'school_id' => $school_id
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
    echo "location.href = '?option=Q02RKIH9IZ386YY&success'";
    echo "</script>";
}
if(isset($_POST['btn-submit-edit']))
{ 
    $rules_id = strip_tags($_POST['rules_id']);
    $rules_text = strip_tags($_POST['rules_text_edit']);
    $rules_status = strip_tags($_POST['rules_status_edit']);
    $upd_by=$_SESSION['userSession'];
    $table  = 'tbl_rules';
    $fields = [
        'rules_text' => $rules_text,
        'rules_status' => $rules_status,
        'upd_by' => $upd_by
    ];
    $Where=['rules_id' => $rules_id];
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
  echo "location.href = '?option=Q02RKIH9IZ386YY&success'";
  echo "</script>";


  } 
if(isset($_POST['DELrules_id'])) {
  $count=count($_POST['DELrules_id']);
  $table  = 'tbl_rules';
  for($i=0;$i<$count;$i++){
   $rules_id = $_POST['DELrules_id'][$i];
   $fields = [
       'is_delete' => 0
   ];
   $Where=['rules_id' => $rules_id];
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
 echo "location.href = '?option=Q02RKIH9IZ386YY&success'";
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
  ระเบียบการเรียนและข้อรับรอง
    <small>จัดการข้อมูลระเบียบการเรียนและข้อรับรอง</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=<?=$_GET["option"]?>">ข้อมูลตั้งต้น</a></li>
  <li class="active">ระเบียบการเรียนและข้อรับรอง</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ระเบียบการเรียนและข้อรับรอง</h3><br>
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
                <h4 class="modal-title">ระเบียบการเรียนและข้อรับรอง</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">          
              <div class="form-group">
                  <label>หัวข้อ</label>
                
                  <input type="text" class="form-control" name="rules_text" id="rules_text" required>
                </div>    
               
              

                <div class="form-group">

                   <label>สถานะการใช้งาน</label>
                   <select name="rules_status" id="rules_status"  class="form-control">
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
        <th>เนื้อหา</th>
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
tbl_rules.rules_id,
tbl_rules.rules_text,
tbl_rules.crt_by,
tbl_rules.crt_date,
tbl_rules.upd_by,
tbl_rules.upd_date,
tbl_rules.rules_status,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_rules ,
tbl_user
WHERE
tbl_rules.crt_by = tbl_user.user_id AND
tbl_rules.school_id =:school_id_param AND
tbl_rules.is_delete ='1'
ORDER BY
tbl_rules.rules_id ASC
");
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
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELrules_id[]" id="pNUM"  value="<?=$rowGen->rules_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
 <!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->rules_text?></td>
     
        <td align="center" >
            <?php
            if($rowGen->rules_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->rules_status=='0') {
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
              <input type="hidden" class="form-control"  name="rules_id" value="<?=$rowGen->rules_id?>"required>
                  <label for="exampleInputEmail1">เนื้อหา</label>
                  <input type="text" class="form-control"  style="width:100%;"  name="rules_text_edit" value="<?=$rowGen->rules_text?>" placeholder="กรอกประเภทยานพาหนะ" required>
 
                  <label>สถานะการใช้งาน</label>
                   <select name="rules_status_edit" id="rules_status_edit" style="width:100%;"  class="form-control">
                   <option <?php if($rowGen->rules_status=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($rowGen->rules_status=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
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
      <th>เนื้อหา</th>
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