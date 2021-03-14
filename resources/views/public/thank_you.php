<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Muli:100,300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="<?= asset('userassets/template') ?>/style/style.css">
    </head>
    <body>
        <div class="background_image">
            <div class="overlay">

            </div>
        </div>
        <div class="header">
            <a href="<?=url('/');?>" class="logo"><img src="<?= asset('userassets/template') ?>/images/logo.png" alt="Ebbsey"></a>
        </div>

        <div class="page_body">
            <div class="container">
                <div class="icon">
                    <img src="<?= asset('userassets/template') ?>/images/image1.png" alt="image">
                </div>
                <div class="divider">
                    <span></span>
                </div>
                <h2>Thank you for your signup</h2>
                <div class="text-content">
                    
                </div>
                <a href="<?=url('login');?>" class="btn" target="_blank">Login</a>
                <ul class="social">
                    <li><a href="https://www.facebook.com/Ebbseys/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.instagram.com/ebbseys/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="thanks_popup_overlay">
            <div class="thanks_popup_wrap">
                <div class="thanks_popup">
                    <!--<span id="closebtn"></span>-->
                    <div class="popup-body">
                        <div class="icon_envelop">
                            <img src="<?= asset('userassets/template') ?>/images/icon-envelope.png" alt="thumbs-up">
                        </div>
                        <div class="title">
                            <h1>Thank you for signing up!</h1>
                        </div>
                        <div class="text_content">
                            <p>We have sent a confirmation email<br/>
                                In order to complete the sign up process please verify your email by clicking the link in your inbox.</p>
                            <hr/>
                            <p>If you didn’t recieve the Confirmation email, Click on the link below to resend it. <a href="<?=url('resend_verification_email')?>">Resend verification email</a></p>
                        </div>
                        <a href="<?= url('/') ?>" class="emailBtn"> Visit Home</a>
                        <div class="followus">
                            <div class="label-followus"> Follow US </div>
                            <ul>
                                <li><a href="https://www.facebook.com/Ebbseys/" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                                <li><a href="https://www.instagram.com/ebbseys/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>			
        </div>

    </body>
</html>