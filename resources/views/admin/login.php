<!DOCTYPE html>
<html lang="en">
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?= asset('/') ?>" class="text-center">                    
                    <img src="<?= asset('/adminassets/images/logo.png') ?>" alt="Ebbsey Logo" width="150"/>
                </a>
            </div>                
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to Access Dashboard</p>
                <form action="<?= asset('admin_login') ?>" method="post">
                    <?php if (Session::has('error')) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                            <?php echo Session::get('error') ?>
                        </div>
                    <?php } ?>
                    <?php if ($errors->any()) { ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors->all() as $error) { ?>
                                    <li><?= $error ?></li>
                                <?php }
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <?php include 'includes/footer.php'; ?>
</html>