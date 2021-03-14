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
                        <?= $userType == "user" ? "Users" : "Trainers"?>
                        <small>Ebbsey</small>
                    </h1>
                    <div class="alert alert-success ajax-alert" style="display: none" ><span class="text-message"></span></div>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><?= $userType == "user" ? "Users" : "Trainers"?></h3>
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
                                                <th width="30px">Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <!--<th>Address</th>-->
                                                <th width="50px" class="text-center">Phone</th>
                                                <?php if( $userType == 'trainer'){ ?>
                                                    <th width="50px" class="text-center">is Featured</th>
                                                    <th width="50px" class="text-center">Trainer Type</th>
                                                <?php } ?>
                                                <th width="20px" class="text-center">Status</th>
                                                <th width="20px" class="text-center">Action</th>
                                                <th width="30px" class="text-center">Go to</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($users as $user) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php echo $i;  ?></td>
                                                    <td width="30px" class="table_img"> 
                                                        <a href="<?=asset('user_detail_admin/'.$user->id)?>"><img src="<?=  $user->image != null ? asset('public/images/'.$user->image): asset('public/images/users/default.jpg') ?>"></a>
                                                    </td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$user->id)?>"><?=$user->first_name.' '.$user->last_name?></a></td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$user->id)?>"><?=$user->email?></a></td>
                                                    <!--<td><?=$user->address?></td>-->
                                                    <td width="50px" class="text-center"><?=$user->phone?></td>
                                                    <?php if( $userType == 'trainer'){ ?>
                                                        <!--<td><a href="javascript:void(0)" onclick="featureTrainer(<?=$user->id?>)"><?= $user->is_featured_by_admin == 0 ? 'feature this trainer':'unfeatured this trainer' ?></a></td>-->
                                                        <td width="50px" class="text-center"> 
                                                            <?= $user->is_featured_by_admin == 0 ? '<span class="text-danger"> Not Featured </span>':'<span class="text-success"> Featured </span>'  ; ?> 
                                                            <input type="checkbox" name="is_featured" onclick="featureTrainer(<?=$user->id?>)" 
                                                            <?= $user->is_featured_by_admin == 1 ? 'checked':'' ?>  style="vertical-align: middle;" > 
                                                        </td>
                                                        <td> <?php $j = 1; foreach($user->trainerTrainingTypes as $types){  ?> <?= $types->trainingTypes->title ?>  <?php if($j < $user->trainerTrainingTypes->count()){ echo ',';} $j++;}?> </td>
                                                    <?php } ?>
                                                        <td width="20px" class="text-center"> 
                                                            <select name="status" data-id="<?=$user->id;?>" data-type="<?=$user->user_type;?>" class="user_status">
                                                                <option value="1" <?=($user->is_approved_by_admin == 1)?'selected':''?>>Active</option>
                                                                <option value="0" <?=($user->is_approved_by_admin == 0 || $user->is_approved_by_admin == 2)?'selected':''?>>Inactive</option>
                                                            </select>
                                                        </td>
                                                    <td width="20px" class="text-center"><a href="javascript:void(0)" <?php if($user->user_type == 'trainer') { ?> onclick="deleteTrainer(<?=$user->id?>)"<?php }else { ?> onclick="deleteUser(<?=$user->id?>)" <?php } ?>  class="text-danger delete"><i class="fa fa-trash-o"></i></a></td>
                                                    <td width="30px" class="text-center"><a href="<?=asset('user_detail_admin/'.$user->id)?>" class="btn btn-info">View Detail</a></td>
                                                </tr>
                                            <?php $i++; } ?>
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
        $('body').on('change','.user_status',function(){          
        var status = $(this).val();
        var user_id = $(this).attr('data-id');
        var user_type = $(this).attr('data-type');
            $.ajax({
                url: base_url + 'change_status',
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'json',
                data: {'user_id': user_id, status:status,user_type:user_type},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {     
                        $('.ajax-alert').show();
                    if(data.success){
                        $('.ajax-alert').removeClass('alert-danger');
                        $('.ajax-alert').addClass('alert-success');
                        $('.text-message').html(data.msg);   
                    } else { 
                        $('.ajax-alert').removeClass('alert-success');
                        $('.ajax-alert').addClass('alert-danger');
                        $('.text-message').html(data.msg); 
                    }
                }
            }); 
    });
    function deleteUser(user_id){
          $('.confirm_message').html('Are you sure to delete this?');    
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_user_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'user_id': user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    console.log(data);
                    window.location.href= base_url+'users_admin';
                }
            });
        });
    }
    function deleteTrainer(user_id){
        $('.confirm_message').html('Are you sure to delete this?');    
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'delete_user_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'user_id': user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    console.log(data);
                    window.location.href= base_url+'trainers_admin';
                }
            });
        });
    }
</script>
<script>
    function featureTrainer(trainer_id){ 
            $('.confirm_message').html('Are you sure to mark this as feature?');    
        $('#confirmModal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
            $.ajax({
                url: base_url + 'feature_trainer',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'trainer_id': trainer_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    if(data.error){
                        alert(data.error);
                    }
                    window.location.href= base_url+'trainers_admin';
                }
            });
        });
    }
</script>