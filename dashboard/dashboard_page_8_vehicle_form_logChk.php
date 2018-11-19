<?php
//เพิ่มยานพาหนะ
$table="tbl_vegicle_data";
if(isset($_POST['btn-submit-add']))
{ 
    if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
    {
    $newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/image_vehicle/");
    }else{
    $newimage=false;
    }

///Convert วันที่ tax_day_end
if(isset($_POST['tax_day_end'])){
    $tax_day_end=DatetoYMD($_POST['tax_day_end']);    
    }else{
    $tax_day_end=false; 
    }
    ///Convert วันที่ vegicle_day_start
    if(isset($_POST['vegicle_day_start'])){   
    $vegicle_day_start=DatetoYMD($_POST['vegicle_day_start']); 
    }else{
    $vegicle_day_start=false; 
    }

    ///จัด Array user_energy ให้อยู่ในกลุ่ม text เดียวกัน 3 กลุ่ม
     $user_energyA = isset($_POST['user_energy'][0]) ? $_POST['user_energy'][0] : false; 
     $user_energyB = isset($_POST['user_energy'][1]) ? $_POST['user_energy'][1] : false; 
     $user_energyC = isset($_POST['user_energy'][2]) ? $_POST['user_energy'][2] : false;
     $user_energy="$user_energyA $user_energyB $user_energyC";
////
$vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
$vehicle_img = $newimage;
$license_plate = strip_tags($_POST['license_plate']);
$province_id = strip_tags($_POST['province_id']);
$vegicle_brand = strip_tags($_POST['vegicle_brand']);
$gear_type = strip_tags($_POST['gear_type']);
$vegicle_color = isset($_POST['vegicle_color']) ? $_POST['vegicle_color'] : false; 
$vegicle_number = isset($_POST['vegicle_number']) ? $_POST['vegicle_number'] : false; 
$machine_number = isset($_POST['machine_number']) ? $_POST['machine_number'] : false; 
$user_energy = $user_energy;
$tax_day_end = $tax_day_end;
$vegicle_day_start = $vegicle_day_start;
$school_id = strip_tags($_POST['school_id']);
$crt_by=$_SESSION['userSession']; 
$crt_date=date("Y-m-d H:i:s");
$vegicle_status = strip_tags($_POST['vegicle_status']);

$fields = [
    'vehicle_type_id' => $vehicle_type_id,
    'vehicle_img' => $vehicle_img,
    'license_plate' => $license_plate,
    'province_id' => $province_id,
    'vegicle_brand' => $vegicle_brand,
    'gear_type' => $gear_type,
    'vegicle_color' => $vegicle_color,
    'vegicle_number' => $vegicle_number,
    'machine_number' => $machine_number,
    'user_energy' => $user_energy,
    'tax_day_end' => $tax_day_end,
    'vegicle_day_start' => $vegicle_day_start,
    'school_id' => $school_id,
    'crt_by' => $crt_by,
    'crt_date' => $crt_date,
    'vegicle_status' => $vegicle_status
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
echo "location.href = '?option=vehicle-data&success'";
echo "</script>";

}

// แก้ไขยานพาหนะ
if(isset($_POST['btn-submit-edit']))
{ 



if(isset($_FILES['imageupload']['tmp_name']) && !empty($_FILES['imageupload']['tmp_name']))
{
$newimage=add_images($_FILES['imageupload']['tmp_name'],$_FILES['imageupload']['name'],"../images/image_vehicle/");
$del_img_file=delfile($_POST['vehicle_img'],"../images/image_vehicle/");
}else{
$newimage=$_POST['vehicle_img'];
}


///Convert วันที่ tax_day_end
if(isset($_POST['tax_day_end'])){
    $tax_day_end=DatetoYMD($_POST['tax_day_end']);    
    }else{
    $tax_day_end=false; 
    }
    ///Convert วันที่ vegicle_day_start
    if(isset($_POST['vegicle_day_start'])){   
    $vegicle_day_start=DatetoYMD($_POST['vegicle_day_start']); 
    }else{
    $vegicle_day_start=false; 
    }

    ///จัด Array user_energy ให้อยู่ในกลุ่ม text เดียวกัน 3 กลุ่ม
     if(isset($_POST['user_energy']) && !empty($_POST['user_energy'])){
     $user_energyA = isset($_POST['user_energy'][0]) ? $_POST['user_energy'][0] : false; 
     $user_energyB = isset($_POST['user_energy'][1]) ? $_POST['user_energy'][1] : false; 
     $user_energyC = isset($_POST['user_energy'][2]) ? $_POST['user_energy'][2] : false;
     $user_energy="$user_energyA $user_energyB $user_energyC";
     }else{
        $user_energy=$_POST['user_energy2'];
     }
////
$vegicle_data_id = strip_tags($_POST['vegicle_data_id']);
$vehicle_type_id = strip_tags($_POST['vehicle_type_id']);
$vehicle_img = $newimage;
$license_plate = strip_tags($_POST['license_plate']);
$province_id = strip_tags($_POST['province_id']);
$vegicle_brand = strip_tags($_POST['vegicle_brand']);
$gear_type = strip_tags($_POST['gear_type']);
$vegicle_color = isset($_POST['vegicle_color']) ? $_POST['vegicle_color'] : false; 
$vegicle_number = isset($_POST['vegicle_number']) ? $_POST['vegicle_number'] : false; 
$machine_number = isset($_POST['machine_number']) ? $_POST['machine_number'] : false; 
$user_energy = $user_energy;
$tax_day_end = $tax_day_end;
$vegicle_day_start = $vegicle_day_start;
$school_id = strip_tags($_POST['school_id']);
$upd_by=$_SESSION['userSession']; 
$vegicle_status = strip_tags($_POST['vegicle_status']);

$fields = [
    'vehicle_type_id' => $vehicle_type_id,
    'vehicle_img' => $vehicle_img,
    'license_plate' => $license_plate,
    'province_id' => $province_id,
    'vegicle_brand' => $vegicle_brand,
    'gear_type' => $gear_type,
    'vegicle_color' => $vegicle_color,
    'vegicle_number' => $vegicle_number,
    'machine_number' => $machine_number,
    'user_energy' => $user_energy,
    'tax_day_end' => $tax_day_end,
    'vegicle_day_start' => $vegicle_day_start,
    'school_id' => $school_id,
    'upd_by' => $upd_by,
    'vegicle_status' => $vegicle_status
];
$Where=['vegicle_data_id' => $vegicle_data_id];
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
echo "location.href = '?option=vehicle-detail&evgdt=$vegicle_data_id&success'";
echo "</script>";

}
?>