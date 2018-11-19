<?php
require_once('../class/class_user.php');
$user_list = new USER();
if(isset($_POST['btn-submit-add']))
{
  $user_name = strip_tags($_POST['user_name']);
  $user_email = strip_tags($_POST['user_email']);
  $user_password = strip_tags($_POST['user_password']);
  $user_prefix = isset($_POST['user_prefix']) ? $_POST['user_prefix'] : false;  
  $user_firstname = strip_tags($_POST['user_firstname']);
  $user_lastname = strip_tags($_POST['user_lastname']);
  $school_id = strip_tags($_POST['school_id']);
  $branch_id=strip_tags($_POST['branch_id']);
  $user_group_id=strip_tags($_POST['user_group_id']);
  $user_flag = strip_tags($_POST['user_flag']);
  $user_crt=date("Y-m-d H:i:s");
  $user_status='3';  //เจ้าหน้าที่ทั่วไป
  //Chk user
  $stmt = $qGeneral->runQuery("SELECT tbl_user.user_id FROM tbl_user WHERE tbl_user.user_name =:user_name_param");
  $stmt->execute(array(":user_name_param"=>$user_name));
  $total_user=$stmt->rowCount();

  //Chk email
  $stmt1 = $qGeneral->runQuery("SELECT tbl_user.user_id FROM tbl_user WHERE tbl_user.user_email =:user_email_param");
  $stmt1->execute(array(":user_email_param"=>$user_email));
  $total_email=$stmt1->rowCount();

  if($total_user>='1'){
    echo "<script>";
    echo 'swal("Error !", "Username ซ้ำกัน กรุณาทำรายการใหม่ !", "error")';
    echo "</script>";
  }elseif($total_email>='1'){
    echo "<script>";
    echo 'swal("Error !", "E-mail ซ้ำกัน กรุณาทำรายการใหม่ !", "error")';
    echo "</script>";
  }else{
  $user_list->register_user($user_name,$user_password,$user_prefix,$user_firstname,$user_lastname,$user_email,$school_id,$branch_id,$user_group_id,$user_crt,$user_flag,$user_status);
    echo "<script>";
    echo "location.href = '?option=authorities-data-general&success'";
    echo "</script>";
  }
}
if(isset($_POST['DELuser_id'])) {
  $count=count($_POST['DELuser_id']);
  for($i=0;$i<$count;$i++){
   $user_id = $_POST['DELuser_id'];
   $user_list->delete_user($user_id[$i]);
   echo "<script>";
   echo "location.href = '?option=authorities-data-general&success'";
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

     //Random password generator- by javascriptkit.com
     //Visit JavaScript Kit (http://javascriptkit.com) for script
     //Credit must stay intact for use

     var keylist="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789" // ตัวอักษรที่จะให้มีอยู่ใน Password
     var temp=''

     function generatepass(plength){
     temp=''
     for (i=0;i<plength;i++)
     temp+=keylist.charAt(Math.floor(Math.random()*keylist.length))
     return temp
     }

     function populateform(enterlength){
     document.frmMain.user_name.value=generatepass(enterlength)
     }
     function populateform2(enterlength){
     document.frmMain.user_password.value=generatepass(enterlength)
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
              req.open("GET", "../library/school_and_branch.php?data="+src+"&val="+val); //สร้าง connection
              req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
              req.send(null); //ส่งค่า
         }
         
         window.onLoad=dochange('school_id', -1);
      
     </script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนเจ้าหน้าที่
    <small>จัดการข้อมูลตั้งต้น</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=authorities-data-general">ทะเบียนเจ้าหน้าที่</a></li>
  <li class="active">เจ้าหน้าที่ทั่วไป</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">เจ้าหน้าที่ทั่วไป</h3><br>
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
                <h4 class="modal-title">เจ้าหน้าที่ทั่วไป</h4>
              </div>
              <form id="frmMain" name="frmMain" method="post">
              <div class="modal-body">    

              <div class="col-xs-6">
                  <label>User Name</label> <label style="color:red;">*</label>

                  <div class="input-group">
                   <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform(7)">Generate</button>
                </div>
                  <input type="text" class="form-control" name="user_name" autocomplete="off"  required>
                  <span id="mySpan"></span>
                </div>
                </div>

              <div class="col-xs-6">
              <label>Password</label> <label style="color:red;">*</label>
              <div class="input-group">
               <div class="input-group-btn">
              <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
            </div>
              <input type="text" class="form-control" autocomplete="off" name="user_password" required>
            </div>
            </div> 

            <div class="form-group">

<label>คำนำหน้า</label> 
                  
<select class="form-control" style="width: 100%;" name="user_prefix" id="user_prefix" >
<option value="">--ไม่มี--</option>
<?php
$qa3 = $qGeneral->runQuery(
"SELECT
tbl_master_titlename.title_id,
tbl_master_titlename.title_name
FROM
tbl_master_titlename
WHERE
tbl_master_titlename.title_status = '1' AND
tbl_master_titlename.is_delete = '1' 
ORDER BY
tbl_master_titlename.title_id ASC");
                 $qa3->execute();
                 while($rowD= $qa3->fetch(PDO::FETCH_OBJ)) {
                 echo "<option value='$rowD->title_name'>$rowD->title_name</option>";
                 }
                 ?>
                 
                    </select>
                </div>             

<div class="form-group">
<label >ชื่อจริง</label>    <label style="color:red;">*</label>      
<input type="text" class="form-control" name="user_firstname" id="user_lastname" required  placeholder="ชื่อจริง" >
</div>
<div class="form-group">
<label >นามสกุล</label>    <label style="color:red;">*</label>      
<input type="text" class="form-control" name="user_lastname" id="user_lastname" required  placeholder="นามสกุล" >
</div>
<div class="form-group">
<label >E-mail</label>   <label style="color:red;">*</label>      
<input type="email" class="form-control" name="user_email" id="user_email" required placeholder="E-mail">
</div>          
<div class="form-group"> 
<label>โรงเรียน</label>   <label style="color:red;">*</label> 
<span id="school_id">
<select class="form-control" required >
<option value="" >- เลือกโรงเรียน -</option>
</select>
</span>
</div>    
<div class="form-group"> 
<label>สาขา</label>   <label style="color:red;">*</label> 
<span id="branch_id">
<select class="form-control" required >
<option value="" >- สาขา -</option>
</select>
</span>
</div>              

<div class="form-group"> 
<label>กลุ่มผู้ใช้งาน</label>   <label style="color:red;">*</label> 
<span id="user_group_id">
<select class="form-control" required >
<option value="" >- เลือกกลุ่มผู้ใช้งาน -</option>
</select>
</span>
</div>              
                <div class="form-group">

                   <label>สถานะการใช้งาน</label>
                   <select name="user_flag" id="user_flag"  class="form-control">
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
        <th>กลุ่มผู้ใช้งาน</th>
        <th>Username</th>
        <th>Password</th>
        <th>ชื่่อผู้ใช้งาน</th>
        <th>สถานะ</th>
        <th>โรงเรียน</th>
        <th>สาขา</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $user_list->runQuery(
"SELECT
tbl_user.user_id,
tbl_user.user_name,
tbl_user.user_password,
tbl_user.user_password_shows,
tbl_user.user_prefix,
tbl_user.user_firstname,
tbl_user.user_lastname,
tbl_user.user_email,
tbl_user.user_img,
tbl_user.user_crt,
tbl_user.user_flag,
tbl_school.school_name,
tbl_branch.branch_name,
tbl_user_group.user_group_name
FROM
tbl_user ,
tbl_school,
tbl_branch,
tbl_user_group
WHERE
tbl_user.school_id = tbl_school.school_id AND
tbl_user.branch_id = tbl_branch.branch_id AND
tbl_user.user_group_id = tbl_user_group.user_group_id AND
tbl_user.user_status ='3' AND
tbl_user.is_delete ='1' 
ORDER BY
tbl_user.user_id DESC

");
$qg->execute();
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELuser_id[]" id="pNUM"  value="<?=$rowGen->user_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
 <!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->user_group_name?></td>
        <td><?=$rowGen->user_name?></td>
        <td align="center" >
        <?=$rowGen->user_password_shows?>
          </td>
         
        <td align="center"><?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?><br> (สร้างเมื่อ <?php echo DateThai_2($rowGen->user_crt);?>)</td>
        <td align="center">
        <?php
            if($rowGen->user_flag=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->user_flag=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>
        
        </td>
        <td><?=$rowGen->school_name?></td>
        <td><?=$rowGen->branch_name?></td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->user_img)){ echo "disabled";}?>>
        รูปประจำตัว
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=authorities-general-edit&auttid=<?=$rowGen->user_id?>'" >
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
        <h4 class="modal-title">รูปประจำตัว :: <?=$rowGen->user_firstname?> <?=$rowGen->user_lastname?> <?=$rowGen->school_name?></h4>
      </div>
      <div class="modal-body">
   
     
  <span class="thumbnail">
  <img src="../images/images_user/<?=$rowGen->user_img?>" alt="<?=$rowGen->user_img?>">
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
      <th>กลุ่มผู้ใช้งาน</th>
      <th>Username</th>
      <th>Password</th>
      <th>ชื่่อผู้ใช้งาน</th>
      <th>สถานะ</th>
      <th>โรงเรียน</th>
      <th>สาขา</th>
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