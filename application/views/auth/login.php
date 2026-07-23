<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Site Ledger - S.K. Constructions Jagdalpur</title>
    <link rel="icon" type="image/x-icon" href="src/assets/img/favicon.ico"/>
    <link href="<?php echo ADMIN_THEME; ?>src/layouts/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo ADMIN_THEME; ?>src/layouts/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo ADMIN_THEME; ?>src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo ADMIN_THEME; ?>src/layouts/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ADMIN_THEME; ?>src/assets/css/authentication/auth-cover.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <style type="text/css">
        .error{
            color: red;
        }
    </style>
</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
                <?php if ($this->session->flashdata('success')) {?>
                    <div class="col-sm-12 mt-3">
                        <div class="alert  alert-success alert-dismissible fade show" role="alert">
                            <span class="badge badge-pill badge-success">Success</span> 
                            <?php echo $this->session->flashdata('success');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php }?>
                <?php if ($this->session->flashdata('error')) {?>
                    <div class="col-sm-12 mt-3">
                        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                            <span class="badge badge-pill badge-danger">Error</span> 
                            <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php }?>
    
                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>
                        
                    <div class="auth-cover">
    
                        <div class="position-relative">
    
                            <img src="<?php echo ADMIN_THEME; ?>src/assets/img/auth-cover-2.png" alt="auth-img">
    
                            <h2 class="mt-5 text-white font-weight-bolder px-2">S. K. Constructions</h2>
                            <p class="text-white px-2">S.K. Constructions is a leading construction and facilities management company.</p>
                        </div>
                        
                    </div>

                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            
                            <form method="post" action="<?php echo base_url('authenticate'); ?>">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    
                                    <h2>Sign In</h2>
                                    <p>Enter your email and password to login</p>
                                    <div class="error"><?php if (isset($login_error)){echo $login_error;}?></div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                            <label class="form-check-label" for="form-check-default">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-secondary w-100">SIGN IN</button>
                                    </div>
                                </div>
                                
                            </div>
                            </form>
                                
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo ADMIN_THEME; ?>src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


</body>
</html>
