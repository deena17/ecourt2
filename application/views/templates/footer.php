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
    <script src="<?php echo base_url(); ?>static/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script>
  $(function() {
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

    $('#establishment').change(function(){
      var establishment = $(this).val();
      $.ajax({
            method: 'POST',
            url: '<?php echo base_url()."index.php/disposed/getcourtbyestablishment/"; ?>',
            data: { establishment : establishment},
            success: function (data) {
              // var options = '';
              //$('#court_name').find('option').not(':first').remove()
              $('#court_name').find('option').remove()
              // $.each(JSON.parse(data), function(index,value){
              //  options += '<option value="'+value['desgcode']+'">'+value['desgname']+'</option>';
              // });
              $("#court_name").html(data);
            }
        });
   
      });
    });    

    function updateNature(index){
        var establishment = $('#est').val();
        var case_type = $('#'+index+'_case_type').val();
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url()."index.php/disposed/getnaturebycasetype/"; ?>',
            data: { 
                establishment: establishment,
                type: case_type,
              },
            success: function (response) {
              $('#'+index+'_nature').find('option').remove();
              $('#'+index+'_nature').html(response);
            },
        });
      }

    function formSubmit(index){
        event.preventBubble=true;
        var establishment = $('#est').val();
        var courtname = $('#cname').val();
        var cino = $('#'+index+'_cino').val();
        var case_number = $('#'+index+'_case_number').val();
        var type = $('#'+index+'_case_type').val();
        var nature = $('#'+index+'_nature').val();
        var prayer = $('#'+index+'_prayer').val();
        if(type == 0){
          alert('Please selet case type');
        }
        else if(nature == 0){
          alert('Please select nature');
        }
        else if(prayer == 0){
          alert('Please select prayer');
        }
        else{
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url()."index.php/disposed/updatecasedetails/"; ?>',
            data: { 
                establishment: establishment,
                desgcode: courtname,
                nature: nature,
                prayer: prayer,
                casenumber: case_number,
                cino: cino,
                type: type
              },
            success: function (response) {
                $('#'+index+'_submit').removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                $('#'+index+'_icon').removeClass('fa-check').addClass('fa-times');
                $('#'+index+'_btn-text').text('Updated');
                $('#dis-alert').toggle();
                $('#dis-alert').removeClass('alert-danger').addClass('alert-success');
                $('#alert-text').text('Case details updated successfully');
                $('#'+index+'_prayer').removeClass('is-valid');
                $('#'+index+'_nature').removeClass('is-valid');
                $("#dis-alert").fadeTo(2000, 500).slideUp(500, function(){
                  $("#dis-alert").slideUp(200);
                });
            },
            error: function(response){
              $('#dis-alert').toggle();
              $('#dis-alert').removeClass('alert-success').addClass('alert-danger');
              $('#alert-text').text('Something went wrong. Please try later!!!');
              $("#dis-alert").fadeTo(2000, 500).slideUp(500, function(){
              $("#dis-alert").slideUp(200);
              });
            }
        });
      }
    }
</script>
</body>
</html>
