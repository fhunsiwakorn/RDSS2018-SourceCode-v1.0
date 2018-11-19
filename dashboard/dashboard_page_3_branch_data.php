<?php
$table="tbl_branch";

if(isset($_POST['btn-submit-add']))
{

  $branch_name = strip_tags($_POST['branch_name']);
  $branch_number = isset($_POST['branch_number']) ? $_POST['branch_number'] : false; 
  $branch_address = strip_tags($_POST['branch_address']);
  $province_id = strip_tags($_POST['province_id']);
  $amphur_id = strip_tags($_POST['amphur_id']);
  $district_id = strip_tags($_POST['district_id']);
  $zipcode_id = strip_tags($_POST['zipcode_id']);
  $school_id = strip_tags($_POST['school_id']);
  $crt_by=$_SESSION['userSession']; 
  $crt_date=date("Y-m-d H:i:s");
  $branch_status = strip_tags($_POST['branch_status']);
    $fields = [
      'branch_name' => $branch_name,
      'branch_number' => $branch_number,
      'branch_address' => $branch_address,
      'province_id' => $province_id,
      'amphur_id' => $amphur_id,
      'district_id' => $district_id,
      'zipcode_id' => $zipcode_id,
      'school_id' => $school_id,
      'crt_by' => $crt_by,
      'crt_date' => $crt_date,
      'branch_status' => $branch_status
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
    echo "location.href = '?option=branch-data&success'";
    echo "</script>";
} 



if(isset($_POST['DELbranch_id'])) {
  $count=count($_POST['DELbranch_id']);
  for($i=0;$i<$count;$i++){
   $branch_id = $_POST['DELbranch_id'][$i];

   $fields = [
    'is_delete' => 0
  ];
  $Where=['branch_id' => $branch_id];
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
   echo "location.href = '?option=branch-data&success'";
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
  ทะเบียนโรงเรียน
    <small>จัดการข้อมูลโรงเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li class="active">ข้อมูลสาขา</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ข้อมูลสาขา</h3>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> <img id="myImg"  src="../images/images_system/add-1-icon.png"  width="30" height="30" ></button>
      <button type="button" class="btn btn-default"onclick="myFunction()" data-toggle="tooltip" title="ลบ"> <img id="myImg"  src="../images/images_system/recyclebin.gif"  width="30" height="30" ></button>
      </div>
      </div>
   <!--MODAL  -->
   <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มสาขา</h4> 
              </div>
              <form  method="post" name="form_add"id="form_add">
              <div class="modal-body">          
              <div class="row">
              <div class="col-xs-6">
                  <label for="exampleInputEmail1">ชื่อสาขา/สำนักงาน</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" name="branch_name" id="branch_name" required placeholder="กรอกชื่อสาขา/สำนักงาน">
                </div> 
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">เลขที่สาขา/สาขาที่</label>
                
                  <input type="text" class="form-control" name="branch_number" id="branch_number"  placeholder="กรอกเลขที่สาขา/สาขาที่">
                </div>  
                <div class="col-xs-6">
                  <label for="exampleInputEmail1">ที่ตั้ง</label> <label style="color:red;">*</label>
                
                  <input type="text" class="form-control" name="branch_address" id="branch_address" required placeholder="กรอกที่ตั้ง">
                </div>  
                <div class="col-xs-6">         
                <label>เลือกจังหวัด</label> <label style="color:red;">*</label>
                <span id="province_id">
                <select class="form-control" required >
                <option value="" >- เลือกจังหวัด -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกอำเภอ</label> <label style="color:red;">*</label>
                <span id="amphur_id">
                <select class="form-control" required >
                <option value="" >- เลือกอำเภอ -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกตำบล</label> <label style="color:red;">*</label>
                <span id="district_id">
                <select class="form-control" required >
                <option value="" >- เลือกตำบล -</option>
                </select>
                </span>
                </div>
                <div class="col-xs-6">
                <label>เลือกไปรษณีย์</label> <label style="color:red;">*</label>
                <span id="zipcode_id">
                <select class="form-control" required >
                <option value="" >- เลือกไปรษณีย์ -</option>
                </select>
                </span>
                </div>
          
                <div class="col-xs-6">

                   <label>โรงเรียน</label> <label style="color:red;">*</label>
                   <select class="form-control select2" style="width: 100%;" name="school_id"  required>
                   <?php
                 $qa3 = $qGeneral->runQuery(
                 "SELECT
                 tbl_school.school_id,
                 tbl_school.school_name
                 FROM
                 tbl_school 
                 WHERE
                 tbl_school.is_delete='1'          
                 ORDER BY
                 tbl_school.school_id  ASC");
                 $qa3->execute();
                 while($rowC= $qa3->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowC->school_id'>$rowC->school_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>  
                <div class="col-xs-6">

                   <label>สถานะการใช้งาน</label>
                   <select name="branch_status" id="branch_status"  class="form-control">
                   <option value="1">เปิด</option>
                   <option value="0">ปิด</option>

                 </select>

                </div>  
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
     <!--END-MODAL  -->
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
        <th>ชื่อสาขา/สำนักงาน</th>
        <th>เลขที่สาขา/สาขาที่</th>
        <th>ที่อยู่สาขา/สำนักงาน</th>
        <th>โรงเรียน</th>
        <th width="150">จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_branch.branch_id,
tbl_branch.branch_name,
tbl_branch.branch_number,
tbl_branch.branch_address,
tbl_branch.crt_by,
tbl_branch.crt_date,
tbl_branch.upd_by,
tbl_branch.upd_date,
tbl_branch.branch_status,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode,
tbl_school.school_name,
tbl_user.user_firstname,
tbl_user.user_lastname
FROM
tbl_branch ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode ,
tbl_school ,
tbl_user
WHERE
tbl_branch.province_id = tbl_location_province.province_id AND
tbl_branch.amphur_id = tbl_location_amphur.amphur_id AND
tbl_branch.district_id = tbl_location_district.district_id AND
tbl_branch.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_branch.school_id = tbl_school.school_id AND
tbl_branch.is_delete = '1' AND
tbl_branch.crt_by = tbl_user.user_id
ORDER BY
tbl_branch.branch_id DESC
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
<input type="checkbox"  name="DELbranch_id[]" id="pNUM"  value="<?=$rowGen->branch_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->branch_name?></td>
        <td><?=$rowGen->branch_number?></td>
        <td><?=$rowGen->branch_address?> ตำบล <?=$rowGen->district_name?> อำเภอ <?=$rowGen->amphur_name?> จังหวัด <?=$rowGen->province_name?> <?=$rowGen->zipcode?></td>
        <td><?=$rowGen->school_name?></td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >

        <button type="button" class="btn btn-warning"data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=branch-data-edit&ebra=<?=$rowGen->branch_id?>'" >
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
                <h4 class="modal-title">รายละเอียด :: <?=$rowGen->branch_name?></h4>
              </div>
              <div class="modal-body">
              <table class="table table-condensed">
              <tr>
              <td width="150">ชื่อสาขา/สำนักงาน</td>
              <td>: <?=$rowGen->branch_name?>
             </td>          
              </tr>
              <tr>
              <td width="150">เลขที่สาขา/สาขาที่</td>
              <td>: <?=$rowGen->branch_number?>
             </td>          
              </tr>
              <tr>
              <td width="150">ที่อยู่สาขา/สำนักงาน</td>
              <td>: <?=$rowGen->branch_address?> ตำบล <?=$rowGen->district_name?> อำเภอ <?=$rowGen->amphur_name?> จังหวัด <?=$rowGen->province_name?> <?=$rowGen->zipcode?>
             </td>          
              </tr>
              <td width="150">โรงเรียน</td>
              <td>: 
              <?=$rowGen->school_name; ?>
              </td>
              </tr>
              <tr>
              <td width="150">สถานะการใช้งาน</td>
              <td>: 
              <?php
            if($rowGen->branch_status=='1'){
             // echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
              echo "เปิด";
            }elseif ($rowGen->branch_status=='0') {
            //echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            echo "ปิด";
          }
             ?>
             <tr>
              <td width="150">สร้างโดย</td>
              <td>: 
              <?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?>  (<?php echo DateThai_2($rowGen->crt_date);?>)
              </td>
              </tr>
              <tr>
              <td width="150">แก้ไขโดย</td>
              <td>: 
              <?=$dataRow["user_firstname"]?> <?=$dataRow["user_lastname"]?>  (<?php echo DateThai_2($rowGen->upd_date);?>)
              </td>
              </tr>
              </td>
              </tr>
              </tr>
              </table>
     

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
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>ชื่อสาขา/สำนักงาน</th>
      <th>เลขที่สาขา/สาขาที่</th>
      <th>ที่อยู่สาขา/สำนักงาน</th>
      <th>โรงเรียน</th>
      <th width="150">จัดการ</th>
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