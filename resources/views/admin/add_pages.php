<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <style>
        label.error{
            color: red;
        }
    </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Pages
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
                                    <h3 class="box-title">Pages</h3> 
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
                                    <form class="form-horizontal box-body setting_form" id="add_page" method="POST" action="<?= asset('add_pages'); ?>" enctype="multipart/form-data" autocomplete="off">
                                        <?= csrf_field() ?> 
                                        <input type="hidden" name="edit_id" value="<?= isset($id) ? $id : '' ?>" />
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="title" class="control-label">Title</label>
                                                    <input type="text" class="form-control" placeholder="Title" name="title" value="<?= (old('title') ? old('title') : isset($result->title) ? $result->title : ''); ?>">

                                                    <?php if ($errors->has('title')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('title'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-12">
                                                    <div class="form-group">
                                                   <label for="last_name" class="control-label">Image</label>
                                                   <input type="file" class="form-control" name="image">
                                               </div>
                                               </div>-->

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" placeholder="Description" required=""><?= (old('description') ? old('description') : isset($result->content) ? $result->content : '') ?></textarea>
                                                    <label id="description-error" class="error" for="description"></label>
                                                    <?php if ($errors->has('content')) { ?>
                                                        <div class="error alert-danger">
                                                            <?= $errors->first('content'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status">
                                                        <option value="1" <?= (isset($result->status) && $result->status == 1 ? 'selected' : ''); ?>>Active</option>
                                                        <option value="0"  <?= (isset($result->status) && $result->status == 0 ? 'selected' : ''); ?>>InActive</option>
                                                    </select>
                                                </div>
                                            </div> 
                                        </div> 
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-success form-control">save</button>
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
        </div>
    </body>
</html>
<script src="<?= asset('userassets/js/jquery.validate.min.js') ?>"></script>
<script>
    CKEDITOR.replace('description');
    function deleteUser(user_id) {
        if (confirm('Are you sure that you want to delete this user?')) {
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
                    window.location.href = base_url + 'users_admin';
                }
            });
        }
    }
    function deleteTrainer(user_id) {
        if (confirm('Are you sure that you want to delete this Trainer?')) {
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
                    window.location.href = base_url + 'trainers_admin';
                }
            });
        }
    }
    function featureTrainer(trainer_id) {
        if (confirm('Are you sure that you want to change the featuring status of this trainer ?')) {
            $.ajax({
                url: base_url + 'feature_trainer',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'trainer_id': trainer_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    }
                    window.location.href = base_url + 'trainers_admin';
                }
            });
        }
    }
    $("#add_page").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            description: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            }
        }
    });
</script>