<?php $this->load->view('auth/header', array('title' => '404 page not found')); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">403 Error Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content pt-3">
        <div class="error-page">
            <h2 class="headline text-danger"> <strong>403</strong></h2>
            <div class="error-content">
                <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>Oops! Access Denied.</strong></h3>
                <p>You don't have permission to access this resource. Please contact site adminstrator for further support.</p>
                <a href="<?php echo base_url(); ?>dashboard/" class="btn btn-dark px-4 mt-3"><i class="fa fa-arrow-left mr-2"></i>Go to Dashboard</a>
            </div>
        </div>
    </section>
</div>


<?php $this->load->view('auth/footer'); ?>
