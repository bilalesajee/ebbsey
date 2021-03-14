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
                        <span>Fitness Card</span>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Fitness Card Detail</h3>
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
                                    <table id="datatable" class="display responsive nowrap cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th>Ordered By</th>  
                                                <th>Trainer Type</th>  
                                                <th>Referral code</th>  
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Referral Code</th> 
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th width="60px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($card_orders as $order) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php
                                                        echo $i;
                                                        $i++;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= asset('user_detail_admin/' . $order->cardsOrderBy->id) ?>"><?= $order->cardsOrderBy->first_name . ' ' . $order->cardsOrderBy->last_name ?></a>
                                                    </td>
                                                    <td> <?= ucfirst($order->trainer_type); ?> </td>
                                                    <td> <?= $order->referral_code ?> </td>
                                                    <td> <?= $order->email ?> </td>
                                                    <td> <?= $order->phone ?> </td>
                                                    <td> <?= $order->referral_code ?> </td> 
                                                    <td> $<?= $order->price; ?> </td>
                                                    <td> 

                                                        <?php if ($order->is_order_completed == 0) { ?>
                                                            Pending  <input type="checkbox" onclick="orderStatus(<?= $order->id ?>)"> 
                                                            <?php
                                                        } else {
                                                            echo 'Completed';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="60px" class="text-center"> 
                                                        <a href="javascript:void(0)"   onclick="deleteOrder(<?= $order->id ?>)" class="text-danger delete" style="margin-right: 10px;" data-toggle="tooltip" title="" data-original-title="DELETE FITNESS ORDER!"><i class="fa fa-trash-o"></i></a> 
                                                        <a href="<?= url('view_order_detail/' . $order->id); ?>" data-toggle="tooltip" title="" data-original-title="VIEW DETAIL!"><i class="fa fa-eye"></i></a>
                                                    </td>
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
<script>
    function orderStatus(order_id) {

        $('.confirm_message').html('Are you sure to mark this completed ?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'cards_order_status',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'order_id': order_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    window.location.href = base_url + 'business_cards_orders';
                }
            });
        });
    }

    function deleteOrder(order_id) {
        $('.confirm_message').html('Are you sure to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'deleteOrder',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'id': order_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'business_cards_orders';
                }
            });
        });
    }
</script>