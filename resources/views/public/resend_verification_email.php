<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
        <title><?= $title ?></title> 
        <?php include resource_path('views/includes/top.php'); ?>
    </head>
    <body>
        <?php include resource_path('views/includes/header.php'); ?>
        <div class="login_wrapper full_viewport align-items-center d-flex">
            <div class="container">
                <div class="form-container">
                    <div class="form_title">
                        <h5 class="text-white text-center">Resend Verification Email</h5>
                    </div>
                    <?php if (session()->has('error')) { ?>
                        <div class="alert alert-danger"><?php echo Session::get('error'); ?></div>
                    <?php } ?>
                    <?php if (session()->has('success')) { ?>
                        <div class="alert alert-success"><?php echo Session::get('success'); ?></div>
                    <?php } ?>
                    <form method="post" action="<?= asset('resend_verification_email') ?>">
                        <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                        <div class="form-group">
                            <input type="email" placeholder="Email" name="email" class="form-control eb-form-control" value="<?= old("email") ?>" />
                            <?php if ($errors->has('email')) { ?>
                                <div class="error text-danger"><?= $errors->first('email') ?></div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn orange btn-block"> SEND <span class="arrow"></span> </button>
                        </div>
                        <div class="form-group">
                            <p class="text-center text-white">Back to login? <a href="<?= asset('login') ?>" class="txt-link"><strong>Login</strong></a></p>
                            <p class="text-center text-white">Don't have an account? <a href="<?= asset('join-now') ?>" class="txt-link"><strong>Register</strong></a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include resource_path('views/includes/footer.php'); ?>
        <?php include resource_path('views/includes/footerassets.php'); ?>
    </body>
</html>
