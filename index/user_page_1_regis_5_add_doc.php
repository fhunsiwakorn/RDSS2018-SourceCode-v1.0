
<?php
$rst_temp_code_get = isset($_GET['sccode']) ? $_GET['sccode'] :$rst_temp_code_max;
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.rst_temp_code
FROM
tbl_register_temp 
WHERE
tbl_register_temp.rst_temp_code=:rst_temp_code_param AND
tbl_register_temp.school_id=:school_id_param AND
tbl_register_temp.ip_pc=:ip_pc_param");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id,":ip_pc_param"=>$ipaddress));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$rst_temp_code=$dataRow["rst_temp_code"]; //โค้ดอ้างอิงการรับสมัคร
$rst_temp_date_calendar=$dataRow["rst_temp_date_calendar"];

if(isset($_POST['doc_id'])) {
  $table="tbl_register_temp_doc";
  $count=count($_POST['doc_id']);
     // $school_id ประกาศตัวแปรไว้ที่ ../login/select_data_profile.php 
  $page_step='6';
  $rst_temp_code = strip_tags($_POST['rst_temp_code']);
  $sql_process->fastQuery("UPDATE tbl_register_temp SET page_step='$page_step'   WHERE rst_temp_code='$rst_temp_code'");

  $total_data =$sql_process->rowsQuery("SELECT tbl_register_temp_doc.rtd_id FROM tbl_register_temp_doc WHERE tbl_register_temp_doc.rst_temp_code ='$rst_temp_code'");
  for($i=0;$i<$count;$i++){
    
  $rtd_id = $_POST['rtd_id'][$i];
   $doc_id = $_POST['doc_id'][$i];
   $doc_detail = $_POST['doc_detail'][$i];
   $doc_sent = $_POST['doc_sent'][$i];
 
   if($total_data <=0){
    $fields = [
      'doc_id' => $doc_id,
      'doc_detail' => $doc_detail,
      'doc_sent' => $doc_sent,
      'school_id' => $school_id,
      'rst_temp_code' => $rst_temp_code
  ];
  try {
  
      /*
       * Have used the word 'object' as I could not see the actual 
       * class name.
       */
      $sql_process->insert($table, $fields);
    
    }catch(ErrorException $exception) {
    
       $exception->getMessage();  // Should be handled with a proper error message.
    
    }

   }else{

    $fields = [
      'doc_id' => $doc_id,
      'doc_detail' => $doc_detail,
      'doc_sent' => $doc_sent
  ];
  $Where=['rtd_id' => $rtd_id];
  try {
  
    /*
     * Have used the word 'object' as I could not see the actual 
     * class name.
     */
    $sql_process->update($table, $fields,$Where);
  
  }catch(ErrorException $exception) {
  
     $exception->getMessage();  // Should be handled with a proper error message.
  
  }

   }

    }
echo "<script>";
echo "location.href = '?option=main'";
echo "</script>";
  //  echo "<script>";
  //  echo "location.href = '?option=regis-step-6&sccode=$rst_temp_code'";
  //  echo "</script>";
  }
// if(isset($_GET['success'])){
//     echo "<script>";
//     echo 'swal("ทำรายการสำเร็จ !", "ปิดหน้าต่างนี้ !", "success")';
//     echo "</script>";
// }


      

?>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    สมัครเรียน
    <!-- <small>แสดงรายงานข้อมูลเบื้องต้น</small> -->
  </h1>
  <ol class="breadcrumb">
  <?php require ("user_page_1_step.php"); ?>
  </ol>
</section>

<!-- Main content -->
<section class="content">

 
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">สมัครเรียน ขั้นตอนที่ 5 : ตรวจสอบเอกสาร</h3>
  
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">   
 
    <div class="col-xs-12">

    <form method="post" id="form_add_doc"  name="form_add_doc" >
    <input type="hidden" name="rst_temp_code" value="<?=$dataRow['rst_temp_code']?>"/>
    <table id="example5" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ลำดับ</th>

        <th>รายการเอกสาร</th>
        <th>รายละเอียดเอกสาร</th>
        <th>จำนวน</th>
        <th>จำนวนเอกสารค้างส่ง</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_document_regis.doc_id,
tbl_document_regis.doc_name,
tbl_document_regis.doc_number_default,
tbl_document_regis.doc_unit
FROM
tbl_document_regis
WHERE
tbl_document_regis.doc_status='1' AND
tbl_document_regis.is_delete='1' AND
tbl_document_regis.school_id =:school_id_param
ORDER BY
tbl_document_regis.doc_id ASC");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;

//
$stmt2 = $sql_process->runQuery("SELECT rtd_id,doc_detail,doc_sent FROM tbl_register_temp_doc WHERE doc_id=:doc_id_patam AND rst_temp_code=:rst_temp_code_param");
$stmt2->execute(array(":doc_id_patam"=>$rowGen->doc_id,":rst_temp_code_param"=>$dataRow['rst_temp_code']));
$dataRow2=$stmt2->fetch(PDO::FETCH_ASSOC);
$doc_detail = !empty($dataRow2['doc_detail']) ? $dataRow2['doc_detail'] : NULL; 
$doc_sent = !empty($dataRow2['doc_sent']) ? $dataRow2['doc_sent'] : NULL; 
$rtd_id = !empty($dataRow2['rtd_id']) ? $dataRow2['rtd_id'] : NULL; 
?>
      <tr>
 <td align="center">
<?=$num_gen?>
<input type="hidden" class="form-control" name="rtd_id[]" id="rtd_id[]" value="<?=$rtd_id?>" >
<input type="hidden" class="form-control" name="doc_id[]" id="doc_id[]" value="<?=$rowGen->doc_id?>" >
</td>
        <td><?=$rowGen->doc_name?>
      </td>
        <td><input type="text" class="form-control" name="doc_detail[]" id="doc_detail[]" value="<?=$doc_detail?>" ></td>
        <td align="center" ><?=$rowGen->doc_number_default?> <?=$rowGen->doc_unit?></td>
        <td align="center" >จำนวน <input type="number" style="width:75px;" class="form-control" name="doc_sent[]" id="doc_sent[]"  value="<?=$doc_sent?>"> <?=$rowGen->doc_unit?></td>
    
       
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th> 
      <th>รายการเอกสาร</th>
      <th>รายละเอียดเอกสาร</th>
      <th>จำนวน</th>
      <th>จำนวนเอกสารค้างส่ง</th>
      </tr>
      </tfoot>
    </table>

      <div class="col-xs-12">
<label ></label>     
<br>
<center><button type="submit"  name="btn-submit-edit" class="btn btn-primary">บันทึกข้อมูล</button></center>
</div>  
    </form>



</div>



</div>
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
