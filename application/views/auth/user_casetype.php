<?php $this->load->view('templates/header', ['title' => 'Scrutiny']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">User Casetype</h3>
            </div>
            <div class="card-body" style="min-height:500px">
                <div class="row">
                    <div class="col-md-8">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user">Username</label>
                                <select name="user" id="user" class="form-control select2 <?php if(form_error('user')):?> is-invalid <?php endif; ?>" style="width: 100%;">
                                    <option value="">Select user</option>
                                    <?php foreach($users as $u): ?>
                                    <option value="<?php echo $u->userid; ?>" <?php echo set_select('user', $u->userid); ?>><?php echo $u->username; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback">
                                    <?php echo form_error('user'); ?>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                    <label>Case Type</label>
                                    <select class="duallistbox" multiple="multiple" name="case_type[]">
                                        <?php foreach ($case_type as $t): ?>
                                            <option value="<?php echo $t->case_type; ?>"><?php echo $t->type_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                            <div class="mt-2">
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

    $('#filing_number').change(function(){
      var filing_number = $(this).val();
      $.ajax({
            method: 'POST',
            url: `<?php echo base_url()."index.php/cases/getdetailsbyfilingno/"; ?>${filing_number}`,
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
                $("#case-details").append(table);
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
            $("#objection-remarks").attr("disabled", true);
            $("#communication-date").attr("disabled", true);
            $("#compliance-date").attr("disabled", true);
            $("#receipt-date").attr("disabled", true);
        }
});

</script>

<?php $this->load->view('templates/footer'); ?>