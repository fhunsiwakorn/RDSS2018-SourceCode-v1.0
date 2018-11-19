

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

 require_once ("../config/dbl_config.php");
 require_once ('../class/class_query.php');
 $sql_process = new function_query();
    
 $q = urldecode($_GET["q"]);
 $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL;
 ?>

  <table id="" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>
<div class="checkbox">
<label style="font-size: 1em">
<INPUT type="checkbox" onchange="checkAll_d1(this.form.pNUM)" name="chk_all_user" />
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
</div>
        </th>

        <th>รหัสประจำตัว </th>
        <th>ชื่อ - นามสกุล</th>
        <th>เบอรโทร</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen=0;
$qg = $sql_process->runQuery(
"SELECT
tbl_student_data.student_id,
tbl_student_data.student_img,
tbl_student_data.title_name_th,
tbl_student_data.student_firstname_th,
tbl_student_data.student_lastname_th,
tbl_student_data.student_phone,
tbl_student_data.school_id,
tbl_student_data.student_ID_card
FROM
tbl_student_data
WHERE
(tbl_student_data.school_id =:school_id_param AND tbl_student_data.is_delete = '1' AND LOCATE('$q', tbl_student_data.student_firstname_th) > 0) OR
(tbl_student_data.school_id =:school_id_param AND tbl_student_data.is_delete = '1' AND LOCATE('$q', tbl_student_data.student_lastname_th) > 0) OR
(tbl_student_data.school_id =:school_id_param AND tbl_student_data.is_delete = '1' AND LOCATE('$q', tbl_student_data.student_ID_card) > 0)
ORDER BY
tbl_student_data.student_id DESC limit 0,120

");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;


?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELstudent_id[]" id="pNUM"  value="<?=$rowGen->student_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->student_ID_card?> </td>
        <td><?=$rowGen->title_name_th?><?=$rowGen->student_firstname_th?> <?=$rowGen->student_lastname_th?></td>
        <td><?=$rowGen->student_phone?></td>

        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->student_img)){ echo "disabled";}?>>
        รูปประจำตัว
        </button>
        <button type="button" class="btn btn-warning"onclick="window.location.href='?option=student-detail&estu=<?=$rowGen->student_id?>'" data-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=student-data-edit&estu=<?=$rowGen->student_id?>'" >
        แก้ไข
        <!-- <img id="myImg"  src="../images/images_system/Edit.png"  width="30" height="30" > -->
        </button>
        </div>
        </div>
 
  <!-- Modal DETAIL -->
  <div class="modal fade" id="modal-detail-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รูปประจำตัว :: <?=$rowGen->student_firstname_th?> <?=$rowGen->student_lastname_th?></h4>
              </div>
              <div class="modal-body">
           
             
          <span class="thumbnail">
          <img src="../images/images_student/<?=$rowGen->student_img?>" alt="<?=$rowGen->trainer_img?>">
          </span>
         

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>              
              </div>
              
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->    
        </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>รหัสประจำตัว </th>
        <th>ชื่อ - นามสกุล</th>
        <th>เบอรโทร</th>
        <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>