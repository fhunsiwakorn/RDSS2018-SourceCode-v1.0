<?php
////ชำระเงิน
  if(isset($_POST['rp_total_list_price']) && !empty($_POST['rp_total_list_price']) && isset($_POST['rp_total_pay']) && !empty($_POST['rp_total_pay'])){
    
    // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php
    $rp_total_list_price = strip_tags($_POST['rp_total_list_price']);
    $rp_discount = strip_tags($_POST['rp_discount']);
    $rp_discount_price = strip_tags($_POST['rp_discount_price']);
    $rp_total_price = strip_tags($_POST['rp_total_price']);
    $rp_total_pay = strip_tags($_POST['rp_total_pay']);
    $rp_in_debt = strip_tags($_POST['rp_in_debt']);
    $rp_vat = strip_tags($_POST['rp_vat']);
    $rp_vat_price = strip_tags($_POST['rp_vat_price']);
    $rp_vat_unit = strip_tags($_POST['rp_vat_unit']);
    $rp_note = strip_tags($_POST['rp_note']);
    $crt_by=$_SESSION['userSession']; 
    $crt_date=date("Y-m-d H:i:s");
    $pay_code = strip_tags($_POST['pay_code2']);
    $register_code = strip_tags($_POST['register_code2']);
    ///
    // $rp_total_pay_2=number_format($rp_total_pay, 2, '.', '');
    // $rp_in_debt_2=number_format($rp_in_debt, 2, '.', '');

    $rp_booknumber=date("m/Y");
    $stmt2 = $sql_process->runQuery("SELECT MAX(tbl_register_pay.rp_number) as  rp_number FROM tbl_register_pay WHERE tbl_register_pay.rp_booknumber=:rp_booknumber_param AND tbl_register_pay.school_id=:school_id_param");
    $stmt2->execute(array(":rp_booknumber_param"=>$rp_booknumber,":school_id_param"=>$school_id));
    $total_data2=$stmt2->rowCount();
    $dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
    if($total_data2>=1){

            // ถ้าเป็นใบเสร็จเดิมที่ยังค้างชำระให้ใช้หมายเลขเดิม
            // $stmt3 = $sql_process->runQuery("SELECT   tbl_register_pay.rp_booknumber,tbl_register_pay.rp_number FROM tbl_register_pay WHERE tbl_register_pay.register_code=:register_code_param ORDER BY tbl_register_pay.rp_id DESC");
            // $stmt3->execute(array(":register_code_param"=>$register_code));
            // $dataRow3=$stmt3->fetch(PDO::FETCH_ASSOC);
            // $total_data3=$stmt3->rowCount();
            // if($total_data3>=1){
            //   $rp_booknumber=$dataRow3["rp_booknumber"];
            //   $rp_number=$dataRow3["rp_number"];
            // }else{
             
            //   $amd=$dataRow2["rp_number"]+1;
            //   $rp_number=sprintf("%04d", $amd);
            // }
            $amd=$dataRow2["rp_number"]+1;
            $rp_number=sprintf("%04d", $amd);
     
    }else{
      $rp_number="0001";
    }
    ///
    $table  = 'tbl_register_pay';
    $fields = [
        'rp_booknumber' => $rp_booknumber,
        'rp_number' => $rp_number,
        'rp_total_list_price' => $rp_total_list_price,
        'rp_discount' => $rp_discount,
        'rp_discount_price' => $rp_discount_price,
        'rp_total_price' => $rp_total_price,
        'rp_total_pay' => $rp_total_pay,
        'rp_in_debt' => $rp_in_debt,
        'rp_vat' => $rp_vat,
        'rp_vat_price' => $rp_vat_price,
        'rp_vat_unit' => $rp_vat_unit,
        'rp_note' => $rp_note,
        'crt_by' => $crt_by,
        'crt_date' => $crt_date,
        'pay_code' => $pay_code,
        'register_code' => $register_code,
        'school_id' => $school_id
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

    ////////
 
  // สถานะการชำระเงิน RS = Reservations (ลูกค้าจองตารางเรียน แต่ยังไม่ชำระเงิน) PP = Partial pay (ชำระเงินบางส่วนแต่ยังไม่ครบ) PA = Pay All (ชำระเงินครบทั้งหมดแล้ว)	
  if($rp_in_debt !=0 ) {
    $rm_pay_status_set="PP";
  }elseif($rp_in_debt ==0 ){
    $rm_pay_status_set="PA";
  }
  $sql_process->fastQuery("UPDATE tbl_register_main SET rm_pay_status='$rm_pay_status_set'   WHERE register_code='$register_code' AND school_id='$school_id'");
    echo "<script>";
    echo "location.href = '?option=AV7KO8G42H2PXDB&success'";
    echo "</script>";
// }else{
//   echo "<script>";
//   echo "location.href = '?option=AV7KO8G42H2PXDB&error'";
//   echo "</script>";
// }

  } 
  
  