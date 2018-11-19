<?php

if(isset($_POST['DELtransportation_id'])) {
  $table="tbl_dlt_data";
  $count=count($_POST['DELtransportation_id']);
  for($i=0;$i<$count;$i++){
   $transportation_id = $_POST['DELtransportation_id'][$i];
 
      
   $fields = [
    'is_delete' => 0
];
$Where=['transportation_id' => $transportation_id];
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
   echo "location.href = '?option=DLT-data&success'";
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
  สำนักงานขนส่งจังหวัด
    <small>จัดการข้อมูลสำนักงานขนส่งจังหวัด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=DLT-data">สำนักงานขนส่งจังหวัด</a></li>
  <li class="active">ข้อมูลสำนักงานขนส่งจังหวัด</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลสำนักงานขนส่งจังหวัด</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
    
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ" > <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    
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
        <th>รหัสสำนักงานขนส่ง</th>
        <th>ชื่อสำนักงานขนส่ง</th>
        <th>ที่ตั้ง</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_dlt_data.transportation_id,
tbl_dlt_data.transportation_office_id,
tbl_dlt_data.transportation_office_name,
tbl_dlt_data.province_id,
tbl_dlt_data.amphur_id,
tbl_dlt_data.crt_by,
tbl_dlt_data.crt_date,
tbl_dlt_data.upd_by,
tbl_dlt_data.upd_date,
tbl_dlt_data.trans_status,
tbl_dlt_data.is_delete,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_dlt_data ,
tbl_location_province ,
tbl_location_amphur ,
tbl_user
WHERE
tbl_dlt_data.province_id = tbl_location_province.province_id AND
tbl_dlt_data.amphur_id = tbl_location_amphur.amphur_id AND
tbl_dlt_data.crt_by = tbl_user.user_id AND
tbl_dlt_data.is_delete='1'
ORDER BY
tbl_dlt_data.transportation_id DESC
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
<input type="checkbox"  name="DELtransportation_id[]" id="pNUM"  value="<?=$rowGen->transportation_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->transportation_office_id?></td>
        <td><?=$rowGen->transportation_office_name?></td>
        <td>จังหวัด <?=$rowGen->province_name?> <br> อำเภอ <?=$rowGen->amphur_name?></td>
        <td><?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?><br> (<?php echo DateThai_2($rowGen->crt_date);?>)</td>
        <td><?=$dataRow["user_firstname"]?> <?=$dataRow["user_lastname"]?> <br> (<?php echo DateThai_2($rowGen->upd_date);?>)</td>
        <td align="center" >
            <?php
            if($rowGen->trans_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->trans_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>

          </td>
        <td>
        <div  align="center">
       
        <div class="btn-group-vertical" >

        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=DLT-edit&trs=<?=$rowGen->transportation_id?>'" >
        <!-- <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" > -->
       แก้ไข
        </button>
        </div>
        </div>
  
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>รหัสสำนักงานขนส่ง</th>
      <th>ชื่อสำนักงานขนส่ง</th>
      <th>ที่ตั้ง</th>
      <th>สร้างโดย</th>
      <th>แก้ไขโดย</th>
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