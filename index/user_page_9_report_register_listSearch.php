
<?php
    header("content-type: text/html; charset=utf-8");
    header ("Expires: Wed, 21 Aug 2013 13:13:13 GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");

    require_once ("../config/dbl_config.php");
    require_once ('../class/class_q_general.php');
    $qGeneral = new Q_gen();

    $data = $_GET['data'];
    $val = $_GET['val'];
    $vehicle_type_id = isset($_GET['vehicle_type_id']) ? $_GET['vehicle_type_id'] : NULL;
    $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
    $course_data_id = isset($_GET['course_data_id']) ? $_GET['course_data_id'] : NULL; 

    
    if ($data=='vehicle_type_id2') {
              echo "<select name='vehicle_type_id' id='vehicle_type_id' onChange=\"dochange('course_data_id2', this.value)\" class=\"form-control\" required>";
              echo "<option value=''>- เลือกประเภทหลักสูตร -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  tbl_master_vehicle_type.vehicle_type_id,
                  tbl_master_vehicle_type.vehicle_type_name
                 
                  FROM
                  tbl_master_vehicle_type
                  WHERE
                  tbl_master_vehicle_type.vehicle_type_status='1' AND
                  tbl_master_vehicle_type.is_delete ='1'
                  ORDER BY
                  tbl_master_vehicle_type.vehicle_type_id  ASC");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='$rs->vehicle_type_id'>$rs->vehicle_type_name</option>";
                
              }
         }


    elseif ($data=='course_data_id2') {
              echo "<select name='course_data_id' id='course_data_id' class=\"form-control\"  >\n";
              echo "<option value=''>- เลือกหลักสูตร -</option>\n";
       
  $stm= $qGeneral->runQuery(
    "SELECT
     tbl_course_data.course_data_id,tbl_course_data.course_data_name
     FROM
     tbl_course_data 
     WHERE 
    (tbl_course_data.course_data_status='1'  AND 
     tbl_course_data.is_delete='1' AND
     tbl_course_data.school_id='$school_id' AND
     tbl_course_data.vehicle_type_id= '$val') OR
     (tbl_course_data.course_data_status='1'  AND 
     tbl_course_data.is_delete='1' AND
     tbl_course_data.school_id='0' AND
     tbl_course_data.vehicle_type_id= '$val')
     ORDER BY
     course_data_name");
    $stm->execute();
    while($rs= $stm->fetch(PDO::FETCH_OBJ)) {   
        echo "<option value='$rs->course_data_id'>$rs->course_data_name</option>";
            
              }
         }
         echo "</select>\n";

?>
