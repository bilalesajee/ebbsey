<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
           
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Ebbsey
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Coupon</h3>
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
                                    <form class="form-horizontal box-body setting_form" method="POST" action="<?= asset('add_coupon_admin'); ?>" enctype="multipart/form-data" autocomplete="off">
                                        <?= csrf_field() ?>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="title" class="control-label">Title</label>
                                                    <input type="text" class="form-control" placeholder="Title" name="title">

                                                    <?php if ($errors->has('title')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('title'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="valid_till" class="control-label">Valid Till</label>
                                                    <input type="text" class="form-control valid_untill" placeholder="Valid Till" name="valid_till">

                                                    <?php if ($errors->has('valid_till')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('valid_till'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="discount" class="control-label">Discount</label>
                                                    <input type="number" min="0" max="100" onkeyup="if(this.value > 100){this.value = null;}" class="form-control" placeholder="Discount" name="discount">

                                                    <?php if ($errors->has('discount')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('discount'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="discount" class="control-label">Number of passes</label>
                                                    <input type="number" class="form-control" placeholder="Number of passes" name="passes_count">

                                                    <?php if ($errors->has('passes_count')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('passes_count'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-success form-control">Add</button>
                                            </div>
                                        </div>
                                    </form>
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
            <script>
            $('.valid_untill').datepicker({
                autoclose: true,
                format: 'MM dd, yyyy'
            });
            </script>
        </div>
    </body>
</html>
