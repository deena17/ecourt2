<?php $this->load->view('templates/header', ['title' => 'Index Register']); ?>
<div class="content-wrapper">
    <section class="content pt-3">
        <div class="card card-outline card-primary" style="min-height:600px">
            <div class="card-header text-center">
                <h3 class="card-title">Index Register</h3>
            </div>
            <div class="card-body p-2">
                <div class="" id="document-alert"></div>
                <?php if(isset($indexs)): ?>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-group">
                        <?php foreach($indexs as $i): ?>
                            <input type="hidden" value="<?php echo $i->cino; ?>" name="cino" id="cino">
                            <input type="hidden" value="<?php echo $i->srno; ?>" name="srno[]">
                            <li class="list-group-item" id="list_<?php echo $i->srno; ?>">
                                <?php if($this->permission->has(['FORA'])): ?>
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="checkbox_<?php echo $i->srno; ?>" class="checkbox" value="<?php echo $i->srno; ?>">
                                    <label for="checkbox_<?php echo $i->srno; ?>"></label>
                                </div>
                                <?php endif; ?>
                                <a href="javascript:void(0)" onclick="loadDocument('<?php echo $i->cino; ?>', <?php echo $i->srno;?>)" ><?php echo strtoupper($i->docu_name); ?></a>
                                <div class="float-right">
                                    <span class="badge bg-info"><?php echo date("d-m-Y", strtotime($i->paperdate)); ?></span>
                                    <?php if($this->permission->has(['FORA'])): ?>
                                    <a href="javascript:void(0)" class="" onclick="deleteDocument('<?php echo $i->cino; ?>', <?php echo $i->srno;?>)">
                                        <i class="fa fa-trash-alt text-danger ml-1"></i></a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <?php if($this->permission->has(['FORA'])): ?>
                            <li class="list-group-item">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all">Select All</label>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm float-right" onclick="deleteSeleted()">Delete Selected</a>
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
                <?php else: ?>
                    <p class="text-danger text-center"><strong>No documents found</strong></p>
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

    function deleteDocument(cino, srno){
        if(!$('#checkbox_'+srno).prop("checked")){
            alert("Please confirm the document to delete");
            return;
        }
        if(confirm("Are you sure want to delete the selected document?")){
            $.ajax({
                method: 'POST',
                url: `<?php echo base_url()."indexregister/delete/"; ?>`,
                data: { cino, srno },
                success: function (response) {
                    if(response.status=='success' && response.code == 200){
                        let message = `
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span>Index register deleted successfully</span>
                            </div>
                        `;
                        $("#document-alert").html(message);
                        $("#list_"+srno).remove();
                    } 
                    else if(response.status=='failure' && response.code == 400){
                        let message = `
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span>Something went wrong. Please try later.</span>
                            </div>
                        `;
                        $("#document-alert").html(message);
                        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                            $(".alert").slideUp(200);
                        });
                    }
                },
                error: function(response){
                    let message = `
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span>Something went wrong. Please try later.</span>
                        </div>
                    `;
                    $("#document-alert").html(message);
                    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                        $(".alert").slideUp(200);
                    });
    
                }
            });
        }
    }

    function deleteSeleted(){
        let cino = $("#cino").val();
        let srno = [];
        $("input:checkbox[class=checkbox]:checked").each(function(){
            srno.push($(this).val());
        });
        if(confirm("Are you sure want to delete the selected document(s)?")){
            $.ajax({
                method: 'POST',
                url: `<?php echo base_url()."indexregister/delete"; ?>`,
                data: { cino, srno },
                success: function (response) {
                    if(response.status=='success' && response.code == 200){
                        let message = `
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span>Index register deleted successfully</span>
                            </div>
                        `;
                        $("#document-alert").html(message);
                        $("input:checkbox[class=checkbox]:checked").each(function(){
                            $(this).parent().parent().remove();
                        });
                        location.reload();
                    } 
                    else if(response.status=='failure' && response.code == 400){
                        let message = `
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <span>Something went wrong. Please try later.</span>
                            </div>
                        `;
                        $("#document-alert").html(message);
                    }
                },
                error: function(response){
                    let message = `
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span>Something went wrong. Please try later.</span>
                        </div>
                    `;
                    $("#document-alert").html(message);
    
                }
            });
        }
    }

    $("#select-all").click(function () {
        $(".checkbox").prop('checked', $(this).prop('checked'));
    });
</script>

<?php $this->load->view('templates/footer'); ?>