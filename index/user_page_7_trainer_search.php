
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
 $school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL;
 $q = urldecode($_GET["q"]);

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
        <th>เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </thead>
      <tbody>
<?php
  $num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_trainer_data.trainer_id,
tbl_trainer_data.trainer_img,
tbl_trainer_data.trainer_finger_print,
tbl_trainer_data.title_name_th,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_trainer_data.school_id,
tbl_trainer_data.trainer_status,

tbl_trainer_data.trainer_card,
tbl_trainer_data.trainer_phone
FROM
tbl_trainer_data 
WHERE
(tbl_trainer_data.school_id = :school_id_param AND tbl_trainer_data.is_delete = '1' AND LOCATE('$q', tbl_trainer_data.trainer_firstname_th) > 0) OR
(tbl_trainer_data.school_id = :school_id_param AND tbl_trainer_data.is_delete = '1' AND LOCATE('$q', tbl_trainer_data.trainer_lastname_th) > 0) OR
(tbl_trainer_data.school_id = :school_id_param AND tbl_trainer_data.is_delete = '1' AND LOCATE('$q', tbl_trainer_data.trainer_card) > 0)
ORDER BY
tbl_trainer_data.trainer_id DESC limit 0,120
");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?>
      <tr>
      <td align="center">
<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="DELtrainer_id[]" id="pNUM"  value="<?=$rowGen->trainer_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label> 
<!-- <?php echo  sprintf("%02d", $num_gen); ?>.) -->
</div>
</td>
        <td><?=$rowGen->trainer_card?></td>
        <td><?=$rowGen->title_name_th?><?=$rowGen->trainer_firstname_th?> <?=$rowGen->trainer_lastname_th?></td>
        <td><?=$rowGen->trainer_phone?></td>
        <td align="center">
        <?php
            if($rowGen->trainer_status=='1'){
              echo '<small class="label label-success"  data-toggle="tooltip" title="เปิด"><i class="fa fa-clock-o"></i> เปิด</small>';
            }elseif ($rowGen->trainer_status=='0') {
            echo '<small class="label label-danger" data-toggle="tooltip" title="ปิด"><i class="fa fa-clock-o"></i> ปิด</small>';
            }
             ?>
        </td>
        <td>
        <div  align="center">
        <div class="btn-group-vertical" >
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->trainer_img)){ echo "disabled";}?>>
        รูปประจำตัว
        </button>
        <button type="button" class="btn btn-warning"onclick="window.location.href='?option=trainer-detail&etnr=<?=$rowGen->trainer_id?>'" data-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
        รายละเอียด
        <!-- <img id="myImg"  src="../images/images_system/info.png"   width="30" height="30" > -->
        </button>
        <button type="button" class="btn btn-warning"  onclick="window.location.href='?option=trainer-data-edit&etnr=<?=$rowGen->trainer_id?>'" >
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
                <h4 class="modal-title">รูปประจำตัว :: <?=$rowGen->trainer_firstname_th?> <?=$rowGen->trainer_lastname_th?></h4>
              </div>
              <div class="modal-body">
           
             
          <span class="thumbnail">
          <img src="../images/images_trainer/<?=$rowGen->trainer_img?>" alt="<?=$rowGen->trainer_img?>">
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
        <th>เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
      </tfoot>
    </table>