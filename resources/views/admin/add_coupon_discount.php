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
                        Ebbsey
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content" style="min-height: 25px;padding: 0px;">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Add More Coupon Discount</h3>
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
                                    <form class="form-horizontal box-body setting_form" method="POST" action="<?= asset('add_coupon_discount_admin'); ?>" enctype="multipart/form-data" autocomplete="off">
                                        <?= csrf_field() ?>
                                            <div class="col-sm-4">
                                                <div class="form-group"  style="margin-right: 5px;">
                                                    <label for="discount" class="control-label">Number of Passes</label>
                                                    <input type="number" class="form-control" placeholder="Number of passes" name="passes_count">

                                                    <?php if ($errors->has('passes_count')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('passes_count'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="discount" class="control-label">Discount</label>
                                                    <input type="number" step="0.01" min="0" max="100" onkeyup="if(this.value > 100){this.value = null;}" class="form-control" placeholder="Discount" name="discount">

                                                    <?php if ($errors->has('discount')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('discount'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <div class="col-sm-1" style="margin-top: 26px;">
                                            <button type="submit" class="btn btn-success form-control">Add</button>
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
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Number of Passes</th>
                                                <th>Discount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($result as $val) { ?>
                                                <tr>
                                                    <td><?php echo $i;  ?></td>
                                                    <td>
                                                        <?=$val->no_of_coupons?>
                                                    </td> 
                                                    <td>
                                                        <?=$val->discount?>%
                                                    </td>
                                                    <td>
                                                        <a href="<?=asset('delete_coupon_discount').'/'.$val->id;?>" onclick="return confirm('Are you sure to delete this?');" class="text-danger delete"><i class="fa fa-trash-o"></i></a>
                                                        <a href="javascript:void(0)" onclick="editDiscount(<?= $val->id ?>)" data-discount="<?=$val->discount?>" data-coupons="<?=$val->no_of_coupons?>" class="text-danger edit_discount" style="margin-right: 10px;" data-toggle="tooltip" title="Edit Discount!"><i class="fa fa-edit"></i></a> 
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
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 750px;margin: 180px auto;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Discount</h5>
<!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>-->
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal box-body setting_form" method="POST" action="<?= asset('add_coupon_discount_admin'); ?>" enctype="multipart/form-data" autocomplete="off">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="discount" class="control-label">Number of Passes</label>
                                            <input type="number" class="form-control" placeholder="Number of passes" id="passes_count" name="passes_count">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="discount" class="control-label">Discount</label>
                                            <input type="number" id="discount" step="0.01" min="0" max="100" onkeyup="if(this.value > 100){this.value = null;}" class="form-control" placeholder="Discount" name="discount" value="">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-primary" id="edit">Done</button>
                        </div>
                    </div>
                </div>
            </div> 
            <script>
    function editDiscount(discount_id) {
        var passes = $('.edit_discount').attr('data-coupons');
        var discount_val = $('.edit_discount').attr('data-discount');
        $('#passes_count').val(passes);
        $('#discount').val(discount_val) ;
        $('#editModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#edit', function (e) {
            var new_pass_val = $('#passes_count').val();
            var new_discount = $('#discount').val();
            $.ajax({
                url: base_url + 'edit_coupon_discount',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'id': discount_id,'discount':new_discount,'passes':new_pass_val,'_token' : '<?= csrf_token() ?>'},
                success: function (data) {
                    location.reload();
                }
            });
        });
    }
    </script>
        </div>
    </body>
</html>
