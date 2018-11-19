<!-- jQuery 3 -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../plugins/AdminLTE-2.4.0-rc/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../plugins/AdminLTE-2.4.0-rc/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../plugins/AdminLTE-2.4.0-rc/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- bootstrap datepicker -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- DataTables -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/AdminLTE-2.4.0-rc/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../plugins/AdminLTE-2.4.0-rc/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../plugins/AdminLTE-2.4.0-rc/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../plugins/AdminLTE-2.4.0-rc/dist/js/demo.js"></script>
<script  src="../plugins/AdminLTE-2.4.0-rc/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8">
</script>
<script>
$(function () {
    $('.select2').select2()
      //Datemask dd/mm/yyyy
  $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
   $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
   $('[data-mask]').inputmask()
   
    $('#example1').DataTable()
    $('#example2').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable()
    $('#example5').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#example6').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
   //Date picker
  
     $('#datepickerX').datepicker({
format : "dd/mm/yyyy",
  autoclose: false,
  language: 'th',
  multidate: true
})
    //Date picker
    $('#datepicker').datepicker({
      format : "dd/mm/yyyy",
      autoclose: true,
  language: 'th'
    })


       //Date picker
       $('#datepicker2').datepicker({
      format : "dd/mm/yyyy",
      autoclose: true,
  language: 'th'
    })

  })
</script>