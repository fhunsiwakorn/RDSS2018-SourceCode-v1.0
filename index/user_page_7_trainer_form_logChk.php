<?php   
///log post เพิ่มครูฝึก
$table="tbl_trainer_data";
if(isset($_POST['btn-submit-add']))
{ 
//คำนวนอายุ
$birthday=DatetoYMD($_POST['trainer_birthday']);  
$today = date("Y-m-d");   //จุดต้องเปลี่ยน


///Convert วันที่ trainer_card_Issue_date
if(!empty($_POST['trainer_card_Issue_date'])){
    $trainer_card_Issue_date=DatetoYMD($_POST['trainer_card_Issue_date']);
  
}else{
    $trainer_card_Issue_date=false;  
}

///Convert วันที่ trainer_card_expired
if(isset($_POST['trainer_card_expired'])){    
$trainer_card_expired=DatetoYMD($_POST['trainer_card_expired']); 
}else{
$trainer_card_expired=false; 
}
///Convert วันที่ trainer_Passport_Issue_date
if(!empty($_POST['trainer_Passport_Issue_date'])){  
$trainer_Passport_Issue_date=DatetoYMD($_POST['trainer_Passport_Issue_date']); 
}else{
$trainer_Passport_Issue_date=false;     
}
///Convert วันที่ trainer_Passport_card_expired
if(!empty($_POST['trainer_Passport_card_expired'])){     
$trainer_Passport_card_expired=DatetoYMD($_POST['trainer_Passport_card_expired']); 
}else{
$trainer_Passport_card_expired=false;  
}
///Convert วันที่ trainer_code_motorcycle_Issue_date
if(!empty($_POST['trainer_code_motorcycle_Issue_date'])){   
$trainer_code_motorcycle_Issue_date=DatetoYMD($_POST['trainer_code_motorcycle_Issue_date']); 
}else{
$trainer_code_motorcycle_Issue_date=false;  
}
///Convert วันที่ trainer_code_motorcycle_card_expired
if(!empty($_POST['trainer_code_motorcycle_card_expired'])){    
$trainer_code_motorcycle_card_expired=DatetoYMD($_POST['trainer_code_motorcycle_card_expired']); 
}else{
$trainer_code_motorcycle_card_expired=false;  
}
///Convert วันที่ trainer_code_car_Issue_date
if(!empty($_POST['trainer_code_car_Issue_date'])){   
$trainer_code_car_Issue_date=DatetoYMD($_POST['trainer_code_car_Issue_date']); 
}else{
$trainer_code_car_Issue_date=false;    
}
///Convert วันที่ trainer_code_car_card_expired
if(!empty($_POST['trainer_code_car_card_expired'])){      
$trainer_code_car_card_expired=DatetoYMD($_POST['trainer_code_car_card_expired']); 
}else{
$trainer_code_car_card_expired=false; 
}
///Convert วันที่ trainer_code_land_transport_Issue_date
if(isset($_POST['trainer_code_land_transport_Issue_date'])){    
$trainer_code_land_transport_Issue_date=DatetoYMD($_POST['trainer_code_land_transport_Issue_date']); 
}else{
$trainer_code_land_transport_Issue_date=false; 
}
///Convert วันที่ trainer_code_land_transport_card_expired
if(isset($_POST['trainer_code_land_transport_card_expired'])){    
$trainer_code_land_transport_card_expired=DatetoYMD($_POST['trainer_code_land_transport_card_expired']); 
}else{
$trainer_code_land_transport_card_expired=false; 
}

    if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
    {
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/images_trainer/");
}else{
 $newimage=false;
}

$trainer_img=$newimage;
$trainer_finger_print = isset($_POST['trainer_finger_print']) ? $_POST['trainer_finger_print'] : false;
$title_name_th = strip_tags($_POST['title_name_th']);
$trainer_firstname_th = strip_tags($_POST['trainer_firstname_th']);
$trainer_lastname_th = strip_tags($_POST['trainer_lastname_th']);
$title_name_eng = isset($_POST['title_name_eng']) ? $_POST['title_name_eng'] : false;
$trainer_firstnam_eng = isset($_POST['trainer_firstnam_eng']) ? $_POST['trainer_firstnam_eng'] : false;
$trainer_lastname_eng = isset($_POST['trainer_lastname_eng']) ? $_POST['trainer_lastname_eng'] : false;
$trainer_card = isset($_POST['trainer_card']) ? $_POST['trainer_card'] : false;
$trainer_card_Issue_date = isset($_POST['trainer_card_Issue_date']) ? $_POST['trainer_card_Issue_date'] : false;
$trainer_card_expired = isset($_POST['trainer_card_expired']) ? $_POST['trainer_card_expired'] : false;
$trainer_Passport = isset($_POST['trainer_Passport']) ? $_POST['trainer_Passport'] : false;
$trainer_Passport_Issue_date = isset($_POST['trainer_Passport_Issue_date']) ? $_POST['trainer_Passport_Issue_date'] : false;
$trainer_Passport_card_expired = $trainer_Passport_card_expired;  
$trainer_code_motorcycle = isset($_POST['trainer_code_motorcycle']) ? $_POST['trainer_code_motorcycle'] : false;  
$trainer_code_motorcycle_Issue_date = $trainer_code_motorcycle_Issue_date ;  
$trainer_code_motorcycle_card_expired = $trainer_code_motorcycle_card_expired;  
$trainer_code_car = isset($_POST['trainer_code_car']) ? $_POST['trainer_code_car'] : false; 
$trainer_code_car_Issue_date = $trainer_code_car_Issue_date; 
$trainer_code_car_card_expired = $trainer_code_car_card_expired; 
$trainer_code_land_transport = isset($_POST['trainer_code_land_transport']) ? $_POST['trainer_code_land_transport'] : false; 
$trainer_code_land_transport_Issue_date = isset($_POST['trainer_code_land_transport_Issue_date']) ? $_POST['trainer_code_land_transport_Issue_date'] : false; 
$trainer_code_land_transport_card_expired = isset($_POST['trainer_code_land_transport_card_expired']) ? $_POST['trainer_code_land_transport_card_expired'] : false; 
$nationality_id = strip_tags($_POST['nationality_id']);  
$country_id = strip_tags($_POST['country_id']);  
$trainer_birthday = $birthday;
$trainer_age = cal_age($birthday,$today);
$trainer_email = isset($_POST['trainer_email']) ? $_POST['trainer_email'] : false; 
$trainer_line = isset($_POST['trainer_line']) ? $_POST['trainer_line'] : false; 
$trainer_phone = strip_tags($_POST['trainer_phone']);
$trainer_address = strip_tags($_POST['trainer_address']);
$province_id = strip_tags($_POST['province_id']);
$amphur_id = strip_tags($_POST['amphur_id']);
$district_id = strip_tags($_POST['district_id']);
$zipcode_id = strip_tags($_POST['zipcode_id']);
$trainer_type_id = strip_tags($_POST['trainer_type_id']);
$teach_type_id = strip_tags($_POST['teach_type_id']);
// $school_id = strip_tags($_POST['school_id']);

    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s"); 
    $trainer_status = strip_tags($_POST['trainer_status']);
    $trainer_code=random_password(20);
  $fields = [
    'trainer_img' => $trainer_img,
    'trainer_finger_print' => $trainer_finger_print,
    'title_name_th' => $title_name_th,
    'trainer_firstname_th' => $trainer_firstname_th,
    'trainer_lastname_th' => $trainer_lastname_th,
    'trainer_firstnam_eng' => $trainer_firstnam_eng,
    'trainer_lastname_eng' => $trainer_lastname_eng,
    'trainer_card' => $trainer_card,
    'trainer_card_Issue_date' => $trainer_card_Issue_date,
    'trainer_card_expired' => $trainer_card_expired,
    'trainer_Passport' => $trainer_Passport,
    'trainer_Passport_Issue_date' => $trainer_Passport_Issue_date,
    'trainer_Passport_card_expired' => $trainer_Passport_card_expired,
    'trainer_code_motorcycle' => $trainer_code_motorcycle,
    'trainer_code_motorcycle_Issue_date' => $trainer_code_motorcycle_Issue_date,
    'trainer_code_motorcycle_card_expired' => $trainer_code_motorcycle_card_expired,
    'trainer_code_car' => $trainer_code_car,
    'trainer_code_car_Issue_date' => $trainer_code_car_Issue_date,
    'trainer_code_car_card_expired' => $trainer_code_car_card_expired,
    'trainer_code_land_transport' => $trainer_code_land_transport,
    'trainer_code_land_transport_Issue_date' => $trainer_code_land_transport_Issue_date,
    'trainer_code_land_transport_card_expired' => $trainer_code_land_transport_card_expired,
    'nationality_id' => $nationality_id,
    'country_id' => $country_id,
    'trainer_birthday' => $trainer_birthday,
    'trainer_age' => $trainer_age,
    'trainer_email' => $trainer_email,
    'trainer_line' => $trainer_line,
    'trainer_phone' => $trainer_phone,
    'trainer_address' => $trainer_address,
    'province_id' => $province_id,
    'amphur_id' => $amphur_id,
    'district_id' => $district_id,
    'zipcode_id' => $zipcode_id,
    'trainer_type_id' => $trainer_type_id,
    'teach_type_id' => $teach_type_id,
    'school_id' => $school_id,
    'crt_by' => $crt_by,
    'crt_date' => $crt_date,
    'trainer_status' => $trainer_status,
    'trainer_code' => $trainer_code
    
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
    echo "location.href = '?option=FS1KQBSUYBBTE90&success'";
    echo "</script>";
}

///log post แก้ไขครูฝึก
if(isset($_POST['btn-submit-edit']))
{ 
//คำนวนอายุ
$birthday=DatetoYMD($_POST['trainer_birthday']);  
$today = date("Y-m-d");   //จุดต้องเปลี่ยน


///Convert วันที่ trainer_card_Issue_date
if(!empty($_POST['trainer_card_Issue_date'])){
    $trainer_card_Issue_date=DatetoYMD($_POST['trainer_card_Issue_date']);
  
}else{
    $trainer_card_Issue_date=false;  
}

///Convert วันที่ trainer_card_expired
if(isset($_POST['trainer_card_expired'])){    
$trainer_card_expired=DatetoYMD($_POST['trainer_card_expired']); 
}else{
$trainer_card_expired=false; 
}
///Convert วันที่ trainer_Passport_Issue_date
if(!empty($_POST['trainer_Passport_Issue_date'])){  
$trainer_Passport_Issue_date=DatetoYMD($_POST['trainer_Passport_Issue_date']); 
}else{
$trainer_Passport_Issue_date=false;     
}
///Convert วันที่ trainer_Passport_card_expired
if(!empty($_POST['trainer_Passport_card_expired'])){     
$trainer_Passport_card_expired=DatetoYMD($_POST['trainer_Passport_card_expired']); 
}else{
$trainer_Passport_card_expired=false;  
}
///Convert วันที่ trainer_code_motorcycle_Issue_date
if(!empty($_POST['trainer_code_motorcycle_Issue_date'])){   
$trainer_code_motorcycle_Issue_date=DatetoYMD($_POST['trainer_code_motorcycle_Issue_date']); 
}else{
$trainer_code_motorcycle_Issue_date=false;  
}
///Convert วันที่ trainer_code_motorcycle_card_expired
if(!empty($_POST['trainer_code_motorcycle_card_expired'])){    
$trainer_code_motorcycle_card_expired=DatetoYMD($_POST['trainer_code_motorcycle_card_expired']); 
}else{
$trainer_code_motorcycle_card_expired=false;  
}
///Convert วันที่ trainer_code_car_Issue_date
if(!empty($_POST['trainer_code_car_Issue_date'])){   
$trainer_code_car_Issue_date=DatetoYMD($_POST['trainer_code_car_Issue_date']); 
}else{
$trainer_code_car_Issue_date=false;    
}
///Convert วันที่ trainer_code_car_card_expired
if(!empty($_POST['trainer_code_car_card_expired'])){      
$trainer_code_car_card_expired=DatetoYMD($_POST['trainer_code_car_card_expired']); 
}else{
$trainer_code_car_card_expired=false; 
}
///Convert วันที่ trainer_code_land_transport_Issue_date
if(isset($_POST['trainer_code_land_transport_Issue_date'])){    
$trainer_code_land_transport_Issue_date=DatetoYMD($_POST['trainer_code_land_transport_Issue_date']); 
}else{
$trainer_code_land_transport_Issue_date=false; 
}
///Convert วันที่ trainer_code_land_transport_card_expired
if(isset($_POST['trainer_code_land_transport_card_expired'])){    
$trainer_code_land_transport_card_expired=DatetoYMD($_POST['trainer_code_land_transport_card_expired']); 
}else{
$trainer_code_land_transport_card_expired=false; 
}
    if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
    {
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/images_trainer/");

$trainer_img_before=$_POST['trainer_img'];
$del_img_file=delfile($trainer_img_before,"../images/images_trainer/");
}else{
 $newimage=false;
}

$trainer_id =strip_tags($_POST['trainer_id']);
$trainer_img=$newimage;
$trainer_finger_print = isset($_POST['trainer_finger_print']) ? $_POST['trainer_finger_print'] : false;
$title_name_th = strip_tags($_POST['title_name_th']);
$trainer_firstname_th = strip_tags($_POST['trainer_firstname_th']);
$trainer_lastname_th = strip_tags($_POST['trainer_lastname_th']);
$title_name_eng = isset($_POST['title_name_eng']) ? $_POST['title_name_eng'] : false;
$trainer_firstnam_eng = isset($_POST['trainer_firstnam_eng']) ? $_POST['trainer_firstnam_eng'] : false;
$trainer_lastname_eng = isset($_POST['trainer_lastname_eng']) ? $_POST['trainer_lastname_eng'] : false;
$trainer_card = isset($_POST['trainer_card']) ? $_POST['trainer_card'] : false;
$trainer_card_Issue_date = isset($_POST['trainer_card_Issue_date']) ? $_POST['trainer_card_Issue_date'] : false;
$trainer_card_expired = isset($_POST['trainer_card_expired']) ? $_POST['trainer_card_expired'] : false;
$trainer_Passport = isset($_POST['trainer_Passport']) ? $_POST['trainer_Passport'] : false;
$trainer_Passport_Issue_date = isset($_POST['trainer_Passport_Issue_date']) ? $_POST['trainer_Passport_Issue_date'] : false;
$trainer_Passport_card_expired = $trainer_Passport_card_expired;  
$trainer_code_motorcycle = isset($_POST['trainer_code_motorcycle']) ? $_POST['trainer_code_motorcycle'] : false;  
$trainer_code_motorcycle_Issue_date = $trainer_code_motorcycle_Issue_date ;  
$trainer_code_motorcycle_card_expired = $trainer_code_motorcycle_card_expired;  
$trainer_code_car = isset($_POST['trainer_code_car']) ? $_POST['trainer_code_car'] : false; 
$trainer_code_car_Issue_date = $trainer_code_car_Issue_date; 
$trainer_code_car_card_expired = $trainer_code_car_card_expired; 
$trainer_code_land_transport = isset($_POST['trainer_code_land_transport']) ? $_POST['trainer_code_land_transport'] : false; 
$trainer_code_land_transport_Issue_date = isset($_POST['trainer_code_land_transport_Issue_date']) ? $_POST['trainer_code_land_transport_Issue_date'] : false; 
$trainer_code_land_transport_card_expired = isset($_POST['trainer_code_land_transport_card_expired']) ? $_POST['trainer_code_land_transport_card_expired'] : false; 
$nationality_id = strip_tags($_POST['nationality_id']);  
$country_id = strip_tags($_POST['country_id']);  
$trainer_birthday = $birthday;
$trainer_age = cal_age($birthday,$today);
$trainer_email = isset($_POST['trainer_email']) ? $_POST['trainer_email'] : false; 
$trainer_line = isset($_POST['trainer_line']) ? $_POST['trainer_line'] : false; 
$trainer_phone = strip_tags($_POST['trainer_phone']);
$trainer_address = strip_tags($_POST['trainer_address']);
$province_id = strip_tags($_POST['province_id']);
$amphur_id = strip_tags($_POST['amphur_id']);
$district_id = strip_tags($_POST['district_id']);
$zipcode_id = strip_tags($_POST['zipcode_id']);
$trainer_type_id = strip_tags($_POST['trainer_type_id']);
$teach_type_id = strip_tags($_POST['teach_type_id']);
// $school_id = strip_tags($_POST['school_id']);

    $upd_by=$_SESSION['userSession']; 
    $trainer_status = strip_tags($_POST['trainer_status']);

    $fields = [
        'trainer_img' => $trainer_img,
        'trainer_finger_print' => $trainer_finger_print,
        'title_name_th' => $title_name_th,
        'trainer_firstname_th' => $trainer_firstname_th,
        'trainer_lastname_th' => $trainer_lastname_th,
        'trainer_firstnam_eng' => $trainer_firstnam_eng,
        'trainer_lastname_eng' => $trainer_lastname_eng,
        'trainer_card' => $trainer_card,
        'trainer_card_Issue_date' => $trainer_card_Issue_date,
        'trainer_card_expired' => $trainer_card_expired,
        'trainer_Passport' => $trainer_Passport,
        'trainer_Passport_Issue_date' => $trainer_Passport_Issue_date,
        'trainer_Passport_card_expired' => $trainer_Passport_card_expired,
        'trainer_code_motorcycle' => $trainer_code_motorcycle,
        'trainer_code_motorcycle_Issue_date' => $trainer_code_motorcycle_Issue_date,
        'trainer_code_motorcycle_card_expired' => $trainer_code_motorcycle_card_expired,
        'trainer_code_car' => $trainer_code_car,
        'trainer_code_car_Issue_date' => $trainer_code_car_Issue_date,
        'trainer_code_car_card_expired' => $trainer_code_car_card_expired,
        'trainer_code_land_transport' => $trainer_code_land_transport,
        'trainer_code_land_transport_Issue_date' => $trainer_code_land_transport_Issue_date,
        'trainer_code_land_transport_card_expired' => $trainer_code_land_transport_card_expired,
        'nationality_id' => $nationality_id,
        'country_id' => $country_id,
        'trainer_birthday' => $trainer_birthday,
        'trainer_age' => $trainer_age,
        'trainer_email' => $trainer_email,
        'trainer_line' => $trainer_line,
        'trainer_phone' => $trainer_phone,
        'trainer_address' => $trainer_address,
        'province_id' => $province_id,
        'amphur_id' => $amphur_id,
        'district_id' => $district_id,
        'zipcode_id' => $zipcode_id,
        'trainer_type_id' => $trainer_type_id,
        'teach_type_id' => $teach_type_id,
        'school_id' => $school_id,
        'upd_by' => $upd_by,
        'trainer_status' => $trainer_status
        
      ];
      $Where=['trainer_id' => $trainer_id];
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
      echo "location.href = '?option=FS1KQBSUYBBTE90&success'";
      echo "</script>";
    // echo "<script>";
    // echo "location.href = '?option=trainer-detail&etnr=$trainer_id&success'";
    // echo "</script>";
}
?>