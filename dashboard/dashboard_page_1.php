<?php
// ปี
$year_present = date("Y");
$send_year= isset($_POST['year_post']) ? $_POST['year_post'] : $year_present; 
?>


<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    รายงานข้อมูลเบื้องต้น
    <small>แสดงรายงานข้อมูลเบื้องต้น</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <li class="active">หน้าหลัก</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

 <!-- Info boxes -->
 <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-home"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนโรงเรียน</span>
              <span class="info-box-number"><?php echo $total_school=$qGeneral->rowsQuery("SELECT tbl_school.school_id FROM tbl_school WHERE tbl_school.school_id !='0'");?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนหลักสูตร</span>
              <span class="info-box-number"><?php echo $total_course=$qGeneral->rowsQuery("SELECT tbl_course_data.course_data_id FROM tbl_course_data WHERE tbl_course_data.is_delete ='1'  ");?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนครูฝึก</span>
              <span class="info-box-number"><?php echo $total_trainer=$qGeneral->rowsQuery("SELECT tbl_trainer_data.trainer_id FROM tbl_trainer_data WHERE tbl_trainer_data.is_delete ='1'  ");?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนนักเรียน</span>
              <span class="info-box-number"><?php echo $total_student=$qGeneral->rowsQuery("SELECT tbl_student_data.student_id FROM tbl_student_data WHERE tbl_student_data.is_delete ='1'  ");?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">รายงานเบื้องต้น</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
    <div class="row">

    <div class="col-xs-12">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/highcharts-more.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

            <div id="container"></div>
            <button id="plain" class="btn btn-warning">แนวตั้ง</button>
            <button id="inverted" class="btn btn-warning">แนวนอน</button>
            <button id="polar" class="btn btn-warning">วงกลม</button>
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

<?php
  $JanuaryRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '1' AND YEAR(crt_date) = '$send_year' ");
  $FebruaryRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '2' AND YEAR(crt_date) = '$send_year'  ");
  $MarchRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '3' AND YEAR(crt_date) = '$send_year' ");
  $AprilRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '4' AND YEAR(crt_date) = '$send_year'");
  $MayRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '5' AND YEAR(crt_date) = '$send_year'  ");
  $JuneRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '6' AND YEAR(crt_date) = '$send_year' ");
  $JulyRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '7' AND YEAR(crt_date) = '$send_year' ");
  $AugustRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '8' AND YEAR(crt_date) = '$send_year'  ");
  $SeptemberRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '9' AND YEAR(crt_date) = '$send_year'");
  $OctoberRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '10' AND YEAR(crt_date) = '$send_year' ");
  $NovemberRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '11' AND YEAR(crt_date) = '$send_year'");
  $DecemberRows = $qGeneral->rowsQuery("SELECT student_id from tbl_student_data WHERE is_delete='1' AND MONTH(crt_date) = '12' AND YEAR(crt_date) = '$send_year' ");
?>

<script>
var chart = Highcharts.chart('container', {

    title: {
        text: 'กราฟแสดงจำนวนการสมัครเรียนต่อเดือนในแต่ละช่วงปี <?=$send_year+543?>'
    },

    subtitle: {
        text: 'ปี <?=$send_year+543?>'
    },

    xAxis: {
        categories: [
          'มกราคม',
          'กุมภาพันธ์',
          'มีนาคม',
          'เมษายน',
          'พฤษภาคม',
          'มิถุนายน',
          'กรกฎาคม',
          'สิงหาคม',
          'กันยายน',
          'ตุลาคม',
          'พฤศจิกายน',
          'ธันวาคม']
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: [<?=$JanuaryRows?>,<?=$FebruaryRows?>, <?=$MarchRows?>, <?=$AprilRows?>, <?=$MayRows?>, <?=$JuneRows?>,<?=$JulyRows?>, <?=$AugustRows?>, <?=$SeptemberRows?>, <?=$OctoberRows?>, <?=$NovemberRows?>, <?=$DecemberRows?>],
        showInLegend: false
    }]

});


$('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
});

$('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
});

</script>
