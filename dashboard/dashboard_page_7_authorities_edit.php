<?php
require_once('../class/class_user.php');
$user_list = new USER();

if(isset($_POST['btn-submit-edit']))
{ 
    if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
    {
$imageupload = $_FILES['imageupload']['tmp_name'];//ภาพที่1
$imageupload_name = $_FILES['imageupload']['name'];//ภาพที่1
$arraypic = explode(".",$imageupload_name);
$filename = $arraypic[0];//ชื่อไฟล์
$filetype = $arraypic[1];//นามสกุลไฟล์
    if($filetype=="gif" || $filetype=="jpg"||$filetype=="jpeg"|| $filetype=="png"||  $filetype=="JPG" ||  $filetype=="PNG"){  ////ตรวจสอบระเภทรูปภาพ
$newimage = random_password(6).".".$filetype;  ////Randomชื่อรูปภาพ
copy($imageupload,"../images/images_user/".$newimage); //อัพโหลดไปยัง folder
///Resize รูปภาพ
$width=600; //*** Fix Width & Heigh (Autu caculate) ***//
$size=GetimageSize($imageupload);
$height=round($width*$size[1]/$size[0]);
$images_orig = ImageCreateFromJPEG($imageupload); 
//$images_orig = imagecreatefrompng($imageupload);
$photoX = ImagesX($images_orig);
$photoY = ImagesY($images_orig);
$images_fin = ImageCreateTrueColor($width, $height);
ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
ImageJPEG($images_fin,"../images/images_user/".$newimage);
ImageDestroy($images_orig);
ImageDestroy($images_fin);
//ลบรูปเก่าทิ้ง
$user_img=$_POST['user_img'];
$del_img_file="../images/images_user/$user_img";
@unlink($del_img_file);
    }else{
        $newimage=$_POST['user_img']; 
    }
}else{
    $newimage=$_POST['user_img'];
}
$user_id = strip_tags($_POST['user_id']);
$user_name = strip_tags($_POST['user_name']);
$user_password = strip_tags($_POST['user_password']);
$user_prefix = strip_tags($_POST['user_prefix']);
$user_firstname = strip_tags($_POST['user_firstname']);
$user_lastname = strip_tags($_POST['user_lastname']);
$user_email = strip_tags($_POST['user_email']);
$user_img = $newimage;
$school_id = strip_tags($_POST['school_id']);
$branch_id=false;
$user_group_id=false;
$user_flag = strip_tags($_POST['user_flag']);
 //Chk user
 $stmt = $qGeneral->runQuery("SELECT tbl_user.user_id FROM tbl_user WHERE tbl_user.user_name =:user_name_param AND tbl_user.user_id!=:user_id_param");
 $stmt->execute(array(":user_name_param"=>$user_name,":user_id_param"=>$user_id));
 $total_user=$stmt->rowCount();

 //Chk email
 $stmt1 = $qGeneral->runQuery("SELECT tbl_user.user_id FROM tbl_user WHERE tbl_user.user_email =:user_email_param AND tbl_user.user_id!=:user_id_param");
 $stmt1->execute(array(":user_email_param"=>$user_email,":user_id_param"=>$user_id));
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
$user_list->edit_user($user_id,$user_name,$user_password,$user_prefix,$user_firstname,$user_lastname,$user_email,$user_img,$school_id,$branch_id,$user_group_id,$user_flag);
echo "<script>";
echo "location.href = '?option=authorities-edit&auttid=$user_id&success'";
echo "</script>";
  }
}
if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}

