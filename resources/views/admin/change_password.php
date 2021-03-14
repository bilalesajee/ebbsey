<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!-- Main content -->
                <section class="content">
                    <div class="login-box">
                        <div class="login-logo">
                            <b>Ebbsey</b>
                        </div>
                        <div class="login-box-body">
                            <form action="<?= asset('change_password_admin') ?>" method="post">
                                <?php if (Session::has('success')) { ?>
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        <?php echo Session::get('success') ?>
                                    </div>
                                <?php } ?>
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
                                <p class="login-box-msg">Change and reset Password</p>
                                <div class="form-group has-feedback">
                                    <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" name="password" class="form-control" placeholder="New Password">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>

                </section> 
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
