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
                                <?php  $document_name = $i->cino.'_'.$i->srno; ?>
                                <a href="#" onclick="loadDocument('<?php echo $document_name; ?>')" ><?php echo $i->remarks; ?></a>
                                <a href="#" class="float-right" onclick="deleteDocument(<?php echo $document_name; ?>)"><i class="text-danger fa fa-trash" style="font-size:20px"></i></a>
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
                    <div class="col-md-8" style="min-height:600px;">
                    <embed 
                        src="<?php echo base_url(); ?>static/pdf/blank.pdf" 
                        width="100%"
                        height="700"
                        id="pdf-viewer"
                        class="border"
                    /> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function loadDocument(doc){
        let fileName = doc+'.pdf';
        document.getElementById("pdf-viewer").src = `<?php echo base_url(); ?>static/pdf/${fileName}`;

    }
</script>

<?php $this->load->view('templates/footer'); ?>