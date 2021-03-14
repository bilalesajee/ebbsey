<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Order Detail
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <?php if ($result->type == 'simple' || $result->type == 'both' || $result->type == '') { ?>
                                        <h3 class="profile-username text-center"><b>Partners Business Card</b></h3>

                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>First Name</b> <p class="pull-right"><?= $result->first_name ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Last Name</b> <p class="pull-right"><?= $result->last_name ?></p>
                                            </li>
                                            <!--                                        <li class="list-group-item">
                                                                                        <b>User Type</b> <p class="pull-right"><?= ucfirst($result->cardsOrderBy->user_type); ?></p>
                                                                                    </li>-->
                                            <li class="list-group-item">
                                                <b>Phone </b> <p class="pull-right"><?= $result->phone; ?></p> 
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b> <p class="pull-right"><?= $result->email ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Address</b> <p class="pull-right"><?= $result->address ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Referral code</b> <p class="pull-right"><?= $result->referral_code ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Profile URL</b> <p class="pull-right"><?= $result->url; ?></p>
                                            </li>

                                            <li class="list-group-item">
                                                <b>Amount</b> 
                                                <p class="pull-right">
                                                    <?php echo '$' . $result->price; ?>
                                                </p> 
                                            </li> 
                                            <li class="list-group-item">
                                                <b>Payment Type</b> 
                                                <p class="pull-right">
                                                    <?php
                                                    if ($result->pay_later == 1) {
                                                        echo 'Pay Later';
                                                    } else {
                                                        echo 'Paid online';
                                                    }
                                                    ?>
                                                </p> 
                                            </li> 
                                        </ul>
                                        <?php
                                    }
                                    if ($result->type == 'custom' || $result->type == 'both') {
                                        ?>

                                        <h3 class="profile-username text-center"><b>Partners Profile Shoot</b></h3>
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>Date</b> <p class="pull-right"><?= $result->shot_date ?></p>
                                            </li> 
                                            <li class="list-group-item">
                                                <b>Order Time</b> <p class="pull-right"><?= $result->order_time ?></p>
                                            </li>
                                            <?php if ($result->client_location) { ?>
                                                <li class="list-group-item">
                                                    <b>Client Location</b> <p class="pull-right"><?= $result->client_location ?></p>
                                                </li>
                                            <?php } ?>
                                            <li class="list-group-item">
                                                <b>Amount</b> 
                                                <p class="pull-right">
                                                    <?php echo '$' . $result->price; ?>
                                                </p> 
                                            </li> 
                                            <li class="list-group-item">
                                                <b>Payment Type</b> 
                                                <p class="pull-right">
                                                    <?php
                                                    if ($result->pay_later == 1) {
                                                        echo 'Pay Later';
                                                    } else {
                                                        echo 'Paid online';
                                                    }
                                                    ?>
                                                </p> 
                                            </li> 


                                        </ul>
                                    <?php } ?>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <!-- /.row -->

                </section>
                <!-- /.content -->
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
