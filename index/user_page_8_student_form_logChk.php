<?php   
$table="tbl_student_data";
///log post เพิ่มนักเรียน
if(isset($_POST['btn-submit-add']))
{ 
//คำนวนอายุ
$birthday=DatetoYMD($_POST['student_birthday']);  
$today = date("Y-m-d");   //จุดต้องเปลี่ยน

if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
{
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/images_student/");
}else{
$newimage=false;
}


$student_type_register = strip_tags($_POST['student_type_register']);
$student_img=$newimage;

$student_finger_print = isset($_POST['student_finger_print']) ? $_POST['student_finger_print'] : false; 
$title_name_th = strip_tags($_POST['title_name_th']);
$student_firstname_th = strip_tags($_POST['student_firstname_th']);
$student_lastname_th = strip_tags($_POST['student_lastname_th']);
$title_name_eng = strip_tags($_POST['title_name_eng']);
$student_firstnam_eng = strip_tags($_POST['student_firstnam_eng']);
$student_lastname_eng = strip_tags($_POST['student_lastname_eng']);
$student_ID_card = strip_tags($_POST['student_ID_card']);
$student_Passport = strip_tags($_POST['student_Passport']);
$nationality_id = strip_tags($_POST['nationality_id']);
$country_id = strip_tags($_POST['country_id']);
$student_birthday = $birthday;
$student_age = cal_age($birthday,$today);;
$student_email = isset($_POST['student_email']) ? $_POST['student_email'] : false; 
$student_line = isset($_POST['student_line']) ? $_POST['student_line'] : false; 
$student_disability = isset($_POST['student_disability']) ? $_POST['student_disability'] : false; 

$student_phone = strip_tags($_POST['student_phone']);
$student_address = strip_tags($_POST['student_address']);
$province_id = strip_tags($_POST['province_id']);
$amphur_id = strip_tags($_POST['amphur_id']);
$district_id = strip_tags($_POST['district_id']);
$zipcode_id = strip_tags($_POST['zipcode_id']);
$student_congenital_disease = isset($_POST['student_congenital_disease']) ? $_POST['student_congenital_disease'] : false; 

$career_id = isset($_POST['career_id']) ? $_POST['career_id'] : false; 
$income_id = isset($_POST['income_id']) ? $_POST['income_id'] : false; 
$reason_id = isset($_POST['reason_id']) ? $_POST['reason_id'] : false; 
$memer_contact = strip_tags($_POST['memer_contact']);
$memer_contact_phone = strip_tags($_POST['memer_contact_phone']);
// $school_id = strip_tags($_POST['school_id']);
$register_code=0;
$student_code=random_password(20);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
    $fields = [
        'student_type_register' => $student_type_register,
        'student_img' => $student_img,
        'student_finger_print' => $student_finger_print,
        'title_name_th' => $title_name_th,
        'student_firstname_th' => $student_firstname_th,
        'student_lastname_th' => $student_lastname_th,
        'title_name_eng' => $title_name_eng,
        'student_firstnam_eng' => $student_firstnam_eng,
        'student_lastname_eng' => $student_lastname_eng,
        'student_ID_card' => $student_ID_card,
        'student_Passport' => $student_Passport,
        'nationality_id' => $nationality_id,
        'country_id' => $country_id,
        'student_birthday' => $student_birthday,
        'student_age' => $student_age,
        'student_email' => $student_email,
        'student_line' => $student_line,
        'student_phone' => $student_phone,
        'student_disability' => $student_disability,
        'student_address' => $student_address,
        'province_id' => $province_id,
        'amphur_id' => $amphur_id,
        'district_id' => $district_id,
        'zipcode_id' => $zipcode_id,
        'student_congenital_disease' => $student_congenital_disease,
        'career_id' => $career_id,
        'income_id' => $income_id,
        'reason_id' => $reason_id,
        'memer_contact' => $memer_contact,
        'memer_contact_phone' => $memer_contact_phone,
        'school_id' => $school_id,
        'crt_by' => $crt_by,
        'crt_date' => $crt_date,
        'register_code' => $register_code,
        'student_code' => $student_code
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
    echo "location.href = '?option=student-data&success'";
    echo "</script>";
}

///log post แก้ไขนักเรียน
if(isset($_POST['btn-submit-edit']))
{ 
//คำนวนอายุ
$birthday=DatetoYMD($_POST['student_birthday']);  
$today = date("Y-m-d");   //จุดต้องเปลี่ยน

if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
{
$student_img_before=$_POST['student_img'];
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/images_student/");
$del_img_file=delfile($student_img_before,"../images/images_student/");
}else{
$newimage=$_POST['student_img'];
}

$student_id = strip_tags($_POST['student_id']);
$student_type_register = strip_tags($_POST['student_type_register']);
$student_img=$newimage;

$student_finger_print = isset($_POST['student_finger_print']) ? $_POST['student_finger_print'] : false; 
$title_name_th = strip_tags($_POST['title_name_th']);
$student_firstname_th = strip_tags($_POST['student_firstname_th']);
$student_lastname_th = strip_tags($_POST['student_lastname_th']);
$title_name_eng = strip_tags($_POST['title_name_eng']);
$student_firstnam_eng = strip_tags($_POST['student_firstnam_eng']);
$student_lastname_eng = strip_tags($_POST['student_lastname_eng']);
$student_ID_card = strip_tags($_POST['student_ID_card']);
$student_Passport = strip_tags($_POST['student_Passport']);
$nationality_id = strip_tags($_POST['nationality_id']);
$country_id = strip_tags($_POST['country_id']);
$student_birthday = $birthday;
$student_age = cal_age($birthday,$today);;
$student_email = isset($_POST['student_email']) ? $_POST['student_email'] : false; 
$student_line = isset($_POST['student_line']) ? $_POST['student_line'] : false; 
$student_disability = isset($_POST['student_disability']) ? $_POST['student_disability'] : false; 

$student_phone = strip_tags($_POST['student_phone']);
$student_address = strip_tags($_POST['student_address']);
$province_id = strip_tags($_POST['province_id']);
$amphur_id = strip_tags($_POST['amphur_id']);
$district_id = strip_tags($_POST['district_id']);
$zipcode_id = strip_tags($_POST['zipcode_id']);
$student_congenital_disease = isset($_POST['student_congenital_disease']) ? $_POST['student_congenital_disease'] : false; 

$career_id = isset($_POST['career_id']) ? $_POST['career_id'] : false; 
$income_id = isset($_POST['income_id']) ? $_POST['income_id'] : false; 
$reason_id = isset($_POST['reason_id']) ? $_POST['reason_id'] : false; 
$memer_contact = strip_tags($_POST['memer_contact']);
$memer_contact_phone = strip_tags($_POST['memer_contact_phone']);
// $school_id = strip_tags($_POST['school_id']);

$upd_by=$_SESSION['userSession']; 

$fields = [
    'student_type_register' => $student_type_register,
    'student_img' => $student_img,
    'student_finger_print' => $student_finger_print,
    'title_name_th' => $title_name_th,
    'student_firstname_th' => $student_firstname_th,
    'student_lastname_th' => $student_lastname_th,
    'title_name_eng' => $title_name_eng,
    'student_firstnam_eng' => $student_firstnam_eng,
    'student_lastname_eng' => $student_lastname_eng,
    'student_ID_card' => $student_ID_card,
    'student_Passport' => $student_Passport,
    'nationality_id' => $nationality_id,
    'country_id' => $country_id,
    'student_birthday' => $student_birthday,
    'student_age' => $student_age,
    'student_email' => $student_email,
    'student_line' => $student_line,
    'student_phone' => $student_phone,
    'student_disability' => $student_disability,
    'student_address' => $student_address,
    'province_id' => $province_id,
    'amphur_id' => $amphur_id,
    'district_id' => $district_id,
    'zipcode_id' => $zipcode_id,
    'student_congenital_disease' => $student_congenital_disease,
    'career_id' => $career_id,
    'income_id' => $income_id,
    'reason_id' => $reason_id,
    'memer_contact' => $memer_contact,
    'memer_contact_phone' => $memer_contact_phone,
    'school_id' => $school_id,
    'upd_by' => $upd_by
];
$Where=['student_id' => $student_id];
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
    echo "location.href = '?option=MZI4NFZ0038F41I&success'";
    echo "</script>";
}
?>