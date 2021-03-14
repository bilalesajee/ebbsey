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
                        <span>Discipline </span>
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

                                    <form method="POST" class="dentist-specialists form-horizontal" <?php if (isset($specialization)) { ?> action="<?= asset('edit_specialization'); ?>" <?php } else { ?> action="<?= asset('add_specialization'); ?>" <?php } ?> >
                                        <?= csrf_field() ?>
                                        <label for="inputEmail3" class="col-sm-2 control-label"><?php if (isset($specialization)) { ?>Edit<?php } else { ?>Add New <?php } ?> Discipline</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="title" <?php if (isset($specialization)) { ?>value="<?= $specialization->title ?>"<?php } ?> class="form-control" required="required"/>
                                            <?php if (isset($specialization)) { ?> 
                                                <input type="hidden" name="specialization_id" value="<?= $specialization->id; ?>">
                                            <?php } ?>
                                        </div>
                                        <?php if (isset($specialization)) { ?> 
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <a href="<?= asset('specializations_admin') ?>" class="btn btn-danger">Cancel</a>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary">Add</button>  <?php } ?>
                                    </form>
                                </div>
                                <div class="box-body">
                                    <table id="datatable" class="display responsive nowrap cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th>Discipline Title</th>
                                                <th width="130px" class="text-center">is Approved</th>
                                                <th width="80px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($specializations as $specialization) {
                                                ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?= $count ?></td>
                                                    <td><?= $specialization->title; ?></td>
                                                    <td width="130px" class="text-center"> 
                                                        <?= $specialization->is_approved_by_admin == 0 ? '<span class="text-danger">Not Approved</span>' : '<span class="text-success">Approved</span>'; ?> 
                                                        <input type="checkbox" name="is_approved" onclick="specializationApproval(<?= $specialization->id ?>)" 
                                                               <?= $specialization->is_approved_by_admin == 1 ? 'checked' : '' ?> > 
                                                    </td>
                                                    <td width="80px" class="text-center">
                                                        <a href="javascript:void(0)" onclick="deleteSpecialization(<?= $specialization->id ?>)"  class="text-danger delete" style="margin-right: 10px;" data-toggle="tooltip" title="Delete Discipline !"><i class="fa fa-trash-o"></i></a> 
                                                        <a href="<?= asset('edit_specialization/' . $specialization->id) ?>"  data-toggle="tooltip" title="Edit Discipline !"><i class="fa fa-edit"></i></a>
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
    function deleteSpecialization(specialization_id) {
        $('.confirm_message').html('Are you sure to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_specialization',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'specialization_id': specialization_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'specializations_admin';
                }
            });
        });
    }
    function specializationApproval(specialization_id) {
        $('.confirm_message').html('Are you sure that you want to change the approval status of this specialization?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'specializations_admin_approval',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'specialization_id': specialization_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'specializations_admin';
                }
            });
        });
    }
</script>