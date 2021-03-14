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
                            <tr>
                        <td align="center" valign="top" width="100%" style="color: #1f1f1f;padding: 0 35px;">
                            <table border="0" cellpadding="20" cellspacing="0" width="700" id="emailContainer" style="background: #0e0b16;padding-bottom: 0px;">
                              
                                <tr>
                                    <td align="left" valign="top" style="font-size:25px;padding:0 20px 0px 20px;font-family: 'Lato';color: #fff;text-align: center; ">
                                        Your Class Summary
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="font-size:25px;padding:0 20px 20px 20px;font-family: 'Lato';color: #fff;text-align: center; ">
                                        <p style="padding:0;margin:10px 0 0 0 ;font-size: 15px;color:#cecece; "><?=date('M m, Y', strtotime($class_data->created_at))?></p>
                                    </td>
                                </tr>
                                
                                 <tr>
                                    <td align="left" valign="top" style="font-size:25px;padding:40px 20px 40px 20px;font-family: 'Lato';color: #fff; ">
                                        <table  cellpadding="20" cellspacing="0"  style="border:1px solid #803a1d;background: #0e0b16;padding-bottom: 0px;width: 500px;margin: 0 auto;">
                                            <thead>
                                                <tr>
                                                    <td colspan="3" style="text-align: center;background-color: #f26824">
                                                        <?=$class_data->class_name?>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td  valign="top" style="border:0;font-size:15px;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">Duration</td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">Class Type</td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">Student</td>
                                            </tr>  
                                            <tr>
                                                <td  valign="top" style="border:0;font-size:15px;padding:15px;font-family: 'Lato';color: #626262; text-align: center;"><?=$class_data->start_date.' to '.$class_data->end_date?></td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;text-transform: uppercase;"><?=$class_data->class_type?></td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;"><?=count($class_data->countSpot);?></td>
                                            </tr> 
                                            
                                        </table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td align="left" valign="top" style="font-size:25px;padding:40px 20px 40px 20px;font-family: 'Lato';color: #fff; ">
                                        <table  cellpadding="20" cellspacing="0"  style="border:1px solid #803a1d;background: #0e0b16;padding-bottom: 0px;width: 500px;margin: 0 auto;">
                                            <thead>
                                                <tr>
                                                    <td colspan="3" style="text-align: center;background-color: #f26824">
                                                        Student Detail
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td  valign="top" style="border:0;font-size:15px;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">Student Name</td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">No of passes</td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;">Email</td>
                                            </tr>
                                            <?php 
                                            $total_pas = 0;
                                            if(isset($class_data->countSpot) && count($class_data->countSpot)>0){
                                                foreach($class_data->countSpot as $val) {
                                                    $total_pas = ($total_pas+$val->number_of_passes);
                                                    ?>
 
                                            <tr>
                                                <td  valign="top" style="border:0;font-size:15px;padding:15px;font-family: 'Lato';color: #626262; text-align: center;"><?=$val->appointmentTrainer->first_name.' '.$val->appointmentTrainer->last_name;?></td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;text-transform: uppercase;"><?=$val->number_of_passes?></td>
                                                <td  valign="top" style="font-size:15px;border:0;padding:15px;font-family: 'Lato';color: #626262; text-align: center;"><?=$val->appointmentTrainer->email?></td>
                                            </tr>
                                            <?php } } ?>
                                            
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="padding:15px;font-size:15px;color:#fff;font-family: 'Lato';text-align: center;">
                                       Today your earning of classes is :
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="padding:15px;font-size:25px;color:#fff;font-family: 'Lato';text-align: center;">
                                       <?php $total_price = ($total_pas*$price)?>
                                        $ <?= number_format(round($total_price, 2), 2);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" style="padding:35px 20px 35px 20px;font-size:15px;color:#1f1f1f;font-family: 'Lato'; ">
                                        <a href="<?=url('class-view').'/'.$class_data->id;?>" target="_blank" style="color: #fff;text-transform: uppercase;background-color: #f26824;padding: 10px 30px;border-radius: 4px;text-decoration: none;">View Detail</a>
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
                                                        <a href="#" style="color: #fff;text-decoration: none;">Copyright Ebssey, 2018</a>
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