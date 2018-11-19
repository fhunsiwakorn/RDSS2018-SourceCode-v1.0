<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");
require_once('../class/class_query.php');
$sql_process = new function_query();
$pay_code_get = $_GET['rmpb'];	
$stmt = $sql_process->runQuery("SELECT
tbl_register_pay.rp_booknumber,
tbl_register_pay.rp_number,
tbl_register_pay.rp_total_list_price,
tbl_register_pay.rp_discount,
tbl_register_pay.rp_discount_price,
tbl_register_pay.rp_total_price,
tbl_register_pay.rp_total_pay,
tbl_register_pay.rp_in_debt,
tbl_register_pay.rp_vat,
tbl_register_pay.rp_vat_price,
tbl_register_pay.rp_vat_unit,
tbl_register_pay.rp_note,
tbl_register_pay.crt_by,
tbl_register_pay.crt_date,
tbl_register_pay.school_id,
tbl_school.school_logo,
tbl_school.school_name,
tbl_school.school_applicant_name,
tbl_school.school_booknumber,
tbl_school.school_email,
tbl_school.school_website,
tbl_school.school_facebook,
tbl_school.school_lineID,
tbl_school.school_phone,
tbl_school.school_address,
tbl_school.school_company,
tbl_school.school_company_tax,
tbl_school.school_company_email,
tbl_school.school_company_phone,
tbl_school.school_company_fax,
tbl_school.school_company_address,
tbl_school.vat_status,
tbl_school.vat_percent,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode,
tbl_register_pay.register_code
FROM
tbl_register_pay ,
tbl_school ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode
WHERE
tbl_register_pay.school_id = tbl_school.school_id AND
tbl_school.province_id_2 = tbl_location_province.province_id AND
tbl_school.amphur_id_2 = tbl_location_amphur.amphur_id AND
tbl_school.district_id_2 = tbl_location_district.district_id AND
tbl_school.zipcode_id_2 = tbl_location_zipcode.zipcode_id AND
tbl_register_pay.pay_code=:pay_code_param
");
$stmt->execute(array(":pay_code_param"=>$pay_code_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$school_id=$dataRow["school_id"];
$register_code=$dataRow["register_code"];
           //LogoSchool Image
        if(!empty($dataRow["school_logo"])){
            $pathschoolimg="../images/images_school/".$dataRow["school_logo"];
          }else{
            $pathschoolimg="../images/images_system/nologo.png";
          }

          
       

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
tbl_student_data.register_code =:register_code_param
");
$stmt2->execute(array(":register_code_param"=>$register_code,":school_id_param"=>$school_id));
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
<!-- onLoad="javascript:window.print();" -->
<body style="font-size:12px;" onLoad="javascript:window.print();">

<table style="text-align: left; width: 100%;"  border="0">
  <tbody>
    <tr>
      <td align="left"><span style="color:#e5640d;font-weight: bold;" >เล่มที่ <?=$dataRow["rp_booknumber"]?></span></td>
      <td align="right"><span style="color:#e5640d;font-weight: bold;" >เลขที่ <?=$dataRow["rp_number"]?></span></td>
    </tr>
  </tbody>
</table>
<br>
<!-- ////////// -->
<table style="text-align: left; width: 100%;" border="0">
  <tbody>
  <tr align="center">
      <td><b>ใบเสร็จ</b></td>
    </tr>
    <tr  align="center">
      <td><?=$dataRow["school_name"]?> โดย  <?=$dataRow["school_company"]?> </td>
    </tr>
    <tr align="center">
      <td><?=$dataRow["school_company_address"]?>  ต.<?=$dataRow["district_name"]?> อ.<?=$dataRow["amphur_name"]?> จ.<?=$dataRow["province_name"]?> <?=$dataRow["zipcode"]?> โทร <?=$dataRow["school_company_phone"]?></td>
    </tr>
    <tr align="center">
      <td>เลขที่ผู้เสียภาษี  <?=$dataRow["school_company_tax"]?></td>
    </tr>
  </tbody>
</table>

<!-- ////////// -->
<table style="text-align: left; width: 100%;"  border="0">
  <tbody>
    <tr>
      <td align="left">ชื่อ <?=$dataRow2["title_name_th"]?> <?=$dataRow2["student_firstname_th"]?> <?=$dataRow2["student_lastname_th"]?></td>
      <td align="right"><?php echo  DateThai_full2($dataRow["crt_date"]);?></td>
    </tr>
    <tr>
    <td colspan="2" rowspan="1">เลขที่เสียภาษี  <?=$dataRow2["student_ID_card"]?></td>
    </tr>
    <tr>
    <td colspan="2" rowspan="1">ที่อยู่ <?=$dataRow2["student_address"]?>  ตำบล/แขวง  <?=$dataRow2["district_name"]?> อำเภอ/เขต  <?=$dataRow2["amphur_name"]?> จังหวัด  <?=$dataRow2["province_name"]?> <?=$dataRow2["zipcode"]?> โทรศัพท์  <?=$dataRow2["student_phone"]?></td>
    </tr>
  </tbody>
</table>


<table style="text-align: left; width: 100%;"  border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
  <tbody>
    <tr align="center" style="font-weight: bold;background-color:#e8eaed;">
      <td>ลำดับ</td>
      <td>รายการ</td>
      <td>จำนวนหน่วย</td>
      <td>ราคาต่อหน่วย</td>
      <td>จำนวนเงิน</td>
    </tr>
    <?php
$numpv=0;
    $qpl = $sql_process->runQuery(
"SELECT
tbl_register_pay_list.rpl_list_name,
tbl_register_pay_list.rpl_unit,
tbl_register_pay_list.rpl_price_price,
tbl_register_pay_list.rpl_price
FROM
tbl_register_pay_list
WHERE
tbl_register_pay_list.pay_code =:pay_code_param
ORDER BY
tbl_register_pay_list.rpl_id ASC
");
$qpl->execute(array(":pay_code_param"=>$pay_code_get));
while($rowPl= $qpl->fetch(PDO::FETCH_OBJ)) {
  $numpv++;
?>
    <tr>
      <td align="center"><?=$numpv?></td>
      <td><?=$rowPl->rpl_list_name?></td>
      <td align="center"><?=$rowPl->rpl_unit?></td>
      <td align="center"><?php echo number_format($rowPl->rpl_price_price,2);?></td>
      <td align="center"><?php echo number_format($rowPl->rpl_price,2);?></td>
    </tr>
<?php } ?>

<tr>

      <td colspan="4" rowspan="1" align="right"><b>รวม</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_total_list_price"],2);?></td>
    </tr>
    <?php if($dataRow['vat_status']=='1'){ 

 ?>
<tr>
      <td colspan="2" rowspan="2"> </td>
      <td colspan="2" rowspan="1" align="right" ><b>รวม Vat <?=$dataRow['vat_percent']?> %</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_vat_price"],2);?></td>
    </tr>

<tr>
 <?php } ?>
<tr>
      <td colspan="2" rowspan="3"><?=$dataRow["rp_note"]?></td>
      <td colspan="2" rowspan="1" align="right" ><b>ส่วนลดเป็นเงินจำนวน</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_discount_price"],2);?></td>
    </tr>

<tr>
    
      <td colspan="2" rowspan="1" align="right"><b>จำนวนเงินที่ต้องชำระสุทธิ</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_total_price"],2);?></td>
    </tr>

<tr>

      <td colspan="2" rowspan="1" align="right"><b>จำนวนเงินที่ค้างชำระ</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_in_debt"],2);?></td>
    </tr>

<tr style="background-color:#e8eaed;">
      <td colspan="2" rowspan="1">จำนวนเงิน(ตัวอักษร) : <?php echo num2wordsThai("$dataRow[rp_total_pay]"); ?>บาทถ้วน</td>
      <td colspan="2" rowspan="1" align="right"><b>จำนวนเงินที่ชำระทั้งสิ้น</b></td>
      <td align="center"><?php echo number_format($dataRow["rp_total_pay"],2);?></td>
    </tr>


  </tbody>
</table>


</body>
</html>
