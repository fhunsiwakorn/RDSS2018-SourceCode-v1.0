<?php  
   header("Content-type:text/html; charset=UTF-8");        
   header("Cache-Control: no-store, no-cache, must-revalidate");       
   header("Cache-Control: post-check=0, pre-check=0", false);      
    mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');
	setlocale(LC_ALL, 'th_TH');

    require_once ("../config/dbl_config.php");
    require_once ('../class/class_q_general.php');
    $qGeneral = new Q_gen();
       
    $q = urldecode($_GET["q"]);
    // $q = iconv("UTF-8",$q);
    //$q = iconv("UTF-8","TIS-620",$q);

    $pagesize = 50; 
    $table_db="tbl_location_district"; 
    $find_id="district_id"; 
    $find_field="district_name"; 

    // $sql = "select * from tbl_location_amphur  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";  
    // $results = mysql_query($sql); 
    //$sql = "select * from $table_db  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize"; 
    $stm= $qGeneral->runQuery("SELECT $find_id,$find_field FROM $table_db WHERE tbl_location_district.is_delete ='1'AND LOCATE('$q', $find_field) > 0 
    ORDER BY LOCATE('$q', $find_field), $find_field LIMIT $pagesize");
        $stm->execute();
        while($rs= $stm->fetch(PDO::FETCH_ASSOC)) {
    

   // while ($row = mysql_fetch_array( $results )) {  

        $id = $rs['district_id'];      
        $name = trim($rs['district_name']);
        $name = addslashes($name); // ป้องกันรายการที่ ' ไม่ให้แสดง error
        $name = htmlspecialchars($name); // ป้องกันอักขระพิเศษ
        //$name = ucwords( strtolower($rs->amphur_name)); // ฟิลด์ที่ต้องการแสดงค่า
        $name = str_replace("'", "'", $name);  
        $display_name = preg_replace("/(" .$q. ")/i", "<b>$1</b>", $name);  
        echo "<li onselect=\"this.setText('$name').setValue('$id');\">$name</li>";  
    }  

 
?>  