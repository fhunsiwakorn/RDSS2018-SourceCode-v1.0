<?php
if(isset($_POST['btn-submit-add']))
{   
  
  $data_gen_id = strip_tags($_POST['data_gen_id']);
  $school_company = strip_tags($_POST['school_company']);
  $school_company_tax = strip_tags($_POST['school_company_tax']);
  $school_company_email = strip_tags($_POST['school_company_email']);
  $school_company_phone = strip_tags($_POST['school_company_phone']);
  $school_company_fax = strip_tags($_POST['school_company_fax']);
  $school_company_address = strip_tags($_POST['school_company_address']);
  $province_id_2 = strip_tags($_POST['province_id']);
  $amphur_id_2 = strip_tags($_POST['amphur_id']);
  $district_id_2 = strip_tags($_POST['district_id']);
  $zipcode_id_2 = strip_tags($_POST['zipcode_id']);
  $vat_status = strip_tags($_POST['vat_status']);
  $vat_percent = isset($_POST['vat_percent']) ? $_POST['vat_percent'] : 0;
  $upd_by=$_SESSION['userSession']; 
  $table  = 'tbl_school';
  $fields = [
    'school_company' => $school_company,
    'school_company_tax' => $school_company_tax,
    'school_company_email' => $school_company_email,
    'school_company_phone' => $school_company_phone,
    'school_company_fax' => $school_company_fax,
    'school_company_address' => $school_company_address,
    'province_id_2' => $province_id_2,
    'amphur_id_2' => $amphur_id_2,
    'district_id_2' => $district_id_2,
    'zipcode_id_2' => $zipcode_id_2,
    'vat_status' => $vat_status,
    'vat_percent' => $vat_percent,
    'upd_by' => $upd_by
    
];
$Where=['data_gen_id' => $data_gen_id];
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
  echo "location.href = '?option=0VUI326UGYB6A1Y&success'";
  echo "</script>";
}
// if(isset($_GET['success'])){
//     echo "<script>";
//     echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
//     echo "</script>";
// }
$data_gen_id_get = $_GET['data_gen'];	
$stmt = $qGeneral->runQuery("SELECT * FROM tbl_school WHERE data_gen_id=:data_gen_id_param");
$stmt->execute(array(":data_gen_id_param"=>$data_gen_id_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['get_data'])){ ///ใช้ข้อมูลเดียวกันกับโรงเรียน
  $school_name = $dataRow['school_name'];
  $school_email = $dataRow['school_email'];
  $school_phone = $dataRow['school_phone'];
  $school_fax = $dataRow['school_fax'];
  $school_address = $dataRow['school_address'];
  $province_id = $dataRow['province_id'];
  $amphur_id = $dataRow['amphur_id'];
  $district_id = $dataRow['district_id'];
  $zipcode_id = $dataRow['zipcode_id'];
}else{
  $school_name = $dataRow['school_company'];
  $school_email = $dataRow['school_company_email'];
  $school_phone = $dataRow['school_company_phone'];
  $school_fax = $dataRow['school_company_fax'];
  $school_address = $dataRow['school_company_address'];
  $province_id = $dataRow['province_id_2'];
  $amphur_id = $dataRow['amphur_id_2'];
  $district_id = $dataRow['district_id_2'];
  $zipcode_id = $dataRow['zipcode_id_2'];
}
$school_company_tax = $dataRow['school_company_tax'];
$vat_status = isset($_POST['vat_status']) ? $_POST['vat_status'] : $dataRow['vat_status'];

if($dataRow['vat_percent']==0){
  $vat_percent=7;
}else{
  $vat_percent=$dataRow['vat_percent'];
}
?>

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
     req.open("GET", "../library/localtion.php?province_idE=<?=$province_id?>&amphur_idE=<?=$amphur_id?>&district_idE=<?=$district_id?>&zipcode_idE=<?=$zipcode_id?>&data="+src+"&val="+val); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
     req.send(null); //ส่งค่า
}

