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
                        <Blogs
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
                                    <h3 class="box-title">Blogs</h3>
                                    <a href="<?=url('add_blog_admin');?>" class="btn btn-success pull-right">Add Blog</a>
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
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>  
                                                <th>Status</th> 
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($result as $val) { ?>
                                                <tr>
                                                    <td><?php echo $i;  ?></td>
                                                    <td class="table_img"> 
                                                       <?=$val->title?>
                                                    </td>
                                                    <td>
                                                        <img src="<?=  $val->image != null ? asset('public/images/'.$val->image): asset('public/images/blogs/default.jpg') ?>" width="50" height="50">
                                                    </td> 
                                                    <td><?=(strlen($val->description) > 50)?substr($val->description, 0, 50).'...':$val->description;?></td>
                                                    <td><?=($val->status == 1)?'Active':'Inactive';?></td>
                                                    
                                                     
                                                    <td>
                                                        <a href="<?=url('delete_blog_admin').'/'.$val->id;?>" onclick="return confirm('Are you sure to delete this?');" class="text-danger delete"><i class="fa fa-trash-o"></i></a> |
                                                     <a href="<?=url('add_blog_admin').'/'.$val->id;?>" class="text-danger delete"><i class="fa fa-edit"></i></a></td>
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
    function deleteUser(user_id){
        if(confirm('Are you sure that you want to delete this?')){
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
        }
    }
    function deleteTrainer(user_id){
        if(confirm('Are you sure that you want to delete this Trainer?')){
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
        }
    }
</script>
<script>
    function featureTrainer(trainer_id){
        if(confirm('Are you sure that you want to change the featuring status of this trainer ?')){
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
        }
    }
</script>