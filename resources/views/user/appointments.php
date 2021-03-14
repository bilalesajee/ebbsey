<?php include resource_path('views/includes/header.php'); ?>
<style>
    .btn_warning {
        background-color: #f26824; 
    }
    .blockUI.blockOverlay {
        z-index: 1100 !important;
    }
    .blockUI.blockMsg.blockPage {
        z-index: 1101 !important;
    }
</style>
<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">APPOINTMENTS</h4>
            </div>
        </div>
        <form action="<?= url('appointments') ?>" name="" class="form_section">
            <div class="row align-items-center mb-3">
                <div class="col-sm-12 d-flex">
                    <div class="appoinments_listing_search d-flex w-100">
                        <div class="search_field search_result w-100">
                            <input type="text" placeholder="SEARCH" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" class="form-control eb-form-control" />
                            <i class="fa fa-search"></i>
                            <i class="fa fa-times-circle"></i>
                        </div>
                        <input type="submit" class="btn orange btn-lg ml-4" value="Search"> 
                    </div> 
                </div> 
            </div>
        </form>
        <div class="row align-items-center mb-3">
            <?php if ($pending_appointments->count()) { ?>
                <div class="col-sm-12 mt-4">
                    <h5 class="text-orange mb-0"><strong>Appointment Requests <span class="text-white">(<?= $pending_appointments->count() ?>)</span></strong></h5>
                </div>
                <?php
                if ($pending_appointments) {
                    foreach ($pending_appointments as $value) {
                        if ($value->appointmentClient->image) {
                            $imag_url = asset('public/images/' . $value->appointmentClient->image);
                        } else {
                            $imag_url = asset('public/images/users/default.jpg');
                        }
                        if ($value->status == 'pending') {
                            ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="appointment-box">
                                    <div class="head">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?= $imag_url ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name d-sm-flex"> <?= ucfirst($value->appointmentClient->first_name) . ' ' . ucfirst($value->appointmentClient->last_name) ?> 
                                                    <?php if (strtotime($value->end_date) > strtotime(date('Y-m-d H:i:s'))) { ?>  
                                                        <a href="#" class="btn d-none d-sm-block orange small round"  data-toggle="modal" data-target="#exampleModalCenter<?= $value->id ?>"> Refer a Trainer </a>
                                                    <?php } ?>
                                                </div>
                                                <div class="type">
                                                    <?php $age = date_diff(date_create($value->appointmentTrainer->dob), date_create('today'))->y; ?>
                                                    Age <?= $age ?> years
                                                </div>
                                                <?php if (strtotime($value->end_date) > strtotime(date('Y-m-d H:i:s'))) { ?>  
                                                    <a href="#" class="btn orange d-sm-none small round"  data-toggle="modal" data-target="#exampleModalCenter<?= $value->id ?>"> Refer a Trainer </a>
                                                <?php } ?>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <strong class="text-orange">Start Time</strong>
                                                <div><?= $value->start_time ?></div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <strong class="text-orange">End Time</strong>
                                                <div><?= $value->end_time ?></div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <strong class="text-orange">Date</strong>
                                                <div><?= date('F d, Y', strtotime($value->date)) ?></div>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <strong class="text-orange">Session Type</strong>
                                                <div><?php
                                                    if ($value->number_of_passes == '1') {
                                                        echo 'Individual';
                                                    } else if ($value->number_of_passes == '2') {
                                                        echo 'Couple';
                                                    } else {
                                                        echo 'Group';
                                                    }
                                                    ?></div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <strong class="text-orange">Goals</strong>
                                                <div>
                                                    <?php
                                                    if ($value->appointmentClient->userFitness) {
                                                        foreach ($value->appointmentClient->userFitness as $goals) {
                                                            echo $goals->goal->title . ', ';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <strong class="text-orange">Distance</strong>
                                                <div>
                                                    <?php
                                                    if ($current_user->lat != '' && $current_user->lng != '') {
                                                        $cal_dis = distance($current_user->lat, $current_user->lng, $value->client_lat, $value->client_lng);
                                                        if ($cal_dis['status'] == 'OK') {
                                                            echo '<span class="curr_distance">' . number_format($cal_dis['distance'], 2, '.', '') . '</span>' . ' Miles';
                                                            echo '<input type="hidden" name="cal_distance" value="' . number_format($cal_dis['distance'], 2, '.', '') . '">';
                                                            echo '<input type="hidden" name="cal_duration" value="' . round($cal_dis['duration']) . '">';
                                                        } else {
                                                            echo 'Unable to deduct location.';
                                                        }
                                                    } else {
                                                        echo 'Unable to deduct location. Please update your valid address';
                                                    }
                                                    ?>   
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <input type="hidden" name="curr_address" value="<?= $current_user->address ?>">
                                    <input type="hidden" name="curr_lat" value="<?= $current_user->lat ?>">
                                    <input type="hidden" name="curr_lng" value="<?= $current_user->lng ?>">
                                    <input type="hidden" name="client_lat" value="<?= $value->client_lat ?>">
                                    <input type="hidden" name="client_lng" value="<?= $value->client_lng ?>">                                    
                                    <div class="d-flex response_btns"> 
                                        <?php if (strtotime($value->end_date) < strtotime(date('Y-m-d H:i:s'))) { ?>  
                                            <a href="javascript:void(0)" class="btn-warning confirm disabled"> Expired </a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0)" class="btn_warning confirm confirm_dialoge"  data-id="<?= $value->id ?>" data-client-id="<?= $value->appointmentClient->id ?>"> Confirm </a>
                                        <?php } ?>
                                        <a href="javascript:void(0)" data-id="<?= $value->id ?>" data-client-id="<?= $value->appointmentClient->id ?>" class="btn_red discard_appoint"> Discard </a>

                                    </div>
                                    <div class="loader_absolute d-none" id="loader_absolute<?= $value->id ?>">
                                        <div class="inner d-flex align-items-center justify-content-center">
                                            <div class="icon_loader"></div>
                                        </div>
                                    </div>

                                </div> <!-- appointment -->

                            </div> <!-- col --> 

                            <?php
                        }
                    }
                }
                ?>

            <?php } ?> 
            <!--Confirmation Box-->
            <div class="modal fade" id="addavailability" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLongTitle">Are you sure to confirm this?</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row"> 
                                    <div class="col-12"><label>Travel From</label> </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-sm-8">
                                        <div class="input-group"> 
                                            <input type="text" id="autocomplete" name="address" placeholder="Street Address"  value="" class="form-control eb-form-control travel_from"/>
                                            <input type="hidden" name="id"/>

                                            <input type="hidden" id="lat" name="curr_lat"/>
                                            <input type="hidden" id="lng" name="curr_lng"/>

                                            <input type="hidden" name="client_lat" value=""/>
                                            <input type="hidden" name="client_lng" value=""/>

                                            <input type="hidden" name="trainee_distance" value=""/>
                                            <input type="hidden" name="travelling_time" value=""/>
                                        </div>
                                        <label id="location_error" style="display: none;" class="error text-orange"></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="button" class="btn btn-lg orange calculate_distance" value="Calculate">
                                    </div>
                                </div> 
                            </div>
                            <div class="row"> 
                                <div class="col-sm-12">
                                    <strong class="text-orange">Distance</strong>
                                    <div>
                                        <span class="cal_distance"></span> 
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="modal-footer justify-content-start">
                            <button type="button" data-id="" data-client-id="" class="btn btn-lg orange confim_now">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Confirmation Box--> 
        </div> <!-- row -->

        <div class="filter_appointments_wrap">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7">
                    <div class="records_found dark">All Sessions </div>
                </div> <!-- col -->
                <div class="col-lg-3 col-md-4 col-sm-5">
                    <select class="pull-right filter form-control eb-form-control" name="filter">
                        <option value="">All</option>
                        <option value="accepted" <?= (isset($_GET['filter']) && $_GET['filter'] == 'accepted') ? 'selected' : '' ?>>Accepted</option>
                        <option value="completed" <?= (isset($_GET['filter']) && $_GET['filter'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div> <!-- col -->
            </div> <!-- row -->
        </div>

        <ul class="appoinments_listing">
            <?php
            if ($result && count($result) > 0) {

                foreach ($result as $value) {
                    if ($value->appointmentClient->image) {
                        $imag_url = asset('public/images/' . $value->appointmentClient->image);
                    } else {
                        $imag_url = asset('public/images/users/default.jpg');
                    }
                    if ($value->status != 'pending' && $value->status != 'expired') {
                        ?>
                        <li class="d-flex flex-column flex-md-row"> 
                            <div class="align-items-center d-flex flex-lg-row flex-md-column flex-sm-row profile_info">
                                <div class="image">
                                    <div class="img" style="background-image: url(<?= $imag_url ?>);"></div>
                                </div>
                                <div class="info">
                                    <div class="name"><?= $value->appointmentClient->first_name . ' ' . $value->appointmentClient->last_name ?></div>
                                    <div class="type">
                                        <?php $age = date_diff(date_create($value->appointmentClient->dob), date_create('today'))->y; ?>
                                        Age <?= $age ?> years
                                    </div>
                                    <?php if ($value->status == 'accepted' && (time() < strtotime($value->start_date)) ) { ?>
                                        <a href="#" class="btn d-none d-sm-block orange small round"  data-toggle="modal" data-target="#exampleModalCenter<?= $value->id ?>"> Refer a Trainer </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="detail d-lg-flex">
                                <div class="info flex-column w-100 d-flex align-self-center">
                                    <div class="row no-gutters w-100">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-2">
                                            <div><strong class="text-orange">Date</strong></div>
                                            <div><?= date('F d, Y', strtotime($value->date)) ?></div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-2">
                                            <strong class="text-orange">Session Type</strong>
                                            <div> <?php
                                                if ($value->number_of_passes == '1') {
                                                    echo 'Individual';
                                                } else if ($value->number_of_passes == '2') {
                                                    echo 'Couple';
                                                } else {
                                                    echo 'Group';
                                                }
                                                ?></div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-2">
                                            <strong class="text-orange">Start Time</strong>
                                            <div><?= $value->start_time; ?></div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-2">
                                            <strong class="text-orange">End Time</strong>
                                            <div><?= $value->end_time; ?></div>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-12 mb-2">
                                            <div><strong class="text-orange">Goals</strong></div>
                                            <div>
                                                <?php
                                                if ($value->appointmentClient->userFitness) {
                                                    foreach ($value->appointmentClient->userFitness as $goals) {
                                                        echo $goals->goal->title . ', ';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-12 mb-2">
                                            <div><strong class="text-orange">Status</strong></div>
                                            <div><?= ucfirst($value->status); ?></div>
                                        </div>
                                        <?php if ($value->status == 'accepted') { ?>
                                            <div class="col-12 mb-2">
                                                <strong class="text-orange">Address</strong>
                                                <div><?= $value->client_location; ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="btns-group ml-lg-auto align-self-center">


                                    <?php if ($value->status == 'accepted') { ?>
                                        <a href="javascript:void(0)" onclick="openMessageModal(<?= $value->appointmentClient->id ?>)" class="btn btn-outline"> Message </a>

                                        <?php if(time() < strtotime($value->start_date)){?>                                       
                                        <a href="javascript:void(0)" data-id="<?= $value->id ?>" data-client-id="<?= $value->appointmentClient->id ?>" class="btn btn-outline mx-auto cancel"> Cancel Session </a> 
                                        <?php } ?>
                                        <a href="<?= url('session_detail') . '/' . $value->id; ?>" class="btn btn-outline"> View Detail </a>
                                        <!-- Change appointmetn model start-->
                                        <div class="modal fade" id="changeAppointmet_<?= $value->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="exampleModalLongTitle">Change Appointment Date/time.</h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="post" class="change_appointmetn_form">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label>Appointment date.</label>
                                                                    <input type="hidden" name="edit_id" value="<?= $value->id ?>">
                                                                    <input type="hidden" name="user_timezone" value="">
                                                                    <div class="input-group date" id="timefrom" data-target-input="nearest">
                                                                        <input autocomplete="off" id="shoot_date" data-toggle="datetimepicker" data-target="#shoot_date" type="text" class="form-control  eb-form-control" name="date" placeholder="Select Date" value="" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="m-2 session_time" id="time_slot"></div>
                                                                </div>
                                                                <div class="col-sm-12 m-2 text-danger">
                                                                    <span class="validation_errro"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-start">
                                                            <button type="button" class="btn btn-lg orange change_date_btn">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End change appointmetn model start-->
                                    <?php } else if ($value->status == 'rejected' || $value->status == 'completed' || ($value->status == 'canceled')) { ?>

                                        <a href="javascript:void(0)" data-id="<?= $value->id; ?>" class="btn btn-purple orange delete_appointment"> Delete</a> 
                                        <a href="<?= url('session_detail') . '/' . $value->id; ?>" class="btn btn-outline"> View Detail </a>

                                    <?php } ?>

                                </div>
                            </div> 
                        </li> 
                        <?php
                    }
                }
            } else {
                ?>
                <li class="text-center pt-2 pb-2">
                    No result found
                </li>
            <?php } ?>
        </ul>
        <?= $result->links() ?>
    </div><!-- container -->
</div><!-- overlay -->
</div><!-- image_overlay -->        
<?php
if ($pending_appointments) {
    foreach ($pending_appointments as $value) {
        ?>
        <div class="modal fade" id="exampleModalCenter<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Refer a Trainer</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 mb-2">
                                <div class="search_field dark">
                                    <input type="text" placeholder="SEARCH" class="form-control eb-form-control" data-appoint_id="<?= $value->id; ?>" id="searcy_tranner">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div> 
                        </div>
                        <div class="refer_trainer_list_wrap">
                            <ul class="refer_trainer_list">
                                <?php
                                if ($tainee) {
                                    foreach ($tainee as $traine) {
                                        if ($traine->image) {
                                            $imag_url = asset('public/images/' . $traine->image);
                                        } else {
                                            $imag_url = asset('public/images/users/default.jpg');
                                        }
                                        ?>
                                        <li class="d-flex align-items-center">
                                            <div class="profile_info d-flex align-items-center">
                                                <div class="image">
                                                    <div class="img" style="background-image: url(<?= $imag_url ?>);"></div>
                                                </div>
                                                <div class="info">
                                                    <div class="name"><?= $traine->first_name . ' ' . $traine->last_name ?></div>
                                                    <div class="type">Age <?= date_diff(date_create($traine->dob), date_create('today'))->y; ?> years

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto"> 
                                                <a href="javascript:void(0)" data-appointment-id="<?= $value->id; ?>" data-client-id="<?= $value->appointmentClient->id; ?>" data-client-lat="<?= $value->client_lat; ?>" data-client-lng="<?= $value->client_lng; ?>" data-trainee-id="<?= $traine->id; ?>" class="btn_message refer_to">Refer</a>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?> 
                                    <li class="align-items-center d-flex justify-content-center">
                                        <p class="text-center">No record found</p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<?php
if ($result) {
    foreach ($result as $value) {
        ?>
        <div class="modal fade" id="exampleModalCenter<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Refer a Trainer</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-12 mb-2">
                                <div class="search_field dark">
                                    <input type="text" placeholder="SEARCH" class="form-control eb-form-control" data-appoint_id="<?= $value->id; ?>" id="searcy_tranner">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div> 
                        </div>
                        <div class="refer_trainer_list_wrap">
                            <ul class="refer_trainer_list">
                                <?php
                                if ($tainee) {
                                    foreach ($tainee as $traine) {
                                        if ($traine->image) {
                                            $imag_url = asset('public/images/' . $traine->image);
                                        } else {
                                            $imag_url = asset('public/images/users/default.jpg');
                                        }
                                        ?>
                                        <li class="d-flex align-items-center">
                                            <div class="profile_info d-flex align-items-center">
                                                <div class="image">
                                                    <div class="img" style="background-image: url(<?= $imag_url ?>);"></div>
                                                </div>
                                                <div class="info">
                                                    <div class="name"><?= $traine->first_name . ' ' . $traine->last_name ?></div>
                                                    <div class="type">Age <?= date_diff(date_create($traine->dob), date_create('today'))->y; ?> years

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto"> 
                                                <a href="javascript:void(0)" data-appointment-id="<?= $value->id; ?>" data-client-id="<?= $value->appointmentClient->id; ?>" data-client-lat="<?= $value->client_lat; ?>" data-client-lng="<?= $value->client_lng; ?>" data-trainee-id="<?= $traine->id; ?>" class="btn_message refer_to">Refer</a>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?> 
                                    <li class="align-items-center d-flex justify-content-center">
                                        <p class="text-center">No record found</p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <?php
    }
}
?>

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

    var days_array = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    $('#shoot_date').datetimepicker({
        format: 'MMMM DD, YYYY',
        pickTime: false,
        minDate: moment(),
        authide: true
    });

    $("#shoot_date").on("blur.datetimepicker", function (e) {
        var date = $(this).val();
        var new_date = new Date(date);
        console.log(new_date);
        var day_no = new_date.getDay();
        var selected_day = days_array[day_no];
        $.ajax({
            type: "POST",
            url: "<?php echo asset('getAvailableTimeSlots'); ?>",
            data: {'date': date, 'day': selected_day, 'timezone': getUserTimeZone()},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                $('#time_slot').html(data.html);
            }
        });
    });

    $('body').on('click', '.change_date_btn', function () {
        $form = $(this).parents('form');
        $form.find('input[name="user_timezone"]').val(getUserTimeZone());
        var new_date = $form.find('input[name="date"]').val();
        var new_time = $form.find('input:radio[name="time"]:checked').val();

        if (typeof new_date == 'undefined' || new_date == '') {
            $form.find('.validation_errro').html('Date field is required');
            return false;
        }

        if (typeof new_time == 'undefined' || new_time == '') {
            $form.find('.validation_errro').html('Time field is required');
            return false;
        }
        showLoading();
        var formData = new FormData($form[0]);
        $.ajax({
            type: "POST",
            url: base_url + "update_appointment_schedule",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', "<?= csrf_token(); ?>");
            },
            success: function (data) {
                if (data.success) {
                    $('.custom_alert').show();
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> ' + data.message);
                    hideLoading();
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);

                } else {
                    $('.custom_alert').removeClass('alert-success');
                    $('.custom_alert').addClass('alert-danger');
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Error! </strong> ' + data.error);
                    $('.custom_alert').show();
                    hideLoading();
                }
            }
        });

    });

    $('body').on('change', '.filter', function () {
        var val = $(this).val();
        window.location.href = base_url + 'appointments?filter=' + val;
    });

    jQuery(".refer_trainer_list_wrap").mCustomScrollbar({});

    window.initAutocomplete = function () {
        autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')),
                {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    }

    $('body').on('change', '.travel_from', function () {
        $(this).parents('.row').find('input[name="curr_lat"]').val('');
        $(this).parents('.row').find('input[name="curr_lng"]').val('');
        $(this).parents('.row').find('.confim_now').attr('disabled', true);
    });

    $('body').on('click', '.calculate_distance', function () {

        var address = $(this).parents('.row').find('input[name="address"]').val();
        var confirm_now = $(this).parents('.row').find('.confim_now');

        var curr_lat = $(this).parents('.form-group').find('input[name="curr_lat"]').val();
        var curr_lng = $(this).parents('.form-group').find('input[name="curr_lng"]').val();

        var client_lat = $(this).parents('.form-group').find('input[name="client_lat"]').val();
        var client_lng = $(this).parents('.form-group').find('input[name="client_lng"]').val();

        var distance_field = $(this).parents('.form-group').find('input[name="trainee_distance"]');
        var time_field = $(this).parents('.form-group').find('input[name="travelling_time"]');


        var distance_div = $(this).parents('.row').find('.cal_distance');

        if (!curr_lat || !curr_lng) {
            $(this).parents('.row').find('input[name="address"]').focus();
            return false;
        }
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('calcute_distance_ajax') ?>",
            data: {curr_lat: curr_lat, curr_lng: curr_lng, client_lat: client_lat, client_lng: client_lng, "_token": "<?= csrf_token() ?>"},
            dataType: 'json',
            success: function (data) {
                hideLoading();
                confirm_now.attr('disabled', false);
                distance_field.val(data.distance);
                distance_div.html(data.distance + ' Miles');
                time_field.val(data.duration);
            }
        });
    });

    $('body').on('click', '.confirm_dialoge', function () {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-client-id');
        var trainee_distance = $(this).parents('.appointment-box').find('input[name="cal_distance"]').val();
        var travelling_time = $(this).parents('.appointment-box').find('input[name="cal_duration"]').val();
        $('#modal_title').html('Appointment Confirmation.');
        $('#modal_body').html('Are you sure to confirm this appointment?');
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#modal_yes_btn', function (e) {
            showLoading();
            $.ajax({
                type: "POST",
                url: "<?= url('confirm_appointment') ?>",
                data: {id: id, trainee_distance: trainee_distance, travelling_time: travelling_time},
                dataType: 'json',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', "<?= csrf_token(); ?>");
                },
                success: function (data) {
                    if (data.success) {

                        generateThread(otherid);
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
                        setTimeout(function () {
                            hideLoading();
                            window.location.reload();
                        }, 1000);

                    } else {
                        $('.custom_alert').removeClass('alert-success');
                        $('.custom_alert').addClass('alert-danger');
                        $('.alert-content').html('<strong><i class="fa fa-check"></i> Warning! </strong> ' + data.error);
                        $('.custom_alert').show();
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    }
                }
            });
        });
    });

    $('body').on('click', '.confim_now', function () {
        var otherid = $(this).attr('data-client-id');
        var address = $(this).parents('.modal-content').find('input[name="address"]').val();
        var curr_lat = $(this).parents('.modal-content').find('input[name="curr_lat"]').val();
        var curr_lng = $(this).parents('.modal-content').find('input[name="curr_lng"]').val();

        var trainee_distance = $(this).parents('.modal-content').find('input[name="trainee_distance"]').val();
        var time_field = $(this).parents('.modal-content').find('input[name="travelling_time"]').val();

        var id = $(this).parents('.modal-content').find('input[name="id"]').val();
        $(this).parents('.modal-content').find('#location_error').hide();

        if (!address && !curr_lat && !curr_lng) {
            $('#location_error').html('This field is required');
            $('#location_error').show();
            return false;
        }
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('confirm_appointment') ?>",
            data: {id: id, address: address, curr_lat: curr_lat, curr_lng: curr_lng, trainee_distance: trainee_distance, travelling_time: time_field},
            dataType: 'json',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', "<?= csrf_token(); ?>");
            },
            success: function (data) {
                if (data.success) {

                    generateThread(otherid);
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
                    setTimeout(function () {
                        hideLoading();
                        window.location.reload();
                    }, 1000);

                } else {
                    $('.custom_alert').removeClass('alert-success');
                    $('.custom_alert').addClass('alert-danger');
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Warning! </strong> ' + data.error);
                    $('.custom_alert').show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                }
            }
        });
    });

    $('body').on('keyup', '#searcy_tranner', function () {
        var search = $(this).val();
        var appoint_id = $(this).attr('data-appoint_id');
        $('.refer_trainer_list').html(`<div class="inner d-flex align-items-center justify-content-center">
                                        <div class="icon_loader"></div>
                                    </div>`);
        $.ajax({
            type: "POST",
            url: "<?= url('search_tranner_ajax') ?>",
            data: {search: search, appoint_id: appoint_id, "_token": "<?= csrf_token() ?>"},
            dataType: 'json',
            success: function (data) {
                $('.refer_trainer_list').html(data.result);
            }
        });
    });

    $('body').on('click', '.complete', function () {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-client-id');
        var element_id = $(this).parents('.appointment-box').find('.loader_absolute').attr('id');
        $('#modal_title').html('Complete Session?');
        $('#modal_body').html('Are you sure that you want to complete this session?');
        $('#modal_yes_btn').attr('onclick', 'complete(' + id + ',' + otherid + ',' + element_id + ')');
        $('#modal').modal('show');
    });

    function complete(id, otherid, element_id) {
        $('#modal').modal('hide');
        showLoading();
        $('#' + element_id).removeClass('d-none');
        $.ajax({
            type: "POST",
            url: "<?= url('response_appointment') ?>",
            data: {id: id, type: 'complete', respond_by: 'tranee', },
            dataType: 'json',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
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
                $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> Session Completed successfully');
                setTimeout(function () {
                    hideLoading();
                    window.location.reload();
                }, 1000);
            }
        });
    }

    $('body').on('click', '.refer_to', function () {
        var appointment_id = $(this).attr('data-appointment-id');
        var trainee_id = $(this).attr('data-trainee-id');
        var otherid = $(this).attr('data-client-id');
        var lat = $(this).attr('data-client-lat');
        var lng = $(this).attr('data-client-lng');
        $.ajax({
            type: "POST",
            url: "<?php echo asset('check_for_distance_range'); ?>",
            data: {'lat': lat, 'lng': lng, 'trainer_id': trainee_id},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    $('.custom_alert').hide();
                    $('#modal_title').html('Refer Session?');
                    $('#modal_body').html('Are you sure you want to refer this?');
                    $('#modal_yes_btn').attr('onclick', 'referTo(' + appointment_id + ',' + trainee_id + ',' + otherid + ')');
                    $('#modal').modal('show');
                } else {
                    $('.custom_alert').removeClass('alert-success');
                    $('.custom_alert').addClass('alert-danger');
                    $('.alert-content').html('This trainer cannot travel to client\'s area!');
                    $('.custom_alert').fadeIn();
                    setTimeout(function () {
                        $('.custom_alert').fadeOut();
                    }, 5000);
                }
            }
        });
    });

    function referTo(appointment_id, trainee_id, otherid) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('reffer_to') ?>",
            data: {appointment_id: appointment_id, trainee_id: trainee_id, '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                $('.custom_alert').removeClass('alert-danger');
                $('.custom_alert').addClass('alert-success');
                $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> Session reffered successfully');
                socket.emit('notification_get', {
                    "user_id": otherid,
                    "other_id": '<?= $current_id ?>',
                    "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                    "photo": '<?= $current_photo ?>',
                    "text": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>' + data.text,
                    "url": '<?= asset('trainer-public-profile') ?>' + '/' + trainee_id,
                    "type": 'appointment',
                    "unread_counter": ''
                });
                setTimeout(function () {
                    hideLoading();
                    window.location.reload();
                }, 1000);
            }
        });
    }

    $('body').on('click', '.discard_appoint', function (e) {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-client-id');
        var element_id = $(this).parents('.appointment-box').find('.loader_absolute').attr('id');
        $('#modal_title').html('Discard Request?');
        $('#modal_body').html('Are you sure that you want to discard this session request?');
        $('#modal_yes_btn').attr('onclick', 'discardAppointment(' + id + ',' + otherid + ',"' + element_id + '")');
        $('#modal').modal('show');
    });

    function discardAppointment(id, otherid, element_id) {
        $('#modal').modal('hide');
        $('#' + element_id).removeClass('d-none');
        $.ajax({
            type: "POST",
            url: "<?= url('response_appointment') ?>",
            data: {id: id, type: 'discard', respond_by: 'tranee', '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
                $('.custom_alert').removeClass('alert-danger');
                $('.custom_alert').addClass('alert-success');
                $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> Session discarded successfully');
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
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    }

    $('body').on('click', '.cancel', function () {
        var id = $(this).attr('data-id');
        var otherid = $(this).attr('data-client-id');
        var element_id = $(this).parents('.appointment-box').find('.loader_absolute').attr('id');
        $('#modal_title').html('Cancel Session?');
        $('#modal_body').html('Are you sure that you want to cancel this session?');
        $('#modal_yes_btn').attr('onclick', 'cancel(' + id + ',' + otherid + ',' + element_id + ')');
        $('#modal').modal('show');
    });

    function cancel(id, otherid, element_id) {
        $('#modal').modal('hide');
        showLoading();
        $('#' + element_id).removeClass('d-none');
        $.ajax({
            type: "POST",
            url: "<?= url('response_appointment') ?>",
            data: {id: id, type: 'cancel', respond_by: 'tranee', '_token': "<?= csrf_token(); ?>"},
            dataType: 'json',
            success: function (data) {
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
                $('.custom_alert').show();
                $('.custom_alert').removeClass('alert-danger');
                $('.custom_alert').addClass('alert-success');
                $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> Session canceled successfully');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    }

    $('body').on('click', '.delete_appointment', function () {
        var id = $(this).attr('data-id');
        $('#modal_title').html('Delete Appointment?');
        $('#modal_body').html('Are you sure that you want to delete this appointment?');
        $('#modal_yes_btn').attr('onclick', 'deleteAppointment(' + id + ')');
        $('#modal').modal('show');
    });

    function deleteAppointment(id) {
        $('#modal').modal('hide');
        showLoading();
        $.ajax({
            type: "POST",
            url: "<?= url('response_appointment') ?>",
            data: {id: id, type: 'del', 'delete_by': 'tranee', '_token': "<?= csrf_token(); ?>"},
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&libraries=places&callback=initAutocomplete"
async defer></script>
</body>
</html>