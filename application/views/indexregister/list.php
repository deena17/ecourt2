<?php $this->load->view('templates/header', ['title' => 'Index Register']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary" style="min-height:600px">
            <div class="card-header text-center">
                <h3 class="card-title">Index Register</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-4 offset-md-2">
                            <div class="form-group">
                                <label for="case_type">Case type</label>
                                <select name="case_type" id="case_type" class="form-control">
                                    <option value="">Select casetype</option>
                                    <?php foreach($case_type as $t): ?>
                                        <option value="<?php echo $t->case_type; ?>" <?php echo set_select('case_type', $t->case_type); ?>><?php echo $t->type_name; ?></option>      
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="case_no">Case Number</label>
                                <input type="text" class="form-control" name="case_no" id="case_no" value="<?php echo set_value('case_no'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="case_year">Case Year</label>
                                <input type="text" class="form-control" name="case_year" id="case_year" value="<?php echo set_value('case_year'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2 pt-4 mt-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
                <?php if(isset($indexs)): ?>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <?php foreach($indexs as $i): ?>
                            <li class="list-group-item">
                                <?php if($this->permission->has(['FORA'])): ?>
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="<?php echo $i->srno; ?>">
                                    <label for="<?php echo $i->srno; ?>"></label>
                                </div>
                                <?php endif; ?>
                                <a href="#" onclick="loadDocument('<?php echo $i->cino; ?>', <?php echo $i->srno;?>)" ><?php echo strtoupper($i->docu_name); ?></a>
                                <div class="float-right">
                                    <span class="badge bg-info"><?php echo date("d-m-Y", strtotime($i->paperdate)); ?></span>
                                    <?php if($this->permission->has(['FORA'])): ?>
                                    <a href="javascript:void(0)" class=""><i class="fa fa-trash-alt text-danger ml-1"></i></a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <?php if($this->permission->has(['FORA'])): ?>
                            <li class="list-group-item">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="delete-all-checkbox">
                                    <label for="delete-all-checkbox">Select All</label>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm float-right">Delete Selected</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-danger" id="document-title">
                                ...
                            </div>
                            <div class="card-body" style="min-height:600px" id="document-content">

                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<script>
    function loadDocument(cino, srno){
      $.ajax({
            method: 'POST',
            url: `<?php echo base_url()."indexregister/get-index-document/"; ?>${cino}/${srno}`,
            data: { cino, srno },
            success: function (response) {
                $("#document-title").text(response.title).wrapInner("<strong/>");
                let content = '';
                $("#document-content").html(content);
                if(response.file_path){
                    content = `
                        <embed 
                        src="${response.file_path}" 
                        width="100%"
                        height="700"
                        class="border"
                    /> 
                    `;
                    $("#document-content").html(content);
                }
                else{
                    content = `<p class="text-danger text-center"><strong>Document not found.</strong></h5>`;
                    $("#document-content").html(content);
                }
                // 
            }
        });
    }
</script>

<?php $this->load->view('templates/footer'); ?>