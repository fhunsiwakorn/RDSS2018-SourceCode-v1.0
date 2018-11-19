<?php  $pay_code = random_password(20); ?>

<script type="text/javascript">
 var auto_refresh = setInterval(
 function ()
 {
 $('#load_list<?=$num_gen?>').load('user_page_6_Payment_manage_table_list_load.php?pay_code=<?=$pay_code?>').fadeIn("slow");
 
 }, 1000); // refresh every 10000 milliseconds
 
 </script>

<script type="text/javascript">
 var auto_refresh = setInterval(
 function ()
 {
 $('#load_list_price<?=$num_gen?>').load('user_page_6_Payment_manage_table_list_price_load.php?pay_code=<?=$pay_code?>&vat=<?=$dataRow_1['vat_percent']?>&register_code=<?=$rowGen->register_code?>').fadeIn("slow");
 
 }, 1000); // refresh every 10000 milliseconds
 
   
 </script>

 <script>
var  myVar<?=$num_gen?>;

function myFunctionX<?=$num_gen?>() {
    myVar<?=$num_gen?> = setTimeout(function(){
    //   alert("Hello"); 
        rpl_list_name = document.form_<?=$num_gen?>.rpl_list_name.value = '';
 
        rpl_price_price = document.form_<?=$num_gen?>.rpl_price_price.value =  '';
        rpl_price = document.form_<?=$num_gen?>.rpl_price.value =  '';
        
         }, 3000);
  
}

function chkSUM<?=$num_gen?>(){

var rpl_unit=parseFloat(document.form_<?=$num_gen?>.rpl_unit.value);
var rpl_price_price=parseFloat(document.form_<?=$num_gen?>.rpl_price_price.value);
document.form_<?=$num_gen?>.rpl_price.value= (rpl_unit * 1) * (rpl_price_price * 1); //---- เปลี่ยนเอาจะ + - * /

}

// function myStopFunction<?=$num_gen?>() {
//     clearTimeout(myVar);
// }

 
function startCalc<?=$num_gen?>(){ 

/////
rp_vat_price = document.form_2<?=$num_gen?>.rp_vat_price.value;  ////ราคารวมทั้งหมด
rp_discount = document.form_2<?=$num_gen?>.rp_discount.value; ///ส่วนลด
rp_discount_price = document.form_2<?=$num_gen?>.rp_discount_price.value = (rp_vat_price * rp_discount) / (100 * 1);  ////ส่วนลดเป็นจำนวนเงิน	
rp_total_price = document.form_2<?=$num_gen?>.rp_total_price.value = (rp_vat_price * 1) - (rp_discount_price * 1);  ////รวมค่าชำระสุทธิ
rp_total_pay = document.form_2<?=$num_gen?>.rp_total_pay.value; ////จำนวนเงินที่ชำระ	
rp_in_debt = document.form_2<?=$num_gen?>.rp_in_debt.value = (rp_total_price * 1) - (rp_total_pay * 1).toFixed(2);  /////จำนวนเงินที่คงค้างชำระ	


SendTorp_note = document.form_<?=$num_gen?>.SendTorp_note.value;
rp_note = document.form_2<?=$num_gen?>.rp_note.value=SendTorp_note; 
} 

 
	function ck_enable<?=$num_gen?>(){
		var ck_dis = document.getElementById('pNUM<?=$num_gen?>');
		if(ck_dis.checked == true){
            rp_total_price = document.form_2<?=$num_gen?>.rp_total_price.value; ///( ชำระหมด/ไม่มีค้าง ) รวมค่าชำระสุทธิ
            rp_total_pay = document.form_2<?=$num_gen?>.rp_total_pay.value =rp_total_price;  ////รวมค่าชำระสุทธิ
	
		}else{
            rp_total_pay = document.form_2<?=$num_gen?>.rp_total_pay.value = 0;
		}
	}
