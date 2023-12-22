<?php $this->load->view('templates/header', ['title' => 'Scrutiny']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Case Objection Compliance</h3>
            </div>
            <div class="card-body" style="min-height:500px">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <?php if($this->session->flashdata('message')): ?>
                            <div class="alert <?php echo $this->session->flashdata('alert-class'); ?> alert-dismissible fade show" role="alert" id="alert">
                                <?php echo $this->session->flashdata('message'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-group row">
                                <label for="filing_number" class="col-sm-3 col-form-label">Filing Number</label>
                                <div class="col-sm-9">
                                    <select name="filing_number" id="filing_number" class="form-control select2 <?php if(form_error('filing_number')):?> is-invalid <?php endif; ?>" style="width: 100%;">
                                        <option value="">Select Filing Number</option>
                                        <?php foreach($cases as $c): ?>
                                        <option value="<?php echo $c->cino; ?>" <?php echo set_select('filing_number', $c->cino); ?>><?php echo $c->case_number; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="invalid-feedback">
                                        <?php echo form_error('filing_number'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2" id="case-details">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Objection</label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="objection-yes" name="objection" value="Y" <?php echo set_radio('objection','Y');?>>
                                    <label for="objection-yes">Yes</label>
                                </div>
                                <div class="icheck-danger d-inline ml-3">
                                    <input type="radio" id="objection-no" name="objection" value="N" <?php echo set_radio('objection','N',TRUE);?>>
                                    <label for="objection-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="scrutiny-date" class="col-sm-2 col-form-label">Date of Scrutiny</label>
                            <div class="col-sm-2">
                                <input 
                                    type="text" 
                                    class="form-control datepicker <?php if(form_error('scrutiny_date')):?> is-invalid <?php endif; ?>" 
                                    id="scrutiny-date" 
                                    name="scrutiny_date"
                                    value="<?php echo set_value('scrutiny_date'); ?>"
                                >
                                <span class="invalid-feedback">
                                    <?php echo form_error('scrutiny_date'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="objection_remarks">Objection Remarks</label>
                                    <textarea name="objection_remarks" id="objection-remarks" cols="30" rows="2" class="form-control <?php if(form_error('objection_remarks')):?> is-invalid <?php endif; ?>" disabled="disabled"></textarea>
                                    <span class="invalid-feedback">
                                        <?php echo form_error('objection_remarks'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Communication on Date</label>
                                    <input 
                                        type="text" 
                                        name="communication_date" 
                                        id="communication-date" 
                                        value="<?php echo set_value('communication_date'); ?>"
                                        class="form-control datepicker <?php if(form_error('communication_date')):?> is-invalid <?php endif; ?>" 
                                        disabled="disabled"
                                    >
                                    <span class="invalid-feedback">
                                        <?php echo form_error('communication_date'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Objection Compliance Date</label>
                                    <input 
                                        type="text" 
                                        name="compliance_date" 
                                        id="compliance-date" 
                                        value="<?php echo set_value('compliance_date'); ?>"
                                        class="form-control datepicker <?php if(form_error('compliance_date')):?> is-invalid <?php endif; ?>" 
                                        disabled="disabled"
                                    >
                                    <span class="invalid-feedback">
                                        <?php echo form_error('compliance_date'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Document Receipt Date</label>
                                    <input 
                                        type="text" 
                                        name="receipt_date" 
                                        id="receipt-date" 
                                        class="form-control datepicker <?php if(form_error('receipt_date')):?> is-invalid <?php endif; ?>" 
                                        disabled="disabled"
                                        value="<?php echo set_value('receipt_date'); ?>"
                                    >
                                    <span class="invalid-feedback">
                                        <?php echo form_error('receipt_date'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>

    $(function(){
        if($('input[type=radio][name=objection]:checked').val() == 'Y'){
            $("#objection-remarks").attr("disabled", false);
            $("#communication-date").attr("disabled", false);
            $("#compliance-date").attr("disabled", false);
            $("#receipt-date").attr("disabled", false);
        }
    });

    $('#filing_number').change(function(){
      var filing_number = $(this).val();
      $.ajax({
            method: 'POST',
            url: `<?php echo base_url()."case/details-by-filing-number/"; ?>${filing_number}`,
            data: { filing_number },
            success: function (response) {
                let table = `
                    <table class="table table-bordered">
                        <tr>
                            <td>Plaintiff&nbsp;Name</td>
                            <td>${response.pet_name}</td>
                            <td>Respondent&nbsp;Name</td>
                            <td>${response.res_name}</td>
                        </tr>
                        <tr>
                            <td>Petitioner&nbsp;Advocate</td>
                            <td>${response.pet_adv}</td>
                            <td>Respondent&nbsp;Advocate</td>
                            <td>${response.res_adv}</td>
                        </tr>
                        <tr>
                            <td>Court&nbsp;Fee</td>
                            <td>${response.amount}</td>
                            <td>Suit&nbsp;Value</td>
                            <td>${response.juri_value}</td>
                        </tr>
                    </table>
                `;
                $("#case-details").html(table);
            }
        });
    });

    $('input[type=radio][name=objection]').change(function() {
        var filing_number = $("#filing_number").val();
        if(filing_number == ''){
            alert('Please select the filing number');
            return false
        }
        if (this.value == 'Y') {
            $("#objection-remarks").attr("disabled", false);
            $("#communication-date").attr("disabled", false);
            $("#compliance-date").attr("disabled", false);
            $("#receipt-date").attr("disabled", false);
        }
        else if (this.value == 'N') {
            $("#objection-remarks").attr("disabled", true).removeClass('is-invalid');
            $("#communication-date").attr("disabled", true).removeClass('is-invalid');
            $("#compliance-date").attr("disabled", true).removeClass('is-invalid');
            $("#receipt-date").attr("disabled", true).removeClass('is-invalid');
        }
    });

</script>

<?php $this->load->view('templates/footer'); ?>