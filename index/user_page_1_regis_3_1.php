
<?php
require_once("../config/dbl_config.php");
require_once('../class/class_query.php');
$sql_process = new function_query();
$school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL;
$rst_temp_code_get= isset($_GET['register_code']) ? $_GET['register_code'] : NULL;
$vegicle_data_id_get= isset($_GET['vegicle_data_id']) ? $_GET['vegicle_data_id'] : NULL;

?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>
#
        </th>
        <th>รูป</th>
        <th>ประเภทรถ</th>
        <th>ยี่ห้อรถ/ชื่อเรียก </th>
        <th>ทะเบียนรถ</th>
        <th>สี</th>
      </tr>
      </thead>
      <tbody>
<?php

  $num_gen='0';
  $sql="SELECT
  tbl_vegicle_data.vegicle_data_id,
  tbl_vegicle_data.vehicle_img,
  tbl_vegicle_data.license_plate,
  tbl_vegicle_data.vegicle_brand,
  tbl_vegicle_data.vegicle_color,
  tbl_vegicle_data.vegicle_status,
  tbl_master_vehicle_type.vehicle_type_name,
  tbl_location_province.province_name,
  tbl_school.school_name
  FROM
  tbl_vegicle_data ,
  tbl_master_vehicle_type ,
  tbl_location_province ,
  tbl_school
  WHERE
    tbl_vegicle_data.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
    tbl_vegicle_data.province_id = tbl_location_province.province_id AND
    tbl_vegicle_data.school_id = tbl_school.school_id AND
    tbl_vegicle_data.school_id = :school_id_param AND
    tbl_vegicle_data.is_delete = '1' AND
    tbl_vegicle_data.vegicle_status= '1' 
";


 ///แสดง sql


$qg = $sql_process->runQuery("$sql");
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {


$totalSql="SELECT tbl_register_main.vegicle_data_id FROM tbl_register_main_class_schedule,tbl_register_main WHERE 

";

    $num2=0;
    $q12 = $sql_process->runQuery(
      "SELECT
      tbl_register_temp_class_schedule.rmcs_start_date,
      tbl_register_temp_class_schedule.rmcs_date_end
      FROM
      tbl_register_temp_class_schedule
      WHERE
      tbl_register_temp_class_schedule.school_id=:school_id_param AND
      tbl_register_temp_class_schedule.rst_temp_code=:rst_temp_code_param
      ORDER BY
      tbl_register_temp_class_schedule.rmcs_id ASC
      
      ");
    
      $q12->execute(array(":rst_temp_code_param"=>$rst_temp_code_get,":school_id_param"=>$school_id));
      $total=$q12->rowCount();
      while($rowGen12= $q12->fetch(PDO::FETCH_OBJ)) {
        
        $num2++;
        // if($num2==1){
        //       $sql .= ' AND ' ; 
        // }
        // $sql .= 'tbl_register_main_class_schedule.rmcs_start_date'."<>'".$rowGen12->rmcs_start_date."' AND ".'tbl_register_main_class_schedule.rmcs_date_end'."<>'". $rowGen12->rmcs_date_end."'";
        $totalSql .= "
       ( tbl_register_main_class_schedule.school_id='$school_id'  AND tbl_register_main_class_schedule.register_code=tbl_register_main.register_code
        AND tbl_register_main.vegicle_data_id ='$rowGen->vegicle_data_id' AND
        tbl_register_main_class_schedule.rmcs_start_date  BETWEEN '$rowGen12->rmcs_start_date'  AND '$rowGen12->rmcs_date_end' AND tbl_register_main_class_schedule.rmcs_date_end    BETWEEN '$rowGen12->rmcs_start_date'  AND '$rowGen12->rmcs_date_end')";
        if($num2 < $total)
        {
          $totalSql .= ' OR ' ; 
        }
    
      }
      $total_data =$sql_process->rowsQuery("$totalSql");
    //   echo "<center>";
    //   var_dump($totalSql);
    //   echo "</center>";

$num_gen++;
if(!empty($rowGen->vehicle_img)){
  $path_img="../images/image_vehicle/".$rowGen->vehicle_img;
}else{
  $path_img="../images/images_system/"."default_image.png";
}
?>
      <tr>
      <td align="center">
      <?php if($total_data<=0){ ?>
      <div class="radio">
            <label style="font-size: 1.5em">
                <input type="radio" name="vegicle_data_id_post" id="vegicle_data_id_<?=$num_gen?>" value="<?=$rowGen->vegicle_data_id?>" <?php if($vegicle_data_id_get ==$rowGen->vegicle_data_id){ echo "checked";} ?>>
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
               
            </label>
        </div>
    <?php }else{ ?>  
 <label style="color:red;">ไม่ว่าง </lable>
    <?php } ?>
       
</td>
<td> 
<div align="center">
<a href="#"  data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" ><img src="<?=$path_img?>" style="height: 120px; width: 120px;"></a>
</div>  
<!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-detail-<?=$num_gen?>" <?php if(empty($rowGen->vehicle_img)){ echo "disabled";}?>>
รูปยานพาหนะ
        </button> -->
         <!-- Modal DETAIL -->
  <div class="modal fade" id="modal-detail-<?=$num_gen?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รูป <?=$rowGen->vegicle_brand?></h4>
              </div>
              <div class="modal-body">
           
             
          <span class="thumbnail">
          <img src="<?=$path_img?>"  alt="<?=$rowGen->vehicle_img?>" style="width: 100%;">
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
        <td><?=$rowGen->vehicle_type_name?></td>
        <td><?=$rowGen->vegicle_brand?></td>
        <td><?=$rowGen->license_plate?> <br> <?=$rowGen->province_name?></td>
        <td><?=$rowGen->vegicle_color?></td> 
        
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>#</th>
      <th>รูป</th>
        <th>ประเภทรถ</th>
        <th>ยี่ห้อรถ/ชื่อเรียก </th>
        <th>ทะเบียนรถ</th>
        <th>สี</th>
   
      </tr>
      </tfoot>
    </table>