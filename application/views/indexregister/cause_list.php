<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Cause List</h3>
            </div>
            <div class="card-body">
                <div class="" id="objection-alert"></div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>#</th>
                                    <th>Case&nbsp;Number</th>
                                    <th>Cause Title</th>
                                    <th>Advocate&nbsp;Name</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php static $index=1; foreach($cases as $c): ?>
                                <tr>
                                    <td><?php echo $index; ?></td>
                                    <td><?php echo $c->case_number; ?></td>
                                    <td><?php echo $c->pet_name; ?><span class="text-danger px-3">Vs</span><?php echo $c->res_name; ?></td>
                                    <td>Petitioner Adv: <?php echo $c->pet_adv; ?><br>Respondent Adv: <?php echo $c->res_adv; ?></td>
                                    <td><a href="<?php echo base_url(); ?>indexregister/<?php echo $c->cino; ?>/documents" class="btn btn-info btn-sm">Documents</a></td>
                                </tr>
                                <?php $index++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="modal fade" id="document-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-primary"></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer justify-content-right">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function enableRemarks(id){
        $(`#remarks_${id}`).attr('readonly', false);
    }

    function disableRemarks(id){
        $(`#remarks_${id}`).val('');
        $(`#remarks_${id}`).attr('readonly', true);
    }

    function loadDocument(cino, srno){
      $.ajax({
            method: 'POST',
            url: `<?php echo base_url()."indexregister/get-eindex-document/"; ?>${cino}/${srno}`,
            data: { cino, srno },
            success: function (response) {
                $(".modal-title").text(response.title).wrapInner("<strong/>");
                let content = '';

                if(response.file_path){
                    // document.getElementById("document-viewer").src = response.file_path;
                    content = `
                        <embed 
                        src="${response.file_path}" 
                        width="100%"
                        height="700"
                        class="border"
                    /> 
                    `;
                    $(".modal-body").html(content);
                }
                else{
                    content = `<p class="text-danger text-center"><strong>Document not found.</strong></h5>`;
                    $(".modal-body").html(content);
                }
                // 
            }
        });
    }


    function formSubmit(index){
        var cino = $('#cino_'+index).val();
        var srno = $('#srno_'+index).val();
        //var objection = $('#objection_'+index).val();
        var objection = $("input[name=objection_"+index+"]").val();
        var remarks = $('#remarks_'+index).val();
        $.ajax({
            method: 'POST',
            url: `<?php echo base_url(); ?>scrutiny/${cino}/update-objection`,
            data: { 
                cino, srno, objection, remarks
            },
            success: function (response) {
                
                $('#submit-btn_'+index).removeClass('btn-info').addClass('btn-danger').prop('disabled', true);
                // $('#'+index+'_icon').removeClass('fa-check').addClass('fa-times');
                $('#submit-btn_'+index).text('Updated');        
                $('#checkbox_'+index).attr('disbled',false).attr('checked', true).attr('disbled', false);
                message = `
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span>Objection details updated successfully</span>
                    </div>
                `;
                $("#objection-alert").html(message);
            },
            error: function(response){
                let message = `
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span>Something went wrong. Please try later.</span>
                    </div>
                `;
                $("#objection-alert").html(message);
            }
        });
    }
</script>
