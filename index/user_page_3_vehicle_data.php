<?php
if(isset($_POST['DELvegicle_data_id'])) {
  $count=count($_POST['DELvegicle_data_id']);
  $table="tbl_vegicle_data";
  for($i=0;$i<$count;$i++){
   $vegicle_data_id = $_POST['DELvegicle_data_id'][$i];
  
   
   $fields = [
    'is_delete' => 0
];
$Where=['vegicle_data_id' => $vegicle_data_id];
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
   echo "location.href = '?option=vehicle-data&success'";
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
  ข้อมูลยานพาหนะ
  <small>จัดการข้อมูลยานพาหนะ</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <!-- <li><a href="?option=trainer-data">ทะเบียนยานพาหนะ</a></li> -->
  <li class="active">ข้อมูลยานพาหนะ</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลยานพาหนะ</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default"onclick="window.location.href='?option=AddVehicleForm'"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    <div class="box-body">

</div>
    <br>
    <form method="post" id="form_del"  name="form_del" runat="server">
    <div class="box-body table-responsive no-padding">
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

        <th>ประเภทรถ</th>
        <th>ยี่ห้อรถ/ชื่อเรียก </th>
        <th>ทะเบียนรถ</th>
        <th>สี</th>
        <th>โรงเรียน</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php

  $num_gen='0';

$qg = $sql_process->runQuery(
"SELECT
tbl_vegicle_data.vegicle_data_id,
tbl_vegicle_data.vehicle_img,
tbl_vegicle_data.license_plate,
tbl_vegicle_data.vegicle_brand,
tbl_vegicle_data.vegicle_color,
tbl_vegicle_data.vegicle_status,
tbl_master_vehicle_type.vehicle_type_name,
tbl_location_province.province_name,
tbl_school.school_name
FROM
tbl_vegicle_data ,
tbl_master_vehicle_type ,
tbl_location_province ,
tbl_school
WHERE
tbl_vegicle_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_vegicle_data.province_id = tbl_location_province.province_id AND
tbl_vegicle_data.school_id = tbl_school.school_id AND
tbl_vegicle_data.school_id = :school_id_param AND
tbl_vegicle_data.is_delete = '1'
ORDER BY
tbl_vegicle_data.vegicle_data_id DESC
");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELvegicle_data_id[]" id="pNUM"  value="<?=$rowGen->vegicle_data_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->vehicle_type_name?></td>
        <td><?=$rowGen->vegicle_brand?></td>
        <td><?=$rowGen->license_plate?> <br> <?=$rowGen->province_name?></td>
        <td><?=$rowGen->vegicle_color?></td> 
        <td><?=$rowGen->school_name?></td> 
        <td align="center">
        <?php
            if($rowGen->vegicle_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->vegicle_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>
        </td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->vehicle_img)){ echo "disabled";}?>>
        รูปยานพาหนะ
        </button>
        <button type="button" class="btn btn-warning"onclick="window.location.href='?option=VehicleDetail&evgdt=<?=$rowGen->vegicle_data_id?>'" data-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=VehicleEdit&evgdt=<?=$rowGen->vegicle_data_id?>'" >
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
                <h4 class="modal-title">รูป <?=$rowGen->vegicle_brand?></h4>
              </div>
              <div class="modal-body">
           
             
          <span class="thumbnail">
          <img src="../images/image_vehicle/<?=$rowGen->vehicle_img?>" alt="<?=$rowGen->vehicle_img?>">
          </span>
         

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>              
              </div>
              
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
      <th>ประเภทรถ</th>
      <th>ยี่ห้อรถ/ชื่อเรียก </th>
      <th>ทะเบียนรถ</th>
      <th>สี</th>
      <th>โรงเรียน</th>
      <th>สถานะ</th>
      <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>
        </div>
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