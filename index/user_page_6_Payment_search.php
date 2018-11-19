

<?php
//get the q parameter from URL


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
 require_once ("../library/general_funtion.php");
 require_once ("../config/dbl_config.php");
 require_once ('../class/class_query.php');
 $sql_process = new function_query();
    
 $q = urldecode($_GET["q"]);
 $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL; 
 $stmt_1 = $sql_process->runQuery("SELECT vat_status,vat_percent FROM tbl_school WHERE school_id=:school_id_param");
$stmt_1->execute(array(":school_id_param"=>$school_id));
$dataRow_1=$stmt_1->fetch(PDO::FETCH_ASSOC);
 ?>
<script src="../plugins/jquery_add_tr/jquery-1.9.1.js"></script>
 <table id="example6" class="table table-bordered table-striped">
    <thead>
      <tr>
      <th>ลำดับ</th>
      <th>ชื่อ-นามสกุล/บัตร ปชช.</th>
        <th>เลขที่ใบสมัคร</th>
        <th>หลักสูตร</th>
        <th>พิมพ์แบบบันทึกผล</th>
        <th>พิมพ์ใบสมัคร</th>
        <th>วันที่ลงทะเบียน</th>
        <th>สถานะลงทะเบียน/สอบ</th>
        <th>ค้างชำระ/ใบเสร็จ</th>
        <th>ชำระเงิน</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_register_main.rm_id,
tbl_register_main.rm_number,
tbl_register_main.student_id,
tbl_register_main.course_data_id,
tbl_register_main.rm_date,
tbl_register_main.rm_pay_status,
tbl_register_main.rm_source,
tbl_register_main.rm_status,
tbl_register_main.testing_result,
tbl_register_main.complete_date,
tbl_register_main.register_code,
tbl_course_data.course_data_name,
tbl_student_data.student_firstname_th,
tbl_student_data.student_lastname_th,
tbl_student_data.student_ID_card,
tbl_course_price.cp_price
FROM
tbl_register_main ,
tbl_student_data ,
tbl_course_data ,
tbl_course_price
WHERE
(tbl_register_main.school_id =:school_id_param AND tbl_register_main.course_data_id = tbl_course_data.course_data_id AND tbl_course_price.course_code = tbl_course_data.course_code AND tbl_register_main.student_id = tbl_student_data.student_id AND LOCATE('$q', tbl_student_data.student_firstname_th) > 0) OR
(tbl_register_main.school_id =:school_id_param AND tbl_register_main.course_data_id = tbl_course_data.course_data_id AND tbl_course_price.course_code = tbl_course_data.course_code AND tbl_register_main.student_id = tbl_student_data.student_id AND LOCATE('$q', tbl_student_data.student_lastname_th) > 0) OR
(tbl_register_main.school_id =:school_id_param AND tbl_register_main.course_data_id = tbl_course_data.course_data_id AND tbl_course_price.course_code = tbl_course_data.course_code AND tbl_register_main.student_id = tbl_student_data.student_id AND LOCATE('$q', tbl_student_data.student_ID_card) > 0)
ORDER BY
tbl_register_main.rm_id DESC
");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>

      <tr>
       <td align="center"><?=$num_gen?></td>
       <td><?=$rowGen->student_firstname_th?> <?=$rowGen->student_lastname_th?><br><?=$rowGen->student_ID_card?></td>
        <td><?=$rowGen->rm_number?></td>
        <td ><?=$rowGen->course_data_name?> </td>  
        <td align="center">
<button type="button" class="btn btn-default" title="พิมพ์แบบบันทึกผล" data-toggle="tooltip"> <img id="myImg"  src="../images/images_system/Iconshow-Hardware-Printer.ico"  width="30" height="30" ></button>      
        </td>
        <td align="center">
<button type="button" class="btn btn-default" title="พิมพ์ใบสมัคร" data-toggle="tooltip"> <img id="myImg"  src="../images/images_system/Iconshow-Hardware-Printer.ico"  width="30" height="30" ></button>        
        </td>
        <td align="center"><?php echo DateThai($rowGen->rm_date)?> </td>
        <td align="center">
        <?php
        // สถานะการชำระเงิน RS = Reservations (ลูกค้าจองตารางเรียน แต่ยังไม่ชำระเงิน) PP = Partial pay (ชำระเงินบางส่วนแต่ยังไม่ครบ) PA = Pay All (ชำระเงินครบทั้งหมดแล้ว)	
            if($rowGen->rm_pay_status=="RS"){
              echo '<small class="label label-info"  data-toggle="tooltip" title="ลงทะเบียนใหม่"><i class="fa fa-money"></i> ลงทะเบียนใหม่</small>';
            }elseif ($rowGen->rm_pay_status=="PP") {
            echo '<small class="label label-warning" data-toggle="tooltip" title="ค้างชำระ"><i class="fa fa-money"></i>  ค้างชำระ</small>';
            }elseif ($rowGen->rm_pay_status=="PA") {

              echo '<small class="label label-success" data-toggle="tooltip" title="ชำระเงินครบแล้ว"><i class="fa fa-money"></i>  ชำระเงินครบแล้ว</small>';
            }
             ?>
        
        </td>
        <td align="center">
        
        <div  align="center">
        <button type="button" class="btn btn-default" title="ใบเสร็จ" data-toggle="modal" data-target="#modal-bill-<?=$num_gen?>"> <img id="myImg"  src="../images/images_system/invoice-software-250x250.png"  width="30" height="30" ></button>               
        </div>

        <!-- <div class="btn-group-vertical">
                      <button type="button" class="btn btn-danger"><?php echo number_format($dataR['rp_total_pay'],2); ?></button>
                      <button type="button" class="btn btn-warning"  title="ใบเสร็จ" data-toggle="modal" data-target="#modal-bill-<?=$num_gen?>">ใบเสร็จ</button>
        </div> -->
        <?php include ("user_page_6_Payment_bill.php"); ?>
        </td>
        <td >
        <div  align="center">
        <button type="button" class="btn btn-default" title="ชำระเงิน" data-toggle="modal" data-target="#modal-edit-<?=$num_gen?>"> <img id="myImg"  src="../images/images_system/payment-512.png"  width="30" height="30" ></button>               
        </div>
        <?php include ("user_page_6_Payment_manage_table.php"); ?>


        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th>
      <th>ชื่อ-นามสกุล/บัตร ปชช.</th>
        <th>เลขที่ใบสมัคร</th>
        <th>หลักสูตร</th>
        <th>พิมพ์แบบบันทึกผล</th>
        <th>พิมพ์ใบสมัคร</th>
        <th>วันที่ลงทะเบียน</th>
        <th>สถานะลงทะเบียน/สอบ</th>
        <th>ค้างชำระ/ใบเสร็จ</th>
        <th>ชำระเงิน</th>
      </tr>
      </tfoot>
    </table>