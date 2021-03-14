<?php
$segment = Request::segment(1);
$current_id = '';
$current_name = '';
$current_user = '';
$current_user_type = '';
$current_photo = asset('public/images/users/default.jpg');
$current_email = '';
//$full_name = '';
if (Auth::user()) {
    $current_id = Auth::user()->id;
    $current_email = Auth::user()->email;
    $current_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
    $current_user = Auth::user();
    $current_user_type = Auth::user()->user_type;
    if (Auth::user()->image) {
        $current_photo = asset('public/images/' . Auth::user()->image);
    } else {
        $current_photo = asset('public/images/users/default.jpg');
    }
//    $full_name = $current_user->first_name . ' ' . $current_user->last_name;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="<?= csrf_token(); ?>">
        <?php if ($segment == 'messages') { ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <?php } else { ?>
            <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
        <?php } ?>
        <title><?= $title ?></title> 
        <meta property="og:url"                content="<?=url('/')?>" />
        <meta property="og:type"               content="article" />
        <meta property="og:title" content="Ebbsey">
        <meta property="og:description" content="Sore Today, Strong Tomorrow. Connecting you with the most highly passionate, experienced health and fitness professionals in the industry to ensure you reach your maximum potential in the shortest time possible regardless of your location or hectic lifestyle. We strive to promote a healthier and happier community." /> 
        <meta property="og:image"  content="https://www.ebbsey.com/userassets/images/home-slide.jpg" />

        <?php include resource_path('views/includes/top.php'); ?>   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script> 
        <script>
            var socket = io('<?= env('SOCKETS') ?>');
            base_url = "<?= asset('/'); ?>";
        </script>
    </head>
    <body>
        <header class="header">
            <?php
            if ($segment !== 'messages') {
                ?>
                <div class="topbar">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 d-none d-xs-none d-md-block">
                                <div class="booking">
                                    <span>Booking time Mon-Fri 5:30am - 9:30pm Sat-Sun 7:00am - 9:30pm</span>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12 ml-auto">
                                <div class="search">
                                    <form method="get" action="<?= asset('search') ?>" class="d-flex">
                                        <label>Quick Search</label>
                                        <input type="hidden" name="search_type" value="trainer">
                                        <input <?php if (isset($_GET['keyword'])) { ?> value="<?= $_GET['keyword'] ?>" <?php } ?> name="keyword" type="search" class="searchfield">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- top bar -->
            <?php } ?>
            <nav class="main-nav">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <div class="logo">
                                <a href="<?= asset('/'); ?>">
                                    <img src="<?= asset('userassets/images/logo.png') ?>" class="img-fluid" alt="Ebbsey" />
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="header-menu d-flex align-items-center justify-content-end">
                                <ul class="navigation">
                                    <li class="<?= (Request::segment(1) == 'search' && ( isset($_GET['type']) && $_GET['type'] == 'trainer')) ? 'active' : '' ?>"><a href="<?= url('search?search_type=trainer'); ?>">Find Professionals</a></li>
                                    <li class="<?= (Request::segment(1) == 'search' && ( isset($_GET['type']) && $_GET['type'] == 'class')) ? 'active' : '' ?>"><a href="<?= url('search?search_type=class'); ?>">Find Classes</a></li>
                                    <!--<li class="<?= (Request::segment(1) == 'blog') ? 'active' : '' ?>"><a href="<?= asset('blog') ?>">Blog</a></li>-->
                                    <li class="<?= (Request::segment(1) == 'about') ? 'active' : '' ?>"><a href="<?= asset('about') ?>">About</a></li>
                                    <li class="<?= (Request::segment(1) == 'contact') ? 'active' : '' ?>"><a href="<?= asset('contact') ?>">Contact</a></li>
                                    <?php if (isset($current_user) && $current_user != null) { ?>
                                        <li class="setting_listitem"><a href="<?= $current_user_type == 'trainer' ? asset('/trainer-profile') : asset('/user-profile') ?>"> 
                                                <span class="profile-pic rounded-circle" style="background-image: url('<?= $current_photo ?>') "></span><?= ucfirst($current_user->first_name); ?></a>
                                            <ul>
                                                <?php if ($current_user->is_approved_by_admin == 1) { ?>
                                                    <?php if ($current_user_type == 'trainer') { ?>
                                                        <li class="earnings">
                                                            <a href="javascript:void(0)">
                                                                <span onclick="window.location = '<?= asset('earning_history?type=balance') ?>'">
                                                                    <strong>Your Balance</strong>
                                                                    <strong class="amount" id="total_amount">$<?= number_format(round($current_user->total_cash, 2), 2) ?></strong>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li><a href="<?= url('classes'); ?>">Classes</a></li>
                                                        <li>
                                                            <a href="<?= asset('appointments') ?>"> Appointment 
                                                                <span class="badge unseen_appointments"><?= getUnseenAppointmentsForTrainer() ? getUnseenAppointmentsForTrainer() : '' ?></span>
                                                            </a>
                                                        </li>
                                                        <li><a href="<?= url('order_card') ?>"> Fitness Card </a></li>
                                                        <li><a href="<?= asset('earning_history?type=earning') ?>"> Earning History </a></li>
                                                        <?php if(!$current_user->is_bank_account_verified) { ?>
                                                        <li><a class="blink" href="<?= asset('bank_tab?connect_stripe=1') ?>"> Connect Stripe </a></li>
                                                        <?php } ?>   
                                                    <?php } ?>   


                                                    <li onclick="readMessage('unread_messages')">
                                                        <a href="<?= asset('messages') ?>"> Messages 
                                                            <span class="badge unread_messages"><?= getUnreadMessages() ? getUnreadMessages() : '' ?></span>
                                                        </a>
                                                    </li>
                                                    <li><a href="<?= $current_user_type == 'trainer' ? asset('/trainer-profile') : asset('/user-profile') ?>"> My Profile </a></li>
                                                    <li><a href="<?= $current_user_type == 'trainer' ? asset('/edit-trainer-profile') : asset('/edit-user-profile') ?>"> Edit Profile </a></li>
                                                    <li class='google_calendar'>
                                                        <form method="post" action="<?= asset('sync_google_calendar') ?>">
                                                            <input onChange="this.form.submit()" type="checkbox" name="value" <?= isset($current_user->google_access_token) ? 'checked' : '' ?>> 
                                                            Sync Google Calendar
                                                            <input type="hidden" name="_token" value=" <?= csrf_token() ?>">
                                                        </form>
                                                    </li>
                                                <?php } ?>
                                                <li><a href="<?= asset('user-logout') ?>"> Logout </a></li>
                                            </ul>
                                        </li>
                                    <?php } else { ?>
                                        <li class="<?= (Request::segment(1) == 'login') ? 'active' : '' ?>"><a href="<?= asset('/login') ?>">Login</a></li>
                                        <li  class="<?= (Request::segment(1) == 'join-now') ? 'active' : '' ?>"><a href="<?= asset('/join-now') ?>">Join Now</a></li>
                                    <?php } ?>
                                    <?php if (isset($current_user) && $current_user != null) { ?>
                                        <?php if ($current_user_type == 'user') { ?>
                                                                <!--<li><a href="<?= asset('get_passes') ?>">Get Passes</a></li>-->
                                        <?php } ?>
                                    <?php } ?>  
                                </ul>
                                <ul class="social">
                                    <li><a href="https://www.facebook.com/Ebbseys/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/ebbseys/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav> <!-- Navigation bar -->
            <div class="mobile_header">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <div class="logo">
                                <a href="<?= asset('/'); ?>">
                                    <img src="<?= asset('userassets/images/logo.png') ?>" class="img-fluid" alt="Ebbsey" />
                                </a>
                            </div>
                            <div class="menu_button ml-auto">
                                <div class="bars">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- mobile header -->
        </header>
        <div class="gap_fixed_header <?= $segment == 'messages' ? 'messages' : '' ?>"></div>
        <div class="mobile_menu_wrap <?= $segment == 'messages' ? 'messages' : '' ?>">
            <div class="mobile_profile">
                <?php if (Auth::user()) { ?>
                    <div class="profile_setting d-flex align-items-center">
                        <div class="profile_info d-flex align-items-center">
                            <div class="image">
                                <div class="img" style="background-image: url(<?= $current_photo ?>)"></div>
                            </div>
                            <div class="info">
                                <div class="type"><?= ucfirst($current_name); ?></div>
                            </div>
                        </div>
                        <div class="edit_profile ml-auto">
                            <a href="<?= $current_user_type == 'trainer' ? asset('/edit-trainer-profile') : asset('/edit-user-profile') ?>" class="btn orange">Edit Profile</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="profile_btns d-flex justify-content-between">
                        <div>
                            <a href="<?= asset('join-now') ?>" class="btn black btn-lg">Signup</a>
                        </div>
                        <div>
                            <a href="<?= asset('login') ?>" class="btn orange btn-lg">Login</a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Auth::user() && Auth::user()->user_type == 'user_type') { ?>
                    <div class="earning d-flex align-items-center">
                        <strong class="earning_label">Your Balance</strong> 
                        <strong class="amount ml-auto" id="total_amount">$<?= number_format(round($current_user->total_cash, 2), 2) ?></strong>
                    </div>
                <?php } ?> 
            </div>

            <ul class="mobile_navigation">
                <?php if (Auth::user()) { ?>
                    <?php if ($current_user->is_approved_by_admin == 1) { ?>
                        <li><a href="<?= $current_user_type == 'trainer' ? asset('/trainer-profile') : asset('/user-profile') ?>"> My Profile </a></li>
                        <li><a href="<?= $current_user_type == 'trainer' ? asset('/edit-trainer-profile') : asset('/edit-user-profile') ?>"> Edit Profile </a></li>
                        <li onclick="readMessage('unread_messages')">
                            <a href="<?= asset('messages') ?>"> Messages 
                                <span class="badge unread_messages"><?= getUnreadMessages() ? getUnreadMessages() : '' ?></span>
                            </a>
                        </li>
                        <?php if ($current_user_type == 'user') { ?>
                                                <!--<li><a href="<?= asset('get_passes') ?>">Get Passes</a></li>-->
                        <?php } ?>
                        <?php if ($current_user_type == 'trainer') { ?>
                            <li><a href="<?= url('classes'); ?>">Classes</a></li>
                            <li>
                                <a href="<?= asset('appointments') ?>"> Appointment 
                                    <span class="badge unseen_appointments"><?= getUnseenAppointmentsForTrainer() ? getUnseenAppointmentsForTrainer() : '' ?></span>
                                </a>
                            </li>
                            <li><a href="<?= url('order_card') ?>"> Business card </a></li>
                            <li><a href="<?= asset('earning_history?type=earning') ?>"> Earning History </a></li>
                            <?php if(!$current_user->is_bank_account_verified) { ?>
                                <li><a class="blink" href="<?= asset('bank_tab?connect_stripe=1') ?>"> Connect Stripe </a></li>
                            <?php } ?>   
                        <?php } ?>    
                    <?php } ?>    
                    <li><a href="<?= asset('user-logout') ?>"> Logout </a></li>
                <?php } else { ?>    
                    <li class="<?= (Request::segment(1) == 'search') ? 'active' : '' ?>"><a href="<?= url('search?search_type=class'); ?>">Find Professionals & Classes</a></li> 
                    <li class="<?= (Request::segment(1) == 'contact') ? 'active' : '' ?>"><a href="<?= asset('contact') ?>">Contact</a></li>
                <?php } ?>    
            </ul>
        </div>
        <div class="sticky_notification">
            <div class="alert alert-success custom_alert" style="display: none">
                <div class="alert-content"></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>        
            </div>
        </div>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129788347-1"></script>
        <script>
                            window.dataLayer = window.dataLayer || [];
                            function gtag() {
                                dataLayer.push(arguments);
                            }
                            gtag('js', new Date());

                            gtag('config', 'UA-129788347-1');
        </script>