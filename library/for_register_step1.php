
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
    $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : 0; 
    $vehicle_type_id = isset($_GET['vehicle_type_id']) ? $_GET['vehicle_type_id'] : NULL; 
    $course_group_id = isset($_GET['course_group_id']) ? $_GET['course_group_id'] : NULL; 
    $course_data_id = isset($_GET['course_data_id']) ? $_GET['course_data_id'] : NULL; 
    $trainer_id = isset($_GET['trainer_id']) ? $_GET['trainer_id'] : NULL; 
    $ragetime_id = isset($_GET['ragetime_id']) ? $_GET['ragetime_id'] : NULL; 
    if ($data=='vehicle_type_id') {
              echo "<select name='vehicle_type_id' onChange=\"dochange('course_group_id', this.value)\" class=\"form-control\" required>";
              echo "<option value=''>- ประเภทรถ -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_master_vehicle_type 
                  WHERE is_delete='1' AND
                  vehicle_type_status='1'
                  ORDER BY
                  vehicle_type_id  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                    // echo "<option value='$rs->school_id'>$rs->school_name</option>"; 
                 
                    echo"<option value='$rs->vehicle_type_id'";
                    if ($vehicle_type_id == $rs->vehicle_type_id)
                    {
                      echo "SELECTED";
                    }
                    echo ">$rs->vehicle_type_name</option>\n";
                
              }
         }

if ($data=='course_group_id') {
echo "<select name='course_group_id' onChange=\"dochange('course_data_id', this.value)\"  class=\"form-control\" required>";
echo "<option value=''>- กลุ่มหลักสูตร -</option>\n";

               $stm= $qGeneral->runQuery(
                "SELECT
                 *
                 FROM
                 tbl_course_group 
                 WHERE 
                 course_status='1' AND is_delete='1' 
                 ORDER BY
                 course_group_id");
                $stm->execute();
                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                  // echo "<option value='$rs->user_group_id'>$rs->user_group_name</option>";   
                  echo"<option value='$rs->course_group_id.$val.$rs->course_group_subject_auto'"; 
                  //$val = vehicle_type_id
                  //$rs->course_group_id=course_group_id
                  if ($course_group_id == $rs->course_group_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->course_group_name</option>\n";       
                }
              }
    
              if ($data=='course_data_id') {
                error_reporting(E_ALL & ~E_NOTICE);
                $arrayid = explode(".",$val);
                $id_1 = $arrayid[0];// course_group_id
                $id_2 = $arrayid[1];// vehicle_type_id
                $id_3 = $arrayid[1];// course_group_subject_auto

                //ถ้า course_group_subject_auto=1 คือเป็นการ กำหนดรายวิชาบังคับ จังกำหนดให้   school_id=0 เพราะเป็นหลักสูตรกลาง    
                if($id_3==1 || $course_data_id !=NULL){ $statememnt="school_id='0'";}else{  $statememnt="school_id='$school_id'"; }

                echo "<select name='course_data_id'  class=\"form-control\" required>";
                echo "<option value=''>- เลือกหลักสูตร -</option>\n";
                
                               $stm= $qGeneral->runQuery(
                                "SELECT
                                 *
                                 FROM
                                 tbl_course_data 
                                 WHERE                                                              
                                 (course_group_id='$id_1' AND  vehicle_type_id='$id_2'   AND course_data_status='1' AND is_delete='1'  AND $statememnt) OR
                                 (course_group_id='$course_group_id' AND  vehicle_type_id='$vehicle_type_id'  AND course_data_status='1' AND is_delete='1'  AND $statememnt)                              
                                 ORDER BY
                                 course_data_id");
                                $stm->execute();
                                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                                  // echo "<option value='$rs->user_group_id'>$rs->user_group_name</option>";   
                                  echo"<option value='$rs->course_data_id'";
                                  if ($course_data_id == $rs->course_data_id)
                                  {
                                    echo "SELECTED";
                                  }
                                  echo ">$rs->course_data_name</option>\n";       
                                }
                              }

                              
                 if ($data=='select_trnORtime') {  ///ช่วงเวลาหรือครู       
                echo "<select name='select_trnORtime' onChange=\"dochange('setType', this.value)\" class=\"form-control\" required>";
                echo "<option value=''>- เลือกช่วงเวลาหรือครู -</option>\n";
                echo "<option value='1'>- ครู -</option>\n";
                echo "<option value='2'>- ช่วงเวลา -</option>\n";
                              }
///ถ้าเป็นครู
     if ($data=='setType' && $val=='1') {     
      echo "<div class='col-xs-4'>";
      echo "<label >เลือกครู</label> <label style='color:red;'>*</label>" ;    
                echo "<select name='trainer_id'  class=\"form-control\" required>";
                echo "<option value=''>- เลือกครู -</option>\n";
                
                               $stm= $qGeneral->runQuery(
                                "SELECT
                                 *
                                 FROM
                                 tbl_trainer_data 
                                 WHERE                                                              
                                 (trainer_status='1' AND  is_delete='1'   AND school_id='$school_id')                         
                                 ORDER BY
                                 trainer_id 
                                 ASC");
                                $stm->execute();
                                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                                  // echo "<option value='$rs->user_group_id'>$rs->user_group_name</option>";   
                                  echo"<option value='$rs->trainer_id'";
                                  if ($trainer_id == $rs->trainer_id)
                                  {
                                    echo "SELECTED";
                                  }
                                  echo ">$rs->title_name_th $rs->trainer_firstname_th $rs->trainer_lastname_th</option>\n";       
                                }
                               
                              
                              }
          ///ถ้าเป็นเวลา
          if ($data=='setType' && $val=='2') {   
            echo "<div class='col-xs-2'>";
            echo "<label >เวลาเริ่มต้น</label> <label style='color:red;'>*</label>" ;
            echo "<input type='time' name='start_time' class=\"form-control\" required>"; 
            echo "</div>"; 
            echo "<div class='col-xs-2'>";
            echo "<label >เวลาสิ้นสุด</label> <label style='color:red;'>*</label>" ;
            echo "<input type='time' name='end_time' class=\"form-control\" required>"; 
            echo "</div>";    
          }                       
         echo "</select>\n";
         echo "</div>"; 
?>
