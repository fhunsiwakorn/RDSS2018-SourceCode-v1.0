<?php
require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");
require_once('../class/class_query.php');
$sql_process = new function_query();

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : NULL;
$start_end = isset($_POST['start_end']) ? $_POST['start_end'] : NULL;
$vehicle_type_id = isset($_POST['vehicle_type_id']) ? $_POST['vehicle_type_id'] : NULL;
$course_data_id = isset($_POST['course_data_id']) ? $_POST['course_data_id'] : NULL;
$school_id = isset($_GET['school_id']) ? $_GET['school_id'] : NULL;

if($vehicle_type_id != NULL && $course_data_id == NULL ){
    $statement="AND tbl_course_data.vehicle_type_id='$vehicle_type_id'";
}elseif($course_data_id != NULL){
$statement="AND tbl_register_main.course_data_id='$course_data_id' AND tbl_course_data.vehicle_type_id='$vehicle_type_id'";
}elseif($course_data_id == NULL){
    $statement=NULL ;
}

// 
?>

 <table id="example6" class="table table-bordered table-striped">
    <thead>
      <tr>
      <th>ลำดับ</th>
      <th>วันเดือนปีที่สมัคร</th>
      <th>เลขที่บัตรประจำตัวประชาชน</th>
        <th>ชื่อผู้สมัครเรียน</th>
        <th>ที่อยู่</th>
      </tr>
      </thead>
      <tbody>
<?php
$num_gen='0';
$qg = $sql_process->runQuery(
"SELECT
tbl_register_main.rm_number,
tbl_register_main.rm_date,
tbl_register_main.student_id,
tbl_register_main.vegicle_data_id,
tbl_student_data.student_firstname_th,
tbl_student_data.student_lastname_th,
tbl_student_data.student_ID_card,
tbl_student_data.student_address,
tbl_location_province.province_name,
tbl_location_amphur.amphur_name,
tbl_location_district.district_name,
tbl_location_zipcode.zipcode
FROM
tbl_register_main ,
tbl_student_data ,
tbl_course_data  ,
tbl_location_province ,
tbl_location_amphur ,
tbl_location_district ,
tbl_location_zipcode 

WHERE
tbl_register_main.student_id = tbl_student_data.student_id AND
tbl_register_main.course_data_id = tbl_course_data.course_data_id AND
tbl_student_data.province_id = tbl_location_province.province_id AND
tbl_student_data.amphur_id = tbl_location_amphur.amphur_id AND
tbl_student_data.district_id = tbl_location_district.district_id AND
tbl_student_data.zipcode_id = tbl_location_zipcode.zipcode_id AND
tbl_register_main.school_id =:school_id_param AND
tbl_register_main.rm_date BETWEEN '$start_date' AND '$start_end' 
$statement
GROUP BY
tbl_register_main.register_code
ORDER BY
tbl_register_main.rm_id ASC

");
// $qg->execute();
$qg->execute(array(":school_id_param"=>$school_id));
while($rowGen= $qg->fetch(PDO::FETCH_OBJ)) {
$num_gen++;
?> 

      <tr>
       <td align="center"><?=$num_gen?></td>
       <td>
       <?php echo DateThai($rowGen->rm_date)?>
     </td>
      
        <td >
        <?=$rowGen->student_ID_card?>      
        </td>
       
        <td><?=$rowGen->student_firstname_th?> <?=$rowGen->student_lastname_th?> </td> 
      <td>
      <?php
     
    echo "&nbsp".$rowGen->student_address."&nbsp";
    echo "ตำบล"."&nbsp".$rowGen->district_name."&nbsp";
    echo "อำเภอ"."&nbsp".$rowGen->amphur_name."&nbsp";
    echo "จังหวัด"."&nbsp".$rowGen->province_name."&nbsp";
    echo "&nbsp".$rowGen->zipcode."&nbsp";
?>
      </td>
      </tr>
<?php } ?>
      </tbody>
      <tfoot>
      <tr>
      <th>ลำดับ</th>
      <th>วันเดือนปีที่สมัคร</th>
      <th>เลขที่บัตรประจำตัวประชาชน</th>
        <th>ชื่อผู้สมัครเรียน</th>
        <th>ที่อยู่</th>
      </tr>
      </tfoot>
    </table>