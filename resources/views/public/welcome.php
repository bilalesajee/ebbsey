<?php include resource_path('views/includes/header.php'); ?>
<div class="login_wrapper full_viewport align-items-center d-flex">
    <div class="container">
        <div class="form-container">
            <div class="form_title">
                <h5 class="text-white text-center"><strong>WELCOME TO EBBSEY</strong></h5>
            </div>
            <form>
                <div class="form-group">
                    <a href="<?= asset('trainer-register') ?>" class="btn btn-block orange">SIGN UP VIA PROFESSIONAL TRAINER <span class="arrow"></span></a>
                </div>
                <div class="form-group">
                    <p class="text-center or"><strong class="text-white"> OR </strong></p>
                </div>
                <div class="form-group">
                    <a href="<?= asset('user-register') ?>" class="btn btn-block orange">SIGN UP AS A CUSTOMER <span class="arrow"></span></a>
                </div>
                <div class="form-group">
                    <p class="text-center text-white">Already have an account? <a href="<?= asset('/login') ?>" class="txt-link"><strong>Login Here</strong></a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>
