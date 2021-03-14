<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome <?= isset($title) ? $title : '' ?> </title>
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
                            <td align="center" valign="top" width="100%" style="color: #9ea1a6; padding: 0 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="width:100%; background: #0e0b16;padding-bottom: 0px;">
                                    <tr>
                                        <td align="left" valign="top" style="padding:0 20px 20px 20px; font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">Welcome, <?= isset($username) ? $username : '' ?></p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                We will like to congratulate you on your decision to get healthy and fit. 
                                                We are thrilled that you’ve taken the first step. Now, let’s guild you to the finish line. 
                                            </p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                We will like to take this opportunity to introduce ourselves and provide you with a few tips to get you started on your fitness journey.
                                            </p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                First, here are a few things you should consider bringing with you to each session:
                                            </p>
                                            <ul type="none" style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                        A water bottle to keep hydrated before, during and after sessions</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                        A small towel to dry off during sessions</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">100% determination</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">100% persistence</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">100% Intensity  </span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <img src="<?= asset('userassets/images/icons/tick.png') ?>" alt="tick" />
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">100% consistency </span>
                                                </li>
                                            </ul>
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                Did you know we offer a range of classes, from beginners to advances? Our mission is to make your health and fitness journey experience fun and beneficial by providing you with not only vetted and certified professionals but fitness professionals who will guide, counsel, motivate, encourage and support you all in your journey for a healthier and happier life. All this at an affordable rate and to any location of your choice.
                                           </p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                Visit <a href="<?=url('search?search_type=trainer');?>"><?=url('search?search_type=trainer');?></a> to browse and book a session or class with one of our Health and Fitness Professionals.
                                           </p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                Also, did you know, with your passes, you can always book as an individual, couples, groups or join a class at no extra fee? If you’d like to get in touch with us directly, just email us at <a href='mailto:help@ebbsey.com'>help@ebbsey.com</a>
                                           </p> 
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;"> We hope you are as excited to get started as your trainers. Remember, it’s about progress, no magic pill.</p>
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
                                                        <p style="font-size: 12px; font-family: 'Helvetica',sans-serif;"><a href="<?= url('login') ?>" target="_blank" style="color: #f26824; font-size: 12px; font-family: 'Helvetica',sans-serif;"> Sign in to your account</a></p>
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