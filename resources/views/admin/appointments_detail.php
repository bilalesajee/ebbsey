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
                        <?= $dataType == "session" ? "Sessions" : "Classes" ?>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><?= $dataType == "session" ? "Sessions" : "Classes" ?></h3>
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
                                                <th width="80px" class="text-center">Class Trainer</th>
<!--                                                <th>Class Spots</th>
                                                <th>Total Participants</th>-->
                                                <th>Class Location</th>
                                                <th>Class Type</th>
<!--                                                <th>Start date</th>
                                                <th>End date</th>-->
                                                <!--<th>Status</th>-->
                                                <th>Feature Class</th>
                                                <th>View Class Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($classes as $class) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php echo $i;
                                            $i++; ?></td>
                                                    <td width="80px" class="text-center"><a href="<?= asset('user_detail_admin/' . $class->classtTrainer->id) ?>"><?= $class->classtTrainer->first_name . ' ' . $class->classtTrainer->last_name ?></a></td>
    <!--                                                    <td><?= $class->spot ?></td>
                                                    <td><?= $class->participants ?></td>-->
                                                    <td><?= $class->location ?></td>
                                                    <td><?= isset($class->class_type) ? $class->class_type : 'N/A' ?></td>
                                                    <!--<td><?= isset($class->classtType->title) ? $class->classtType->title : 'N/A' ?></td>-->
    <!--                                                    <td><?= $class->start_date ?></td>
                                                    <td><? = $class->end_date ?></td>-->
                                                    <!--<td><?= $class->status ?></td>-->
                                                    <td><a href="javascript:void(0)" onclick="featureClass(<?= $class->id ?>)"><?= $class->is_featured_by_admin == 0 ? 'Feature this class' : 'Unfeatured this class' ?></a></td>
                                                    <td><a href="<?= asset('class_detail_admin/' . $class->id) ?>" class="btn btn-info">View Detail</a></td>

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
    function featureClass(class_id) {
        $('.confirm_message').html('Are you sure that you want to make this class featured?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'feature_class',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'class_id': class_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    }
                    window.location.href = base_url + 'all_classes';
                }
            });
        });

    }
</script>

