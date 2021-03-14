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
                        <?= $userType == 'user' ? "User Profile Detail" : "Trainer Profile Detail" ?> 
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box box-primary">
                                <div class="box-body box-profile"> 
                                    <a href="<?= $user->original_image != null ? asset(image_fix_orientation('public/images/' . $user->original_image)) : asset('public/images/users/default.jpg') ?>" class="fancybox" >
                                        <span class="profile-user-img img-responsive img-circle" style="background-image:url(<?= $user->image != null ? asset(image_fix_orientation('public/images/' . $user->image)) : asset(image_fix_orientation('public/images/users/default.jpg')) ?>)"></span>
                                    </a>
                                    <h3 class="profile-username text-center"><?= ucfirst($user->first_name) . ' ' . $user->last_name ?></h3>
                                    <div style="text-align : center;">
                                        <?php
                                        if ($user->user_type == 'trainer') {
                                            if ($user->image != null) {
                                                if ($user->is_image_approved_by_admin == 1) {
                                                    ?>
                                                    <span class="text text-bold" style="font-size: 14px;">Status : </span>
                                                    <span class="label label-success" style="font-size: 12px;">Approved</span>
                                                    <p style="margin-top: 15px;">
                                                        <a href="<?= asset('admin_deny_image/' . $user->id) ?>" class="btn btn-danger">Deny <i class="fa fa-ban"></i></a>
                                                    </p>
                                                <?php } else if ($user->is_image_approved_by_admin == 2) { ?>
                                                    <span class="label label-danger" style="font-size: 12px;">Denied</span>
                                                    <p style="margin-top: 15px;">
                                                        <a href="<?= asset('admin_approve_image/' . $user->id) ?>" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                                                    </p>
                                                <?php } else { ?>
                                                    <span class="label label-warning" style="font-size: 12px;">Pending</span>
                                                    <p style="margin-top: 15px;">
                                                        <a href="<?= asset('admin_approve_image/' . $user->id) ?>" class="btn btn-success">Approve <i class="fa fa-check"></i></a>
                                                        <a href="<?= asset('admin_deny_image/' . $user->id) ?>" class="btn btn-danger">Deny <i class="fa fa-ban"></i></a>
                                                    </p>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <span>No image Uploaded yet!</span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <ul class="list-group list-group-unbordered user_detail_listing">
                                        <li class="list-group-item">
                                            <b>Email</b> 
                                            <p><?= $user->email ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Gender</b> 
                                            <p><?= $user->gender ? ucfirst($user->gender) : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>City</b> 
                                            <p><?= $user->city ? $user->city : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Address</b> 
                                            <p><?= $user->address ? $user->address : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>State</b> 
                                            <p><?= $user->state ? $user->state : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Phone</b> 
                                            <p><?= $user->phone ? $user->phone : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Date of Birth</b> 
                                            <p><?= $user->dob ? date('F d, Y', strtotime($user->dob)) : 'N/A' ?></p>
                                        </li>
                                        <?php if ($userType == 'trainer') { ?>
                                            <li class="list-group-item">
                                                <b>Trainer's Type</b> <p><?php
                                                    $i = 1;
                                                    foreach ($user->trainerTrainingTypes as $types) {
                                                        ?> <?= $types->trainingTypes->title ?>  <?php
                                                        if ($i < $user->trainerTrainingTypes->count()) {
                                                            echo ',';
                                                        } $i++;
                                                    }
                                                    ?>  </p>
                                            </li> 
                                            <li class="list-group-item">
                                                <b>Experiences</b> 
                                                <p><?= $user->years_of_experience ? $user->years_of_experience : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Referral Code</b> 
                                                <p><?= $user->referral_code ? $user->referral_code : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>License Expire Date : </b> 
                                                <p><?= $user->license_expire_date ? $user->license_expire_date : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Do you have a facility to teach your class?</b> 
                                                <p><?= $user->trainerQuestion1 ? ucfirst($user->trainerQuestion1->choice) : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Do you own vehicle ?</b> 
                                                <p><?= $user->trainerQuestion2 ? ucfirst($user->trainerQuestion2->choice) : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Do you have a personal trainer insurance?</b> 
                                                <p><?= $user->trainerQuestion3 ? ucfirst($user->trainerQuestion3->choice) : 'N/A' ?></p>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item">
                                            <b>Last Login</b> 
                                            <p><?= $user->last_login ? date('F d, Y g:i A', strtotime($user->last_login)) : 'N/A' ?></p>
                                        </li>
                                    </ul>
                                    <?php if ($user->user_type == 'trainer') { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Certificates</h3>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body no-padding" style="overflow-x: auto;">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Type</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">View</th>
                                                                    <th class="text-center">Download</th>
                                                                    <th class="text-center">Approve</th>
                                                                    <th class="text-center">Deny</th>
                                                                </tr>
                                                                <?php
                                                                if (!$certificates->isEmpty()) {
                                                                    $i = 1;
                                                                    foreach ($certificates as $certificate) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $i ?></td>
                                                                            <td><?= $certificate->certificateType->title ?></td>
                                                                            <td>
                                                                                <?php if ($certificate->is_approved_by_admin == 1) { ?>
                                                                                    <span class="label label-success">Approved</span>
                                                                                <?php } else if ($certificate->is_approved_by_admin == 2) { ?>
                                                                                    <span class="label label-danger">Denied</span>
                                                                                <?php } else { ?>
                                                                                    <span class="label label-warning">Pending</span>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" href="<?= asset('public/documents/' . $certificate->file) ?>" style="margin-right: 10px;"><i class="fa fa-fw fa-eye"></i></a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="<?= asset('public/documents/' . $certificate->file) ?>" download><i class="fa fa-fw fa-download"></i></a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php if ($certificate->is_approved_by_admin == 1) { ?>
                                                                                    <a href="<?= asset('admin_approve_certificates/' . $certificate->id) ?>" class="text text-gray" style="pointer-events: none;" ><i class="fa fa-check"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="<?= asset('admin_approve_certificates/' . $certificate->id) ?>" class="text text-success" ><i class="fa fa-check"></i></a>
                                                                                <?php } ?>

                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php if ($certificate->is_approved_by_admin == 2) { ?>
                                                                                    <a href="<?= asset('admin_deny_certificates/' . $certificate->id) ?>" class="text text-gray " style="pointer-events: none;" ><i class="fa fa-ban"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="<?= asset('admin_deny_certificates/' . $certificate->id) ?>" class="text text-danger" ><i class="fa fa-ban"></i></a>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- /.box-body -->
                                                </div> <!-- /.box -->
                                            </div> <!-- col 6-->
                                            <div class="col-md-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Cv</h3>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body no-padding" style="overflow-x: auto;">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Type</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">View</th>
                                                                    <th class="text-center">Download</th>
                                                                    <th class="text-center">Approve</th>
                                                                    <th class="text-center">Deny</th>
                                                                </tr>
                                                                <?php
                                                                if (!$cvs->isEmpty()) {
                                                                    $i = 1;
                                                                    foreach ($cvs as $cv) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $i ?></td>
                                                                            <td><?= $cv->certificateType->title ?></td>
                                                                            <td>
                                                                                <?php if ($cv->is_approved_by_admin == 1) { ?>
                                                                                    <span class="label label-success">Approved</span>
                                                                                <?php } else if ($cv->is_approved_by_admin == 2) { ?>
                                                                                    <span class="label label-danger">Denied</span>
                                                                                <?php } else { ?>
                                                                                    <span class="label label-warning">Pending</span>
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a target="_blank" href="<?= asset('public/documents/' . $cv->file) ?>" ><i class="fa fa-fw fa-eye"></i></a>

                                                                            </td>
                                                                            <td class="text-center">
                                                                                <a href="<?= asset('public/documents/' . $cv->file) ?>" download><i class="fa fa-fw fa-download"></i></a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php if ($cv->is_approved_by_admin == 1) { ?>
                                                                                    <a href="<?= asset('admin_approve_cv/' . $cv->id) ?>" class="text text-gray" style="pointer-events: none;" ><i class="fa fa-check"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="<?= asset('admin_approve_cv/' . $cv->id) ?>" class="text text-success" ><i class="fa fa-check"></i></a>
                                                                                <?php } ?>

                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php if ($cv->is_approved_by_admin == 2) { ?>
                                                                                    <a href="<?= asset('admin_deny_cv/' . $cv->id) ?>" class="text text-gray " style="pointer-events: none;" ><i class="fa fa-ban"></i></a>
                                                                                <?php } else { ?>
                                                                                    <a href="<?= asset('admin_deny_cv/' . $cv->id) ?>" class="text text-danger" ><i class="fa fa-ban"></i></a>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- /.box-body -->
                                                </div> <!-- /.box -->
                                            </div> <!-- col 6 -->
                                        </div> <!-- row -->
                                    <?php } ?>
                                </div>
                                <!-- /.box-body -->
                            </div>

                            <?php if ($user->user_type == 'traine') { ?>
                                <div style="margin-top: 15px;margin-bottom: 10px;">
                                    <div class="trainer_status" style="border: 0;">
                                        <span class="text text-bold">CV Status : </span>
                                        <?php if (!$user->trainerDocuments->isEmpty()) { ?>
                                            <?php
                                            foreach ($user->trainerDocuments as $document) {
                                                if ($document->document_type == 'cv') {
                                                    if ($document->is_approved_by_admin == 1) {
                                                        ?>
                                                        <span style="display :inline-block;color: #961c1c;"> CV Approved
                                                            <img src="<?= asset('adminassets/images/happy.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                    <?php } else if ($document->is_approved_by_admin == 2) { ?>
                                                        <span style="display :inline-block;color: #961c1c;"> CV Denied
                                                            <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                        <a href="<?= asset('admin_approve_cv/' . $document->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve CV<i class="fa fa-check"></i></a>
                                                    <?php } else { ?>  
                                                        <span style="display :inline-block;color: #961c1c;"> CV Pending
                                                            <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                        <a href="<?= asset('admin_approve_cv/' . $document->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve CV<i class="fa fa-check"></i></a>
                                                        <a href="<?= asset('admin_deny_cv/' . $document->id) ?>" class="btn btn-danger" style="display: block;width: 160px;">Deny CV<i class="fa fa-check"></i></a>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <?php if ($document->document_type == 'certification') { ?> <?php } else { ?>
                                                        <span>No CV!</span>
                                                    <?php } ?>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <span>No CV!</span>
                                        <?php } ?>
                                    </div>
                                    <div class="trainer_status">
                                        <span class="text text-bold">Image Status : </span>
                                        <?php
                                        if ($user->image != null) {
                                            if ($user->is_image_approved_by_admin == 1) {
                                                ?>
                                                <span style="display :inline-block;color: #961c1c;"> Image Approved
                                                    <img src="<?= asset('adminassets/images/happy.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                </span>
                                            <?php } else if ($user->is_image_approved_by_admin == 2) { ?>
                                                <span style="display :inline-block;color: #961c1c;"> Image Denied
                                                    <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                </span>
                                                <a href="<?= asset('admin_approve_image/' . $user->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve Image<i class="fa fa-check"></i></a>
                                            <?php } else { ?>
                                                <span style="display :inline-block;color: #961c1c;"> Pending
                                                    <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                </span>
                                                <a href="<?= asset('admin_approve_image/' . $user->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve Image<i class="fa fa-check"></i></a>
                                                <a href="<?= asset('admin_deny_image/' . $user->id) ?>" class="btn btn-danger" style="display: block;width: 160px;">Deny Image<i class="fa fa-check"></i></a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <span>No image Uploaded yet!</span>
                                        <?php } ?>
                                    </div>
                                    <div class="trainer_status">
                                        <?php if (!$user->trainerDocuments->isEmpty()) { ?>
                                            <?php foreach ($user->trainerDocuments as $document) { ?>
                                                <?php if ($document->document_type == 'certification') { ?>  
                                                    <?php if ($document->is_approved_by_admin == 1) { ?>
                                                        <div>
                                                            <span class="text text-bold">Certificate Type :</span> <?= $document->certificateType ? $document->certificateType->title : 'not specified' ?>
                                                        </div>
                                                        <span class="text text-bold">Certificates Status : </span>
                                                        <span style="display :inline-block;color: #961c1c;"> Certificate Approved
                                                            <img src="<?= asset('adminassets/images/happy.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                    <?php } else if ($document->is_approved_by_admin == 2) { ?>
                                                        <div><span class="text text-bold">Certificate Type :</span>  <?= $document->certificateType->title ?></div>
                                                        <span class="text text-bold">Certificates Status : </span>
                                                        <span style="display :inline-block;color: #961c1c;"> Certificate Denied
                                                            <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                        <a href="<?= asset('admin_approve_certificates/' . $document->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve Certificates<i class="fa fa-check"></i></a>
                                                    <?php } else { ?> 
                                                        <div>
                                                            <span class="text text-bold">Certificate Type :</span>  <?= $document->certificateType->title ?>
                                                        </div>
                                                        <span class="text text-bold">Certificates Status : </span>
                                                        <span style="display :inline-block;color: #961c1c;"> Pending
                                                            <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                                        </span>
                                                        <a href="<?= asset('admin_approve_certificates/' . $document->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Approve Certificates<i class="fa fa-check"></i></a>
                                                        <a href="<?= asset('admin_deny_certificates/' . $document->id) ?>" class="btn btn-danger" style="display: block;width: 160px;">Deny Certificates<i class="fa fa-check"></i></a>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <?php if ($document->document_type == 'cv') { ?> <?php } else { ?>
                                                        <span class="trainer_status" >No Certificates!</span>
                                                    <?php } ?>

                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?> 
                                            <span class="text text-bold">Certificates Status : </span>No Certificates!
                                        <?php } ?> 
                                    </div>

                                    <div class="trainer_status">
                                        <?php if ($user->is_approved_by_admin == 2) { ?>
                                            <br><br>
                                            <span style="display :inline-block;color: #961c1c;"> Blocked for one month
                                                <img src="<?= asset('adminassets/images/sad.png') ?>" style="margin-left: 5px;width: 20px;vertical-align: sub;">
                                            </span>
                                            <a href="<?= asset('activateTranner/' . $user->id) ?>" class="btn btn-success" style="display: block;width: 160px;">Activate Tranner<i class="fa fa-check"></i></a> 
                                        <?php } ?>

                                    </div>
                                </div>
                            <?php } ?>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>