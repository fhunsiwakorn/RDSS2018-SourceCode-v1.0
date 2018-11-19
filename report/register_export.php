<?php
require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");
require_once('../class/class_query.php');
$sql_process = new function_query();
$register_code_get = $_GET['rmc'];	
$stmt = $sql_process->runQuery("SELECT
tbl_register_main.rm_id,
tbl_register_main.rm_number,
tbl_register_main.student_id,
tbl_register_main.course_data_id,
tbl_register_main.rm_date,
tbl_register_main.rm_pay_status,
tbl_register_main.rm_source,
tbl_register_main.rm_status,
tbl_register_main.testing_result,
tbl_register_main.complete_date,
tbl_register_main.school_id,
tbl_register_main.branch_id,
tbl_register_main.transportation_id,
tbl_register_main.crt_by,
tbl_register_main.crt_date,
tbl_register_main.upd_by,
tbl_register_main.upd_date,
tbl_register_main.register_code,
tbl_course_data.course_data_code,
tbl_course_data.course_data_name,
tbl_course_data.course_data_total_hour,
tbl_course_data.vehicle_type_id,
tbl_student_data.student_id,
tbl_dlt_data.transportation_office_name,
tbl_location_province.province_name,
tbl_school.school_logo,
tbl_school.school_name,
tbl_school.school_email,
tbl_school.school_website,
tbl_school.school_facebook,
tbl_school.school_lineID,
tbl_school.school_phone,
tbl_school.school_fax,
tbl_school.school_address,
tbl_school.province_id,
tbl_school.amphur_id,
tbl_school.district_id,
tbl_school.zipcode_id,
tbl_school.school_id
FROM
tbl_register_main ,
tbl_course_data ,
tbl_student_data ,
tbl_dlt_data ,
tbl_location_province ,
tbl_school
WHERE
tbl_register_main.course_data_id = tbl_course_data.course_data_id AND
tbl_register_main.register_code = tbl_student_data.register_code AND
tbl_register_main.transportation_id = tbl_dlt_data.transportation_id AND
tbl_dlt_data.province_id = tbl_location_province.province_id AND
tbl_register_main.school_id = tbl_school.school_id AND
tbl_register_main.register_code =:register_code_param 
");
$stmt->execute(array(":register_code_param"=>$register_code_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$school_id=$dataRow["school_id"];

           //LogoSchool Image
        if(!empty($dataRow["school_logo"])){
            $pathschoolimg="../images/images_school/".$dataRow["school_logo"];
          }else{
            $pathschoolimg="../images/images_system/nologo.png";
          }
$dataA=$sql_process->QueryField1("SELECT province_name FROM tbl_location_province   WHERE province_id='".$dataRow["province_id"]."' ");          
$dataB=$sql_process->QueryField1("SELECT amphur_name FROM tbl_location_amphur   WHERE amphur_id='".$dataRow["amphur_id"]."' ");          
$dataC=$sql_process->QueryField1("SELECT district_name FROM tbl_location_district   WHERE district_id='".$dataRow["district_id"]."' ");  
$dataD=$sql_process->QueryField1("SELECT zipcode FROM tbl_location_zipcode   WHERE zipcode_id='".$dataRow["zipcode_id"]."' "); 


///// ข้อมูลนักเรียน
$stmt2 = $sql_process->runQuery("SELECT
tbl_student_data.student_type_register,
tbl_student_data.student_img,
tbl_student_data.student_finger_print,
tbl_student_data.title_name_th,
tbl_student_data.student_firstname_th,
tbl_student_data.student_lastname_th,
tbl_student_data.title_name_eng,
tbl_student_data.student_firstnam_eng,
tbl_student_data.student_lastname_eng,
tbl_student_data.student_ID_card,
tbl_student_data.student_Passport,
tbl_student_data.nationality_id,
tbl_student_data.country_id,
tbl_student_data.student_birthday,
tbl_student_data.student_age,
tbl_student_data.student_email,
tbl_student_data.student_line,
tbl_student_data.student_phone,
tbl_student_data.student_disability,
tbl_student_data.student_address,
tbl_student_data.province_id,
tbl_student_data.amphur_id,
tbl_student_data.district_id,
tbl_student_data.zipcode_id,
tbl_student_data.student_congenital_disease,
tbl_student_data.career_id,
tbl_student_data.income_id,
tbl_student_data.reason_id,
tbl_student_data.memer_contact,
tbl_student_data.memer_contact_phone,
tbl_student_data.school_id,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode
FROM
tbl_student_data ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode
WHERE
tbl_student_data.province_id = tbl_location_province.province_id AND
tbl_student_data.amphur_id = tbl_location_amphur.amphur_id AND
tbl_student_data.district_id = tbl_location_district.district_id AND
tbl_student_data.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_student_data.school_id =:school_id_param AND
tbl_student_data.student_id =:student_id_param
");
$stmt2->execute(array(":student_id_param"=>$dataRow["student_id"],":school_id_param"=>$dataRow["school_id"]));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);

   //User Image
   if(!empty($dataRow2["student_img"])){
    $pathuserimg="../images/images_student/".$dataRow2["student_img"];
  }else{
    $pathuserimg="../images/images_system/no_pic.jpg";
  }
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$name_system?></title>
<link rel="stylesheet" href="../fonts/thsarabunnew.css" />
<link rel="stylesheet" href="../fonts/style_font.css" />
<link rel="stylesheet" href="../plugins/checkboxes.css">

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">


<style>
.underlinedoc {
	border-bottom: dashed 1px #333333;
}
</style>
</head>
<body style="font-size:12px;" onLoad="javascript:window.print();">

<table style="text-align: left; width: 100%;" border="0">
<tbody>
    <tr align="center">
    <td colspan="2" rowspan="1">ใบสมัคร</td>
    </tr>
    <tr>
    <td colspan="2" rowspan="1" align="center">
    <img src='<?=$pathschoolimg?>' style="width:150px; height:45px"> <br>
   <b> <?=$dataRow["school_name"]?> </b><br>
    <?=$dataRow["school_address"]?>  ต.<?=$dataC["district_name"]?> อ.<?=$dataB["amphur_name"]?> จ.<?=$dataA["province_name"]?> <?=$dataD["zipcode"]?> โทร <?=$dataRow["school_phone"]?>
    </td>
    </tr>
    <tr>
      <td align="right">เลขที่ใบสมัคร <?=$dataRow["rm_number"]?> </td>
      <td colspan="1" rowspan="5" align="center"> <img src='<?=$pathuserimg?>' style="width:138px; height:153px"></td>
    </tr>
    <tr>
      <td align="right"><?php echo DateThai_full($dataRow["rm_date"]); ?></td>
    </tr>
    <tr>
      <td class="underlinedoc">&nbsp;&nbsp; ข้าพเจ้า <?=$dataRow2["title_name_th"]?> <?=$dataRow2["student_firstname_th"]?> <?=$dataRow2["student_lastname_th"]?> อายุ <?=$dataRow2["student_age"]?> เลขที่บัตรประชาชน  <?=$dataRow2["student_ID_card"]?> </td>
    </tr>
    <tr>
      <td class="underlinedoc">
      บ้านเลขที่ <?=$dataRow2["student_address"]?> ตำบล/แขวง <?=$dataRow2["district_name"]?>  อำเภอ/เขต <?=$dataRow2["amphur_name"]?>  จังหวัด <?=$dataRow2["province_name"]?>
      </td> 
    </tr>
    <tr>
      <td class="underlinedoc">
      โทรศัพท์มือถือ  <?=$dataRow2["student_phone"]?>  โทรศัพท์บ้าน  &nbsp;&nbsp;&nbsp;&nbsp;    โทรศัพท์ที่ทำงาน &nbsp;&nbsp;&nbsp;&nbsp;
      </td> 
    </tr>
  </tbody>
</table>

<!-- ////////// -->
<labe><b>ขอสมัครเรียนฝึกหัดขับ</b></labe>

<table style="text-align: left; width: 100%;" border="0">
  <tbody>
    <tr>
    <?php
    $total_data =$sql_process->rowsQuery("SELECT vehicle_type_id FROM tbl_master_vehicle_type WHERE  vehicle_type_status ='1' AND is_delete ='1'");
$numpv=0;
    $qg = $sql_process->runQuery(
"SELECT
tbl_master_vehicle_type.vehicle_type_id,
tbl_master_vehicle_type.vehicle_type_name
FROM
tbl_master_vehicle_type
WHERE
tbl_master_vehicle_type.is_delete ='1' AND
tbl_master_vehicle_type.vehicle_type_status ='1'
ORDER BY
tbl_master_vehicle_type.vehicle_type_id ASC
");
$qg->execute();
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
  $numpv++;
	


?>
      <td>
  
<div class="checkbox">
            <label style="font-size: 0.2em">
                <input type="checkbox"   <?php if( $dataRow["vehicle_type_id"]==$rowGen->vehicle_type_id) { echo "checked";} ?> disabled>
                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                <?=$rowGen->vehicle_type_name?>
            </label>
        </div>
      </td>
      <?php   for($i=0;$i<$total_data;$i++){
      if($numpv==$i*4) { echo "  </tr><tr>"; }
      } 
      ?> 
<?php } ?>
    </tr>
  </tbody>
</table>
<!-- //////////////////// -->

<table style="text-align: left; width: 100%;" border="0">
  <tbody>
    <tr>
      <td class="underlinedoc">หลักสูตร <?=$dataRow["course_data_name"]?> รหัส <?=$dataRow["course_data_code"]?> จำนวน <?=$dataRow["course_data_total_hour"]?> ชั่วโมง</td>
    </tr>
    <tr>
      <td class="underlinedoc">บุคคลอ้างอิง  <?=$dataRow2["memer_contact"]?> โทรศัพท์ <?=$dataRow2["memer_contact_phone"]?></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>

<!-- //////////////////// -->
<table style="text-align: left; width: 100%;" border="0">
  <tbody>
    <tr>
      <td><b>ข้าพเจ้าได้ทราบระเบียบการเรียนแล้วและขอรับรองดังต่อไปนี้</b></td>
    </tr>
    <?php
    $np=0;
$qg1 = $sql_process->runQuery(
"SELECT
tbl_rules.rules_id,
tbl_rules.rules_text
FROM
tbl_rules
WHERE
tbl_rules.school_id =:school_id_param AND
tbl_rules.rules_status ='1' AND
tbl_rules.is_delete ='1'
ORDER BY
tbl_rules.rules_id ASC
");
$qg1->execute(array(":school_id_param"=>$school_id));
while($rowGen1= $qg1->fetch(PDO::FETCH_OBJ)) {
  $np++;
?>
    <tr>

      <td><?=$np?>. <?=$rowGen1->rules_text?></td>
    </tr>
<?php } ?>

  </tbody>
</table>
<!-- //////////////////// -->
<table style="text-align: left; width: 100%;" border="0">
  <tbody>
    <tr>
      <td width="250">ข้าพเจ้ามีความประสงค์ขอรับใบอนุญาตขับขี่ ณ
      </td>
      <td width="250">
      <div class="checkbox">
<label style="font-size: 0.2em">
<input type="checkbox"  >
<span class="cr"><i class="cr-icon fa fa-check"></i></span>
<?=$dataRow["school_name"]?>
</label>
</div>

      </td>
      <td width="250">
      <div class="checkbox">
<label style="font-size: 0.2em">
<input type="checkbox"  >
<span class="cr"><i class="cr-icon fa fa-check"></i></span>
สำนักงานขนส่งเขตพื้นที่/จังหวัด <?=$dataRow["province_name"]?> 
</label>
</div>

      
      </td>
    </tr>
  </tbody>
</table>

<!-- //////////////////// -->
<table  style="text-align: left; width: 100%;" border="0">
  <tbody>
    <tr align="center">
      <td>ลงชื่อ................................................สำหรับเจ้าหน้าที่ <br> (.......................................................)</td>
      <td>ลงชื่อ................................................ผู้สมัครเรียน <br> (.......................................................)</td>
    </tr>
  </tbody>
</table>

<hr style="border:0px;border-bottom:1px dashed #000" />

<!-- //////////////////// -->
<table  style="text-align: left; width: 100%;" border="0">
  <tbody>

    <tr>
    <?php
    $np1=0;
$total_data1 =$sql_process->rowsQuery("SELECT doc_id FROM tbl_document_regis WHERE school_id='$school_id' AND doc_status ='1' AND is_delete ='1'");
$qg2 = $sql_process->runQuery(
"SELECT
tbl_document_regis.doc_id,
tbl_document_regis.doc_name
FROM
tbl_document_regis
WHERE
tbl_document_regis.school_id =:school_id_param AND
tbl_document_regis.doc_status ='1' AND
tbl_document_regis.is_delete ='1'
ORDER BY
tbl_document_regis.doc_id ASC
");
$qg2->execute(array(":school_id_param"=>$school_id));
while($rowGen2= $qg2->fetch(PDO::FETCH_OBJ)) {
  $np1++;
  $numf=$np1%2;
$stmt1 = $sql_process->runQuery("SELECT tbl_register_main_doc.doc_id FROM tbl_register_main_doc WHERE register_code=:register_code_param AND doc_id='$rowGen2->doc_id'");
$stmt1->execute(array(":register_code_param"=>$register_code_get));
$docRow=$stmt1->fetch(PDO::FETCH_ASSOC);
?>

      <td>
      <div class="checkbox">
<label style="font-size: 0.2em">
<input type="checkbox"  <?php if( $docRow["doc_id"]==$rowGen2->doc_id) { echo "checked";} ?> disabled >
<span class="cr"><i class="cr-icon fa fa-check"></i></span>
<?=$rowGen2->doc_name?>
</label>
</div>
     
      </td>
      <?php   for($i=0;$i<$total_data1;$i++){
      if($np1==$i*2) { echo "  </tr><tr>"; }
      } 
      ?> 
 
      <?php } ?>
      </tr>

  </tbody>
</table>

</body>
</html>
