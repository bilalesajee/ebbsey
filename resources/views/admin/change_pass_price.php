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
                        <small>Ebbsey</small>
                        Change Pass Price
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <form action="<?= asset('pass_price') ?>" method="post">
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
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="text" name="current_price" class="form-control" value="<?= isset($pass_price->price)? $pass_price->price:'Price not set yet!' ?>" disabled="true"><br>
                                    <input type="text" name="new_price" class="form-control" placeholder="New Price"><br>
                                    <input type="hidden" name="pass_id" class="form-control" value="<?= isset($pass_price->id)? $pass_price->id:''; ?>"><br>
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                                </form>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </section> 
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
