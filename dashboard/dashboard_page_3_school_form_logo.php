<?php
$table="tbl_school";

if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
{
  $newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/images_school/");
  $del_img_file=delfile($_POST['school_logo'],"../images/images_school/");
  $school_id = strip_tags($_POST['school_id']);
  $school_logo = $newimage;
  $upd_by=$_SESSION['userSession'];
  ////



$fields = [
  'school_logo' => $school_logo,
  'upd_by' => $upd_by
];
$Where=['school_id' => $school_id];
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
echo "location.href = '?option=school-logo&edc=$school_id&success'";
echo "</script>";

}


if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
?>
<?php
$school_id_get = $_GET['edc'];	
$stmt = $qGeneral->runQuery("SELECT tbl_school.school_logo,tbl_school.school_name FROM tbl_school WHERE school_id=:school_id_param");
$stmt->execute(array(":school_id_param"=>$school_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
     // picture
$school_logo=$dataRow["school_logo"];
if(!empty($school_logo)){
$sc_image ="../images/images_school/"."$school_logo";
}else{
$sc_image = "../images/images_system/noimage.gif";
}
?>
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
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
ทะเบียนโรงเรียน
  <small>จัดการข้อมูลโรงเรียน</small>
</h1>
<ol class="breadcrumb">
<li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<li><a href="?option=school-data">ทะเบียนโรงเรียน</a></li>
<li class="active">โลโก้โรงเรียน</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"> โลโก้ :: <?=$dataRow["school_name"]?></h3>
      <!-- <div class="box-tools pull-right">
    
    </div> -->
    
    <div class="box-body">
    <form enctype="multipart/form-data"   runat="server" name="pic_edit_form"  id="pic_edit_form"  method="post" >
    <input type="hidden" class="form-control" name="school_id" id="school_id" value="<?=$_GET['edc']?>">
    <input type="hidden" class="form-control" name="school_logo" id="school_logo" value="<?=$dataRow["school_logo"]?>">
           <div class="box-body" align="center">
     <input type="file" name="imageupload" id="imageupload" onchange="readURL(this);"    style="display:none" >
     <img  src="<?=$sc_image?>" alt="เพิ่มเฉพาะรูปภาพ !" id="blah"  width="300" height="300"/>


           </div>
           <!-- /.box-body -->
<hr />
           <div class="box-footer" align="center">
           <button type="button" class="btn btn-default"  name="uploadbutton" onclick="imageupload.click()">
               <i class="glyphicon glyphicon-folder-open"></i> &nbsp;&nbsp;อัพโหลดรูปภาพ</button>
             <button type="submit" class="btn btn-warning" name="subimg">
               <i class="glyphicon glyphicon-floppy-disk"></i> &nbsp;&nbsp;บันทึกข้อมูล</button>
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