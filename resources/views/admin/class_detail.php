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
                        Class Detail
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                
                                <div class="box-body box-profile">
                                    <?php 
                                    if($class->getImage){
                                        $class_image = $class->getImage->thumbnail_path;
                                    ?>
                                        <div style="background-image:url('<?= asset('adminassets/images/'. $class_image) ?>');display : inline-block ;margin: 0 auto;width: 160px;padding: 3px;border: 1px dashed #77777782;height : 100px;background-size: cover;background-position: center center;background-repeat: no-repeat; "></div>
                                    <?php  } ?>
                                    <h3 class="profile-username text-center"><b>Trainer :</b> <a href="<?= asset('user_detail_admin/'.$class->classtTrainer->id) ?>"><?= $class->classtTrainer->first_name . ' ' . $class->classtTrainer->last_name ?></a></h3>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Email</b> <p class="pull-right"><?= $class->classtTrainer->email ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Description</b> <p><?= $class->description ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Class Type </b> <p class="pull-right"><?= isset($class->class_type) ? $class->class_type : 'N/A' ?></p>
                                            <!--<b>Class Type </b> <p class="pull-right"><?= isset($class->classtType->title) ? $class->classtType->title : 'N/A' ?></p>-->
                                        </li>
                                        <li class="list-group-item">
                                            <b>Spot</b> <p class="pull-right"><?= $class->spot ? $class->spot : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Participants</b> <p class="pull-right"><?= $class->participants ? $class->participants : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Location</b> <p class="pull-right"><?= $class->location ? $class->location : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Difficulty Level</b> <p class="pull-right"><?= $class->difficulty_level ? $class->difficulty_level : 'N/A' ?></p>
                                        </li>

                                        <li class="list-group-item">
                                            <b>Calories</b> <p class="pull-right"><?= $class->calories ? $class->calories : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Start Date</b> <p class="pull-right"><?= $class->start_date ? date('F d, Y h:i a', strtotime($class->start_date)):'N/A' ?></p>
                                        </li>
<!--                                        <li class="list-group-item">
                                            <b>End Date</b> <p class="pull-right"><? = $class->end_date ? date('F d, Y h:i a', strtotime($class->end_date)):'N/A' ?></p>
                                        </li>-->
                                    </ul>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <!-- /.row -->

                </section>
                <!-- /.content -->
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
