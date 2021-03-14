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
                        Trainer Account Approval Requests
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
                                    Approval Requests
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
                                                <th>Sr#</th>
                                                <th>Image</th>
                                                <th>Trainer Name</th>
                                                <th>Email</th>
                                                <th>SSN#</th> 
                                                <th>Phone</th> 
                                                <th>Trainer Type</th>
                                            
                                                <th>Go to</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($users as $user) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="table_img"> 
                                                        <img src="<?= $user->image != null ? asset('public/images/' . $user->image) : asset('public/images/users/default.jpg') ?>">
                                                    </td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $user->id) ?>"><?= $user->first_name . ' ' . $user->last_name ?></a></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $user->id) ?>"><?= $user->email ?></a></td>

                                                    <td><?= $user->ssn ?></td>
                                                    <!--<td><?= $user->dob ?></td>-->
                                                    <!--<td><?= $user->address ?></td>-->
                                                    <td><?= $user->phone ?></td>
                                                    <!--<td><?= $user->experience ?></td>-->
                                                    <td> <?php
                                                        $j = 1;
                                                        foreach ($user->trainerTrainingTypes as $types) {
                                                            ?> <?= $types->trainingTypes->title ?>  <?php
                                                            if ($j < $user->trainerTrainingTypes->count()) {
                                                                echo ',';
                                                            } $j++;
                                                        }
                                                        ?> </td> 
                                                    <td>
                                                        <a href="<?= asset('user_detail_admin/' . $user->id) ?>" class="btn btn-info"> Profile <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                                    </td>

                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
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
    function deleteUser(user_id) {
        $('.confirm_message').html('Are you sure that you want to remove this user?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        .one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_user_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'user_id': user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'trainer_approvals';
                }
            });
        });
    }
</script>
<script>
    function approveTrainer(trainer_id) {
        $('.confirm_message').html('Are you sure that you want to approve this trainer ?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        .one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'approve_trainer',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'trainer_id': trainer_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'trainer_approvals';
                }
            });
        });
    }
    function denyTrainer(trainer_id) {
        
        $('.confirm_message').html('Are you sure that you want to deny this trainer request ?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        })
        .one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'deny_trainer_request',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'trainer_id': trainer_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'trainer_approvals';
                }
            });
        }); 
    }
</script>