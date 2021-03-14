<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome <?= isset($title) ? $title : '' ?></title>
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="200" id="bodyTable" style="margin: 0 auto; line-height: 21px; max-width:650px; width: 100%" >
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0"  width="100%" style="width:100%; background: #0e0b16;padding-bottom: 0px;">
                        <tr>
                            <td align="center" valign="top" style="padding: 30px 0 25px;">
                                <table border="0" cellpadding="12" cellspacing="0" style="width:100%;background: #f26824;padding-bottom: 0px;">
                                    <tr>
                                        <td>
                                            <img src="<?= asset('userassets/images/logo.png') ?>" alt="logo" border="0" style="margin: 0 auto;display: block; width: 200px;">
                                        </td>    
                                    </tr>   
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:100%;padding-bottom: 0px;">
                                    <tr>
                                        <td width="35px"></td>
                                        <td align="center" style="text-align: center;">
                                            <h2 style="font-size:21px; color:#e86729; font-family: 'Helvetica',sans-serif; "><?= isset($title) ? $title : '' ?></h2>
                                        </td>
                                        <td width="35px"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" width="100%" style="color: #9ea1a6; padding: 0 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="width:100%; background: #0e0b16;padding-bottom: 0px;">
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px; font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; "><?= isset($mr) ? $mr : 'Hey' ?>  <?= isset($username) ? $username : '' ?>,</p>
                                            <?php if (isset($para_one) && $para_one != '') { ?>
                                                <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                    <?= $para_one ?>
                                                </p>   
                                            <?php } ?>
                                            <?php if (isset($para_two) && $para_two != '') { ?>
                                                <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                    <?= $para_two ?>
                                                </p>
                                            <?php } ?>

                                            <?php if (isset($para_three) && $para_three != '') { ?>
                                                <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                    <?= $para_three ?>
                                                </p>
                                            <?php } ?>

                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;"> Yours in Health,<br/> <span style="color: #f26824">Ebbsey! </span> </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%' style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td style="padding:0 20px 0px 20px;">
                                                        <h2 align="center" style="font-weight: normal; font-size: 22px; font-family: 'Helvetica',sans-serif;">
                                                            <span style="color: #f26824; font-weight: normal; font-size: 22px">FOLLOW</span>
                                                            <span style="color: #ffffff; font-weight: normal; font-size: 22px"> US</span>
                                                        </h2>
                                                        <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">We would love to hear from you. Follow us and get updates on events and promotions.</p>
                                                        <a href="https://www.facebook.com/Ebbseys/" target="_blank" style="display: inline-block; text-decoration: none;"><img src="<?= asset('userassets/images/icons/icon-facebook.png') ?>" style="width: 36px; height: 36px;"/></a>
                                                        <a href="https://www.instagram.com/ebbseys/" target="_blank" style="display: inline-block; text-decoration: none;"><img src="<?= asset('userassets/images/icons/icon-instagram.png') ?>" style="width: 36px; height: 36px;"/></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%'  style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td height="20px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%'  style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td>
                                                        <img src="<?= asset('userassets/images/divider.png') ?>" style="width: 100%; height: 1px;"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%'  style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td height="20px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%'  style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td>
                                                        <p style="color: #ffffff; font-size: 12px; font-family: 'Helvetica',sans-serif;">Our mailing address is:<br/>
                                                            2010 Corporate Ridge Suite # 700 McLean, Virginia <br/> Copyright (C) 2018. Ebbsey All rights reserved. </p>
                                                        <p style="font-size: 12px; font-family: 'Helvetica',sans-serif;"><a href="<?= url('login'); ?>"style="color: #f26824; font-size: 12px; font-family: 'Helvetica',sans-serif;"> Sign in to your account</a></p>
                                                        <p style="color: #ffffff; font-size: 12px; font-family: 'Helvetica',sans-serif;">
                                                            <img src="<?= asset('userassets/images/logo.png'); ?>" alt="ebbsey"  border="0" style="margin: 0 auto;display: block; width: 160px;" />
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%' style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td height="20px"></td>
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