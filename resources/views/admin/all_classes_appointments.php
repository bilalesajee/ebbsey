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
                        Classes Appointments
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Classes Appointments</h3>
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
                                                <th>Class Name</th>
                                                <th>Trainer</th>
                                                <th width="100px" class="text-center">Type</th>
                                                <th width="130px" class="text-center">Booked By</th>
                                                <th width="70px" class="text-center">Starting at</th>
                                                <th width="70px" class="text-center">Ending at</th>
                                                <th width="70px" class="text-center">Number of passes</th>
                                                <th width="70px" class="text-center">Amount</th>
                                                <th width="70px" class="text-center">Status</th>
                                                <th width="70px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($sessions as $session) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php echo $i;
                                            $i++;
                                                ?></td>
                                                    <td><a href="<?= asset('class_detail_admin/' . $session->classAppointment->id) ?>"><?= $session->classAppointment->class_name ?></a></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $session->appointmentTrainer->id) ?>"><?= $session->appointmentTrainer->first_name . ' ' . $session->appointmentTrainer->last_name ?></a></td>
                                                    <td width="100px" class="text-center"><?= $session->type; ?></td>
                                                    <td width="130px" class="text-center"><a href="<?= asset('user_detail_admin/' . $session->appointmentClient->id) ?>"><?= $session->appointmentClient->first_name . ' ' . $session->appointmentClient->last_name ?></a></td>
                                                    <td width="70px" class="text-center"><?= $session->start_time ?></td>
                                                    <td width="70px" class="text-center"><?= $session->end_time ?></td>
                                                    <td width="70px" class="text-center"><?= $session->number_of_passes ?></td>
                                                    <td width="70px" class="text-center"><?= $session->amount_to_transfer ? '$'.$session->amount_to_transfer : '' ?></td>
                                                    <td width="70px" class="text-center"><?= $session->status ?></td>
                                                    <td width="70px" class="text-center">
                                                        <?php if($session->status == 'completed' && $session->is_refunded == 0) { ?>
                                                            <a onclick="refund('<?=$session->id?>')" href="javascript:void(0)" class="btn btn-success">Refund</a></td>
                                                        <?php } else if($session->status == 'completed' && $session->is_refunded == 1) { ?>
                                                            Refunded
                                                        <?php } ?>
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
    function refund(id) {
        $('.confirm_message').html('Are you sure that you want to refund this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'refund_appointment_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'id': id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        });
    }
</script>
