<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Appointment Referral</title>
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
                                            <h2 style="font-size:21px; color:#f26824; font-family: 'Helvetica',sans-serif; ">Appointment Referral</h2>
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
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">Hey <?= isset($username) ? $username : '' ?> </p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">Due to unforeseeable circumstance, Your Health and Fitness Professional, [trainer name] cannot make it to the session for (session date) (session time) and (session location). However, [trainer name] has referral you to another Health and Fitness Professional that shares the same discipline.</p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif;">Your new Health and Fitness Professional for session on (session date) (session time) at (session location) is (new trainer name with a hyperlink to his profile).</p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">Do you accept and approve (new trainer name with a hyperlink to his profile)? A way for a Yes or NO</p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;"> Regards,<br/> <span style="color: #f26824">Ebbsey! </span> </p>
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
                                                        <p style="font-size: 12px; font-family: 'Helvetica',sans-serif;"><a href="#"style="color: #f26824; font-size: 12px; font-family: 'Helvetica',sans-serif;"> Sign in to your account</a></p>
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