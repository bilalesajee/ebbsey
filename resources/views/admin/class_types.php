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
                        <span>Class Types</span>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <?php if (session()->has('success')) { ?>
                                        <div class="text-success"><?php echo Session::get('success'); ?></div>
                                    <?php } ?>
                                    <?php if (session()->has('error')) { ?>
                                        <div class="text-danger"><?php echo Session::get('error'); ?></div>
                                    <?php } ?>
                                    <h3 class="box-title form-titles"><?php if (isset($class_type)) { ?>Edit<?php } else { ?>Add New <?php } ?> Class Types</h3>

                                    <form method="POST" class="dentist-specialists" <?php if (isset($class_type)) { ?> action="<?= asset('edit_class_type'); ?>" <?php } else { ?> action="<?= asset('add_class_type'); ?>" <?php } ?> >
                                        <?= csrf_field() ?>
                                        <input type="text" name="title" <?php if (isset($class_type)) { ?>value="<?= $class_type->title ?>"<?php } ?> class="col-md-3" required="required"/>
                                        <?php if (isset($class_type)) { ?> 
                                            <input type="hidden" name="class_type_id" value="<?= $class_type->id; ?>">
                                        <?php } ?>
                                        <?php if (isset($class_type)) { ?> 
                                            <button type="submit" class="btn btn-success" style="margin-left: 15px;line-height: 0.8;">Update</button>
                                            <a href="<?= asset('class_types') ?>" class="btn btn-danger" style="margin-left: 15px;line-height: 0.8;padding: 10px;">Cancel</a>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-success" style="margin-left: 15px;line-height: 0.8;">Add</button>  <?php } ?>
                                    </form>
                                </div>
                                <div class="box-body">
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Class Type Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($class_types as $class_type) {
                                                ?>
                                                <tr>
                                                    <td><?= $count ?></td>
                                                    <td><?= $class_type->title; ?></td><td>
                                                        <a href="javascript:void(0)" onclick="deleteClassType(<?= $class_type->id ?>)"  class="text-danger delete" data-toggle="tooltip" title="DELETE CLASS TYPE!"><i class="fa fa-trash-o"></i></a> 
                                                        <a href="<?= asset('edit_class_type/' . $class_type->id) ?>"  data-toggle="tooltip" title="EDIT CLASS TYPE!"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
<?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
<script>
    function deleteClassType(class_type_id) {
        $('.confirm_message').html('Are you sure to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_class_type',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'class_type_id': class_type_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'class_types';
                }
            });
        });
    }
</script>