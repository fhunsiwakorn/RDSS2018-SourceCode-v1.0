<?php

require_once("../config/dbl_config.php");
require_once("../library/general_funtion.php");

  require_once('../class/class_query.php');
  $sql_process = new function_query();
///แสดงรายการอ้างอิง
$month_tho=date("m");
$year_tho=date("Y");

$rst_temp_code = isset($_GET['rst_temp_code']) ? $_GET['rst_temp_code'] : NULL; 
$stmt = $sql_process->runQuery("SELECT
tbl_register_temp.rst_temp_code,
tbl_register_temp.rst_temp_date_calendar,
tbl_register_temp.vehicle_type_id,
tbl_register_temp.trainer_id,
tbl_register_temp.school_id,
tbl_course_data.course_data_id,
tbl_course_data.course_data_name,
tbl_trainer_data.trainer_firstname_th,
tbl_trainer_data.trainer_lastname_th,
tbl_master_vehicle_type.vehicle_type_allow,
tbl_course_group.course_group_name,
tbl_course_group.course_group_subject_auto
FROM
tbl_register_temp ,
tbl_course_data ,
tbl_trainer_data ,
tbl_master_vehicle_type ,
tbl_course_group
WHERE
tbl_course_group.course_group_id=tbl_course_data.course_group_id AND
tbl_register_temp.course_data_id = tbl_course_data.course_data_id AND
tbl_register_temp.trainer_id = tbl_trainer_data.trainer_id AND
tbl_register_temp.vehicle_type_id = tbl_master_vehicle_type.vehicle_type_id AND
tbl_register_temp.rst_temp_code=:rst_temp_code_param
");
$stmt->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$dataRow=$stmt->fetch(PDO::FETCH_ASSOC);
$school_id=$dataRow["school_id"];
$trainer_id=$dataRow["trainer_id"];
$course_group_subject_auto=$dataRow["course_group_subject_auto"];
///event temp
$sql = "SELECT
tbl_register_temp_class_schedule.rmcs_id,
tbl_register_temp_class_schedule.subject_data_id,
tbl_register_temp_class_schedule.rmcs_start_date,
tbl_register_temp_class_schedule.rmcs_date_end,
tbl_register_temp_class_schedule.rmcs_hour,
tbl_register_temp_class_schedule.crt_by,
tbl_register_temp_class_schedule.crt_date,
tbl_register_temp_class_schedule.upd_by,
tbl_register_temp_class_schedule.upd_date,
tbl_register_temp_class_schedule.num_code,
tbl_register_temp_class_schedule.rst_temp_code,
tbl_subject_data.subject_data_name
FROM
tbl_register_temp_class_schedule ,
tbl_subject_data
WHERE
tbl_register_temp_class_schedule.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_register_temp_class_schedule.rst_temp_code=:rst_temp_code_param

HAVING
YEAR(tbl_register_temp_class_schedule.rmcs_start_date) >= '$year_tho' AND YEAR(tbl_register_temp_class_schedule.rmcs_date_end) >= '$year_tho'
";
$req = $sql_process->runQuery($sql);
$req->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$events = $req->fetchAll(); 

////คำนวนหาชั่วโมงปฏิบัติของหลักสูตรตามรายวิชา
$stmtCal = $sql_process->runQuery("SELECT
SUM(tbl_subject_in_course.time_study) AS time_study
FROM
tbl_subject_in_course ,
tbl_subject_data
WHERE
tbl_subject_in_course.subject_data_id = tbl_subject_data.subject_data_id AND
tbl_subject_data.type_study_id = :type_study_id_param AND  
tbl_subject_in_course.course_data_id = :course_data_id_param 
ORDER BY
tbl_subject_data.subject_data_id ASC");
$stmtCal->execute(array(":type_study_id_param"=>2,":course_data_id_param"=>$dataRow["course_data_id"]));
$calRow=$stmtCal->fetch(PDO::FETCH_ASSOC);
$sumtotal=$calRow['time_study'];
// type_study_id_param"=>2 คือ วิชาเรียนปฏิบัต

///ตรวจสอบจำนวนช่วงโมงอ้างอิงจากโค้ด tmp
////คำนวนหาชั่วโมงจาก calendar tmp
$stmtCal2 = $sql_process->runQuery("SELECT
SUM(tbl_register_temp_class_schedule.rmcs_hour) AS rmcs_hour
FROM
tbl_register_temp_class_schedule
WHERE
tbl_register_temp_class_schedule.rst_temp_code = :rst_temp_code_param AND
tbl_register_temp_class_schedule.type_study_id='2'");
$stmtCal2->execute(array(":rst_temp_code_param"=>$rst_temp_code));
$calRow2=$stmtCal2->fetch(PDO::FETCH_ASSOC);
$sumtotal2=$calRow2['rmcs_hour'];
if($sumtotal2=='0' || $sumtotal2==NULL){
	$sumtotal2 =0;
}else{
	$sumtotal2 =$sumtotal2;
}


////ตารางเรียนจริงที่ถูกบันทึกไว้
$qg = $sql_process->runQuery(
"SELECT
tbl_register_main_class_schedule.rmcs_id,
tbl_register_main_class_schedule.rmcs_start_date,
tbl_register_main_class_schedule.rmcs_date_end,
tbl_register_main_class_schedule.rmcs_hour,
tbl_course_data.course_data_name
FROM
tbl_register_main_class_schedule ,
tbl_register_main ,
tbl_course_data
WHERE
tbl_register_main_class_schedule.register_code = tbl_register_main.register_code AND
tbl_register_main.course_data_id = tbl_course_data.course_data_id AND
tbl_register_main_class_schedule.type_study_id = '2' AND
tbl_register_main_class_schedule.vehicle_type_id =:vehicle_type_id_param AND
tbl_register_main_class_schedule.trainer_id =:trainer_id_param
HAVING
YEAR(tbl_register_main_class_schedule.rmcs_start_date) >= '$year_tho' AND YEAR(tbl_register_main_class_schedule.rmcs_date_end) >= '$year_tho'
ORDER BY
tbl_register_main_class_schedule.rmcs_id ASC ");
$qg->execute(array(":vehicle_type_id_param"=>$dataRow['vehicle_type_id'],":trainer_id_param"=>$trainer_id));
// $qg->execute();
$learnEvns = $qg->fetchAll(); 

///วันหยุดโรงเรียน
$qg1 = $sql_process->runQuery(
	"SELECT
	tbl_holiday.hd_id,
	tbl_holiday.hd_title,
	tbl_holiday.hd_start_date,
	tbl_holiday.hd_end_date
	FROM
	tbl_holiday
	WHERE
	tbl_holiday.school_id=:school_id_param AND
	tbl_holiday.is_delete='1'
	HAVING
	YEAR(tbl_holiday.hd_start_date) >= '$year_tho' AND YEAR(tbl_holiday.hd_start_date) >= '$year_tho'
	ORDER BY
	tbl_holiday.hd_id DESC");
	$qg1->execute(array(":school_id_param"=>$school_id));
	$hdevns = $qg1->fetchAll(); 

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$name_system?></title>

    <!-- Bootstrap Core CSS -->
    <link href="../plugins/FullCalendar_modify/FullCalendar/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='../plugins/FullCalendar_modify/FullCalendar/css/fullcalendar.css' rel='stylesheet' />

  <link rel="stylesheet" href="../plugins/checkboxes.css">
    <!-- Custom CSS -->
    <style>
    /* body { */
        /* padding-top: 70px; */
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    /* } */
	#calendar {
		max-width: 100%;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>
</head>

<body>



    <!-- Page Content -->
    <div class="container">

        <div class="row">
				<!-- <label style="color:red;">* คำชี้แจง : ควรเลือกช่วงเวลาให้อยู่ในวันเดียวกัน</label> -->
            <div class="col-lg-12 text-center">
						<label style="color:blue;font-size:22px;">จำนวนชั่วโมง  <?=$sumtotal2?> / <?=$sumtotal?></label> <?php  // var_dump($qg) ?>
                <div id="calendar" class="col-centered">
                </div>
            </div>
			
        </div>
        <!-- /.row -->
		
		<!-- Modal -->
		
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="user_page_1_regis_3_calendarChk.php">
			<input type="hidden" name="rst_temp_code" id="rst_temp_code" value="<?=$dataRow["rst_temp_code"]?>" />
			<input type="hidden" name="course_group_subject_auto" id="course_group_subject_auto" value="<?=$course_group_subject_auto?>" />
			<input type="hidden" name="trainer_id" id="trainer_id" value="<?=$dataRow["trainer_id"]?>" />
			<input type="hidden" name="crt_by" id="crt_by" value="<?=$_SESSION['userSession']?>" />
			<!--vehicle_type_allow อนุญาตให้เปิดสอนได้หลายคนในเวลาเดียวกัน 1=ได้ ,0=ไม่ได้ -->
			<input type="hidden" name="vehicle_type_allow" id="vehicle_type_allow" value="<?=$dataRow["vehicle_type_allow"]?>" />
			<input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="<?=$dataRow["vehicle_type_id"]?>" />
			<input type="hidden" name="sum_hour" id="sum_hour" value="<?=$sumtotal?>" />
			<input type="hidden" name="sum_hour2" id="sum_hour2" value="<?=$sumtotal2?>" />
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">จองวันและเวลาเรียน</h4>
			  </div>
			  <div class="modal-body"> 
			
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">หลักสูตร</label>
					<div class="col-sm-10">
					  <input type="text" name="title" readonly class="form-control" value="หลักสูตร <?=$dataRow["course_data_name"]?>">
					</div>
				  </div>
					<input type="hidden" name="color" id="color" value="#F39C12" />
				
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">เวลาเริ่มต้น</label>
					<div class="col-sm-10">
					  <input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				  </div>
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">เวลาสิ้นสุด</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" readonly>
					</div>
				  </div>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
				<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
			
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="user_page_1_regis_3_calendarDel.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">จองวันและเวลาเรียน</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">หลักสูตร</label>
					<div class="col-sm-10">
					<input type="text" name="title" id="title" readonly class="form-control" >
					</div>
				  </div>
					<input type="hidden" name="color" id="color" value="#FFD700" />
				  <div class="form-group">
				
				    <div class="form-group"> 

		<div class="checkbox">
<label style="font-size: 1em">
<input type="checkbox"  name="delete" id="pNUM"  value="<?=$rowGen->career_id?>">
<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
</label>
ลบข้อมูลนี้ !
</div>

					</div>
				  
				  <input type="hidden" name="id" class="form-control" id="id">
				
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่างนี้</button>
				<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

  
		 <script src="../plugins/FullCalendar_modify/FullCalendar/js/jquery.js"></script>
		 <script src="../plugins/FullCalendar_modify/FullCalendar/js/bootstrap.min.js"></script>
		 <script src='../plugins/FullCalendar_modify/FullCalendar_3.5.1/lib/moment.min.js'></script>
		 <script src='../plugins/FullCalendar_modify/FullCalendar_3.5.1/fullcalendar.min.js'></script>
		 <script src='../plugins/FullCalendar_modify/FullCalendar_3.5.1/locale/th.js'></script>
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				// right: 'month,agendaWeek,agendaDay,listMonth'
				right: 'agendaWeek,agendaDay'
			},
			 defaultView: 'agendaWeek',
			defaultDate: '<?=$dataRow["rst_temp_date_calendar"]?>',

navLinks: true, // can click day/week names to navigate views
// hiddenDays: [0,6],
minTime: '06:00:00', // display from 16 to
maxTime: '23:00:00', // 23 
 slotDuration: '01:00:00', // 15 minutes for each row
allDaySlot: true, // don't show "all day" at the top
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				// header("Location: index.php");
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			
				
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php		
			foreach($events as $event): 
			?>
				{
					id: '<?=$event['rmcs_id']?>.<?=$event['subject_data_id']?>',
					title: '(<?=$event["rmcs_hour"]?>) <?=$event["subject_data_name"]?>',
					start: '<?=$event['rmcs_start_date']?>',
					end: '<?=$event['rmcs_date_end']?>',
					color: '#F39C12',
				},
			<?php endforeach; ?>
		<?php
		 	foreach($learnEvns as $learnEvn): 
		?>
			{
					id: '<?=$learnEvn['rmcs_id']?>',  
					title: '(<?=$learnEvn['rmcs_hour']?>) <?=$learnEvn['course_data_name']?>',
					start: '<?=$learnEvn['rmcs_start_date']?>',  
					end: '<?=$learnEvn['rmcs_date_end']?>',    
					color: '#008000',
				},
		<?php endforeach; ?>

				<?php
		 	foreach($hdevns as $hdevn): 
		?>
			{
					id: '<?=$hdevn['hd_id']?>',  
					title: '<?=$hdevn['hd_title']?>',
					start: '<?=$hdevn['hd_start_date']?>',  
					end: '<?=$hdevn['hd_end_date']?>',    
					color: '#ED1C24',
				},
		<?php endforeach; ?>

			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'user_page_1_regis_3_calendarEdit.php?vehicle_type_allow=<?=$dataRow["vehicle_type_allow"]?>&trainer_id=<?=$dataRow["trainer_id"]?>&sum_hour=<?=$sumtotal?>&rst_temp_code=<?=$dataRow["rst_temp_code"]?>',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
				// alert('Saved');
				if(rep == 'OK'){
					alert('บันทึกข้อมูลแล้ว');
					window.location.reload();
				}else{
					alert('**Error : เลือกช่วงเวลาไม่ถูกต้อง !!'); 
					window.location.reload();
					// var strMessage = 'Username หรือ Password ไม่ถูกต้อง!';alert (strMessage);
				}
				}
			});
		}
		
	});

</script> 

</body>

</html>
