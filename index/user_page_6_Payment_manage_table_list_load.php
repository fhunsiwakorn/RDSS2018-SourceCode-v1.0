<?php
require_once("../config/dbl_config.php");
 require_once('../class/class_query.php');
 $sql_process = new function_query();
 $pay_code_get = isset($_GET['pay_code']) ? $_GET['pay_code'] : NULL;

    if(isset($_POST['rpl_list_name']) && !empty($_POST['rpl_list_name']) && isset($_POST['rpl_unit']) && !empty($_POST['rpl_unit']) &&
    isset($_POST['rpl_price_price']) && !empty($_POST['rpl_price_price']) && isset($_POST['rpl_price']) && !empty($_POST['rpl_price'])){
        $rpl_list_name = strip_tags($_POST['rpl_list_name']);
        $rpl_unit = strip_tags($_POST['rpl_unit']);
        $rpl_price_price = strip_tags($_POST['rpl_price_price']);
        $rpl_price = strip_tags($_POST['rpl_price']);
        $school_id = strip_tags($_POST['school_id']);
        $pay_code = strip_tags($_POST['pay_code']);
        $register_code = strip_tags($_POST['register_code']);

        $table  = 'tbl_register_pay_list';
        $fields = [
            'rpl_list_name' => $rpl_list_name,
            'rpl_unit' => $rpl_unit,
            'rpl_price_price' => $rpl_price_price,
            'rpl_price' => $rpl_price,
            'school_id' => $school_id,
            'pay_code' => $pay_code,
            'register_code' => $register_code
    
        ];
        
        try {
        
            /*
             * Have used the word 'object' as I could not see the actual 
             * class name.
             */
            $sql_process->insert($table,$fields);
        
        }catch(ErrorException $exception) {
        
             $exception->getMessage();  // Should be handled with a proper error message.
        
              }

    }
        ?>

<table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>รายการ</th>
                  <th>จำนวนหน่วย</th>
                  <th>ราคาต่อหน่วย</th>
                  <th>จำนวนเงิน(บาท)</th>
                 
                </tr>
                <?php
$numpv=0;
    $qpl = $sql_process->runQuery(
"SELECT
tbl_register_pay_list.rpl_list_name,
tbl_register_pay_list.rpl_unit,
tbl_register_pay_list.rpl_price_price,
tbl_register_pay_list.rpl_price
FROM
tbl_register_pay_list
WHERE
tbl_register_pay_list.pay_code =:pay_code_param
ORDER BY
tbl_register_pay_list.rpl_id ASC
");
$qpl->execute(array(":pay_code_param"=>$pay_code_get));
while($rowPl= $qpl->fetch(PDO::FETCH_OBJ)) {
  $numpv++;
?>
                <tr>
                <td align="center"><?=$numpv?></td>
      <td><?=$rowPl->rpl_list_name?></td>
      <td align="center"><?=$rowPl->rpl_unit?></td>
      <td align="center"><?php echo number_format($rowPl->rpl_price_price);?></td>
      <td align="center"><?php echo number_format($rowPl->rpl_price);?></td>
               
                </tr>
<?php } ?>        
              </table>