$user_id_get = $_GET['auttid'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id_param");
$stmt->execute(array(":user_id_param"=>$user_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
    // picture
    $user_img=$dataRow["user_img"];
    if(!empty($user_img)){
    $user_image ="../images/images_user/"."$user_img";
    }else{
    $user_image = "../images/images_system/default-avatarv9899025.gif";
    }
?>

<!-- PRIVIEW PICTURE -->
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
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ทะเบียนเจ้าหน้าที่
  <small>จัดการข้อมูลตั้งต้น</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li ><a href="?option=authorities-data">เจ้าหน้าที่ดูแลระบบ</a></li>
  <li class="active">แก้ไขข้อมูลเจ้าหน้าที่</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">แบบฟอร์มแก้ไขข้อมูลเจ้าหน้าที่ดูแลระบบ</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row"> 
   
<form enctype="multipart/form-data" method="post"   runat="server" id="frmMain" name="frmMain">
<input type="hidden" name="user_id" id="user_id" value="<?=$_GET['auttid']?>"/>
 <input type="hidden" name="user_img" id="user_img" value="<?=$dataRow['user_img']?>"/>
    <div class="col-xs-12">
<ul class="gallery">
<input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" id="imageupload">
<li><img  src="<?=$user_image?>" alt="อัพโหลดได้เฉพาะไฟล์รูปภาพ !" id="blah"  width="256" height="256"/>
<a href="#" data-toggle="tooltip" title="คลิ๊กเพื่ออัพโหลดรูปภาพ" name="uploadbutton" onclick="imageupload.click()"><span class="photo"></span></a></li>
  </ul>
  </div>

  <div class="col-xs-6">
                  <label>User Name</label> <label style="color:red;">*</label>

                  <div class="input-group">
                   <div class="input-group-btn">
                  <button type="button" class="btn btn-danger" onClick="populateform(7)">Generate</button>
                </div>
                  <input type="text" class="form-control" value="<?=$dataRow['user_name']?>"  name="user_name" autocomplete="off"  required>
                  <span id="mySpan"></span>
                </div>
                </div>

              <div class="col-xs-6">
              <label>Password</label> <label style="color:red;">*</label>
              <div class="input-group">
               <div class="input-group-btn">
              <button type="button" class="btn btn-danger" onClick="populateform2(7)">Generate</button>
            </div>
              <input type="text" class="form-control" value="<?=$dataRow['user_password_shows']?>"  autocomplete="off" name="user_password" required>
            </div>
            </div> 
            <div class="col-xs-4">

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
    echo"<option value='$rowD->title_name'";
    if ($dataRow['user_prefix'] == $rowD->title_name)
    {
      echo "SELECTED";
    }
    echo ">$rowD->title_name</option>\n";
}
                 ?>
                 
                    </select>
                </div> 

<div class="col-xs-4">
<label >ชื่อจริง</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['user_firstname']?>" name="user_firstname" id="user_firstname" required placeholder="ชื่อจริง">
</div>
<div class="col-xs-4">
<label >นามสกุล</label> <label style="color:red;">*</label>         
<input type="text" class="form-control" value="<?=$dataRow['user_lastname']?>" name="user_lastname" id="user_lastname" required placeholder="นามสกุล">
</div>

<div class="col-xs-4">
<label >E-mail</label> <label style="color:red;">*</label>         
<input type="email" class="form-control" value="<?=$dataRow['user_email']?>" name="user_email" id="user_email" required placeholder="E-mail">
</div> 

<div class="col-xs-4">

<label>โรงเรียน</label>   <label style="color:red;">*</label> 
                  
<select   class="form-control select2" style="width: 100%;" name="school_id" id="school_id" required>
<?php
$qa8 = $qGeneral->runQuery(
"SELECT
tbl_school.school_id,
tbl_school.school_name
FROM
tbl_school
WHERE
tbl_school.is_delete = '1' 
ORDER BY
tbl_school.school_id ASC");
$qa8->execute();
while($rowI= $qa8->fetch(PDO::FETCH_OBJ)) {
echo"<option value='$rowI->school_id'";
if ($dataRow['school_id'] == $rowI->school_id)
{
  echo "SELECTED";
}
echo ">$rowI->school_name</option>\n";
                 }
                 ?>
                 
                    </select>
                </div> 


                <div class="col-xs-4">
                   <label>สถานะการใช้งาน</label>
                   <select name="user_flag" id="user_flag"  class="form-control">
                   <option <?php if($dataRow['user_flag']=='1'){echo "SELECTED";} ?> value="1">เปิด</option>
                   <option <?php if($dataRow['user_flag']=='0'){echo "SELECTED";} ?> value="0">ปิด</option>
                 </select>
        
              </div> 


  <div class="col-xs-12">
<label ></label>     
<br>
<center><button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกข้อมูล</button></center>
</div>                 
</form>

</div>
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