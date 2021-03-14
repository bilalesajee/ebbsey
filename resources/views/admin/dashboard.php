<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Ebbsey</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('trainers_admin') ?>"><div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-address-card"></i></span>
                                    <a href="<?= asset('trainers_admin') ?>">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Trainers</span>
                                            <span class="info-box-number"><?= $count_trainers ?></span>
                                        </div>
                                    </a>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('users_admin') ?>"><div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                                    <a href="<?= asset('users_admin') ?>">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Users</span>
                                            <span class="info-box-number"><?= $count_users ?></span>
                                        </div>
                                    </a>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('trainer_approvals') ?>"><div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-address-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Approval Requests</span>
                                        <span class="info-box-number"><?= $trainer_account_requests ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('feedbacks') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-star"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Feedback</span>
                                        <span class="info-box-number"><?= $feedbacks_count ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="clearfix visible-sm-block"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box box-green">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Latest Trainers</h3>
                                            <div class="box-tools pull-right">
                                                <span class="label label-danger"><?php if ($count_trainers < 9) { ?><?= $count_trainers ?> New Members<?php } else { ?> 8 New Members<?php } ?> </span>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="users-list clearfix">
                                                <?php
                                                if (isset($latest_trainers)) {
                                                    foreach ($latest_trainers as $latest_trainer) {
                                                        ?>
                                                        <li>
                                                            <a href="<?= asset('user_detail_admin/' . $latest_trainer->id) ?>" >
                                                                <div class="dashboard_user_image">
                                                                    <img src="<?= asset('adminassets/images/spacer.png') ?>" alt="" class="spacer" />
                                                                    <?php if ($latest_trainer->image) { ?>
                                                                        <div class="user_profile_pic" style="background-image:url('<?php echo asset('public/images/' . $latest_trainer->image) ?>')"></div>
                                                                    <?php } else { ?>
                                                                        <div class="user_profile_pic" style="background-image:url('<?php echo asset('public/images/users/default.jpg'); ?>')"></div>
                                                                    <?php } ?>
                                                                </div>
                                                                    <?= strlen($latest_trainer->first_name) + strlen($latest_trainer->last_name) > 15 ? substr( $latest_trainer->first_name.' '. $latest_trainer->last_name, 0, 15) : $latest_trainer->first_name.' '. $latest_trainer->last_name ?> 
                                                            </a>
                                                            <span class="users-list-date">
                                                                <?php
                                                                $join_date = $latest_trainer->created_at;
                                                                $date = date('F d, Y', strtotime($join_date));
                                                                echo $date;
                                                                ?>
                                                            </span>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </ul>
                                            <!-- /.users-list -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-green">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Latest Users</h3>
                                            <div class="box-tools pull-right">
                                                <span class="label label-danger"><?php if (isset($count_users) && $count_users < 9) { ?><?= $count_users ?> New Members<?php } else { ?> 8 New Members<?php } ?> </span>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="users-list clearfix">
                                                <?php
                                                if (isset($latest_users)) {
                                                    foreach ($latest_users as $latest_user) {
                                                        ?>
                                                        <li>
                                                            <a href="<?= asset('user_detail_admin/' . $latest_user->id) ?>" >
                                                                <div class="dashboard_user_image">
                                                                    <img src="<?= asset('adminassets/images/spacer.png') ?>" alt="" class="spacer" />
                                                                    <?php if ($latest_user->image) { ?>
                                                                        <div class="user_profile_pic" style="background-image:url('<?php echo asset('public/images/' . $latest_user->image) ?>')"></div>
                                                                    <?php } else { ?>
                                                                        <div class="user_profile_pic" style="background-image:url('<?php echo asset('public/images/users/default.jpg'); ?>')"></div>
                                                                    <?php } ?>
                                                                </div>

                                                                <?= $latest_user->first_name ?> 
                                                                <?= $latest_user->last_name ?>
                                                            </a>
                                                            <span class="users-list-date">
                                                                <?php
                                                                $join_date = $latest_user->created_at;
                                                                $date = date('F d, Y', strtotime($join_date));
                                                                echo $date;
                                                                ?>
                                                            </span>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- /.content -->
                    </div>
                    <!-- /.content-wrapper -->
                </section> 
            </div>
            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
