<?php
require_once ("user_page_6_Payment_logChk.php");
  if(isset($_GET['success'])){
    echo "<script>";
    echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
    echo "</script>";
}
if(isset($_GET['error'])){
  echo "<script>";
  echo 'swal("Error !", "ระบุข้อมูลไม่ถูกต้อง !", "error")';
  echo "</script>";
}

$stmt_1 = $sql_process->runQuery("SELECT vat_status,vat_percent FROM tbl_school WHERE school_id=:school_id_param");
$stmt_1->execute(array(":school_id_param"=>$school_id));
$dataRow_1=$stmt_1->fetch(PDO::FETCH_ASSOC);
?>


<script src="../plugins/jquery_add_tr/jquery-1.9.1.js"></script>

<script>
function myFunction() {
    document.getElementById("form_del").submit();
}
</script>

<script>
function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #0000";
    }
  }
  xmlhttp.open("GET","user_page_6_Payment_search.php?school_id=<?=$school_id?>&q="+str,true);
  xmlhttp.send();
}

</script>
<script type="text/javascript">
//<![CDATA[
	function redirect(url) {
		// window.location.href = url;
    window.open(url,'','width=750,height=700'); return false;
	}
//]]>

</script>  


<script language="javascript">
function CheckNum(){
		if (event.keyCode < 48 || event.keyCode > 57){
		      event.returnValue = false;
	    	}
	}
</script>
<script language="JavaScript">
						function chkNumber(ele)
						{
						var vchar = String.fromCharCode(event.keyCode);
						if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
						ele.onKeyPress=vchar;
						}
						</script>
<!-- ป้องกัน Copy Paste -->
 <script type="text/javascript">
function noPaste(event)
{
    var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();
    if (event.ctrlKey && pressedKey == 'v')
    {
        // alert('กรุณากรอกเฉพาะตัวเลข');
        swal("กรุณากรอกเฉพาะตัวเลข !", "ปิดหน้าต่างนี้!", "error");
        return false;
    }
}
 
function noRightClick(event)
{
    if (event.button==2)
    {
        // alert("ไม่อนุญาต!");
        swal("ไม่อนุญาต !", "ปิดหน้าต่างนี้!", "error");
    }
}
</script> 



<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  ชำระเงิน
    <small>ข้อมูลตารางใบสมัครพร้อมสถานะการชำระเงิน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <!-- <li ><a href="?option=career">ชำระเงิน</a></li> -->
  <li class="active">ชำระเงิน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ชำระเงิน</h3>
      <div class="box-tools pull-right">
      <div class="btn-group">
      <!-- <button type="button" class="btn btn-success" title="เพิ่มข้อมูล" data-toggle="modal" data-target="#modal-default"> ค้นหาแบบมีเงื่อนไข</button> -->
      
      </div>
      </div>

      </div>
  

   

    <div class="box-body">
   <!-- search form -->
   <div class="col-xs-4">
      <div class="sidebar-form">
      <input type="hidden" name="option"  value="<?=$_GET["option"]?>">
        <div class="input-group">
          <input type="text" name="q" id="q" class="form-control" placeholder="ค้นหานักเรียน..."  autocomplete="off" onkeyup="showResult(this.value);">
          <span class="input-group-btn">
          <button type="button" name="search" id="search-btn" class="btn btn-flat" onclick="window.location.href='?option=<?=$_GET["option"]?>'"><i class="glyphicon glyphicon-refresh"></i>
                </button>
              </span>
        </div>
      </div>  
</div>
<br>

  <div id="livesearch">
    <br>
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
        <th>ใบเสร็จ</th>
        <th>ชำระเงิน</th>
      </tr>
      </thead>
      <tbody>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$num_gen='0';
$total_data = $sql_process->rowsQuery("SELECT tbl_register_main.student_id FROM tbl_register_main,tbl_student_data WHERE tbl_register_main.school_id = '$school_id' AND tbl_register_main.student_id = tbl_student_data.student_id ");
$rows='20';
if($page<=0)$page=1;
$total_page=ceil($total_data/$rows);
if($page>=$total_page)$page=$total_page;
$start=($page-1)*$rows;

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
tbl_register_main.school_id =:school_id_param AND
tbl_register_main.course_data_id = tbl_course_data.course_data_id AND
tbl_course_price.course_code = tbl_course_data.course_code AND
tbl_register_main.student_id = tbl_student_data.student_id
GROUP BY
tbl_register_main.register_code
ORDER BY
tbl_register_main.rm_id DESC
limit $start,$rows
");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
 $dataR=$sql_process->QueryField1("SELECT  MAX(rp_id) as rp_id, rp_in_debt FROM tbl_register_pay   WHERE register_code='$rowGen->register_code' AND school_id='$school_id'");

