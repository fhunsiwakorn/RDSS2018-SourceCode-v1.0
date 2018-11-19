<?php
require_once('../class/class_masterdata_location.php');
$amphur_list = new location_data();
if(isset($_POST['btn-submit-add']))
{ 
    $amphur_code = strip_tags($_POST['amphur_code']);
    $amphur_name = strip_tags($_POST['amphur_name']);
    $province_id = strip_tags($_POST['province_id']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s");
    $amphur_status = strip_tags($_POST['amphur_status']);
	$amphur_list->add_amphur($amphur_code,$amphur_name,$province_id,$crt_by,$crt_date,$amphur_status);
    echo "<script>";
    echo "location.href = '?option=amphur&success'";
    echo "</script>";
}
if(isset($_POST['btn-submit-edit']))
{ 
    $amphur_id = strip_tags($_POST['amphur_id']);
    $amphur_code = strip_tags($_POST['amphur_code_edit']);
    $amphur_name = strip_tags($_POST['amphur_name_edit']);
    $province_id = strip_tags($_POST['province_id_edit']);
    $upd_by=$_SESSION['userSession']; 
    $amphur_status = strip_tags($_POST['amphur_status_edit']);
	$amphur_list->edit_amphur($amphur_id,$amphur_code,$amphur_name,$province_id,$upd_by,$amphur_status);
    echo "<script>";
    echo "location.href = '?option=amphur&success'";
    echo "</script>";
}
if(isset($_POST['DELamphur_id'])) {
  $count=count($_POST['DELamphur_id']);
  for($i=0;$i<$count;$i++){
   $amphur_id = $_POST['DELamphur_id'];
   $amphur_list->delete_amphur($amphur_id[$i]);
   echo "<script>";
   echo "location.href = '?option=amphur&success'";
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
  <li ><a href="?option=amphur">ข้อมูลตั้งต้น</a></li>
  <li class="active">อำเภอ</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">อำเภอ</h3><br>
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
                <h4 class="modal-title">เพิ่มอำเภอ</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">   
              <div class="form-group">
                  <label for="exampleInputEmail1">รหัสอำเภอ</label>
                  <input type="text" class="form-control" maxlength="4" name="amphur_code" id="amphur_code" required placeholder="รหัสอำเภอ">
                  </div>
                  <div class="form-group">
                  <label for="exampleInputEmail1">อำเภอ</label>
                  <input type="text" class="form-control" name="amphur_name" id="amphur_name" required placeholder="กรอกอำเภอ">
             </div>      
         
                <div class="form-group">
                  <label>จังหวัด</label>
                  <select class="form-control" name="province_id"  >
  <?php
$qa = $qGeneral->runQuery(
"SELECT
*
FROM
tbl_location_province
ORDER BY
tbl_location_province.province_name  ASC");
$qa->execute();
while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
echo "<option value='$rowA->province_id'>$rowA->province_name</option>";
}
?>

                  </select>
                </div>  
                <div class="form-group">
                   <label>สถานะการใช้งาน</label>
                   <select name="amphur_status" id="amphur_status"  class="form-control">
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
         <!-- search form -->
         <div class="col-xs-4">
      <form action="#" method="get"name="form1" class="sidebar-form">
      <input type="hidden" name="option"  value="amphur">
      <input name="h_arti_id" type="hidden" id="h_arti_id" value="" />
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหาอำเภอ..." >
          <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
        </div>
      </form>
      <script type="text/javascript">  
    function make_autocom(autoObj,showObj){  
        var mkAutoObj=autoObj;   
        var mkSerValObj=showObj;   
        new Autocomplete(mkAutoObj, function() {  
            this.setValue = function(id) {        
                document.getElementById(mkSerValObj).value = id;  
            }  
            if ( this.isModified )  
                this.setValue("");  
            if ( this.value.length < 1 && this.isNotClick )   
                return ;      
            return "../library/search_data_amphur.php?q=" +encodeURIComponent(this.value);  
        });   
    }     
       
    // การใช้งาน  
    // make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");  
    make_autocom("q","h_arti_id");  
</script>
      </div>
    <form method="post" id="form_del"  name="form_del" runat="server">
    <table id="" class="table table-bordered table-striped">
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
        <th>รหัสอำเภอ</th>
        <th>อำเภอ</th>
        <th>จังหวัด</th>
        <th>สถานะ</th>
        <th>สร้างโดย</th>
        <th>แก้ไขโดย</th>
        <th>แก้ไข</th>
      </tr>
      </thead>
      <tbody>
<?php
if(isset($_GET['page'])){
    $page=$_GET['page'];
  }else{
    $page=1;
  }

    $num_gen='0';
    if(isset($_GET['q'])){
        $seq=$_GET['q'];
      }else{
        $seq=NULL;
      }

$total_data =$qGeneral->rowsQuery("SELECT tbl_location_amphur.amphur_id FROM tbl_location_amphur WHERE tbl_location_amphur.is_delete ='1'");
$rows='20';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;
$qg = $amphur_list->runQuery(
"SELECT
tbl_location_amphur.amphur_id,
tbl_location_amphur.amphur_code,
tbl_location_amphur.amphur_name,
tbl_location_amphur.province_id,
tbl_location_amphur.crt_by,
tbl_location_amphur.crt_date,
tbl_location_amphur.upd_by,
tbl_location_amphur.upd_date,
tbl_location_amphur.amphur_status,
tbl_location_province.province_id,
tbl_location_province.province_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_location_amphur ,
tbl_location_province ,
tbl_user
WHERE
tbl_location_amphur.province_id = tbl_location_province.province_id AND
tbl_location_amphur.crt_by = tbl_user.user_id AND
tbl_location_amphur.is_delete ='1' AND
tbl_location_amphur.amphur_name  LIKE '%$seq%'
ORDER BY
tbl_location_amphur.amphur_name ASC  limit $start,$rows
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
<input type="checkbox"  name="DELamphur_id[]" id="pNUM"  value="<?=$rowGen->amphur_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> <?php //echo  sprintf("%02d", $num_gen); ?>
</div>
</td>
        <td><?=$rowGen->amphur_code?></td>
        <td><?=$rowGen->amphur_name?></td>
        <td><?=$rowGen->province_name?></td>
        <td align="center" >
            <?php
            if($rowGen->amphur_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->amphur_status=='0') {
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
              <input type="hidden" class="form-control"  name="amphur_id" value="<?=$rowGen->amphur_id?>"required>
              <label for="exampleInputEmail1">รหัสอำเภอ</label>
              <input type="text" class="form-control"  maxlength="4" name="amphur_code_edit" style="width:100%;"  id="amphur_code_edit" value="<?=$rowGen->amphur_code?>" required placeholder="รหัสอำเภอ">
               <label for="exampleInputEmail1">อำเภอ</label>
               <input type="text" class="form-control"  style="width:100%;"  name="amphur_name_edit" value="<?=$rowGen->amphur_name?>" placeholder="กรอกอำเภอ" required>
               <label>จังหวัด</label>
                  <select class="form-control" name="province_id_edit"  >
  <?php
$qa = $qGeneral->runQuery(
"SELECT
*
FROM
tbl_location_province
ORDER BY
tbl_location_province.province_name  ASC");
$qa->execute();
while($rowA= $qa->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowA->province_id'";
if ($rowA->province_id ==$rowGen->province_id)
{
  echo "SELECTED";
}
echo ">$rowA->province_name</option>\n";
}
?>

                  </select>
                  <label>สถานะการใช้งาน</label>
                   <select name="amphur_status_edit" id="amphur_status_edit" style="width:100%;"  class="form-control">
                   <option <?php if($rowGen->amphur_status=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($rowGen->amphur_status=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
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
      <th>รหัสอำเภอ</th>
      <th>อำเภอ</th>
      <th>จังหวัด</th>
      <th>สถานะ</th>
      <th>สร้างโดย</th>
      <th>แก้ไขโดย</th>
      <th>แก้ไข</th>
      </tr>
      </tfoot>
    </table>
    </form>
   
    <form method="get" name="supage1">
                <nav aria-label="...">
                <input type="hidden" name="option"  value="amphur">
                <!-- <input type="hidden" name="C"  value="<?php echo $_GET['C']; ?>"> -->
                <!-- <input type="hidden" name="num_gen"  value="<?=$num_gen?>"> -->
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="?option=amphur&q=<?=$seq?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="?option=amphur&q=<?=$seq?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                </ul>
                </nav>
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