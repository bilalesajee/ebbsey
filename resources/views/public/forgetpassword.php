<?php include resource_path('views/includes/header.php'); ?>
<div class="login_wrapper full_viewport align-items-center d-flex">
    <div class="container">
        <div class="form-container">
            <div class="form_title">
                <h5 class="text-white text-center">FORGOT PASSWORD</h5>
            </div>
            <?php if (session()->has('number_error')) { ?>
                <div class="alert alert-danger"><?php echo Session::get('number_error'); ?></div>
            <?php } ?>
            <?php if (session()->has('code_error')) { ?>
                <div class="alert alert-danger"><?php echo Session::get('code_error'); ?></div>
            <?php } ?>
            <?php if (isset($code_sent) && $code_sent == 1) { ?>
                <form id="code_confrim_form" action="<?= asset('/confirm-code') ?>" method="post">
                <?php } else { ?>
                    <form action="<?= asset('/forgot-password') ?>" method="post">
                    <?php } ?>
                    <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <?php if ($errors->has('email')) { ?>
                            <div class="alert alert-danger"><?= $errors->first('email') ?></div>
                        <?php } ?>
                            <input id="email" type="email" name="email" placeholder="Email" value="<?= isset($email) ? $email : '' ?>" class="form-control eb-form-control" />
                    </div>
                    <?php if (isset($last_digits)) { ?>
                        <div class="form-group">
                            <p class="text-white">4 digits code sent on your mobile number <br/><span class="text-orange">* * * * * * * - <?= $last_digits ?></span></p>
                            <!--<span>code is : <? = $code ?></span>-->
                        </div>
                        <div class="form-group">
                            <input type="text" id="code" maxlength="4" name="password_code" placeholder="Enter 4 Digits code" class="form-control eb-form-control" />
                            <span id="code_accepted" style="display: none;"><i class="fa fa-check text-success"></i></span>
                            <span id="code_rejected" style="display: none;"><i class="fa fa-times text-danger"></i></span>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?php if (isset($code_sent) && $code_sent == 1) { ?>
                        <button type="submit" class="btn orange btn-block"> NEXT <span class="arrow"></span> </button>
                        <?php }else { ?>
                            <button type="submit" class="btn orange btn-block"> SUBMIT <span class="arrow"></span> </button>
                        <?php } ?>
                    </div>
                    <p class="text-white text-center">Go back to <a href="<?= asset('/login') ?>" class="txt-link">Login</a></p>
                </form>
        </div>
    </div>
</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $('#code').on("change paste keyup", function(){
    if($(this).val().length >= 4){
        var code =$(this).val();
        var email =$('#email').val();
            $.ajax({
                url: base_url + 'check-code',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'code': code,'email':email,'_token': '<?= csrf_token() ?>'},
                success:function(data) {
                    data = JSON.parse(data);
                    console.log(data.status);
                     if(data.status === "success") {
                         $("#code_rejected").hide();
                         $("#code_accepted").show();
                         setTimeout(function(){
//                            $('#code_confrim_form').submit(); 
                        }, 3000);
                     } else if(data.status === "error") {
                         $("#code_accepted").hide();
                         $("#code_rejected").show();
                     }
//                    window.location.href= base_url+'forgot-password';
                    }
                });
                
    }
});
</script>
</body>
</html>
