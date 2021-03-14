<?php include resource_path('views/includes/header.php'); ?>
<div class="bg_blue full_viewport">
    <div class="profile_header">
        <div class="overlay">
            <div class="container">
                <div class="no-gutters row">
                    <div class="col-lg-3 col-12">
                        <div class="profile_image" style="background-image: url('<?= $current_photo ? asset($current_photo) : asset('public/images/users/default.jpg') ?>')" ></div>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-12">
                        <div class="user_info">
                            <div class="d-flex">
                                <div>
                                    <div class="profile_image_mobile" style="background-image: url('<?= $current_photo ? asset($current_photo) : asset('public/images/users/default.jpg') ?>')" ></div> 
                                </div>
                                <div>
                                    <h1><?= $current_name ?></h1>
                                    <div><i class="fa fa-map-marker"></i><?= $current_user->address ? $current_user->address : 'N/A' ?></div>
                                    <div><i class="fa fa-mars"></i>
                                        <?= date_diff(date_create($current_user->dob), date_create('today'))->y; ?> Years 
                                    </div>
                                </div>
                            </div>
                            <div class="passes">
                                <div class="passes_detail">Your Passes <span> <?= $current_user->passes_count < 0 ? 0 : $current_user->passes_count ?> </span></div>
                            </div>
                        </div>
                        <div class="row flex-row-reverse">
                            <div class="col-md-6 col-12 d-flex align-items-center justify-content-md-end">
                                <div class="user_login_details">  
                                    Last Login: <?= $last_login_time ?>
                                    <br>
                                    <?php
                                    if ($user_last_login && $user_last_login->login_time) {
                                        $start_date = new DateTime($user_last_login->login_time);
                                        $since_start = $start_date->diff(new DateTime($user_last_login->logout_time));
                                        ?>
                                        <span class="session_info">User Session: <?php echo  $since_start->h . '' ?> hours  <?php echo  $since_start->i . '' ?> minutes</span>
                                    <?php } else { ?>
                                        <span class="session_info">User Session: N/A</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <nav class="profile_tab">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All appointments</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">My Classes</a>
                                    </div>
                                </nav>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- col -->
                </div>
            </div>
        </div>
    </div> <!-- section end -->
    <div class="container">
        <div class="tab-content profile" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class=" col-lg-4 col-md-5 col-sm-6 ml-auto mb-3">
                        <select class="filter form-control eb-form-control" name="filter">
                            <option value="">All</option>
                            <option value="accepted" <?= (isset($_GET['filter']) && $_GET['filter'] == 'accepted') ? 'selected' : '' ?>>Accepted</option>
                            <option value="completed" <?= (isset($_GET['filter']) && $_GET['filter'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div> <!-- col-6 -->
                </div> <!-- row -->
                <ul class="session_listing">
                    <?php
                    if (!$user_sessions->isEmpty()) {
                        foreach ($user_sessions as $user_session) {
                            ?>
                            <li class="d-flex flex-wrap" id="row_<?= $user_session->id ?>">
                                <div class="profile_info d-flex align-items-center">
                                    <div class="image"> 
                                        <a href="<?= asset('trainer-public-profile/' . $user_session->appointmentTrainer->id) ?>" ><div class="img large" style="background-image: url(<?= $user_session->appointmentTrainer->image ? asset('public/images/' . $user_session->appointmentTrainer->image) : asset('userassets/images/profile-images.jpg'); ?>);"></div></a>
                                    </div>
                                    <div class="info">
                                        <div class="type">Trainer</div>
                                        <div class="name"><a href="<?= asset('trainer-public-profile/' . $user_session->appointmentTrainer->id) ?>" ><?= $user_session->appointmentTrainer->first_name . ' ' . $user_session->appointmentTrainer->last_name ?></a></div>
                                        <a href="javascript:void(0)" onclick="openMessageModal(<?= $user_session->appointmentTrainer->id ?>)" class="btn_message small"> <i class="fa fa-envelope"></i> Message</a>
                                    </div>
                                </div>
                                <div class="detail d-flex flex-lg-row flex-column">
                                    <div class="info flex-column w-100 d-flex align-self-center">
                                        <div class="row no-gutters w-100">
                                            <div class="col-sm-4 col-6">
                                                <div><strong class="text-orange">Session Type</strong></div>
                                                <div>
                                                    <?php if (isset($user_session->number_of_passes) && $user_session->number_of_passes == 1) { ?>
                                                        Individual 
                                                    <?php } elseif (isset($user_session->number_of_passes) && $user_session->number_of_passes == 2) { ?>
                                                        Couple
                                                    <?php } elseif (isset($user_session->number_of_passes) && $user_session->number_of_passes > 2) { ?> 
                                                        Group
                                                    <?php } else { ?>
                                                        N/A
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <strong class="text-orange">Date</strong>
                                                <div><?= isset($user_session->date) ? date("F d, Y", strtotime($user_session->date)) : 'N/A' ?></div>
                                            </div>
                                            <div class="col-sm-4 col-6">
                                                <strong class="text-orange">Use Passes</strong>
                                                <div><?= isset($user_session->number_of_passes) ? $user_session->number_of_passes : 'N/A' ?></div>
                                            </div>
                                        </div>
                                        <div class="row no-gutters w-100">
                                            <div class="col-sm-4 col-6"> 
                                                <strong class="text-orange">Session Time </strong>
                                                <div>
                                                    <?= $user_session->start_time ?>
                                                </div>
                                            </div> 
                                            <?php
                                            if ($user_session->refferAppointment) {
                                                $refered_tranee = $user_session->refferAppointment->getUser->first_name . ' ' . $user_session->refferAppointment->getUser->last_name;
                                                if(isset($user_session->getReferredBy->id) && $user_session->getReferredBy->id !='') { 
                                                 ?>
                                                <div class="col-sm-4 col-6">
                                                    <strong class="text-orange">Referred By </strong>
                                                    <div>
                                                        <a href="<?= url('trainer-public-profile/' . $user_session->getReferredBy->id) ?>">
                                                        <?=$user_session->getReferredBy->first_name.' '.$user_session->getReferredBy->last_name;?> 
                                                        </a>
                                                    </div>
                                                </div> 
                                                <?php } } ?>

                                            <div class="col-sm-4 col-6"> 
                                                <strong class="text-orange">Status </strong>
                                                <div>
                                                    <?= ucfirst($user_session->status); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btns-group ml-lg-auto align-self-center">
                                        <?php $status_array = array('rejected', 'canceled', 'referred'); ?>

                                        <?php if (in_array($user_session->status, $status_array)) { ?>
                                            <a href="javascript:void(0)"  data-id="<?= $user_session->id ?>" class="btn btn-purple orange delete_appointment"> Delete </a>
                                            <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>
                                        <?php } else if ($user_session->status == 'completed') {
                                            ?>
                                            <a href="javascript:void(0)" data-id="<?= $user_session->id ?>" class="btn btn-purple orange delete_appointment"> Delete</a>
                                            <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>
                                            <?php
                                        }

                                        if ($user_session->status == 'accepted' || $user_session->status == 'pending') {
                                            if (strtotime($user_session->date) >= strtotime(date('Y-m-d'))) {
                                                if ((strtotime($user_session->start_date) - 86400) < strtotime(date('Y-m-d H:i:s')) && $user_session->status == 'accepted') { ?>  
                                                    <a href="javascript:void(0)" data-id="<?= $user_session->id; ?>" data-trainer-id="<?= $user_session->appointmentTrainer->id ?>" class="btn btn-outline orange cancel_request_in_due_time"> Cancel Request </a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0)" data-id="<?= $user_session->id; ?>" data-trainer-id="<?= $user_session->appointmentTrainer->id ?>" class="btn btn-outline orange cancel_request"> Cancel Request </a>
                                                <?php } ?>
                                                <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>

                                            <?php } else if (strtotime($user_session->date) < strtotime(date('Y-m-d'))) { ?>
                                                <!--Expired--> 
                                                <a href="javascript:void(0)" data-id="<?= $user_session->id; ?>" class="btn btn-purple orange delete_appointment">Delete</a>
                                                <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>
                                            <?php } else {
                                                ?>
                                                <a href="javascript:void(0)" data-id="<?= $user_session->id; ?>" data-trainer-id="<?= $user_session->appointmentTrainer->id ?>" class="btn btn-outline orange cancel_request"> Cancel Request </a>
                                                <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>
                                                <?php
                                            }
                                        }
                                        if ($user_session->status == 'expired') {
                                            ?>
                                            <a href="javascript:void(0)" data-id="<?= $user_session->id; ?>" class="btn btn-purple orange delete_appointment">Expired - Delete</a>
                                            <a href="<?= url('session_detail') . '/' . $user_session->id; ?>" class="btn btn-purple"> View Detail </a>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </li> 
                            <?php
                        }
                    } else {
                        ?>
                        <li class="d-flex" id="row_13"><p class="m-3">No result found</p></li>
                    <?php } ?>
                </ul>
                <!--<? = $user_sessions->links() ?>-->
            </div> <!-- Session tab -->
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <ul class="classes_listing">
                    <?php
                    if (!$user_classes->isEmpty()) {
                        foreach ($user_classes as $user_class) {
                            ?>
                            <li class="row no-gutters" id="row_"> 
                                <div class="col-xl-3 col-lg-3 class-image" style="background-image: url(<?= $user_class->classAppointment->classtTrainer->image ? asset('public/images/' . $user_class->classAppointment->classtTrainer->image) : asset('userassets/images/profile-images.jpg'); ?>)">
                                    <?php if ($user_class->status == 'accepted') { ?>
                                        <span class="btn btn-success class_status">Enrolled</span>
                                    <?php } else if ($user_class->status == 'rejected' || $user_class->status == 'canceled' || $user_class->status == 'expired') { ?>
                                        <span class="btn btn-danger class_status"><?= ucfirst($user_class->status); ?></span>
                                    <?php } else { ?>
                                        <span class="btn btn-success class_status"><?= ucfirst($user_class->status); ?></span>
                                    <?php } ?>
                                </div> 
                                <div class="col-xl-9 col-lg-9">
                                    <div class="class-detail">
                                        <div class="class-head">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-12"> 
                                                    <h4><?= isset($user_class->classAppointment->class_name) ? $user_class->classAppointment->class_name : 'N/A' ?></h4>
                                                    <div class="trainer_type d-flex">
                                                        <div class="align-items-center"><span class="icon-trainer"></span>Certified Personal Trainer</div>
                                                        <div class="align-items-center"><span class="icon-groupfitness"></span>Group Fitness Instructor</div>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-5 col-md-12 d-lg-block d-none"> 
                                                    <div class="btns-group d-flex "> 
                                                        <?php $status_array = array('rejected', 'canceled', 'pending'); ?>

                                                        <?php if (in_array($user_class->status, $status_array)) { ?>
                                                            <a href="javascript:void(0)" data-id="<?= $user_class->id ?>" class="btn btn-purple orange delete_appointment"> Delete </a>
                                                            <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                        <?php } else if ($user_class->status == 'completed') {
                                                            ?>
                                                            <a href="javascript:void(0)"  data-id="<?= $user_class->id ?>"  class="btn btn-purple orange delete_appointment"> Delete</a>
                                                            <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                        <?php } else if ($user_class->status == 'accepted') {
                                                            if ((strtotime($user_class->start_date) - 86400) < strtotime(date('Y-m-d H:i:s')) && strtotime(date('Y-m-d H:i:s')) < strtotime($user_class->start_date)) { ?>  
                                                                <a href="javascript:void(0)" data-id="<?= $user_class->id; ?>" class="btn btn-outline orange cancel_request_in_due_time"> Cancel Request </a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0)" data-id="<?= $user_class->id; ?>" class="btn btn-outline orange cancel_request"> Cancel Request </a>
                                                            <?php } ?>
                                                            <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 flex-column w-100 d-flex align-self-center">
                                                <div class="detail">
                                                    <div class="row w-100">
                                                        <div class="col-sm-4">
                                                            <div><strong class="text-orange">Type</strong></div>
                                                            <div><?= isset($user_class->classAppointment->class_type) ? $user_class->classAppointment->class_type : 'N/A' ?></div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <strong class="text-orange">Calories</strong>
                                                            <div><?= isset($user_class->classAppointment->calories) ? $user_class->classAppointment->calories : 'N/A' ?></div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <strong class="text-orange">Spots</strong>
                                                            <div><?= isset($user_class->classAppointment->spot) ? $user_class->classAppointment->spot : 'N/A' ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="row w-100">
                                                        <div class="col-sm-4">
                                                            <div><strong class="text-orange">Difficulty </strong></div>
                                                            <div><?php
                                                                if (isset($user_class->classAppointment->difficulty_level)) {
                                                                    if ($user_class->classAppointment->difficulty_level == 'easy') {
                                                                        echo 'Beginner Level';
                                                                    } else if ($user_class->classAppointment->difficulty_level == 'medium') {
                                                                        echo 'Intermediate Level';
                                                                    } else {
                                                                        echo 'Advance Level';
                                                                    }
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                                ?></div>
                                                        </div> 
                                                        <div class="col-sm-8">
                                                            <strong class="text-orange">Location</strong>
                                                            <div><?= isset($user_class->classAppointment->location) ? $user_class->classAppointment->location : 'N/A' ?></div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="class-time">
                                                    <h6>Class schedule</h6>
                                                    <div class="schedule"> 
                                                        <?php
                                                        if (isset($user_class->classAppointment->classTimetable)) {
                                                            $count = 0;
                                                            foreach ($user_class->classAppointment->classTimetable as $class_timetable) {
                                                                if ($count > 1)
                                                                    break;
                                                                ?>
                                                                <div class="d-flex">
                                                                    <div class="day text-capitalize"><?= $class_timetable->day ?></div>
                                                                    <div class="time"><span> <?= $class_timetable->start_time ?> - <?= $class_timetable->end_time ?> </span></div>
                                                                </div>
                                                                <?php
                                                                $count++;
                                                            }
                                                        }
                                                        ?>
                                                    </div> <!-- schedule -->
                                                </div><!-- class time -->
                                            </div> <!--col 3 -->
                                            <!-- button just for small screens -->
                                            <div class="col-12 d-block d-lg-none">
                                                <div class="btns-group d-flex"> 
                                                    <?php $status_array = array('rejected', 'canceled', 'pending'); ?>

                                                    <?php if (in_array($user_class->status, $status_array)) { ?>
                                                        <a href="javascript:void(0)" data-id="<?= $user_class->id ?>" class="btn btn-purple orange delete_appointment"> Delete </a>
                                                        <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                    <?php } else if ($user_class->status == 'completed') {
                                                        ?>
                                                        <a href="javascript:void(0)"  data-id="<?= $user_class->id ?>"  class="btn btn-purple orange delete_appointment"> Delete</a>
                                                        <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                    <?php } else if ($user_class->status == 'accepted') {
                                                        ?>
                                                        <a href="javascript:void(0)" data-id="<?= $user_class->id; ?>" class="btn btn-outline orange cancel_request"> Cancel Request </a>
                                                        <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>
                                                        <?php
                                                    }
                                                    ?>
        <!--                                                        <a href="javascript::void(0)" data-id="<?= $user_class->id; ?>" class="btn btn-outline orange cancel_class_request"> Cancel Class </a>
        <a href="<?= asset('/class-view/' . $user_class->class_id) ?>" class="btn btn-purple"> View Detail </a>-->
                                                </div>
                                            </div>
                                            <!-- button just for small screens -->
                                        </div>
                                    </div>
                                </div>
                            </li><!-- list item -->
                            <?php
                        }
                    } else {
                        ?>
                        <li class="d-flex" id="row_13"><p class="m-3">No result found</p></li>
                    <?php } ?>
                </ul>
                <!--<? = $user_classes->links() ?>  ul -->
            </div> <!-- Classes tab -->
        </div>
    </div>
</div>
<!--Model-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal_title"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="font-12 mb-4 mt-2">
                    <p id="modal_body"></p>
                </div>
                <div class="row mb-2">                                    
                    <div class="col-sm-12">
                        <div class="d-flex ">
                            <div class="w-100 mr-1">
                                <a href="javascript:void(0)" id="modal_yes_btn" class="btn orange btn-lg mr-1">Yes</a>
                            </div>
                            <div class="w-100 ml-1">
                                <a href="javascript:void(0)" class="btn white btn-lg" data-dismiss="modal">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<!--End Model-->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $('body').on('change', '.filter', function () {
        var val = $(this).val();
        window.location.href = base_url + 'user-profile?filter=' + val;
    });
    $('body').on('click', '.cancel_request_in_due_time', function () {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-trainer-id');
        $('#modal_title').html('Cancel Request?');
        $('#modal_body').html('If you cancel now your pass would still be deducted. Are you sure you want to cancel this?');
        $('#modal_yes_btn').attr('onclick', 'cancelRequestInDueTime(' + id + ',' + otherid + ')');
        $('#modal').modal('show');
    });

    function cancelRequestInDueTime(id, otherid) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('cancel_in_due_time') ?>",
            data: {id: id, '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    socket.emit('notification_get', {
                        "user_id": otherid,
                        "other_id": '<?= $current_id ?>',
                        "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                        "photo": '<?= $current_photo ?>',
                        "text": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>' + data.text,
                        "url": '<?= asset('session_detail') ?>' + '/' + id,
                        "type": 'appointment',
                        "unread_counter": ''
                    });
                    $('#row_' + id).remove();
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.custom_alert').show();
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                    setTimeout(function () {
                        hideLoading();
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    }

    $('body').on('click', '.cancel_request', function () {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-trainer-id');
        $('#modal_title').html('Cancel Request?');
        $('#modal_body').html('Are you sure you want to cancel request?');
        $('#modal_yes_btn').attr('onclick', 'cancelBeforeTime(' + id + ',' + otherid + ')');
        $('#modal').modal('show');
    });

    function cancelBeforeTime(id, otherid) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('cancel_before_time') ?>",
            data: {id: id, '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    socket.emit('notification_get', {
                        "user_id": otherid,
                        "other_id": '<?= $current_id ?>',
                        "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                        "photo": '<?= $current_photo ?>',
                        "text": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>' + data.text,
                        "url": '<?= asset('session_detail') ?>' + '/' + id,
                        "type": 'appointment',
                        "unread_counter": ''
                    });
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.custom_alert').show();
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                    setTimeout(function () {
                        hideLoading();
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    }

    $('body').on('click', '.cancel_class_request', function () {
        var id = $(this).attr('data-id');
        $('#modal_title').html('Cancel Request?');
        $('#modal_body').html('Are you sure you want to cancel request?');
        $('#modal_yes_btn').attr('onclick', 'cancelClassRequest(' + id + ')');
        $('#modal').modal('show');
    });

    function cancelClassRequest(id) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('cancel_class_request') ?>",
            data: {id: id, '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#row_' + id).remove();
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.custom_alert').show();
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                    setTimeout(function () {
                        hideLoading();
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    }

    $('body').on('click', '.delete_appointment', function () {
        var id = $(this).attr('data-id');
        $('#modal_title').html('Delete Appointment?');
        $('#modal_body').html('Are you sure you want to delete this?');
        $('#modal_yes_btn').attr('onclick', 'deleteAppointment(' + id + ')');
        $('#modal').modal('show');
    });

    function deleteAppointment(id) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('response_appointment') ?>",
            data: {id: id, type: 'del', 'delete_by': 'client', '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#row_' + id).remove();
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.custom_alert').show();
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                    setTimeout(function () {
                        hideLoading();
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    }

</script>
</body>
</html>
