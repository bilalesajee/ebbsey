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
                        <span>Qualifications</span>
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

                                    <form method="POST" class="dentist-specialists form-horizontal" <?php if (isset($qualification)) { ?> action="<?= asset('edit_qualification'); ?>" <?php } else { ?> action="<?= asset('add_qualification'); ?>" <?php } ?> >
                                        <?= csrf_field() ?>
                                        <div class="row">
                                            <label for="inputEmail3" class="col-sm-2 col-xs-12 control-label"><?php if (isset($qualification)) { ?>Edit<?php } else { ?>Add New <?php } ?> Qualification</label>
                                            <div class="col-sm-5 col-xs-9">
                                                <input type="text" name="title" <?php if (isset($qualification)) { ?>value="<?= $qualification->title ?>"<?php } ?> class="form-control" required="required"/>
                                                <?php if (isset($qualification)) { ?> 
                                                    <input type="hidden" name="qualification_id" value="<?= $qualification->id; ?>">
                                                <?php } ?>
                                            </div>
                                            <?php if (isset($qualification)) { ?> 
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <a href="<?= asset('qualifications_admin') ?>" class="btn btn-danger">Cancel</a>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-primary">Add</button>  <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <div class="box-body">
                                    <table id="datatable" class="display responsive nowrap cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th>Qualification Title</th>
                                                <th width="130px" class="text-center">is Approved</th>
                                                <th width="80px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($qualifications as $qualification) {
                                                ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?= $count ?></td>
                                                    <td><?= $qualification->title; ?></td>
                                                    <td width="130px" class="text-center"> 
                                                        <?= $qualification->is_approved_by_admin == 0 ? '<span class="text-danger">Not Approved</span>' : '<span class="text-success">Approved</span>'; ?> 
                                                        <input type="checkbox" name="is_approved" onclick="qualificationApproval(<?= $qualification->id ?>)" 
                                                               <?= $qualification->is_approved_by_admin == 1 ? 'checked' : '' ?> style="vertical-align: middle;" > 
                                                    </td>
                                                    <td width="80px" class="text-center">
                                                        <a href="javascript:void(0)" onclick="deleteQualification(<?= $qualification->id ?>)" class="text-danger delete" style="margin-right: 10px;" data-toggle="tooltip" title="DELETE QUALIFICATION!"><i class="fa fa-trash-o"></i></a> 
                                                        <a href="<?= asset('edit_qualification/' . $qualification->id) ?>"  data-toggle="tooltip" title="EDIT QUALIFICATION!"><i class="fa fa-edit"></i></a>
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
    function deleteQualification(qualification_id) {
        $('.confirm_message').html('Are you sure to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_qualification',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'qualification_id': qualification_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'qualifications_admin';
                }
            });
        });
    }

    function qualificationApproval(qualification_id) {

        $('.confirm_message').html('Are you sure that you want to change the approval status of this qualification?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'qualification_admin_approval',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'qualification_id': qualification_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'qualifications_admin';
                }
            });
        });
    }
</script>