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
                        <li class="breadcrumb-item active">404 Error Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content pt-3">
        <div class="error-page">
            <h2 class="headline text-warning"> <strong>404</strong></h2>
            <div class="error-content">
                <h3 class="text-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Oops! Page not found.</strong></h3>
                <p>We could not find the page you were looking for. Meanwhile, you may <a href="<?php echo base_url(); ?>auth/login">return to login page.</a></p>
            </div>
        </div>
    </section>
</div>


<?php $this->load->view('auth/footer'); ?>
