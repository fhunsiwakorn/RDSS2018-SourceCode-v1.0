
<script language=Javascript>
function Inint_AJAX() {
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   alert("XMLHttpRequest not supported");
   return null;
};

function dochange(src, val) {
     var req = Inint_AJAX();
     req.onreadystatechange = function () {
          if (req.readyState==4) {
               if (req.status==200) {
                    document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
               }
          }
     };
     req.open("GET", "user_page_9_report_register_listSearch.php?school_id=<?=$school_id?>&data="+src+"&val="+val); //สร้าง connection
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
     req.send(null); //ส่งค่า
}

window.onLoad=dochange('vehicle_type_id2', -1);

</script>


<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  รายงาน
    <small>รายงานการสมัครเรียน</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="?option=main"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
  <!-- <li ><a href="?option=career">ชำระเงิน</a></li> -->
  <li class="active">รายงานการสมัครเรียน</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">


<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ค้นหาการสมัครเรียน</h3>
      </div>
    
    <div class="box-body">
    <form  name="searchform" id="searchform">
    <div class="row">
                <div class="col-xs-3">
                 <label>วันที่เริ่มต้น</label>     
                  <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="col-xs-3">
                <label>วันที่สิ้นสุด</label>     
                  <input type="date" class="form-control" id="start_end" name="start_end" required>
                </div>
                <div class="col-xs-3">
                <label>ประเภทหลักสูตร</label>  
                <span id="vehicle_type_id2">
                <select class="form-control" name="vehicle_type_id"  >
                   <option value="">-- เลือกประเภทหลักสูตร --</option>  
                    </select>
                    </span>   
                </div>

                <div class="col-xs-3">
                <label> หลักสูตร</label>     
                <span id="course_data_id2">
                <select class="form-control" name="course_data_id"  >
                   <option value="">-- เลือกหลักสูตร --</option>  
                    </select>
                    </span>   
                </div>

                 <div class="col-xs-12">
                <label> <br> </label>     
                <button type="button" class="btn btn-success btn-block btn-flat" id="btnSearch">ค้นหา</button>
                </div>

              </div>
              </form>

</div>
   
    <!-- /.box-body -->
    <div class="box-footer">
      ...
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->


  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">ตารางรายงานการสมัครเรียน</h3>
      </div>
  

   

    <div class="box-body">


  <div id="list-data">
  <center>?</center>
  
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


<script type="text/javascript">
            $(function () {
                $("#btnSearch").click(function () {
                    $.ajax({
                        url: "user_page_9_report_register_searchChk.php?school_id=<?=$school_id?>",
                        type: "post",
                        data: {
                        start_date: $("#start_date").val(),
                        start_end: $("#start_end").val(),
                        vehicle_type_id: $("#vehicle_type_id").val(),
                        course_data_id: $("#course_data_id").val()
                        },
                        beforeSend: function () {
                            $(".loading").show();
                        },
                        complete: function () {
                            $(".loading").hide();
                        },
                        success: function (data) {
                            $("#list-data").html(data);
                        }
                    });
                });
                $("#searchform").on("keyup keypress",function(e){
                   var code = e.keycode || e.which;
                   if(code==13){
                       $("#btnSearch").click();
                       return false;
                   }
                });
            });
        </script>