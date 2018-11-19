<?php

$table="tbl_holiday";

if(isset($_POST['btn-submit-add']))
{
  $hd_title = strip_tags($_POST['hd_title']);
  $hd_start_date = DatetoYMD($_POST['hd_start_date']);
  $hd_end_date = DatetoYMD($_POST['hd_end_date']);
  $crt_by=$_SESSION['userSession'];
  $crt_date=date("Y-m-d H:i:s");

  $hd_start_date="$hd_start_date 00:00:00";
  $hd_end_date="$hd_end_date 23:59:00";
  $fields = [
    'hd_title' => $hd_title,
    'hd_start_date' => $hd_start_date,
    'hd_end_date' => $hd_end_date,
    'crt_by' => $crt_by,
    'crt_date' => $crt_date,
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

    echo "<script>";
    echo "location.href = '?option=00O5B5OT14FP76Z&success'";
    echo "</script>";
    // echo "<center>";
    // echo   $hd_start_date;
    // echo "</center>";
}


if(isset($_POST['btn-submit-edit']))
{
    $hd_id = strip_tags($_POST['hd_id']);
    $hd_title = strip_tags($_POST['hd_title_edit']);
    $hd_start_date = DatetoYMD($_POST['hd_start_date_edit']);
    $hd_end_date = DatetoYMD($_POST['hd_end_date_edit']);
    $upd_by=$_SESSION['userSession'];
    $hd_start_date="$hd_start_date 00:00:00";
    $hd_end_date="$hd_end_date 23:59:00";
    $fields = [
        'hd_title' => $hd_title,
        'hd_start_date' => $hd_start_date,
        'hd_end_date' => $hd_end_date,
      'upd_by' => $upd_by
  ];
  $Where=['hd_id' => $hd_id];
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
    echo "location.href = '?option=00O5B5OT14FP76Z&success'";
    echo "</script>";
}
if(isset($_POST['DELhd_id'])) {
  $count=count($_POST['DELhd_id']);
  for($i=0;$i<$count;$i++){
   $hd_id = $_POST['DELhd_id'][$i];
   $fields = [
    'is_delete' => 0
  ];
  $Where=['hd_id' => $hd_id];
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
   echo "location.href = '?option=00O5B5OT14FP76Z&success'";
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
  วันหยุดโรงเรียน
    <small>จัดการข้อมูลวันหยุดโรงเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li class="active">วันหยุดโรงเรียน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">วันหยุดโรงเรียน</h3><br>
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
                <h4 class="modal-title">เพิ่มวันหยุดโรงเรียน</h4>
              </div>
              <form  method="post" name="form_add"id="form_add" autocomplete="off">
              <div class="modal-body">          
              <div class="form-group">
                  <label  >หัวข้อวันหยุด </label>
                
                  <input type="text" class="form-control" name="hd_title" id="hd_title" required placeholder="กรอกหัวข้อวันหยุด">
                </div>   
                <div class="form-group">
                  <label  >วันที่เริ่มต้น </label> 
                  <input type="text" name="hd_start_date"     style="width: 100%" class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepicker"  required >
                </div>  
                <div class="form-group">
                  <label  >วันที่สิ้นสุด </label> 
                  <input type="text" name="hd_end_date"     style="width: 100%" class="form-control pull-right" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepicker2"   required>
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

        <th>หัวข้อวันหยุด</th>
        <th>วันที่เริ่มต้น</th>
        <th>วันที่สิ้นสุด</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>แก้ไข</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$year_tho=date("Y");
$qg = $sql_process->runQuery(
"SELECT
tbl_holiday.hd_id,
tbl_holiday.hd_title,
tbl_holiday.hd_start_date,
tbl_holiday.hd_end_date,
tbl_holiday.crt_by,
tbl_holiday.crt_date,
tbl_holiday.upd_by,
tbl_holiday.upd_date,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_holiday ,
tbl_user
WHERE
tbl_holiday.crt_by = tbl_user.user_id AND
tbl_holiday.school_id=:school_id_param AND
tbl_holiday.is_delete='1'
HAVING
YEAR(tbl_holiday.hd_start_date) >= '$year_tho' AND YEAR(tbl_holiday.hd_start_date) >= '$year_tho'
ORDER BY
tbl_holiday.hd_id DESC");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
//แก้ไขโดย
$upd_by = $rowGen->upd_by;	
$stmt = $qGeneral->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_param");
$stmt->execute(array(":user_id_param"=>$upd_by));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

$arraystd = explode(" ",$rowGen->hd_start_date);
$hd_start_date = $arraystd[0];//ชื่อไฟล์

$arrayetd = explode(" ",$rowGen->hd_end_date);
$hd_end_date = $arrayetd[0];//ชื่อไฟล์
?>
<script>
    $(function () {
    //Date picker
    $('#datepickerhd1<?=$num_gen?>').datepicker({
      format : "dd/mm/yyyy",
      autoclose: true,
  language: 'th'
    })

    //Date picker
    $('#datepickerhd2<?=$num_gen?>').datepicker({
      format : "dd/mm/yyyy",
      autoclose: true,
  language: 'th'
    })
})
</script>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELhd_id[]" id="pNUM"  value="<?=$rowGen->hd_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->hd_title?></td>
        <td align="center" ><?php echo DateThai($rowGen->hd_start_date);?></td>
        <td align="center" ><?php echo DateThai($rowGen->hd_end_date);?> </td>
      
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
              <form  method="post" name="form_<?=$num_gen?>"id="form_<?=$num_gen?>" autocomplete="off">
              <input type="hidden" class="form-control"  name="hd_id" value="<?=$rowGen->hd_id?>" required>
              <label >หัวข้อวันหยุด </label>

                 <input type="text" class="form-control" style="width:100%;"  name="hd_title_edit" id="hd_title_edit" value="<?=$rowGen->hd_title?>" required placeholder="กรอกหัวข้อวันหยุด">
                 <label >วันที่เริ่มต้น </label>
                
                 <input type="text" name="hd_start_date_edit"  value="<?php echo DatetoDMY($hd_start_date);?>"    style="width: 100%" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepickerhd1<?=$num_gen?>"  required >
              
                <label >วันที่สิ้นสุด </label>      
                <input type="text" class="form-control" name="hd_end_date_edit"   style="width:100%;" value="<?php echo DatetoDMY($hd_end_date);?>" data-inputmask="'alias': 'dd/mm/yyyy'" id="datepickerhd2<?=$num_gen?>"   required >

            
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
      <th>หัวข้อวันหยุด</th>
        <th>วันที่เริ่มต้น</th>
        <th>วันที่สิ้นสุด</th>
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