?> 

      <tr>
       <td align="center"><?=$num_gen?></td>
       <td><?=$rowGen->student_firstname_th?> <?=$rowGen->student_lastname_th?><br><?=$rowGen->student_ID_card?></td>
        <td><?=$rowGen->rm_number?></td>
        <td ><?=$rowGen->course_data_name?> </td>  
        <td align="center">
<button type="button" class="btn btn-default" data-toggle="tooltip" title="พิมพ์แบบบันทึกผล" > <img id="myImg"  src="../images/images_system/Iconshow-Hardware-Printer.ico"  width="30" height="30" ></button>      
        </td>
        <td align="center">
<button type="button" class="btn btn-default" data-toggle="tooltip" onClick="window.open('../report/regis-export?rmc=<?=$rowGen->register_code?>','','width=750,height=700'); return false;"  title="พิมพ์ใบสมัคร"  > <img id="myImg"  src="../images/images_system/Iconshow-Hardware-Printer.ico"  width="30" height="30" ></button>        
        </td>
        <td align="center"><?php echo DateThai($rowGen->rm_date)?> </td> 
        <td align="center">
        <?php
        // สถานะการชำระเงิน RS = Reservations (ลูกค้าจองตารางเรียน แต่ยังไม่ชำระเงิน) PP = Partial pay (ชำระเงินบางส่วนแต่ยังไม่ครบ) PA = Pay All (ชำระเงินครบทั้งหมดแล้ว)	
            if($rowGen->rm_pay_status=="RS"){
              echo '<small class="label label-info"  data-toggle="tooltip" title="ลงทะเบียนใหม่"><i class="fa fa-money"></i> ลงทะเบียนใหม่</small>';
            }elseif ($rowGen->rm_pay_status=="PP") {
            echo '<small class="label label-warning" data-toggle="tooltip" title="ค้างชำระ"><i class="fa fa-money"></i>'."&nbsp;"."ค้างชำระ"."&nbsp;".number_format($dataR['rp_in_debt'],2)."&nbsp;"."บาท".'</small>';
            }elseif ($rowGen->rm_pay_status=="PA") {

              echo '<small class="label label-success" data-toggle="tooltip" title="ชำระเงินครบแล้ว"><i class="fa fa-money"></i>  ชำระเงินครบแล้ว</small>';
            }
             ?>
        </td>
        <td>
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
        <button type="button" class="btn btn-default" title="ชำระเงิน" data-toggle="modal" data-target="#modal-pay-<?=$num_gen?>" <?php if($rowGen->rm_pay_status=="PA"){ echo "disabled";} ?>> <img id="myImg"  src="../images/images_system/payment-512.png"  width="30" height="30" ></button>               
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
        <th>ใบเสร็จ</th>
        <th>ชำระเงิน</th>
      </tr>
      </tfoot>
    </table>
    </div>

  <form method="get" name="supage1">
                <nav aria-label="...">
                <input type="hidden" name="option"  value="<?=$_GET["option"]?>">
                <ul class="pager">
                  <li <?php  if($page==1){echo"class='disabled'";} ?>><a href="?option=<?=$_GET["option"]?>&page=<?=$page-1?>"><i class="glyphicon glyphicon-triangle-left"></i><i class="glyphicon glyphicon-triangle-left"></i></a></li>
                  <li><input type="number"  name="page" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$page?>" onchange="submit();" ></li>
                    <li><input type="text" name="totalPage" style="width:150px; height:40px;font-size:20px;text-align: center;" value="<?=$total_page?> : <?=$total_data?>" disabled ></li>
                  <li <?php  if($page==$total_page){echo"class='disabled'";}?>><a href="?option=<?=$_GET["option"]?>&page=<?=$page+1?>"><i class="glyphicon glyphicon-triangle-right"></i><i class="glyphicon glyphicon-triangle-right"></i></a></li>
                </ul>
                </nav>
              </form>  

</div>
   
    <!-- /.box-body -->
    <div class="box-footer">
      ...
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
</div>