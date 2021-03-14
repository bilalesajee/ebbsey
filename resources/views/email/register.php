<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Registration</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="200" id="bodyTable" style="margin: 0 auto;">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0"  style="background: #0e0b16;padding-bottom: 0px;">
                        <tr>
                            <td align="center" valign="top" style="padding: 51px 0 35px;">
                                <table border="0" cellpadding="20" cellspacing="0"  style="width:100%;background: #f26824;padding-bottom: 0px;">
                                    <tr>
                                        <td>
                                            <a href="<?= url('/') ?>"><img src="<?= asset('userassets/images/logo.png') ?>" alt="logo" border="0" style="margin: 0 auto;display: block;  width: 200px;"></a>
                                        </td>    
                                    </tr>   
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" width="100%" style="color: #1f1f1f;padding: 0 35px;">
                                <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #0e0b16;padding-bottom: 0px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 20px 0 20px;font-size:35px;font-weight: 500; font-family: 'Lato';text-align: center;color: #fff;">
                                            Welcome to Ebbsey
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="font-size:15px;color:#1f1f1f;padding:0 20px 20px 20px;font-family: 'Lato';color: #fff; ">
                                            Hello <?= isset($full_name)?$full_name:''?>,
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato';color:#fff; ">
                                            Thank you for signing up for your new account at Ebbsey. Follow the link below to confirm your account
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="padding:35px 20px 35px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato'; ">
                                            <?php if (isset($link)) { ?>
                                                <a href="<?= $link ?>" style="color: #fff;text-transform: uppercase;background-color: #f26824;padding: 10px 30px;border-radius: 4px;text-decoration: none;">VERIFY YOUR ACCOUNT</a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" valign="top" style="padding: 0 0px 20px 0;font-size:15px;font-family: 'Lato';color: #fff; ">
                                            Support: support@ebbsey.com
                                        </td>
                                    </tr>

                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 0px;">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailContainer" style="background: #181520;padding-bottom: 0px;">
                                    <tr>
                                        <td style="padding: 0;" align="center" style="width: 100%;padding: 0 0px 0px 0">
                                            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#332B47" style="border-radius: 5px;text-align: center;padding: 0px 0;">
                                                <tr>
                                                    <td align="center" valign="top" width:100%; style="border-top:1px solid #803a1d;padding:15px 0 0 0;font-size:15px;color:#1f1f1f;font-family: 'Lato';">
                                                        <a href="<?= url('page/privacy-policy') ?>" target="_blank" style="color: #fff;text-decoration: none;padding-bottom: 5px;display: block;">Privacy Policy</a>
                                                        <a href="<?= url('page/terms-of-service') ?>" target="_blank" style="color: #fff;text-decoration: none;">Terms & Conditions</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="padding:0;font-size:15px;color:#1f1f1f;font-family: 'Lato';padding: 10px 0; width:100%">
                                                        <a href="https://www.facebook.com/Ebbseys/" target="_blank" style="color: #fff;text-decoration: none;padding: 0 5px;"><img src="<?= asset('userassets/images/icons/mail-fb.png') ?>"/></a>
                                                        <a href="https://www.instagram.com/ebbseys/" target="_blank" style="color: #fff;text-decoration: none;padding: 0 5px;"><img src="<?= asset('userassets/images/icons/mail-ins.png') ?>"/></a>
                                                    </td>
                                                </tr>  
                                                <tr>
                                                    <td align="center" valign="top" style="padding:0 0 20px 0;font-size:15px;color:#1f1f1f;font-family: 'Lato'; width:100%">
                                                        <a href="#" style="color: #fff;text-decoration: none;">Copyright Ebbsey, 2018</a>
                                                    </td>
                                                </tr> 
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>