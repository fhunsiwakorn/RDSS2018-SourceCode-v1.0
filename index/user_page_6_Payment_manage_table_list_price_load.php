<?php
require_once("../config/dbl_config.php");
require_once('../class/class_query.php');
$sql_process = new function_query();
$pay_code_get = isset($_GET['pay_code']) ? $_GET['pay_code'] : NULL;
$register_code_get= isset($_GET['register_code']) ? $_GET['register_code'] : NULL;
$vat_get = isset($_GET['vat']) ? $_GET['vat'] : NULL;
///ผลรวมรายการที่ทำปัจจุบันทั้งหมด
$stmt = $sql_process->runQuery("SELECT SUM(tbl_register_pay_list.rpl_price) AS rpl_price FROM tbl_register_pay_list WHERE pay_code=:pay_code_param");
$stmt->execute(array(":pay_code_param"=>$pay_code_get));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);

///คำสั่งหาราคาใบเสร็จเดิมว่าจ่ายครบหรือค้างชำระจำนวนเท่าใด
$stmt2 = $sql_process->runQuery("SELECT   tbl_register_pay.rp_in_debt FROM tbl_register_pay WHERE tbl_register_pay.register_code=:register_code_param ORDER BY tbl_register_pay.rp_id DESC");
$stmt2->execute(array(":register_code_param"=>$register_code_get));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
// echo $dataRow['rpl_price'];
if($dataRow2['rp_in_debt'] == 0 || $dataRow2['rp_in_debt']==NULL){
    $set_rpl_price=$dataRow['rpl_price'];
}else{
    $set_rpl_price=$dataRow2['rp_in_debt'];
}
?>
  <label>จำนวนเงินจากรายการทั้งหมด</label>
 <input class="form-control" type="text" style="width: 100%;"  name="rp_total_list_price" id="rp_total_list_price" value="<?php echo  number_format($set_rpl_price, 2, '.', ''); ?>"  required readonly> 
 <!-- ถ้าโรงเรียนนี้มี Vat -->
<?php if($vat_get!=0){ 
    $vat_sum = ( $vat_get * $set_rpl_price) / ($vat_get+100*1);
    if($dataRow2['rp_in_debt']==0 ||  $dataRow2['rp_in_debt']==NULL){
        $vat_price = ($set_rpl_price + $vat_sum);
        $type="text";
    }else{
        $vat_price = $set_rpl_price;
        $type="hidden";
    }
  
 ?>

<label>รวม Vat <?=$vat_get?> %</label>
<input type="hidden" name="rp_vat" id="rp_vat"  onFocus="startCalc<?=$num_gen?>();" onBlur="stopCalc<?=$num_gen?>();" value="<?=$vat_sum?>"  readonly   class="form-control"/>

<input type="<?=$type?>" name="rp_vat_price" id="rp_vat_price" style="width: 100%;"  value="<?php echo  number_format($vat_price, 2, '.', ''); ?>"  readonly   class="form-control"/>

<?php }else{ ?>
<input type="hidden" name="rp_vat" id="rp_vat"  onFocus="startCalc<?=$num_gen?>();" onBlur="stopCalc<?=$num_gen?>();" value="0"  readonly   class="form-control"/>
<input type="text" name="rp_vat_price" id="rp_vat_price" style="width: 100%;"  value="<?=$set_rpl_price?>"  readonly   class="form-control"/>
<?php } ?>
<input type="hidden" name="rp_vat_unit" id="rp_vat_unit"   value="<?=$vat_get?>"  readonly   class="form-control"/>