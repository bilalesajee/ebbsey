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
                        <span>Training Types</span>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <?php if (session()->has('success')) { ?>
                                        <div class="text-success"><?php echo Session::get('success'); ?></div>
                                    <?php } ?>
                                    <?php if (session()->has('error')) { ?>
                                        <div class="text-danger"><?php echo Session::get('error'); ?></div>
                                    <?php } ?>
                                    <form method="POST" class="dentist-specialists" <?php if (isset($training_type)) { ?> action="<?= asset('edit_training_type'); ?>" <?php } else { ?> action="<?= asset('add_training_type'); ?>" <?php } ?>  enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="col-sm-1">
                                            <span id="training_type_image_view" 
                                                  style=";background-image:url(<?= isset($training_type) && $training_type->image ? asset('public/images/' . $training_type->image) : 'public/images/trainer_types/default.jpg' ?>);
                                                  ">
                                                <a href="javascript:void(0);" class="btn delete" id="delete-prof-img" 
                                                   style="<?= isset($training_type) && $training_type->image ? 'display :block' : 'display :none' ?>;">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label><?php if (isset($training_type)) { ?>Edit<?php } else { ?>Add New <?php } ?> Training Type </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" name="title" <?php if (isset($training_type)) { ?>value="<?= $training_type->title ?>"<?php } ?> class="form-control" required="required"/>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div>
                                                        <div class="inline">
                                                            <input type="file" id="training_type_image" name="image" class="col-md-3" style="display: none;"/>
                                                            <label class="btn btn-default" for="training_type_image">Select Image:</label>
                                                        </div>
                                                        <?php if (isset($training_type)) { ?> 
                                                            <input type="hidden" name="training_type_id" value="<?= $training_type->id; ?>">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <a href="<?= asset('training_types_admin') ?>" class="btn btn-danger">Cancel</a>
                                                        <?php } else { ?>
                                                            <button type="submit" class="btn btn-success">Add</button>  
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div><!-- row -->
                                        </div><!-- col -->
                                    </form>
                                </div>
                                <div class="box-body">
                                    <table id="datatable" class="display responsive nowrap cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th>Training Type Title</th>
                                                <th width="75px" class="text-center">Training Type Image</th>
                                                <th width="90px" class="text-center">Status</th>
                                                <th width="80px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($training_types as $training_type) {
                                                ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?= $count ?></td>
                                                    <td><?= $training_type->title; ?></td>
                                                    <td width="75px" class="text-center"><img src="<?= asset('public/images/' . $training_type->image); ?>" alt="TrainerTypeImage" style="width: 65px;height: 65px;"></td>
                                                    <td width="90px" class="text-center">
                                                        <select class="status form-control" name="status" id="status<?= $training_type->id ?>" data-id="<?= $training_type->id ?>">
                                                            <option value="1" <?= $training_type->is_enabled == 1 ? 'selected' : '' ?>>Enable</option>
                                                            <option value="0" <?= $training_type->is_enabled == 0 ? 'selected' : '' ?>>Disable</option>
                                                        </select>
                                                    </td>
                                                    <td width="80px" class="text-center">
                                                        <!--<a href="javascript:void(0)" onclick="deleteTrainingType(<?= $training_type->id ?>)"  class="text-danger delete" data-toggle="tooltip" title="DELETE TRAINING TYPE!"><i class="fa fa-trash-o"></i></a>--> 
                                                        <a href="<?= asset('edit_training_type/' . $training_type->id) ?>"  data-toggle="tooltip" title="EDIT TRAINING TYPE!"><i class="fa fa-edit"></i></a>
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
    function deleteTrainingType(training_type_id) {

        $('.confirm_message').html('Are you sure that you want to delete this training type?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_training_type',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'training_type_id': training_type_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'training_types_admin';
                }
            });
        });
    }

    $(function () {
        $("#training_type_image").on("change", function ()
        {
//                    $("#add_photo_label").hide();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () {
                    // set image data as background 
                    $("#training_type_image_view").css("background-image", "url(" + this.result + ")");
                    // set image data in img tag
//                                $('#admin_dp_view').attr('src',this.result);
                };
            }
            $('#delete-prof-img').show();
        });
    });
    ////////////////////
//        to remove thumbnali

    $("body").on('click', '#delete-prof-img', function () {
        //setting defaultbackgroung image
        $('#training_type_image_view').css('background-image', 'url("public/images/trainer_types/default.jpg")');
        //for making value null of upload button ,so onchange() function can be trigger after selecting same image
        $("#training_type_image").val('');
        $('#delete-prof-img').hide(); //for hide remove icon
    });
</script>
<script type="text/javascript">
    $(document).ready(function () { /* PREPARE THE SCRIPT */
        $(".status").change(function () { /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
            var $this = $(this); /* GET THE VALUE OF THE SELECTED DATA */
            var status = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
            type_id = $(this).attr('data-id');
            if (status == 1) {
                $('.confirm_message').html('Are you sure that you want to enable this training type?');
            } else {
                $('.confirm_message').html('Are you sure that you want to disable this training type?');
            }
            $('#confirmModal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function (e) {
                $.ajax({
                    url: base_url + 'change_training_type_status',
                    type: 'POST',
                    data: {
                        'type_id': type_id,
                        'status': status,
                        "_token": "<?= csrf_token() ?>"
                    },
                    success: function (result) {
                    }
                });
            }).on('click', '#concel_confirm', function () {
                $this.val((status == 1) ? '0' : '1');
            });
        });
    });
</script>