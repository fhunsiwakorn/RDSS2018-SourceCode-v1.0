
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
    $school= isset($_GET['school_idE']) ? $_GET['school_idE'] : NULL;
    $branch = isset($_GET['branch_idE']) ? $_GET['branch_idE'] : NULL; 
    $user_group = isset($_GET['user_group_idE']) ? $_GET['user_group_idE'] : NULL;
    if ($data=='school_id') {
              echo "<select name='school_id' onChange=\"dochange('branch_id', this.value)\" class=\"form-control\" >";
              echo "<option value=''>- เลือกโรงเรียน -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_school 
                  WHERE is_delete='1'
                  ORDER BY
                  school_id  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                  echo"<option value='$rs->school_id'";
                  if ($school == $rs->school_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->school_name</option>\n";
                
              }
         }

		if ($data=='branch_id') {
              echo "<select name='branch_id' onChange=\"dochange('user_group_id', this.value)\" class=\"form-control\" required>";
             echo "<option value=''>- เลือกสาขา -</option>\n";
          
             $stm= $qGeneral->runQuery(
              "SELECT
               *
               FROM
               tbl_branch 
               WHERE 
               branch_status='1' AND is_delete='1' AND
               school_id= '$val' OR  branch_id='$branch'
               ORDER BY
               branch_id");
              $stm->execute();
              while($rs= $stm->fetch(PDO::FETCH_OBJ)) {            
                   echo"<option value='$rs->branch_id'";
                   if ($branch == $rs->branch_id)
                   {
                     echo "SELECTED";
                   }
                   echo ">$rs->branch_name</option>\n";
              }
            }
if ($data=='user_group_id') {
echo "<select name='user_group_id'  class=\"form-control\" required>";
echo "<option value=''>- เลือกกลุ่มผู้ใช้งาน -</option>\n";
   
///รับ $val จาก $branch_id เพื่อรับค่าและเปรียบเทียบว่าตรงกับโรงเรีียนไหน
$branch_id =$val;	
$stmt = $qGeneral->runQuery("SELECT tbl_branch.school_id FROM tbl_branch WHERE branch_id=:branch_id_param");
$stmt->execute(array(":branch_id_param"=>$branch_id));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$school_id=$dataRow['school_id'];
               $stm= $qGeneral->runQuery(
                "SELECT
                 *
                 FROM
                 tbl_user_group 
                 WHERE 
                 user_group_status='1' AND is_delete='1' AND
                 school_id='$school_id' OR user_group_id='$user_group'
                 ORDER BY
                 user_group_id");
                $stm->execute();
                while($rs= $stm->fetch(PDO::FETCH_OBJ)) {            
                     echo"<option value='$rs->user_group_id'";
                     if ($user_group == $rs->user_group_id)
                     {
                       echo "SELECTED";
                     }
                     echo ">$rs->user_group_name</option>\n";
                }
              }
    
         echo "</select>\n";

?>
