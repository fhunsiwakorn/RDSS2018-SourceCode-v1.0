 <!-- Modal  -->
 <div class="modal fade" id="modal-bill-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ใบเสร็จเลขที่ใบสมัคร <?=$rowGen->rm_number?></h4>
              </div>
              <div class="modal-body">
             
  
                  
              <select multiple class="form-control" onchange="redirect(this.value);" style="width: 100%;" >
              <?php
$num_gen1='0';
$qs = $sql_process->runQuery(
"SELECT
tbl_register_pay.rp_booknumber,
tbl_register_pay.rp_number,
tbl_register_pay.pay_code,
tbl_register_pay.rp_total_pay,
tbl_register_pay.crt_date
FROM
tbl_register_pay
WHERE
tbl_register_pay.register_code =:register_code_param AND
tbl_register_pay.school_id =:school_id_param
ORDER BY
tbl_register_pay.rp_id DESC
");
$qs->execute(array(":register_code_param"=>$rowGen->register_code,":school_id_param"=>$school_id));
while($rowPay= $qs->fetch(PDO::FETCH_OBJ)) {
$num_gen1++;

?>
                    <option value="../report/regis-export-bill?rmpb=<?=$rowPay->pay_code?>"><?=$num_gen1?>.  เล่มที่ <?=$rowPay->rp_booknumber?> เลขที่ <?=$rowPay->rp_number?> วันที่ออกใบเสร็จ <?php echo DateThai_2($rowPay->crt_date);?></option>
<?php } ?>
                  </select>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <!-- <button type="submit" class="btn btn-success" name="btn-submit-edit">บันทึกข้อมูล</button> -->
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->    
        </div>