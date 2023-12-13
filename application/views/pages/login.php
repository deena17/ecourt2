<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>static/dist/css/adminlte.min.css?v=3.2.0">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        <a href="#"><b>Login</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <?php if(isset($error)): ?>
                <div class="alert alert-dismissible alert-danger" id="dis-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span style="font-size:12px;"><?= $error; ?></span>
                </div>
                <?php endif; ?>
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="<?php echo base_url(); ?>index.php/auth/login" method="post">
                    <div class="form-group">
                        <label for="establishment">Establishment</label>
                        <select class="form-control <?php if(form_error('establishment')):?> is-invalid <?php endif; ?>" id="establishment" name="establishment">
                            <option value="0" selected="selected">Select Establishment</option>
                            <?php foreach($establishment as $e): ?>
                            <option value="<?php echo $e->est_dbname; ?>" <?php //echo set_select('establishment', $e->est_dbname); ?>><?php echo $e->estname; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback">
                            <?php echo form_error('establishment'); ?>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input 
                            type="text" 
                            class="form-control <?php if(form_error('username')):?> is-invalid <?php endif; ?>" 
                            placeholder="username"
                            id="username"
                            name="username"
                            value="<?php echo set_value('username'); ?>"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <span class="invalid-feedback">
                            <?php echo form_error('username'); ?>
                        </span>
                    </div>
                    <div class="input-group mb-3">
                        <input 
                            type="password" 
                            class="form-control <?php if(form_error('password')):?> is-invalid <?php endif; ?>" 
                            placeholder="Password"
                            id="password"
                            name="password"
                            value="<?php echo set_value('password'); ?>"
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <span class="invalid-feedback">
                            <?php echo form_error('password'); ?>
                        </span>
                    </div>
                    <div class="row pt-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                Remember Me
                                </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center py-3">
            <!-- <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a> -->
            </div>
            <!-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
            </p> -->
        </div>

</div>
</div>


<script src="<?= base_url();?>static/plugins/jquery/jquery.min.js"></script>

<script src="<?= base_url();?>static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url();?>static/dist/js/adminlte.min.js?v=3.2.0"></script>
<script>
    $(function() {
        $("#dis-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#dis-alert").slideUp(200);
        });
    });
     
</script>
</body>
</html>
