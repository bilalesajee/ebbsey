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
                        <span>Fitness Goals</span>
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
                                    <form method="POST" class="dentist-specialists form-horizontal" <?php if (isset($fitness_goal)) { ?> action="<?= asset('edit_fitness_goal'); ?>" <?php } else { ?> action="<?= asset('add_fitness_goal'); ?>" <?php } ?> >
                                        <?= csrf_field() ?>
                                        <label for="inputEmail3" class="col-sm-2 control-label"><?php if (isset($fitness_goal)) { ?>Edit<?php } else { ?>Add New <?php } ?> Fitness Goal</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="title" <?php if (isset($fitness_goal)) { ?>value="<?= $fitness_goal->title ?>"<?php } ?> class="form-control" required="required"/>
                                            <?php if (isset($fitness_goal)) { ?> 
                                                <input type="hidden" name="fitness_goal_id" value="<?= $fitness_goal->id; ?>">
                                            <?php } ?>
                                        </div>
                                        <?php if (isset($fitness_goal)) { ?> 
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="<?= asset('fitness_goals_admin') ?>" class="btn btn-danger">Cancel</a>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary">Add</button>  
                                        <?php } ?>
                                    </form>
                                </div>       
                                <div class="box-body">
                                    <table id="datatable" class="display responsive cell-border" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20px" class="text-center">Sr#</th>
                                                <th>Fitness Goal Title</th>
                                                <th>is Approved</th>
                                                <th width="80px" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            foreach ($fitness_goals as $fitness_goal) {
                                                ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?= $count ?></td>
                                                    <td><?= $fitness_goal->title; ?></td>
                                                    <td width="130px" class="text-center"> 
                                                        <?= $fitness_goal->is_approved_by_admin == 0 ? '<span class="text-danger">Not Approved</span>' : '<span class="text-success">Approved</span>'; ?> 
                                                        <input type="checkbox" name="is_approved" onclick="fitnessGoalApproval(<?= $fitness_goal->id ?>)" 
                                                               <?= $fitness_goal->is_approved_by_admin == 1 ? 'checked' : '' ?> > 
                                                    </td>
                                                    <td width="80px" class="text-center">
                                                        <a href="javascript:void(0)" onclick="deleteFitnessGoal(<?= $fitness_goal->id ?>)"  class="text-danger delete" style="margin-right: 10px;" data-toggle="tooltip" title="DELETE FITNESS GOAL!"><i class="fa fa-trash-o"></i></a> 
                                                        <a href="<?= asset('edit_fitness_goal/' . $fitness_goal->id) ?>"  data-toggle="tooltip" title="EDIT FITNESS GOAL!"><i class="fa fa-edit"></i></a>
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
    function deleteFitnessGoal(fitness_goal_id) {
        $('.confirm_message').html('Are you sure that you want to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_fitness_goal',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'fitness_goal_id': fitness_goal_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'fitness_goals_admin';
                }
            });
        });
    }

    function fitnessGoalApproval(fitness_goal_id) {
        $('.confirm_message').html('Are you sure that you want to delete this?');
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'fitness_goal_approval',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'fitness_goal_id': fitness_goal_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'fitness_goals_admin';
                }
            });
        });
    }
</script>