
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
    $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
    $user_group_id = isset($_GET['user_group_id']) ? $_GET['user_group_id'] : NULL; 
    if ($data=='school_id') {
              echo "<select name='school_id' onChange=\"dochange('user_group_id', this.value)\" class=\"form-control\" >";
              echo "<option value=''>- เลือกโรงเรียน -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_school 
                  WHERE is_delete='1' OR
                  school_id='$school_id' AND
                  school_id!='0' 
                  ORDER BY
                  school_id  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                    // echo "<option value='$rs->school_id'>$rs->school_name</option>"; 
                 
                    echo"<option value='$rs->school_id'";
                    if ($school_id == $rs->school_id)
                    {
                      echo "SELECTED";
                    }
                    echo ">$rs->school_name</option>\n";
                
              }
         }

if ($data=='user_group_id') {
echo "<select name='user_group_id'  class=\"form-control\" required>";
echo "<option value=''>- เลือกกลุ่มผู้ใช้งาน -</option>\n";

               $stm= $qGeneral->runQuery(
                "SELECT
                 *
                 FROM
                 tbl_user_group 
                 WHERE 
                 user_group_status='1' AND is_delete='1' AND
                 school_id='$val' OR
                 user_group_id='$user_group_id'
                 ORDER BY
                 user_group_id");
                $stm->execute();
                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                  // echo "<option value='$rs->user_group_id'>$rs->user_group_name</option>";   
                  echo"<option value='$rs->user_group_id'";
                  if ($user_group_id == $rs->user_group_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->user_group_name</option>\n";       
                }
              }
    
         echo "</select>\n";

?>
