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
                                    <a href="<?=url('add_pages')?>" class="pull-right btn btn-success ">Add New</a>
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
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Status</th> 
                                                <th width="20px" class="text-center">Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($result as $val) { ?>
                                                <tr>
                                                    <td width="20px" class="text-center"><?php echo $i;  ?></td>
                                                     
                                                    <td><?=$val->title?></td>
                                                    <td><?=(strlen($val->content)>100)?substr($val->content, 0,100).'...':$val->content;?></td> 
                                                    <td width="50px" class="text-center"><?=($val->status == 1)?'Active':'InActive';?></td>
                                                   
                                                    <td width="20px" class="text-center"> 
                                                        <a href="<?=url('add_pages/'.$val->id)?>"class="text-danger delete"><i class="fa fa-edit"></i></a>
                                                    </td>
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