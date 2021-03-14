<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Complete Session.</title>
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="200" id="bodyTable" style="margin: 0 auto; line-height: 21px; max-width:650px; width: 100%">
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
                                        <td align="center" style="text-align: center; font-size:21px; color:#e86729; font-family: 'Helvetica',sans-serif; ">
                                            <h2 style="font-size:21px; color:#f26824; font-family: 'Helvetica',sans-serif; ">Congratulation</h2>
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
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">Hi <?= isset($username)?$username:'Client';?></p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">Congratulation! What did you think? We’d love to hear your feedback and find out if there’s anything we could be doing to make your time with us more rewarding. Please, take a minute of your time to write a review and rate <?=$tranner_name;?>.</p>
                                            <br/>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;"><strong style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">How was your session? </strong></p>
                                             <img src="<?= asset('userassets/images/icons/image.png') ?>" alt="rate" />
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;"> Regards,<br/> <span style="color: #f26824">Ebbsey! </span> </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td border="0" cellpadding="0" >
                                            <table border="0" cellpadding="0" cellspacing="0" width='100%'  style="width:100%; color:#9ea1a6; font-family:'Helvetica',sans-serif; text-align: center">
                                                <tr>
                                                    <td>
                                                        <a href="<?= url('feedback') . '/' . $appointment_id ?>" style="color: #fff;text-transform: uppercase;background-color: #f26824;padding: 10px 30px;border-radius: 4px;text-decoration: none;">Give Feedback</a>
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
                                                        <p style="font-size: 12px; font-family: 'Helvetica',sans-serif;"><a href="<?=url('login');?>"style="color: #f26824; font-size: 12px; font-family: 'Helvetica',sans-serif;"> Sign in to your account</a></p>
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