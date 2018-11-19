<?php
require_once('../class/class_masterdata_location.php');
$zipcode_list = new location_data();
if(isset($_POST['btn-submit-add']))
{ 
    $zipcode = strip_tags($_POST['zipcode']);
    $amphur_id = strip_tags($_POST['amphur_id']);
    $province_id = strip_tags($_POST['province_id']);
    $district_id = strip_tags($_POST['district_id']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
    $zipcode_status = strip_tags($_POST['zipcode_status']);
	$zipcode_list->add_zipcode($province_id,$amphur_id,$district_id,$zipcode,$crt_by,$crt_date,$zipcode_status);
    echo "<script>";
    echo "location.href = '?option=zipcode&success'";
    echo "</script>";
}

if(isset($_POST['DELzipcode_id'])) {
  $count=count($_POST['DELzipcode_id']);
  for($i=0;$i<$count;$i++){
   $zipcode_id = $_POST['DELzipcode_id'];
   $zipcode_list->delete_zipcode($zipcode_id[$i]);
   echo "<script>";
   echo "location.href = '?option=zipcode&success'";
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
         function Inint_AJAX() {
            try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
            try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
            try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
            alert("XMLHttpRequest not supported");
            return null;
         };

         function dochange(src, val) {
              var req = Inint_AJAX();
              req.onreadystatechange = function () {
                   if (req.readyState==4) {
                        if (req.status==200) {
                             document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
                        }
                   }
              };
              req.open("GET", "../library/localtion.php?data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         
         window.onLoad=dochange('province_id', -1);
      
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
  <li ><a href="?option=zipcode">ข้อมูลตั้งต้น</a></li>
  <li class="active">ไปรษณีย์</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ไปรษณีย์</h3><br>
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
                <h4 class="modal-title">เพิ่มไปรษณีย์</h4>
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">   
    
                  <div class="form-group">
                  <label for="exampleInputEmail1">ไปรษณีย์</label>
                  <input type="text" class="form-control" maxlength="5" name="zipcode" id="zipcode" required placeholder="กรอกไปรษณีย์">
             </div>      
         
                <div class="form-group">
                <label>เลือกจังหวัด</label>
                <span id="province_id">
                <select class="form-control" required >
                <option value="" >- เลือกจังหวัด -</option>
                </select>
                </span>
                </div>   
                <div class="form-group">
                <label>เลือกอำเภอ</label>
                <span id="amphur_id">
                <select class="form-control" required >
                <option value="" >- เลือกอำเภอ -</option>
                </select>
                </span>
                </div>    
                <div class="form-group">
                <label>เลือกตำบล</label>
                <span id="district_id">
                <select class="form-control" required >
                <option value="" >- เลือกตำบล -</option>
                </select>
                </span>
                </div>  
                <div class="form-group">
                   <label>สถานะการใช้งาน</label>
                   <select name="zipcode_status" id="zipcode_status"  class="form-control">
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
         <!-- search form -->
         <div class="col-xs-4">
      <form action="#" method="get"name="form1" class="sidebar-form">
      <input type="hidden" name="option"  value="zipcode">
      <input name="h_arti_id" type="hidden" id="h_arti_id" value="" />
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหาไปรษณีย์..." >
          <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
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
            return "../library/search_data_zipcode.php?q=" +encodeURIComponent(this.value);  
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
        <th>เลขไปรษณีย์</th>
        <th>ตำบล</th>
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
$total_data =$qGeneral->rowsQuery("SELECT tbl_location_zipcode.zipcode_id FROM tbl_location_zipcode WHERE tbl_location_zipcode.is_delete ='1'");
$rows='20';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;

$qg = $zipcode_list->runQuery(
"SELECT
tbl_location_zipcode.zipcode_id,
tbl_location_zipcode.district_code,
tbl_location_zipcode.province_id,
tbl_location_zipcode.amphur_id,
tbl_location_zipcode.district_id,
tbl_location_zipcode.zipcode,
tbl_location_zipcode.crt_by,
tbl_location_zipcode.crt_date,
tbl_location_zipcode.upd_by,
tbl_location_zipcode.upd_date,
tbl_location_zipcode.zipcode_status,
tbl_location_district.district_name,
tbl_location_district.district_id,
tbl_location_amphur.amphur_name,
tbl_location_amphur.amphur_id,
tbl_location_province.province_name,
tbl_location_province.province_id,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_location_zipcode ,
tbl_location_district ,
tbl_location_amphur ,
tbl_location_province ,
tbl_user
WHERE
tbl_location_zipcode.province_id = tbl_location_province.province_id AND
tbl_location_zipcode.amphur_id = tbl_location_amphur.amphur_id AND
tbl_location_zipcode.district_id = tbl_location_district.district_id AND
tbl_location_zipcode.crt_by = tbl_user.user_id AND
tbl_location_zipcode.is_delete ='1' AND
tbl_location_zipcode.zipcode  LIKE '%$seq%'
ORDER BY
tbl_location_zipcode.zipcode ASC
 limit $start,$rows
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
<input type="checkbox"  name="DELzipcode_id[]" id="pNUM"  value="<?=$rowGen->zipcode_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> <?php //echo  sprintf("%02d", $num_gen); ?>
</div>
</td>
        <td><?=$rowGen->zipcode?></td>
        <td><?=$rowGen->district_name?></td>
        <td><?=$rowGen->amphur_name?></td>
        <td><?=$rowGen->province_name?></td>
        <td align="center" >
            <?php
            if($rowGen->zipcode_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->zipcode_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>

          </td>
          <td align="center"><?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?><br> (<?php echo DateThai_2($rowGen->crt_date);?>)</td>
          <td align="center"><?=$dataRow["user_firstname"]?> <?=$dataRow["user_lastname"]?> <br> (<?php echo DateThai_2($rowGen->upd_date);?>)</td>
        <td>
        <div  align="center">
        <button type="button" onclick="window.location.href='?option=zipcode-edit&ezd=<?=$rowGen->zipcode_id?>'" class="btn btn-default" data-toggle="tooltip" title="แก้ไข">
        <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" >
        </button> 
        </div>
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>เลขไปรษณีย์</th>
      <th>ตำบล</th>
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
                <input type="hidden" name="option"  value="district">
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="?option=zipcode&q=<?=$seq?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                  <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="?option=zipcode&q=<?=$seq?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
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