<?php $this->load->view('templates/header', ['title' => 'Scrutiny']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Case Objection Compliance</h3>
            </div>
            <div class="card-body">
               <div class="row">
                    <div class="col-md-5 offset-md-3">
                        <div class="form-group row">
                            <label for="filing_number" class="col-sm-3 col-form-label">Filing Number</label>
                            <div class="col-sm-9">
                                <select name="filing_number" id="filing_number" class="form-control select2" style="width: 100%;">
                                    <option value="">Select Filing Number</option>
                                    <?php foreach($cases as $c): ?>
                                    <option value="<?php echo $c->filing_no; ?>"><?php echo $c->case_number; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <table class="table no-border">
                            <tr>
                                <td>Plaintiff&nbsp;Name</td>
                                <td id="plaintiff_name"></td>
                                <td>Defendent&nbsp;Name</td>
                                <td id="defendent_name"></td>
                            </tr>
                            <tr>
                                <td>Petitioner&nbsp;Advocate</td>
                                <td id="petitioner_advocate"></td>
                                <td>Defendent&nbsp;Advocate</td>
                                <td id="defendent_advocate"></td>
                            </tr>
                            <tr>
                                <td>Court&nbsp;Fee</td>
                                <td id="court_fee"></td>
                                <td>Suit&nbsp;Value</td>
                                <td id="suit_value"></td>
                            </tr>
                            <tr>
                                <td>Objections</td>
                                <td>
                                    <div class="icheck-success d-inline">
                                        <input type="radio" id="objection-yes" name="objection" value="yes">
                                        <label for="objection-yes">Yes</label>
                                    </div>
                                    <div class="icheck-danger d-inline ml-3">
                                        <input type="radio" id="objection-no" name="objection" value="no" checked>
                                        <label for="objection-no">No</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Date of Scrutiny</td>
                                <td>
                                    <input type="text" class="form-control datepicker" style="width:60%">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row" id="objection-list">
                        <div class="col-md-10 offset-md-1">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Objection Type</th>
                                        <th>Compliance Required</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($objections as $o): ?>
                                        <tr>
                                            <td><?php echo $o->objcode; ?></td>
                                            <td><?php echo $o->objtype; ?></td>
                                            <td>
                                                <div class="icheck-success d-inline">
                                                    <input type="radio" id="r1-<?php echo $o->objcode; ?>" name="name-<?php echo $o->objcode; ?>">
                                                    <label for="r1-<?php echo $o->objcode; ?>">Yes</label>
                                                </div>
                                                <div class="icheck-danger d-inline ml-3">
                                                    <input type="radio" id="r2-<?php echo $o->objcode; ?>" name="name-<?php echo $o->objcode; ?>" checked>
                                                    <label for="r2-<?php echo $o->objcode; ?>">No</label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly="readonly">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3 offset-md-1">
                            <div class="form-group">
                                <label for="">Other Objection</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Other Objection</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Communication on Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-3">
                            <div class="form-group">
                                <label for="">Objection Compliance Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Document Receipt Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                </div>
                <div class="text-center">
                        <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $("#objection-list").hide();

    $('#filing_number').change(function(){
      var filing_number = $(this).val();
      $.ajax({
            method: 'POST',
            url: `<?php echo base_url()."index.php/cases/getdetailsbyfilingno/"; ?>${filing_number}`,
            data: { filing_number },
            success: function (response) {
                $("#plaintiff_name").html(response.pet_name)
                $("#defendent_name").html(response.res_name)
                $("#petitioner_advocate").html(response.pet_adv)
                $("#respondent_advocate").html(response.res_adv)
                $("#court_fee").html(response.court_fee)
                $("#suit_value").html(response.suit_value)
            }
        });
    });

    $('input[type=radio][name=objection]').change(function() {
        var filing_number = $("#filing_number").val();
        if (filing_number == ''){
            alert('Please select filing number')
            return
        }
        if (this.value == 'yes') {
            $("#objection-list").show();
        }
        else if (this.value == 'no') {
            $("#objection-list").hide();
        }
});

</script>

<?php $this->load->view('templates/footer'); ?>