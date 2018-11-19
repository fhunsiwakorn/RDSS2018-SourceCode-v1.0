
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
    $province = isset($_GET['province_idE']) ? $_GET['province_idE'] : NULL;
    $amphur = isset($_GET['amphur_idE']) ? $_GET['amphur_idE'] : NULL; 
    $district = isset($_GET['district_idE']) ? $_GET['district_idE'] : NULL; 
    $zipcode = isset($_GET['zipcode_idE']) ? $_GET['zipcode_idE'] : NULL; 
    
    if ($data=='province_id') {
              echo "<select name='province_id' onChange=\"dochange('amphur_id', this.value)\" class=\"form-control\" required>";
              echo "<option value=''>- เลือกจังหวัด -</option>\n";
                $stm= $qGeneral->runQuery(
                  "SELECT
                  *
                  FROM
                  tbl_location_province 
                  WHERE province_status='1'
                  ORDER BY
                  province_name  ASC ");
                  $stm->execute();
                  while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
                  echo"<option value='$rs->province_id'";
                  if ($province == $rs->province_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->province_name</option>\n";
                
              }
         }

		if ($data=='amphur_id') {
              echo "<select name='amphur_id' onChange=\"dochange('district_id', this.value)\" class=\"form-control\" required>";
             echo "<option value=''>- เลือกอำเภอ -</option>\n";
          
             $stm= $qGeneral->runQuery(
              "SELECT
               *
               FROM
               tbl_location_amphur 
               WHERE 
               amphur_status='1' AND
               province_id= '$val' OR  amphur_id='$amphur'
               ORDER BY
               amphur_name");
              $stm->execute();
              while($rs= $stm->fetch(PDO::FETCH_OBJ)) {            
                   echo"<option value='$rs->amphur_id'";
                   if ($amphur == $rs->amphur_id)
                   {
                     echo "SELECTED";
                   }
                   echo ">$rs->amphur_name</option>\n";
              }
    } 
    if ($data=='district_id') {
              echo "<select name='district_id' onChange=\"dochange('zipcode_id', this.value)\" class=\"form-control\" required>\n";
              echo "<option value=''>- เลือกตำบล -</option>\n";
    
         $stm= $qGeneral->runQuery(
          "SELECT
           *
           FROM
           tbl_location_district 
           WHERE 
           district_status='1' AND
           amphur_id= '$val' OR district_id='$district'
           ORDER BY
           district_name");
          $stm->execute();
          while($rs= $stm->fetch(PDO::FETCH_OBJ)) {  
                  echo"<option value='$rs->district_id'";
                  if ($district == $rs->district_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->district_name</option>\n";
                 
          
              }

    }
    if ($data=='zipcode_id') {
              echo "<select name='zipcode_id' class=\"form-control\" required >\n";
              echo "<option value=''>- เลือกไปรษณีย์ -</option>\n";
       
  $stm= $qGeneral->runQuery(
    "SELECT
     *
     FROM
     tbl_location_zipcode 
     WHERE 
     zipcode_status='1' AND
     district_id= '$val' OR zipcode_id='$zipcode'
     ORDER BY
     zipcode");
    $stm->execute();
    while($rs= $stm->fetch(PDO::FETCH_OBJ)) {   
                  echo"<option value='$rs->zipcode_id'";
                  if ($zipcode == $rs->zipcode_id)
                  {
                    echo "SELECTED";
                  }
                  echo ">$rs->zipcode</option>\n";
            
              }
         }
         echo "</select>\n";

?>
