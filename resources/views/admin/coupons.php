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
                        <Blogs
                        <small>Ebbsey</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Coupons</h3>
                                    <a href="<?=url('add_coupon_admin');?>" class="btn btn-success pull-right">Add Coupon</a>
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
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Title</th>
                                                <th>Code</th>
                                                <th>Valid Till</th>
                                                <th>Discount</th>
                                                <th>Number of Passes</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($result as $val) { ?>
                                                <tr>
                                                    <td><?php echo $i;  ?></td>
                                                    <td> 
                                                       <?=$val->title?>
                                                    </td>
                                                    <td>
                                                        <?=$val->code?>
                                                    </td> 
                                                    <td>
                                                        <?=date('F d, Y', strtotime($val->valid_till))?>
                                                    </td> 
                                                    <td>
                                                        <?=$val->discount?>%
                                                    </td> 
                                                    <td>
                                                        <?=$val->passes_count?>
                                                    </td> 
                                                    <td>
                                                        <a href="<?=asset('delete_coupon').'/'.$val->id;?>" onclick="return confirm('Are you sure to delete this?');" class="text-danger delete"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            <?php $i++; } ?>
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
