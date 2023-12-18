<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="#"></a></strong> All rights reserved.
</footer>

<aside class="control-sidebar control-sidebar-dark">

</aside>
</div>
    <script src="<?php echo base_url(); ?>static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>static/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="<?php echo base_url(); ?>static/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script>
  $(function() {
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(200);
    });

       //Bootstrap Duallistbox
       $('.duallistbox').bootstrapDualListbox()
       
  $('.dataTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $(".datepicker").datepicker({
      changeMonth:true, 
      changeYear: true,
      dateFormat: 'dd-mm-yy',
      maxDate: '+0D'
    });

    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>
</body>
</html>
