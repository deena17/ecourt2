<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Document Objection</h3>
            </div>
            <div class="card-body">
                <div class="" id="objection-alert"></div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-secondary">
                                    <th>#</th>
                                    <th>Document Name</th>
                                    <th>Objection</th>
                                    <th>Remarks</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($documents as $d): ?>
                                    <input type="hidden" id="cino_<?php echo $d->srno; ?>" value="<?php echo $d->cino; ?>">
                                    <input type="hidden" id="srno_<?php echo $d->srno; ?>" value="<?php echo $d->srno; ?>">
                                <tr id="row_<?php echo $d->srno; ?>">
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkbox_<?php echo $d->srno; ?>" readonly>
                                            <label for="<?php echo $d->srno; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a 
                                            href="javascript:void(0)" 
                                            data-backdrop="static" data-keyboard="false"
                                            data-toggle="modal" data-target="#document-modal"
                                            onclick="loadDocument('<?php echo $d->cino; ?>',<?php echo $d->srno; ?>)"
                                        ><?php echo strtoupper($d->remarks); ?>
                                    </a>
                                    </td>
                                    <td>
                                        <div class="icheck-success d-inline">
                                            <input 
                                                type="radio" 
                                                id="yradio_<?php echo $d->srno; ?>" 
                                                name="objection_<?php echo $d->srno; ?>" 
                                                value="Y"
                                                onclick="enableRemarks(<?php echo $d->srno; ?>)" 
                                            />
                                            <label for="yradio_<?php echo $d->srno; ?>">Yes</label>
                                        </div>
                                        <div class="icheck-danger d-inline ml-3">
                                            <input 
                                                type="radio" 
                                                id="nradio_<?php echo $d->srno; ?>" 
                                                name="objection_<?php echo $d->srno; ?>" 
                                                checked 
                                                value="N"
                                                onclick="disableRemarks(<?php echo $d->srno; ?>)" 
                                            />
                                            <label for="nradio_<?php echo $d->srno; ?>">No</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="remarks_<?php echo $d->srno; ?>"
                                            name="remarks_<?php echo $d->srno; ?>"
                                            readonly
                                        >
                                        <div class="invalid-feedback"></div>
                                    </td>
                                    <td>
                                        <button 
                                            class="btn btn-info btn-sm" 
                                            id="submit-btn_<?php echo $d->srno; ?>" 
                                            onClick="formSubmit(<?php echo $d->srno; ?>)"
                                        >Update</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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
        let cino = $('#cino_'+index).val();
        let srno = $('#srno_'+index).val();
        //let objection = $('#objection_'+index).val();
        let objection = $("input[name=objection_"+index+"]:checked").val();
        let remarks = $('#remarks_'+index).val();
        if(objection == 'Y' && remarks == ''){
            $('#remarks_'+index).addClass('is-invalid')
            let immediateSibling = $('#remarks_'+index).next();
            if (immediateSibling.hasClass('invalid-feedback')) {
                immediateSibling.text('Please enter objection remarks');
            } else {
                $('#remarks_'+index).after("<div class='invalid-feedback'>Please enter objection remarks</div>")
            }
            return false;
        }
        $.ajax({
            method: 'POST',
            url: `<?php echo base_url(); ?>scrutiny/${cino}/objection/update`,
            data: { 
                cino, srno, objection, remarks
            },
            success: function (response) {
                $('#submit-btn_'+index).removeClass('btn-info').addClass('btn-danger').prop('disabled', true);
                // $('#'+index+'_icon').removeClass('fa-check').addClass('fa-times');
                $('#submit-btn_'+index).text('Updated');        
                $('#checkbox_'+index).attr('checked', true).parent().addClass('icheck-success');
                message = `
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span>Objection details updated successfully</span>
                    </div>
                `;
                $('#remarks_'+index).removeClass('is-invalid').attr('readonly', true)
                $("#objection-alert").html(message);
            },
            error: function(response){
                $('#checkbox_'+index).attr('checked', true).parent().addClass('icheck-danger');
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