</script> 


          <!-- Modal pay -->
          <div class="modal fade" id="modal-pay-<?=$num_gen?>">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ชำระเงิน เลขที่ใบสมัคร <?=$rowGen->rm_number?></h4>
              </div>
             
              <input type="hidden" name="rp_vat_unit" id="rp_vat_unit" value="<?=$dataRow_1['vat_percent']?>" />
             
              <div class="modal-body">           
              <div class="row">

    <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">รายการ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            

 <div id="load_list<?=$num_gen?>">    
  </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            <form  method="post" name="form_<?=$num_gen?>" id="form_<?=$num_gen?>"  autocomplete="off" target="iframe_target<?=$num_gen?>" action="user_page_6_Payment_manage_table_list_load.php">
            <iframe id="iframe_target<?=$num_gen?>" name="iframe_target<?=$num_gen?>"  style="width:0;height:0;border:0px solid #fff;"></iframe>
            <input type="hidden" name="register_code" id="register_code" value="<?=$rowGen->register_code?>" />
            <input type="hidden" name="pay_code" id="pay_code" value="<?=$pay_code?>" />
            <input type="hidden" name="school_id" id="school_id" value="<?=$school_id?>" />
            <div class="row">
                <div class="col-xs-4">
                  <input type="text" class="form-control" style="width: 100%;" name="rpl_list_name" id="rpl_list_name"  value="<?=$rowGen->course_data_name?>" >
                </div>
                <div class="col-xs-2">
                  <input type="text" class="form-control" style="width: 100%;" name="rpl_unit" id="rpl_unit" value="1"  onFocus="chkSUM<?=$num_gen?>();"  onkeyup="chkSUM<?=$num_gen?>();" > 
                </div>
                <div class="col-xs-2">
                  <input type="text" class="form-control" style="width: 100%;" name="rpl_price_price" id="rpl_price_price" value="<?=$rowGen->cp_price?>"  onFocus="chkSUM<?=$num_gen?>();"  onkeyup="chkSUM<?=$num_gen?>();"  >
                </div>
                <div class="col-xs-2">
                  <input type="text" class="form-control" style="width: 100%;" name="rpl_price" id="rpl_price"  onFocus="chkSUM<?=$num_gen?>();"  onkeyup="chkSUM<?=$num_gen?>();"  value="<?=$rowGen->cp_price?>" > 
                </div>
                <div class="col-xs-2">
                <button type="submit"  class="btn btn-success" name="btn-submit-pay"><i class="glyphicon glyphicon-pushpin" onclick="myFunctionX<?=$num_gen?>();" onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();"></i></button>
             
                </div>

              </div> 
             
              <hr>
              <label>หมายเหตุ</label>
                  <textarea class="form-control"  rows="3" style="width: 100%;" placeholder="" name="SendTorp_note" id="SendTorp_note"  onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();"></textarea>
                  </form>
            </div>
          </div>
          <!-- /.box -->
    
        </div>
        <!-- /.col -->

  <form  method="post" name="form_2<?=$num_gen?>" id="form_2<?=$num_gen?>"  autocomplete="off"  >
  <input type="hidden" name="register_code2" id="register_code2" value="<?=$rowGen->register_code?>" />
    <input type="hidden" name="pay_code2" id="pay_code2" value="<?=$pay_code?>" />
<div class="col-md-4">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">สุทธิ </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

           
             <div id="load_list_price<?=$num_gen?>">
         
             </div>
          
             <input class="form-control" type="hidden"   id="rp_note" name="rp_note" onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();" >
  <label>ส่วนลดของค่าลงทะเบียน(%)</label>
            <input class="form-control" type="text" style="width: 100%;" value="0" id="rp_discount" name="rp_discount"  onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" onchang="plus()"   onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();plus();" OnKeyPress="return chkNumber(this)" >

  <label>เป็นจำนวนเงิน</label>
            <input class="form-control" type="text" style="width: 100%;" id="rp_discount_price" name="rp_discount_price" onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();" >

<div class="checkbox">
<label>
<input type="checkbox"  name="success_pay" id="pNUM<?=$num_gen?>"  value="1"  onClick="ck_enable<?=$num_gen?>();startCalc<?=$num_gen?>();"  onFocus="startCalc<?=$num_gen?>();"  >
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
<b>( ชำระหมด/ไม่มีค้าง )
รวมค่าชำระสุทธิ</b>
</label>
<input class="form-control" type="text" style="width: 100%;"  id="rp_total_price" name="rp_total_price" onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();" > 
</div>
           

      <label>จำนวนเงินที่ชำระ</label>
            <input class="form-control" type="text" style="width: 100%;"  id="rp_total_pay" name="rp_total_pay" onDrag="return false;" onDrop="return false;" onPaste="return false;" onMouseDown="noRightClick(event);" onKeyDown="return noPaste(event);" onchang="plus()"   onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();plus();" OnKeyPress="return chkNumber(this)" required>        

      <label>จำนวนเงินที่คงค้างชำระ</label>
            <input class="form-control" type="text" style="width: 100%;" id="rp_in_debt" name="rp_in_debt"  onFocus="startCalc<?=$num_gen?>();"  onkeyup="startCalc<?=$num_gen?>();" required>  

            </div>
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix">
        

            </div> -->
          </div>
          <!-- /.box -->
    
        </div>
        <!-- /.col -->



 </div> <!-- row -->



                  </div>



              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">ปิดหน้าต่างนี้</button>
                <button type="submit" OnClick="move2<?=$num_gen?>();" onchange="" onFocus="startCalc<?=$num_gen?>();"   class="btn btn-success" name="btn-submit-pay">บันทึกข้อมูล</button>
              </div>
              </form>

            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        </div>
        <!-- /.modal -->  

  <!-- <script>
                        function move2<?=$num_gen?>() {
                       
                          swal({
                            title: "ยืนยันการบันทึกข้อมูล",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "ใช่!",
                            cancelButtonText: "ไม่ใช่!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                          },
                          function(isConfirm){
                            if (isConfirm) {
                            //   swal("บันทึกข้อมูลแล้ว!", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "success");
                              document.getElementById("form_<?=$num_gen?>").submit();
                            } else {
                              swal("ยกเลิกการทำรายการ", "ปิดหน้าต่างนี้เพื่อทำรายการใหม่", "error");
                            }
                          });
                        }
               </script> -->