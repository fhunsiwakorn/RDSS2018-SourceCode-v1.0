<?php
	
$stmt = $sql_process->runQuery("SELECT * FROM tbl_school WHERE school_id=:school_id_param");
$stmt->execute(array(":school_id_param"=>$school_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

//สร้างโดย
$crt_by = $dataRow['crt_by'];
$stmt2 = $sql_process->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_paramA");
$stmt2->execute(array(":user_id_paramA"=>$crt_by));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
//แก้ไขโดย
$upd_by = $dataRow['upd_by'];
$stmt3 = $sql_process->runQuery("SELECT tbl_user.user_firstname,tbl_user.user_lastname FROM tbl_user WHERE user_id=:user_id_paramB");
$stmt3->execute(array(":user_id_paramB"=>$upd_by));
$dataRow3=$stmt3->fetch(PDO::FETCH_ASSOC);

?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ข้อมูลโรงเรียน
    <small>จัดการข้อมูลโรงเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <!-- <li><a href="?option=0VUI326UGYB6A1Y">ข้อมูลโรงเรียน</a></li> -->
  <li class="active">รายละเอียดโรงเรียน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">รายละเอียดโรงเรียน</h3>
              <div class="box-tools pull-right">
        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button> -->
          <button type="button" onclick="window.location.href='?option=edit-sc-form-1'" class="btn btn-warning" data-toggle="tooltip" title="แก้ไข">
        แก้ไข
        </button> 
      </div>      
            </div>
            <div class="box-body">
            <label>ข้อมูลโรงเรียน</label>
            <table class="table table-condensed">
              <tr>
              <td width="150">ชื่อโรงเรียน</td>
              <td>: <?=$dataRow['school_name']?>
             </td>          
              </tr>
              <tr>
              <td width="150">ชื่อผู้ขอจัดตั้งโรงเรียน</td>
              <td>: <?=$dataRow['school_applicant_name']?>
              
              </td>
              <tr>
              <td width="150">เลขที่หนังสือรับรอง</td>
              <td>: <?=$dataRow['school_booknumber']?>             
              </td>              
              </tr>
              </tr>
              <tr>
              <td width="150">อีเมลโรงเรียน</td>
              <td>: <?=$dataRow['school_email']?>
              </td>          
              </tr>
              <tr>
              <td width="150">เว็บไซต์</td>
              <td>: <?=$dataRow['school_website']?>
              </td>          
              </tr>
              <tr>
              <td width="150">facebook</td>
              <td>: <?=$dataRow['school_facebook']?>
              </td>          
              </tr>
              <tr>
              <tr>
              <td width="150">LINE ID</td>
              <td>: <?=$dataRow['school_lineID']?>
              </td>          
              </tr>
              <tr>
              <td width="150">เบอร์โทร</td>
              <td>: <?=$dataRow['school_phone']?>
              </td>
              </tr>
              <tr>
              <td width="150">แฟกต์</td>
              <td>: <?=$dataRow['school_fax']?>
              </td>
              </tr>
              <tr>
              <td width="150">ที่ตั้ง</td>
              <td>: 
             <?php 
            $losc = $sql_process->runQuery("SELECT
            tbl_location_province.province_name,
            tbl_location_amphur.amphur_name,
            tbl_location_district.district_name,
            tbl_location_zipcode.zipcode
            FROM
            tbl_location_province ,
            tbl_location_amphur ,
            tbl_location_district ,
            tbl_location_zipcode
            WHERE
            tbl_location_province.province_id = :province_id_param AND
            tbl_location_amphur.amphur_id = :amphur_id_param AND
            tbl_location_district.district_id = :district_id_param AND
            tbl_location_zipcode.zipcode_id = :zipcode_id_param
            ");
            
            $losc->execute(array(":province_id_param"=>$dataRow['province_id'],
            ":amphur_id_param"=>$dataRow['amphur_id'],
            ":district_id_param"=>$dataRow['district_id'],
            ":zipcode_id_param"=>$dataRow['zipcode_id']
            ));
            $loscRow=$losc->fetch(PDO::FETCH_ASSOC);
            echo "&nbsp".$dataRow['school_address']."&nbsp";
            echo "ตำบล"."&nbsp".$loscRow['district_name']."&nbsp";
            echo "อำเภอ"."&nbsp".$loscRow['amphur_name']."&nbsp";
            echo "จังหวัด"."&nbsp".$loscRow['province_name']."&nbsp";
            echo "&nbsp".$loscRow['zipcode']."&nbsp";
          ?>
              </td>
              
              </tr>
              
              </table>
              <br>
<!-- บรัษัท -->
<label>ข้อมูลบริษัท</label>
            <table class="table table-condensed">
              <tr>
              <td width="150">ชื่อบริษัท</td>
              <td>: <?=$dataRow['school_company']?>
             </td>          
              </tr>
              
              <tr>
              <td width="150">เลขที่เสียภาษี</td>
              <td>: <?=$dataRow['school_company_tax']?>
              </td>          
              </tr>
              <tr>
              <td width="150">อีเมลบริษัท</td>
              <td>: <?=$dataRow['school_company_email']?>
              </td>          
              </tr>
              <tr>
              <td width="150">เบอร์โทร</td>
              <td>: <?=$dataRow['school_company_phone']?>
              </td>
              </tr>
              <tr>
              <td width="150">แฟกต์</td>
              <td>: <?=$dataRow['school_company_fax']?>
              </td>
              </tr>
              <tr>
              <td width="150">ที่ตั้ง</td>
              <td>: 
             <?php 
            $losc2 = $sql_process->runQuery("SELECT
            tbl_location_province.province_name,
            tbl_location_amphur.amphur_name,
            tbl_location_district.district_name,
            tbl_location_zipcode.zipcode
            FROM
            tbl_location_province ,
            tbl_location_amphur ,
            tbl_location_district ,
            tbl_location_zipcode
            WHERE
            tbl_location_province.province_id = :province_id_param2 AND
            tbl_location_amphur.amphur_id = :amphur_id_param2 AND
            tbl_location_district.district_id = :district_id_param2 AND
            tbl_location_zipcode.zipcode_id = :zipcode_id_param2
            ");
            
            $losc2->execute(array(":province_id_param2"=>$dataRow['province_id_2'],
            ":amphur_id_param2"=>$dataRow['amphur_id_2'],
            ":district_id_param2"=>$dataRow['district_id_2'],
            ":zipcode_id_param2"=>$dataRow['zipcode_id_2']
            ));
            $loscRow2=$losc2->fetch(PDO::FETCH_ASSOC);
            echo "&nbsp".$dataRow['school_company_address']."&nbsp";
            echo "ตำบล"."&nbsp".$loscRow2['district_name']."&nbsp";
            echo "อำเภอ"."&nbsp".$loscRow2['amphur_name']."&nbsp";
            echo "จังหวัด"."&nbsp".$loscRow2['province_name']."&nbsp";
            echo "&nbsp".$loscRow2['zipcode']."&nbsp";
          ?>
              </td>
              
              </tr>
              
              </table>
<hr>
<label>สร้างโดย : </label> <?=$dataRow2["user_firstname"]?> <?=$dataRow2["user_lastname"]?> (<?php echo DateThai_2($dataRow["crt_date"]);?>)<br>
<label>แก้ไขโดย : </label> <?=$dataRow3["user_firstname"]?> <?=$dataRow3["user_lastname"]?> (<?php echo DateThai_2($dataRow["upd_date"]);?>)
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


</section>
<!-- /.content -->
</div>