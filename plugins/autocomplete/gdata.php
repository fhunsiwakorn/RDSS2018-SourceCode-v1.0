<?php  
    header("content-type: text/html; charset=utf-8"); 
    // header("Content-type:text/html; charset=tis-620");          
    header("Cache-Control: no-store, no-cache, must-revalidate");         
    header("Cache-Control: post-check=0, pre-check=0", false);         

    require_once ("../../config/dbl_config.php");
    require_once ('../../class/class_q_general.php');
    $qGeneral = new Q_gen();
       
    $q = urldecode($_GET["q"]);
    $q = iconv("UTF-8","TIS-620",$q);


    $pagesize = 50; 
    // $table_db="test_tb1"; 
    // $find_field="subject"; 

    // $sql = "select * from tbl_location_amphur  where locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize";  
    // $results = mysql_query($sql);  
    $stm= $qGeneral->runQuery(
        "SELECT
        *
        FROM
        tbl_location_amphur
        where locate('$q', tbl_location_amphur.amphur_name) > 0 
        order by locate('$q', tbl_location_amphur.amphur_name), tbl_location_amphur.amphur_name limit $pagesize
   ");
        $stm->execute();
        while($rs= $stm->fetch(PDO::FETCH_OBJ)) {
        $id = $rs->amphur_id;      
        $name = $rs->amphur_name;
        $name = str_replace("'", "'", $name);  
        $display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);  
        echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";  
    }  

    // closedb();
?>  