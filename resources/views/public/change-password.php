<?php include resource_path('views/includes/header.php'); ?>
<div class="login_wrapper align-items-center d-flex full_viewport">
    <div class="container">
        <div class="form-container">
            <div class="form_title">
                <h5 class="text-white text-center">CHANGE PASSWORD</h5>
            </div>
            <?php if (session()->has('error')) { ?>
                <div class="alert alert-danger"><?php echo Session::get('error'); ?></div>
            <?php } ?>
            <form action="<?= asset('/change-password') ?>" method="post">
                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                <?php if(isset($user_id)){ ?>
                <input name="user_id" type="hidden" value="<?= $user_id ?>">
                <?php } else if (old('user_id')) { ?>
                    <input name="user_id" type="hidden" value="<?= old('user_id') ?>">
                <?php } else { ?>
                    <?php if ($errors->has('email')) { ?>
                        <div class="alert alert-danger"><?= $errors->first('email') ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Enter Email" class="form-control eb-form-control" />
                    </div>
                <?php } ?>
                <div class="form-group">
                    <?php if ($errors->has('password')) { ?>
                        <div class="alert alert-danger"><?= $errors->first('password') ?></div>
                    <?php } ?>
                    <input type="password" name="password" placeholder="New Password" class="form-control eb-form-control" />
                </div>
                <div class="form-group">
                    <?php if ($errors->has('password_confirmation')) { ?>
                        <div class="alert alert-danger"><?= $errors->first('password_confirmation') ?></div>
                    <?php } ?>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control eb-form-control" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn orange btn-block"> SUBMIT <span class="arrow"></span> </button>
                </div>
                <p class="text-white text-center">Go back to <a href="<?= asset('/login') ?>" class="txt-link">Login</a></p>
            </form>
        </div>
    </div>
</div>
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>
