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
                        Feedback
                        <small>Ebbsey</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Feedback</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php if (Session::has('success')) { ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('success') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (Session::has('error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('error') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($errors->any()) { ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach ($errors->all() as $error) { ?>
                                                    <li><?= $error ?></li>
                                                <?php }
                                                ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <table id="datatable" class="display responsive cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th width="250px">Name</th>
                                                <th>Message</th>
                                                <th width="200px">Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($feedbacks as $feedback) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php echo $i; $i++; ?></td>
                                                    <td width="250px"><?= $feedback->name ?></td>
                                                    <td><?=$feedback->message?></td>
                                                    <td width="200px"><?= $feedback->email ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>