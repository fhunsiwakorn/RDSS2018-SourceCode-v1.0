<?php
if(isset($_GET['setstep'])){
$rst_temp_code=$_GET['cst'];
$setstep=$_GET['setstep'];
    $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$setstep'   WHERE rst_temp_code='$rst_temp_code' AND school_id='$school_id'");
    echo "<script>";
echo "location.href = '?option=main'";
echo "</script>";
}


?>


<li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<?php
for($i=0;$i<$page_stepMAX;$i++){

?>
  <li class="<?php if($i==$page_stepMAX){ echo "active";} ?>"><a href="?option=main&cst=<?=$rst_temp_code?>&setstep=<?=$i+1?>">ขั้นตอนที่ <?=$i+1?></a></li>

<?php } ?>
