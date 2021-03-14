<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome</title>
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
                                            <a href="<?= url('/') ?>"><img src="<?= asset('userassets/images/logo.png') ?>" alt="logo" border="0" style="margin: 0 auto;display: block; width: 200px;"></a>
                                        </td>    
                                    </tr>   
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" width="100%" style="color: #1f1f1f;padding: 0 35px;">
                                <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #0e0b16;padding-bottom: 0px;">
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato';color:#fff; ">
                                            <p><?= isset($title) ? $title : ''; ?></p>
                                            <p> We will like to congratulate you on your decision to get healthy and get fit. We’re thrilled that you’ve taken the first step. Now, let’s take you to your goal. 
                                                We’d like to take this opportunity to introduce ourselves and provide you with a few tips to get you started on your fitness journey.</p>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato';color:#fff; ">
                                            First, here are a few things you should consider bringing with you to each session:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px; font-size:15px;color:#fff;font-family: 'Lato'; ">
                                            <ul style="list-style: none; padding: 0px; color:#fff; font-family: 'Lato'; " >
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> A water bottle to keep hydrated before, during and after sessions </li>
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> A small towel to dry off during session</li>
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> 100% patience</li>
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> 100% determination</li>
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> 100% Intensity  </li>
                                                <li style="margin-bottom: 3px"> <img src="<?= asset('userassets/images/icon_tick.png') ?>" alt=""/> 100% consistency </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato';color:#fff; ">
                                            <p>Did you know we offer a range of classes, from beginners to advances, dance to Yoga? 
                                                Our mission is making your fitness experience fun and rewarding by providing you with only passionate, 
                                                certified health and fitness professionals at an affordable rate.
                                            </p>
                                            <p>Visit <a href="<?= url('search?search_type=trainer'); ?>" target="_blank">www.ebbsey.com?search_type=trainer</a> to browse and book a session or join a class with a Health and fitness professionals.</p>
                                            <p>You can always book individual, couples, groups, change sessions and even change trainer at no extra cost. 
                                                If you’d like to get in touch with us directly, just email us at support@ebbsey.com.</p>
                                            <p>We hope you’re as excited to get started. Remember, it’s about progress not perfection.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato';color:#fff; ">
                                            <p>Regards,</p>
                                            <p>Ebbsey!</p>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" valign="top" style="padding: 0 0px 20px 0;font-size:15px;font-family: 'Lato';color: #fff; ">
                                            Support: support@ebssey.com
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
                                                    <td align="center" valign="top" style="width:100%; padding:0 0 20px 0;font-size:15px;color:#1f1f1f;font-family: 'Lato';">
                                                        <a href="javascript:void(0)" style="color: #fff;text-decoration: none;">Copyright Ebssey, 2018</a>
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