window.onLoad=dochange('province_id', -1);
window.onLoad=dochange('amphur_id', -1);
window.onLoad=dochange('district_id', -1);
window.onLoad=dochange('zipcode_id', -1);

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
  <li><a href="?option=0VUI326UGYB6A1Y">ข้อมูลโรงเรียน</a></li>
  <li><a href="?option=edit-sc-form-1">ขั้นตอนที่ 1 แบบฟอร์มโรงเรียน</a></li>
  <li class="active">ขั้นตอนที่ 2 แบบฟอร์มเพิ่มข้อมูลบริษัท</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">ขั้นตอนที่ 2 แบบฟอร์มเพิ่มข้อมูลบริษัท <?=$dataRow['school_name']?></h3>
              
            </div>
            <div class="box-body">
            <button type="button" onclick="window.location.href='?option=edit-sc-form-2&data_gen=<?=$_GET["data_gen"]?>&get_data'" class="btn btn-success" data-toggle="tooltip" title="ใช้ข้อมูลเดียวกันกับโรงเรียน">
       ใช้ข้อมูลเดียวกันกับโรงเรียน
        </button> <hr>
        <form method="post">
            <input type="hidden" name="data_gen_id" id="data_gen_id" value="<?=$_GET["data_gen"]?>"/>
              <div class="row">
                <div class="col-xs-6">
                <label >ชื่อบริษัท</label> <label style="color:red;">*</label>         
                  <input type="text" class="form-control" name="school_company" value="<?=$school_name?>" id="school_company" required placeholder="กรอกชื่อชื่อบริษัท">
                </div>
                <div class="col-xs-6">
                <label >เลขที่เสียภาษี</label>  <label style="color:red;">*</label>        
                  <input type="text" class="form-control" name="school_company_tax" value="<?=$school_company_tax?>" id="school_company_tax" required placeholder="กรอกเลขที่เสียภาษี">
                </div>
                <div class="col-xs-6">
                <label >อีเมล</label>   <label style="color:red;">*</label>       
                  <input type="email" class="form-control" name="school_company_email" value="<?=$school_email?>" id="school_company_email" required placeholder="กรอกอีเมล">
                </div>
                <div class="col-xs-6">
                <label >ที่ตั้ง</label>   <label style="color:red;">*</label>       
                  <input type="text" class="form-control"  name="school_company_address" id="school_company_address" value="<?=$school_address?>" id="school_company_address"  required placeholder="กรอกที่ตั้ง">
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
                <div class="col-xs-2">
                <label >โทร</label> <label style="color:red;">*</label>         
                  <input type="text" class="form-control" name="school_company_phone" id="school_company_phone" value="<?=$school_phone?>" maxlength="10" required placeholder="กรอกเบอร์โทร">
                </div>   
                <div class="col-xs-3">
                <label >แฟกต์</label>       
                  <input type="text" class="form-control" name="school_company_fax" id="school_company_fax" value="<?=$school_fax?>" maxlength="10"  placeholder="กรอกแฟกต์">
                </div>

                <div class="col-xs-2">
                <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="vat_status" id="vat_status1" onchange="submit();" value="1" <?php if($vat_status ==1){ echo "checked";}?>>
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>        
            </label>
            <label> มี Vat</label>
        </div>
                </div> 

                  <div class="col-xs-2">
                <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="vat_status" id="vat_status2" value="0" onchange="submit();" <?php if($vat_status ==0){ echo "checked";}?> >
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
               
            </label>
            <label>  ไม่มี Vat</label>
        </div>
                </div> 
    <?php if($vat_status ==1){ ?>
             <div class="col-xs-2">
                <label > Vat (Percent)</label> <label style="color:red;">*</label>         
                  <input type="number" class="form-control" name="vat_percent" id="vat_percent" value="<?=$vat_percent?>" maxlength="1">
                </div>   
    <?php } ?>
                <div class="col-xs-12">
                <label ></label>     
                <br>
                <center><button type="submit"  name="btn-submit-add" class="btn btn-primary">บันทึกข้อมูล</button></center>
                </div>    
              </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


</section>
<!-- /.content -->
</div>