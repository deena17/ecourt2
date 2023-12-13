<?php $this->load->view('templates/header', ['title' => 'Index Register']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3 class="card-title">Index Register</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <?php foreach($indexes as $i): ?>
                            <li class="list-group-item">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="<?php echo $i->srno; ?>">
                                    <label for="<?php echo $i->srno; ?>"></label>
                                </div>
                                <a href="#" class="text-secondary"><?php echo $i->remarks; ?></a>
                                <a href="#" class="float-right"><i class="text-danger fa fa-trash" style="font-size:20px"></i></a>
                            </li>
                            <?php endforeach; ?>
                            <li class="list-group-item">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all" class="text-secondary">Select All</label>
                                </div>
                                <a href="#" class="btn btn-danger float-right">Delete Selected</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 border" style="min-height:600px;">

                    </div>
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