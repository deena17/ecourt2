<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>404 Not found</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="<?php echo base_url(); ?>static/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>static/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>static/dist/css/custom.style.css">
    </head>
    <body class="bg-light" style="background:#f4f6f4;!important">
        <section class="content mt-5">
            <div class="error-page" style="margin-top:15%!important;padding:10px!important">
                <h2 class="headline text-danger"> <strong>403</strong></h2>
                <div class="error-content">
                    <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>Oops! Access Denied.</strong></h3>
                    <p>You don't have permission to access this resource. Please contact site adminstrator for further support.</p>
                    <a href="<?php echo base_url(); ?>dashboard/" class="btn btn-dark px-4 mt-3"><i class="fa fa-arrow-left mr-2"></i>Go to Dashboard</a>
                </div>
            </div>
        </section>
    </body>
</html>


