<?php
if(isset($_POST['DELtrainer_id'])) {
  $table="tbl_trainer_data";
  $count=count($_POST['DELtrainer_id']);
  for($i=0;$i<$count;$i++){
   $trainer_id = $_POST['DELtrainer_id'][$i];
   $fields = [
    'is_delete' => 0
];
$Where=['trainer_id' => $trainer_id];
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
   echo "location.href = '?option=trainer-data&success'";
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
<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #0000";
    }
  }
  xmlhttp.open("GET","user_page_7_trainer_search.php?school_id=<?=$school_id?>&q="+str,true);
  xmlhttp.send();
}

</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนครูฝึก
  <small>จัดการข้อมูลครูฝึกทั้งหมด</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li><a href="?option=<?=$_GET["option"]?>">ทะเบียนครูฝึก</a></li>
  <li class="active">ข้อมูลครูฝึก</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลครูฝึก</h3><br>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default"onclick="window.location.href='?option=AddTrainerForm'"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
    <div class="box-body">
         <!-- search form -->
         <div class="col-xs-4">
      <div class="sidebar-form">
      <input type="hidden" name="option"  value="<?=$_GET["option"]?>">
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหาครูฝึก..."  onkeyup="showResult(this.value);">
          <span class="input-group-btn">
          <button type="button" name="search" id="search-btn" class="btn btn-flat" onclick="window.location.href='?option=<?=$_GET["option"]?>'"><i class="glyphicon glyphicon-refresh"></i>
                </button>
              </span>
        </div>
      </div>  
</div>

   
    <form method="post" id="form_del"  name="form_del" runat="server">
    <div id="livesearch">
    <br>
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

         <th>รหัสประจำตัว </th>
        <th>ชื่อ - นามสกุล</th>
        <th>เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
  $num_gen='0';
  $total_data = $sql_process->rowsQuery("SELECT tbl_trainer_data.trainer_id FROM tbl_trainer_data WHERE tbl_trainer_data.is_delete ='1' ");
  $rows='20';
  if($page<=0)$page=1;
  $total_page=ceil($total_data/$rows);
  if($page>=$total_page)$page=$total_page;
  $start=($page-1)*$rows;
$qg = $sql_process->runQuery(
"SELECT
tbl_trainer_data.trainer_id,
tbl_trainer_data.trainer_img,
tbl_trainer_data.trainer_finger_print,
tbl_trainer_data.title_name_th,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_trainer_data.school_id,
tbl_trainer_data.trainer_status,
tbl_trainer_data.trainer_card,
tbl_trainer_data.trainer_phone,
tbl_trainer_data.trainer_code
FROM
tbl_trainer_data
WHERE
tbl_trainer_data.school_id =:school_id_param AND
tbl_trainer_data.is_delete = '1'
ORDER BY
tbl_trainer_data.trainer_id DESC limit $start,$rows
");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELtrainer_id[]" id="pNUM"  value="<?=$rowGen->trainer_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->trainer_card?></td>
        <td><?=$rowGen->title_name_th?><?=$rowGen->trainer_firstname_th?> <?=$rowGen->trainer_lastname_th?></td>
        <td><?=$rowGen->trainer_phone?></td>
      
        <td align="center">
        <?php
            if($rowGen->trainer_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->trainer_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>
        </td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->trainer_img)){ echo "disabled";}?>>
        รูปประจำตัว
        </button>
        <button type="button" class="btn btn-warning"onclick="window.location.href='?option=trainer-detail&etnr=<?=$rowGen->trainer_code?>'" data-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=trainer-data-edit&etnr=<?=$rowGen->trainer_code?>'" >
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
                <h4 class="modal-title">รูปประจำตัว :: <?=$rowGen->trainer_firstname_th?> <?=$rowGen->trainer_lastname_th?></h4>
              </div>
              <div class="modal-body">
           
             
          <span class="thumbnail">
          <img src="../images/images_trainer/<?=$rowGen->trainer_img?>" alt="<?=$rowGen->trainer_img?>">
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
      <th>รหัสประจำตัว </th>
        <th>ชื่อ - นามสกุล</th>
        <th>เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>
    </div>
    </form>
    <form method="get" name="supage1">
                <nav aria-label="...">
                <input type="hidden" name="option"  value="<?=$_GET["option"]?>">
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="?option=trainer-data&q=<?=$seq?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="?option=trainer-data&q=<?=$seq?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
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