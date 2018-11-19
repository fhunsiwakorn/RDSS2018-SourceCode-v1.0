<?php
require_once("../config/dbl_config.php");
require_once('../class/class_register.php');
 $regis_tmp_list = new register_process();

if (isset($_POST['delete']) && isset($_POST['id'])){
 $id = $_POST['id'];
 $arrayid= explode(".",$id);
 $rmcs_id = $arrayid[0];//rmcs_id
 $subject_data_id = $arrayid[1];//subject_data_id
 $regis_tmp_list->delete_regis_tmp_calendar($rmcs_id);

}
header('Location: '.$_SERVER['HTTP_REFERER']);



	
?>
