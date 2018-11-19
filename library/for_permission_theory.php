
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
    // $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
    if ($data=='school_id_x') {
              echo "<select name='school_id' onChange=\"dochange('trainer_id', this.value)\" class=\"form-control\" >";
              echo "<option value=''>- เลือกโรงเรียน -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_school
                  WHERE is_delete='1' AND
                  school_id!='0' 
                  ORDER BY
                  school_id  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='$rs->school_id'>$rs->school_name</option>"; 
                 
                    // echo"<option value='$rs->school_id'";
                    // if ($school_id == $rs->school_id)
                    // {
                    //   echo "SELECTED";
                    // }
                    // echo ">$rs->school_name</option>\n";
                
              }
         }elseif ($data=='trainer_id') {
echo "<select name='trainer_id'  class=\"form-control\" required>";
echo "<option value=''>- เลือกครู / วิทยากร -</option>\n";

               $stm= $qGeneral->runQuery(
                "SELECT
                 tbl_trainer_data.trainer_id,
                 tbl_trainer_data.trainer_firstname_th,
                 tbl_trainer_data.trainer_lastname_th
                 FROM
                 tbl_trainer_data 
                 WHERE 
                 tbl_trainer_data.is_delete='1'  AND
                 tbl_trainer_data.trainer_status='1'  AND
                 school_id='$val' 
                 ORDER BY
                 trainer_id");
                $stm->execute();
                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                  echo "<option value='$rs->trainer_id'>$rs->trainer_firstname_th $rs->trainer_lastname_th </option>";   
             
                }
              }
    
         echo "</select>\n";

?>
