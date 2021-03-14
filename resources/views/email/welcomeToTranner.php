<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome <?= isset($title) ? $title : '' ?></title>
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
                                            <h2 style="font-size:21px; color:#f26824; font-family: 'Helvetica',sans-serif; ">Welcome</h2>
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
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">Hi <?= isset($title) ? $title : '' ?>,</p>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">
                                                Thank you for your interest in the Health and Fitness Professional Partnership at Ebbsey. Our apologies for the delay, but we had to verify your credentials, skills, disciplines and overall background as we owe it to our customers that we have the highest- caliber health and fitness professional in the community.  
                                            </p>

                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; "> 
                                                After carefully vetting, we are honored and pleased with your Health and Fitness background and would love to partner with you in providing a healthier and happier community. 
                                            </p> 
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; "> 
                                                If you agree to accept this offer, you will be eligible for the following in accordance with our Health and Fitness Professional payment structure.

                                            </p> 

                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">Starting Rate <strong style="color: #f26824;">$35.00</strong></p>

                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; font-style: italic; text-decoration: underline; "><strong> Additional </strong></p>
                                            <ul type="disc" style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Morning sessions <strong style="color: #f26824;">$10.00</strong> per session between Morning- (5:30am – 8:30am)</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Couples, Groups & Classes <strong style="color: #f26824;">$20.00</strong> per person/booking (Starting with the 2nd person).</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Referrals Code <strong style="color: #f26824;">$5.00</strong> (Any number of passes purchased with your code will be additional but if the same customer books appt with another trainer you do not receive the $5.</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Client-No Show or After 24 hours Cancellation -<strong style="color: #f26824;">$35.00</strong>  per session or per person at flat fee whichever applies to your session type: Individual, Couple or Group / Class (Excluding session rate and other additions).</span>
                                                </li>

                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Travel -<strong style="color: #f26824;">$ .80</strong> per mile (Starting point: From your home address)</span>
                                                </li>

                                            </ul>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; text-decoration: underline;font-style: italic;"><strong> Deductions  </strong></p>
                                            <ul type="disc" style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;">
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Ebbsey <strong style="color: #f26824;">20%</strong> per session</span>
                                                </li>
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Direct Deposit fee <strong style="color: #f26824;">$1.50</strong> per weekly payout</span>
                                                </li>
                                                <!--                                                <li style="color: #f26824;"> 
                                                                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Instant payout<strong style="color: #f26824;"> $10.00 (optional)</strong></span>
                                                                                                </li>-->
                                                <li style="color: #f26824;"> 
                                                    <span style="color:#9ea1a6; font-family:'Helvetica',sans-serif;">Trainer cancellation / Trainer No- Show or failure to refer and accepted by another trainer - <strong style="color: #f26824;">$35.00 </strong> per session</span>
                                                </li>

                                            </ul>
                                            <p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; ">Your referral code is <strong style="color: #f26824;"><?= isset($referral_code) ? $referral_code : ''; ?></strong></p>
                                            <!--<p style="font-size:14px; color:#9ea1a6; font-family: 'Helvetica',sans-serif; "><strong>Earning and Payment: </strong>Connect with stripe to get paid at www.ebbsey/edit-trainer-profile. </p>-->
                                            <p style="font-size:14px; color:#9ea1a6; font-family:'Helvetica',sans-serif;"> All weekly payouts will be sent out on Wednesdays <br>
                                               To accept this partnership, login in with the email and password you created. Once again, Welcome to the Ebbsey. Feel free to email us at <a href='mailto:support@ebbsey.com'>support@ebbsey.com</a> if you have any questions or concerns.
                                            </p>  
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