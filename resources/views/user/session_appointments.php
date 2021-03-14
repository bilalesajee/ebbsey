<?php include resource_path('views/includes/header.php'); ?>
<div class="edit_profile_wrapper bg_blue">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">APPOINTMENTS</h4>
            </div>
        </div>
        <div class="row align-items-center mb-3">
            <div class="col-sm-12">
                <div class="search_field">
                    <input type="text" placeholder="SEARCH" class="form-control eb-form-control" />
                    <i class="fa fa-search"></i>
                </div>
            </div>

            <?php if ($result->where('status', 'pending')->count()) { ?>
                <div class="col-sm-12 mt-4">
                    <h5 class="text-orange mb-0"><strong>Appointment Requests <span class="text-white">(<?= $result->where('status', 'pending')->count() ?>)</span></strong></h5>
                </div>
                <?php
                if ($result) {
                    foreach ($result as $value) {
                        if ($value->status == 'pending') {
                            ?>
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="appointment-box">
                                    <div class="head">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images4.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name d-sm-flex"> <?= $value->appointmentClient->first_name . ' ' . $value->appointmentClient->last_name ?> 
                                                    <a href="#" class="btn d-none d-sm-block orange small round"  data-toggle="modal" data-target="#exampleModalCenter"> Refer a Trainer </a>
                                                </div>
                                                <div class="type">Trainer</div>
                                                <a href="#" class="btn orange d-sm-none small round"  data-toggle="modal" data-target="#exampleModalCenter"> Refer a Trainer </a>
                                            </div>
                                        </div>
                                        <div class="d-flex action_btns justify-content-between">

                                            <a href="#" class="btn_message mx-auto"> Cancel Session </a>
                                        </div>
                                    </div>
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-sm-4 mb-2">
                                                <strong class="text-orange">Start Time</strong>
                                                <div><?= $value->start_time ?></div>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <strong class="text-orange">End Time</strong>
                                                <div><?= $value->end_time ?></div>
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <strong class="text-orange">Date</strong>
                                                <div><?= $value->date ?></div>
                                            </div>
                                            <div class="col-sm-12 mb-2">
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
                                                <div>Build Muscles, Tone - Up, Diet, Manage Weight</div>
                                            </div>
                                            <div class="col-sm-12">
                                                <strong class="text-orange">Address</strong>
                                                <div><?= $value->appointmentClient->address; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex response_btns">
                                        <a href="javascript:void(0)" data-id="<?= $value->id ?>" class="btn_green confirm"> Confirm </a>
                                        <a href="#" class="btn_red"> Discard </a>
                                    </div>
                                </div> <!-- appointment -->
                            </div> <!-- col --> 
                            <?php
                        }
                    }
                }
                ?>

            <?php } ?> 
        </div> <!-- row -->
        <div class="records_found dark">All Sessions</div>

        <ul class="appoinments_listing">
            <?php
            if ($result) {
                foreach ($result as $value) {
                    if ($value->status != 'pending') {
                        ?>
                        <li class="d-flex flex-column flex-md-row">
                            <div class="align-items-center d-flex flex-lg-row flex-md-column flex-sm-row profile_info">
                                <div class="image">
                                    <div class="img" style="background-image: url(<?php echo asset('userassets/images/image16.jpg'); ?>);"></div>
                                </div>
                                <div class="info">
                                    <div class="name">Jerry Delgado</div>
                                    <div class="type">Age 26 years</div>
                                </div>
                            </div>
                            <div class="detail d-lg-flex">
                                <div class="info flex-column w-100 d-flex align-self-center">
                                    <div class="row no-gutters w-100">
                                        <div class="col-sm-4 mb-2">
                                            <div><strong class="text-orange">Date</strong></div>
                                            <div>22-09-2018</div>
                                        </div>
                                        <div class="col-sm-4 mb-2">
                                            <strong class="text-orange">Session Type</strong>
                                            <div>Individual</div>
                                        </div>
                                        <div class="col-sm-4 mb-2">
                                            <strong class="text-orange">Time</strong>
                                            <div>12:30am</div>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <div><strong class="text-orange">Goals</strong></div>
                                            <div>Build Muscles, Tone - Up, Diet, Manage Weight</div>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <strong class="text-orange">Address</strong>
                                            <div>East 101 Street, New York, NY, USA</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btns-group ml-lg-auto align-self-center">
                                    <a href="#" class="btn btn-outline"> Message </a>
                                    <a href="javascript:void(0)" data-id="<?= $value->id ?>" class="btn btn-outline cancel"> Cancel Session </a>
                                </div>
                            </div>
                        </li> 
                    <?php }
                }
            } ?>
        </ul>
    </div><!-- container -->
</div><!-- overlay -->
</div><!-- image_overlay -->        

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    <div class="col-sm-7 mb-2">
                        <div class="search_field dark">
                            <input type="text" placeholder="SEARCH" class="form-control eb-form-control">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <select class="form-control categories_dropdown eb-form-control ">
                            <option> Build Muscles </option>
                        </select>
                    </div>
                </div>
                <ul class="refer_trainer_list">
                    <li class="d-flex align-items-center">
                        <div class="profile_info d-flex align-items-center">
                            <div class="image">
                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                            </div>
                            <div class="info">
                                <div class="name">James Neves</div>
                                <div class="type">Age 26 years</div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="btn_message">Refer</a>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="profile_info d-flex align-items-center">
                            <div class="image">
                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                            </div>
                            <div class="info">
                                <div class="name">Tim Halter</div>
                                <div class="type">Age 26 years</div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="profile_info d-flex align-items-center">
                            <div class="image">
                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/image9.jpg'); ?>);"></div>
                            </div>
                            <div class="info">
                                <div class="name">Kyle Poe</div>
                                <div class="type">Age 26 years</div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="btn_message">Refer</a>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="profile_info d-flex align-items-center">
                            <div class="image">
                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/image15.jpg'); ?>);"></div>
                            </div>
                            <div class="info">
                                <div class="name">Gregory Tyler</div>
                                <div class="type">Age 26 years</div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="btn_message">Refer</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer justify-content-start">
                <button type="button" class="btn btn-lg orange">Save</button>
            </div>
        </div>
    </div>
</div>
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $('body').on('click', '.confirm', function () {
        var id = $(this).attr('data-id');
        if (confirm('Are you sure to confirm?')) {
            $.ajax({
                type: "POST",
                url: "<?= url('confirm_appointment') ?>",
                data: {id: id},
                dataType: 'json',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {

                    window.location.reload();
                }
            });
        }
    });

    $('body').on('click', '.cancel', function () {
        var id = $(this).attr('data-id');
        if (confirm('Are you sure to cancel?')) {
            $.ajax({
                type: "POST",
                url: "<?= url('cancel_appointment') ?>",
                data: {id: id},
                dataType: 'json',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    window.location.reload();

                }
            });
        }
    });

</script>
</body>
</html>