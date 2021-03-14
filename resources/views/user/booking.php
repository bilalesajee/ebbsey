<?php include resource_path('views/includes/header.php'); ?>
<style>
    .price-plan-wrap.custom_option.element-selected input[type='radio'] {
        display: none;
    }
    .price-plan-wrap.custom_option.element-selected .icon_selected {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<div class="page_overlay booking-page" style="background-image: url('<?= asset('userassets/images/image14.jpg') ?>')">
    <div class="overlay pb-0">
        <div class="booking_header">
            <h3 class="booking_name">You’re now booking <span class="text-orange"><?= $classData->class_name ?></span></h3>
            <div class="trainer_type grey d-flex flex-wrap">
                <div class="ml-sm-auto text-white steps"> STEP <span class="step_count"> 1 </span> / <span> 4 </span></div>
            </div>
        </div>
        <div class="booking_step_progress_bar">
            <span class="progress_bar" style="width: 25%"></span>
        </div>
        <!--Step One-->
        <div id="step_one">
            <div class="step_detail choose_time">
                <div class="title">
                    <h5>PICK A DAY</h5>
                    <p>Fantastic. Which day would you like to pick?</p>
                </div>                
                <div class="full_calender_view_link">
                    <span class="text-orange" data-toggle="modal" data-target="#fullcalender">See Full Calendar View</span>
                </div>
                <div class="owl-carousel calender_carousel owl-theme">
                </div>
            </div>
            <div class="booking_footer d-flex flex-column flex-sm-row flex-wrap align-items-center">
                <div class="next_step">NEXT STEP: <span class="text-orange">PICK A TIME</span> </div>
                <div class="ml-sm-auto"><a href="javascript:void(0)" class="btn orange proceed_to_two">Proceed to next step <span class="arrow"></span></a></div>
            </div>

        </div>
        <!--End Step One-->

        <!--Step tow-->
        <div id="step_two" style="display: none">
            <div class="step_detail choose_time">
                <div class="title">
                    <h5>PICK A TIME</h5>
                    <p>Fantastic. Which time would you like to pick?</p>
                </div>
                <div class="time-period">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6 col-xs-12 found morning_div">
                            <div class="block">
                                <input type="radio" name="period" class="day_part_radio_btn" selected data-day-part="morning"/>
                                <span class="icon-clock"></span>
                                <div class="name d-flex align-items-center justify-content-center"> <span class="icon-sun"></span>MORNING</div>
                                <span class="icon_selected"></span>
                                <div class="font-12 text-orange day_part_alert_message" style="display:none;">
                                    <p class="mb-0">Sorry, this class is booked out.<br> Find another time or day.</p><br/><br/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 found afternoon_div">
                            <div class="block">
                                <input type="radio" name="period" class="day_part_radio_btn" data-day-part="afternoon" />
                                <span class="icon-clock"></span>
                                <div class="name d-flex align-items-center justify-content-center"> <span class="icon-cloud"></span>AFTERNOON</div>
                                <span class="icon_selected"></span>
                                <div class="font-12 text-orange day_part_alert_message" style="display:none;">
                                    <p class="mb-0">Sorry, this class is booked out.<br> Find another time or day.</p><br/><br/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 found evening_div">
                            <div class="block">
                                <input type="radio" name="period" class="day_part_radio_btn" data-day-part="evening"/>
                                <span class="icon-clock"></span>
                                <div class="name d-flex align-items-center justify-content-center"> <span class="icon-night"></span>Evening</div>
                                <span class="icon_selected"></span>
                                <div class="font-12 text-orange day_part_alert_message" style="display:none;">
                                    <p class="mb-0">Sorry, this class is booked out.<br> Find another time or day.</p><br/><br/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="font-weight-bold mt-4">
                        <p>WANT TO CHANGE DAY? <a href="javascript:void(0)" class="text-orange change_day">CLICK HERE</a></p>                
                    </div>
                </div>
                <div class="session_time" id="slots_div"></div>
            </div>
            <div class="booking_footer d-flex flex-column flex-sm-row flex-wrap align-items-center">
                <div class="next_step">NEXT STEP: <span class="text-orange">APPOINTMENT DETAILS</span> </div>
                <div class="ml-sm-auto"><a href="javascript:void(0)" class="btn orange proceed_to_three">Proceed to next step <span class="arrow"></span></a></div>
            </div>
        </div>
        <!--End Step tow-->

        <!--Step three-->
        <div id="step_three" style="display: none">
            <div class="step_detail choose_time">
                <div class="title">
                    <h5>CONFIRMATION OF DETAILS</h5>
                    <p>Are the below appointment details correct?</p>
                </div>
                <div class="time-period">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="block element-selected">
                                <span class="icon-calender"></span>
                                <div class="name d-flex align-items-center justify-content-center selected_day" id="confirmation_day"></div>
                                <span class="icon_selected"></span>
                                <div class="mt-2 text-weight-bold selected_date" id="confirmation_date"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="block element-selected">
                                <span class="icon-clock"></span>
                                <div class="name d-flex align-items-center justify-content-center" id="confirmation_day_part"></div>
                                <div class="session_time">
                                    <span class="time">
                                        <!--<input type="radio" name="period" checked="checked"/>-->
                                        <span class="selected_slot"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="font-weight-bold">
                    <p>WANT TO CHANGE DETAILS? <a href="javascript:void(0)" class="text-orange change_scdeduler">CLICK HERE</a></p>                
                </div>
            </div>
            <div class="booking_footer d-flex flex-column flex-sm-row flex-wrap align-items-center">
                <div class="next_step">NEXT STEP: <span class="text-orange">SELECT PASSES</span> </div>
                <div class="ml-sm-auto"><a href="javascript:void(0)" class="btn orange proceed_to_four">Proceed to next step <span class="arrow"></span></a></div>
            </div>
        </div>
        <!--End Step three-->

        <!--Step four-->
        <div id="step_four" style="display: none">
            <div class="step_detail session_type_step">             
                <div class="title">
                    <h5>GREAT ! WE JUST NEED A FEW MORE DETAILS....</h5>
                    <p>How many passes</p>
                </div>                  
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-8 col-xs-12">
                        <?php
                        $total_pass = $user->passes_count;
                        ?> 
<!--                        <select name="" class="eb-form-control form-control mb-3 rounded session_type" data-total="<?= $total_pass; ?>" id="pass_selector">
                            <option disabled selected="" value="">SESSION TYPE</option>
                            <option value="1">ONE</option>
                            <option value="2">COUPLE</option>                            
                            <option value="3">GROUP SESSION</option>                            
                        </select>-->

                        <select name="" class="eb-form-control form-control mb-3 rounded select_pass" data-total="<?= $total_pass; ?>" id="pass_selector">
                            <option disabled selected="" value="">NO OF PASSES</option>
                            <?php
                            if ($total_pass) {
                                $user_pass = 1;
                                while ($user_pass <= $total_pass) {
                                    ?>
                                    <option value="<?= $user_pass ?>"><?= $user_pass ?></option>
                                    <?php
                                    $user_pass++;
                                }
                            }
                            ?>
                        </select>
                        <p class="font-weight-bold mb-2 mt-5">SESSION SUMMARY</p>
                        <div class="session_label d-flex">
                            <div>Number of passes left</div> 					
                            <div class="ml-auto pass_left"><?= $total_pass < 0 ? 0 : $total_pass ?></div>
                        </div>
                        <p class="text-right">
                            <?php if (!$total_pass || $total_pass < 0) { ?>
                            <div class="alert alert-danger" id="no_passes_left">
                                <strong><i class="fa fa-info-circle"></i> Error!</strong> You have no passes left, buy passes now.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <a href="#" class="" data-toggle="modal" data-target="#exampleModalCenter"> Purchase more passes now </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal_price_packages" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLongTitle">Purchase Passes</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php include resource_path('views/includes/passes.php'); ?>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" id="purchaseButton" class="btn btn-lg orange">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="booking_footer d-flex flex-column flex-sm-row flex-wrap align-items-center">
                <!--<div class="next_step">NEXT STEP: <span class="text-orange">CHOOSE PRICING</span> </div>-->
                <div class="ml-sm-auto"><a href="javascript:void(0)" class="btn orange complete"><span class="icon_loading" style="display : none;"></span> Complete <span class="arrow"></span></a></div>
            </div>
        </div>
        <!--End Step four-->

        <form method="post" action="<?= url('create_booking'); ?>" id="scheduler_frm">
            <?= csrf_field(); ?>
            <input type="hidden" name="pick_date" id="pick_date" value="">
            <input type="hidden" name="pick_day" id="pick_day" value="">
            <input type="hidden" name="pick_time" id="pick_time" value="">
            <input type="hidden" name="no_of_pass" id="no_of_pass" value="">
            <input type="hidden" name="trainee_id" value="<?= $classData->trainer_id; ?>">
            <input type="hidden" name="class_id" value="<?= $classData->id; ?>">
            <input type="hidden" name="user_timezone">
        </form>

        <div class="booking_step_progress_bar bottom">
            <span class="progress_bar" style="width: 25%"></span>
        </div>
    </div>
</div>

<div class="modal fade" id="fullcalender">
    <div class="modal-dialog modal-dialog-centered modal-large modal_calender">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Pick a Date</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="calender_popup">
                    <div class="calender_header d-flex"></div>
                    <div class="calender_body d-flex flex-wrap"></div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn orange proceed_to_two">Proceed to next step <span class="arrow"></span></button>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.stripe.com/checkout.js"></script>


<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    var total_passes = '<?= $total_pass ?>';
    var original_price = referral_price = coupon_price = coupon_discount = referral_deductions = 0;
    $('input[name="expiry_date"]').inputmask("mm/yyyy", {"placeholder": "_", "baseYear": 1900});
    $('input[name="card_number"]').mask("9999-9999-9999-9999");
    $('input[name="cvc"]').mask("999");
    $('input[name="coupon_code"]').mask("******");
    $('input[name="referral_code"]').mask("*****");
    $('#payment_modal_trainer_id').val("<?= $user->id ?>");
    var remaining_spots = 0;

    $(document).ready(function () {
        $('input[name="user_timezone"]').val(getUserTimeZone());
        $('#pass_selector').select2();
    });

    $('.day_part_radio_btn').change(function () {
        let day_part = $(this).attr('data-day-part');
        $('.week_days').hide();
        $('.week_days.' + day_part).show();
    });

    $('body').on('change', '.pick_date', function () {

        $('#slots_div').html('');
        $('.found').each(function () {
            $(this).find('input[name="period"]').removeAttr('selected');
            $(this).find('.block').removeClass('element-selected');
            $(this).find('input[name="period"]').show();
            $(this).find('.icon_selected').show();
            $(this).find('.day_part_alert_message').hide();
        });

        var date = $(this).val();
        var selected_day = $(this).attr('data-day');

        $.ajax({
            type: "POST",
            url: "<?php echo asset('get_available_time_slots_of_class'); ?>",
            data: {'date': date, 'day': selected_day, 'timezone': getUserTimeZone(), 'class_id': '<?= $classData->id ?>'},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    var slots = data.data;
                    if (!data.morning) {
                        $('.morning_div').find('input[name="period"]').hide();
                        $('.morning_div').find('.icon_selected').hide();
                        $('.morning_div').find('.day_part_alert_message').show();
                    } else {
                        $('.morning_div').find('.block').addClass('element-selected');
                    }
                    if (!data.afternoon) {
                        $('.afternoon_div').find('input[name="period"]').hide();
                        $('.afternoon_div').find('.icon_selected').hide();
                        $('.afternoon_div').find('.day_part_alert_message').show();
                    }
                    if (!data.evening) {
                        $('.evening_div').find('input[name="period"]').hide();
                        $('.evening_div').find('.icon_selected').hide();
                        $('.evening_div').find('.day_part_alert_message').show();
                    }
                    for (var i = 0; i < slots.length; i++) {
                        let style = '';
                        if (slots[i]["slot_type"] != 'morning') {
                            style = 'display:none;';
                        }
                        var html = '<span class="week_days ' + slots[i]["slot_type"] + '" style="' + style + '">' +
                                '<span class="time">' +
                                '<input type="radio" name="time" class="pick_time" data-day-part="' + slots[i]["slot_type"] + '" data-remaining-spots="' + slots[i]["remaining_spots"] + '" data-text="' + slots[i]["slot"] + '" value="' + slots[i]["slot"] + '">' +
                                '<span>' + slots[i]["slot"] + '</span>' +
                                '</span>' +
                                '</span>';
                        $('#slots_div').append(html);
                    }
                } else {
                    $('.morning_div').find('input[name="period"]').hide();
                    $('.morning_div').find('.icon_selected').hide();
                    $('.morning_div').find('.day_part_alert_message').show();
                    $('.afternoon_div').find('input[name="period"]').hide();
                    $('.afternoon_div').find('.icon_selected').hide();
                    $('.afternoon_div').find('.day_part_alert_message').show();
                    $('.evening_div').find('input[name="period"]').hide();
                    $('.evening_div').find('.icon_selected').hide();
                    $('.evening_div').find('.day_part_alert_message').show();
                }
            }
        });

        $('#confirmation_date').val($(this).attr('data-date'));
        $('#confirmation_day').val(selected_day);
        $('#scheduler_frm').find('#pick_date').val($(this).val());
        $('#scheduler_frm').find('#pick_day').val(selected_day);
        $('.selected_date').html($(this).val());
        $('.selected_day').html($(this).attr('data-day'));

    });

    var amount, no_of_pass;

    $(document).ready(function () {
        updatePackages();
    });

    $('body').on('change', '#no_of_passes', function () {
        updatePackages();
    });

    document.getElementById('purchaseButton').addEventListener('click', function (e) {
        package_name = $(document).find('input[name=package]:checked').attr('data-package-name');
        new_amount = $(document).find('input[name=package]:checked').val();
        no_of_pass = $(document).find('input[name=package]:checked').attr('data-no-of-pass');
        if (new_amount == 'custome') {
            var custom_val = $(document).find('#total_pas_price').val();
            var no_of_pass = $(document).find('#no_of_passes').val();
            if (!custom_val) {
                alert('Enter number of passes?');
                return false;
            }
            new_amount = custom_val;
        } else if (new_amount == 'multiple_option') {

            var custom_val = $(document).find('#multiple_option_total_pas_price').val();
            var no_of_pass = $(document).find('#multiple_option_no_of_passes').val();

            if (!custom_val) {
                alert('Enter number of passes?');
                return false;
            }
            new_amount = custom_val;

        } else if (!new_amount || typeof new_amount == 'undefined') {
            alert('Please select a plan?');
            return false;
        }

        $('#package_name_card_modal').html(package_name);

        var passes_count = 0;
        if (package_name == 'Flex') {
            passes_count = $('#no_of_passes').val();
        } else if (package_name == 'Active') {
            passes_count = $('#option_1_passes_count').html();
        } else if (package_name == 'Ultimate') {
            passes_count = $('#option_bronze_passes_count').html();
        } else if (package_name == 'Sedentary') {
            passes_count = $('#option_gold_passes_count').html();
        }

        $('#coupon_code_response_label').addClass('d-none');
        $('#referral_code_response_label').addClass('d-none');
        $('input[name="passes_count"]').val(passes_count);
        $('#passes_count_in_card_modal').html(passes_count);
        $('#payment_modal_price').val(new_amount);
        $('#payment_modal_package_name').val(package_name);
        $('#modal_price_span').html('$' + new_amount);
        original_price = new_amount;
        
        $('#message-div').html('');
        $('#card_payment_form').find('button[type="submit"]').removeAttr('disabled');
        $('#card_payment_form')[0].reset();
        $('#exampleModalCenter').modal('hide');
        $('#modal_price_span_prev').html('');
        $('#modal_price_span_prev').addClass('d-none');
        if(package_name != 'Flex'){
            $('#coupon_section').hide();
        } else {
            $('#coupon_section').show();
        }
        setTimeout(function () {
            $('#stripe_payment_modal').modal('show');
        }, 1000);
        e.preventDefault();
    });
    
    $('#stripe_payment_modal').on('hidden.bs.modal', function () {
        coupon_discount = 0;
        referral_deductions = 0;
    });

    jQuery.validator.addMethod(
            "trioDate",
            function (value, element) {
                return value.match(/^\d{1,2}\/\d{4}$/);
            },
            "Please enter a date in the format mm/yyyy"
            );


    $("#card_payment_form").validate({
        rules: {
            expiry_date: {
                trioDate: true
            },
            terms_and_conditions: {
                required: true
            }
        },
        messages: {
            terms_and_conditions: {
                required: 'You must agree to terms and conditions!'
            }
        },
        submitHandler: function (form) {
            $('#card_payment_form').find('button[type="submit"]').attr('disabled', '');
            $('#card_payment_form').find('button[type="submit"]').find('.icon_loading').show();
            var formData = new FormData($('#card_payment_form')[0]);
            $.ajax({
                type: "POST",
                url: $('#card_payment_form').attr('action'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.success) {
                        $('#message-div').html('<div class="alert alert-success">Passes purchased successfully</div>');
                        $('.pass_left').html(res.total);
                        total_passes = res.total;
                        $('#pass_selector').attr('data-total', res.total);
                        $('#pass_selector').html(res.html);
                        $('#no_passes_left').hide();
                        setTimeout(function () {
                            $('#stripe_payment_modal').modal('hide');
                            $('#coupon_code_response_label').addClass('d-none');
                        }, 5000);
                    } else {
                        $('#message-div').html('<div class="alert alert-danger">' + res.error + '</div>');
                        $('#card_payment_form').find('button[type="submit"]').find('.icon_loading').hide();
                        $('#stripe_payment_modal').animate({scrollTop: 0}, 1000);
                    }
                }
            });
        }
    });

    $('#apply_coupon_code_btn').click(function () {
        var code = $('input[name="coupon_code"]').val();
        var passes_count = $('#payment_modal_passes_count').val();
        if (code) {
            $('#coupon_code_response_label').addClass('d-none');
            $.ajax({
                type: "POST",
                url: '<?= asset('validate_coupon_code') ?>',
                dataType: 'json',
                data: {'code': code, 'passes_count': passes_count},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if (data.success) {
                        $('#coupon_code_response_label').addClass('alert-success');
                        $('#coupon_code_response_label').removeClass('alert-danger');
                        $('#coupon_code_response_label').html(data.success);
                        $('#coupon_code_response_label').removeClass('d-none');
                        
                        coupon_discount = data.discount;
                        let new_price = ((parseInt((original_price * (100 - coupon_discount)) / 100)) - referral_deductions).toFixed();
                        let old_value = original_price;
                        
                        $('input[name="amount"]').val(new_price);
                        $('#modal_price_span').html('$' + new_price);
                        $('#modal_price_span_prev').html('$' + old_value);
                        $('#modal_price_span_prev').removeClass('d-none');
                        
                    } else if (data.error) {
                        $('#coupon_code_response_label').removeClass('alert-success');
                        $('#coupon_code_response_label').addClass('alert-danger');
                        $('#coupon_code_response_label').html(data.error);
                        $('#coupon_code_response_label').removeClass('d-none');
                        
                        let price = (original_price - referral_deductions).toFixed();
                        
                        $('input[name="amount"]').val(price);
                        $('#modal_price_span').html('$' + price);
                        $('#modal_price_span_prev').html('');
                        $('#modal_price_span_prev').addClass('d-none');
                    }
                }
            });
        } else {
            $('#coupon_code_response_label').removeClass('alert-success');
            $('#coupon_code_response_label').addClass('alert-danger');
            $('#coupon_code_response_label').html('Coupon cannot be empty!');
            $('#coupon_code_response_label').removeClass('d-none');
        }
    });

    $('#apply_referral_code_btn').click(function () {
        var code = $('input[name="referral_code"]').val();
        if (code) {
            $('#referral_code_response_label').addClass('d-none');
            $.ajax({
                type: "POST",
                url: '<?= asset('validate_referral_code') ?>',
                dataType: 'json',
                data: {'code': code},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if (data.success) {
                        $('#referral_code_response_label').addClass('alert-success');
                        $('#referral_code_response_label').removeClass('alert-danger');
                        $('#referral_code_response_label').html(data.success);
                        $('#referral_code_response_label').removeClass('d-none');
                        
                        let passes_to_be_purchased = parseInt($('#payment_modal_passes_count').val());
//                        referral_deductions = 5 * passes_to_be_purchased;
                        referral_deductions = 5;
                        let new_price = ((parseInt((original_price * (100 - coupon_discount)) / 100)) - referral_deductions).toFixed();
                        let old_value = original_price;
                        
                        $('input[name="amount"]').val(new_price);
                        $('#modal_price_span').html('$' + new_price);
                        $('#modal_price_span_prev').html('$' + old_value);
                        $('#modal_price_span_prev').removeClass('d-none');
                        referral_price = new_price;
                    } else if (data.error) {
                        $('#referral_code_response_label').removeClass('alert-success');
                        $('#referral_code_response_label').addClass('alert-danger');
                        $('#referral_code_response_label').html(data.error);
                        $('#referral_code_response_label').removeClass('d-none');
                        
                        let price = (parseInt((original_price * (100 - coupon_discount)) / 100)).toFixed();
                        
                        $('input[name="amount"]').val(price);
                        $('#modal_price_span').html('$' + price);
                        $('#modal_price_span_prev').html('');
                        $('#modal_price_span_prev').addClass('d-none');
                        
                    }
                }
            });
        } else {
            $('#referral_code_response_label').removeClass('alert-success');
            $('#referral_code_response_label').addClass('alert-danger');
            $('#referral_code_response_label').html('Referral code cannot be empty!');
            $('#referral_code_response_label').removeClass('d-none');
        }
    });

    $('body').on('click', '.proceed_to_two', function () {
        $('.custom_alert').hide();
        if (!$('#pick_date').val()) {
            $('.custom_alert').fadeIn();
            setTimeout(function () {
                $('.custom_alert').fadeOut();
            }, 5000);
            $('.custom_alert').removeClass('alert-success');
            $('.custom_alert').addClass('alert-danger');
            $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> Please select any date');

            return false;
        }
        $('.progress_bar').css('width', '50%');
        $('.step_count').html('2');
        $('#fullcalender').modal('hide');
        $('#step_one').hide();
        $('#step_two').show();
    });

    $('body').on('change', '.pick_time', function () {
        remaining_spots = $(this).attr('data-remaining-spots');
        $('#scheduler_frm').find('#pick_time').val($(this).val());
        $('.selected_slot').html($(this).attr('data-text'));

        let day_part = $(this).attr('data-day-part');
        let icon = '';
        if (day_part == 'morning')
            icon = 'icon-sun';
        else if (day_part == 'afternoon')
            icon = 'icon-cloud';
        else if (day_part == 'evening')
            icon = 'icon-night';
        $('#confirmation_day_part').html('<span class="' + icon + '"></span>' + day_part);

        $.ajax({
            type: "POST",
            url: '<?= asset('check_morning_time') ?>',
            dataType: 'json',
            data: {'time': $(this).val()},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    check_for_morning = 1;
                } else if (data.error) {
                    check_for_morning = 0;
                }
                updatePackages();
            }
        });
    });

    //Step two click
    $('body').on('click', '.proceed_to_three', function () {
        $('.custom_alert').hide();
        if (!$('#pick_time').val()) {
            $('.custom_alert').fadeIn();
            setTimeout(function () {
                $('.custom_alert').fadeOut();
            }, 5000);
            $('.custom_alert').removeClass('alert-success');
            $('.custom_alert').addClass('alert-danger');
            $('.alert-content').html('<strong><i class="fa fa-check"></i> Error! </strong> Please select time slot');

            return false;
        }
        $('.step_count').html('3');
        $('.progress_bar').css('width', '75%');
        $('#step_two').hide();
        $('#step_three').find('.block').addClass('element-selected');
        $('#step_three').show();
    });

    //Step three click
    $('body').on('click', '.proceed_to_four', function () {
        $('.step_count').html('4');
        $('.progress_bar').css('width', '100%');
        $('#step_three').hide();
        $('#step_four').show();
    });

    function resetInputHiddenFields() {
        $('input[name="pick_day"]').val('');
        $('input[name="pick_time"]').val('');
        $('input[name="no_of_pass"]').val('');
    }

    $('body').on('click', '.change_scdeduler', function () {
        resetInputHiddenFields();
        $('.step_count').html('4');
        $('.progress_bar').css('width', '100%');
        $('#step_three').hide();
        $('#step_one').show();
    });
    $('body').on('click', '.change_day', function () {
        resetInputHiddenFields();
        $('.step_count').html('1');
        $('.progress_bar').css('width', '25%');
        $('#step_one').show();
        $('#step_two').hide();
    });

    $('body').on('change', '.select_pass', function () {
        var val = $(this).val();
        $('.custom_alert').hide();
        if (parseInt(val) > parseInt(remaining_spots)) {
            $('.custom_alert').fadeIn();
            setTimeout(function () {
                $('.custom_alert').fadeOut();
            }, 5000);
            $('.custom_alert').removeClass('alert-success');
            $('.custom_alert').addClass('alert-danger');
            $('.alert-content').html('<strong><i class="fa fa-info-circle"></i> Error! </strong>Only "' + remaining_spots + '" spots left!');
            $(this).val('');
            $(this).find('option:eq(0)').prop('selected', true);
            return;
        }
        var total = $(this).attr('data-total');
        var left_pass = (total - val);
        if (left_pass > 0) {
            $('.pass_left').html(left_pass);
        } else {
            $('.pass_left').html('No passes left');
        }
        $('#scheduler_frm').find('#no_of_pass').val(val);
        
    });
    $('body').on('change', '.session_type', function () {
        var val = $(this).val();
        if (val == 1) {
            if (total_passes >= 1) {
                $('.select_pass').val('1');
                $('#scheduler_frm').find('#no_of_pass').val('1');
            }
        } else if (val == 2) {
            if (total_passes >= 2) {
                $('.select_pass').val('2');
                $('#scheduler_frm').find('#no_of_pass').val('2');
            }
        } else if (val == 3) {
            if (total_passes >= 3) {
                $('.select_pass').val('3');
                $('#scheduler_frm').find('#no_of_pass').val('3');
            }
        }
    });

//Complete booking
    $('body').on('click', '.complete', function () {
        var complete_btn = $(this);
        showLoading();
        var formData = new FormData($('#scheduler_frm')[0]);
        $.ajax({
            type: "POST",
            url: $('#scheduler_frm').attr('action'),
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                complete_btn.attr('disabled','');
                $('.icon_loading').show();
            },
            success: function (data) {
                hideLoading();
                $('.custom_alert').fadeIn();            
                if (data.success) {
                    hideLoading();
                    $('.custom_alert').removeClass('alert-danger');
                    $('.custom_alert').addClass('alert-success');
                    $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                    setTimeout(function () {
                        window.location.href = base_url + 'user-profile';
                    }, 2000);

                } else {
                    $('.custom_alert').removeClass('alert-success');
                    $('.custom_alert').addClass('alert-danger');
                    $('.alert-content').html('<strong><i class="fa fa-info-circle"></i> Error! </strong>' + data.message);
                    complete_btn.removeAttr('disabled');
                    $('.icon_loading').hide();
                }
//                var current_position = document.documentElement.scrollTop;
                setTimeout(function () {
                    $('.custom_alert').fadeOut();
                }, 5000);
                $('html').animate({scrollTop: 0}, 1000);
            }
        });
    });

    var today = new Date();
    var carousel_items = '';

    var square_image = '<img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid" />';

    var days_array = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var full_days_array = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    var months_array = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var months_array_int = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

    var class_start_date = new Date('<?= $classData->start_date ?>');
    var class_end_date = new Date('<?= $classData->end_date ?>');

    //carousel calendar

    if (today < class_start_date) {
        today = class_start_date;
    }
    var loop_to = 30;

    for (let i = 0; i <= loop_to; i++) {
        var tomorrow = new Date();
        tomorrow.setMonth(today.getMonth());
        tomorrow.setFullYear(today.getFullYear());
        tomorrow.setDate(today.getDate() + i);

        carousel_items += '<div class="item">' +
                '<div class="day-box">' +
                '<span class="icon-calender"></span>' +
                '<div class="day-name">' + days_array[tomorrow.getDay()] + '</div>' +
                '<span class="icon_selected"></span>' +
                '<div class="date">' + tomorrow.getDate() + ' ' + months_array[tomorrow.getMonth()] + ' ' + tomorrow.getFullYear()
                + '</div>' +
                '<input type="radio" class="pick_date" data-day="' + full_days_array[tomorrow.getDay()] + '" name="period" data-date="' + months_array_int[tomorrow.getMonth()] + '-' + tomorrow.getDate() + '-' + tomorrow.getFullYear() + '" value="' + tomorrow.getDate() + '-' + months_array_int[tomorrow.getMonth()] + '-' + tomorrow.getFullYear() + '">' +
                '</div>' +
                '</div>';
    }

    var carousel = $(".calender_carousel");
    carousel.html(carousel_items);

//reinitialize the carousel (call here your method in which you've set specific carousel properties)
    carousel.owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        navText: ['<span></span>', '<span></span>'],
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            767: {
                items: 3
            },
            992: {
                items: 4
            },
            1200: {
                items: 6
            }
        }
    });

    //popup calendar


    var calender_popup_header = '';
    for (let i = 0; i < days_array.length; i++) {
        calender_popup_header += '<div>' + days_array[i] + '</div>';
    }
    $('.calender_popup .calender_header').html(calender_popup_header);
    var calender_popup_body = '';
    $('.calender_popup .calender_body').html(calender_popup_body);


    var today = new Date();
    var diff = 30;

    actual_date_obj = '';

    current_date = class_start_date.getDate();
    x = class_start_date.getDay();

    if (today < class_start_date) {
        actual_date_obj = class_start_date;
        current_date = class_start_date.getDate();
        x = class_start_date.getDay();
    } else if (today > class_start_date) {
        actual_date_obj = today;
        current_date = today.getDate();
        x = today.getDay();

        var difference_bw_current_and_start_date = Math.abs(today.getTime() - class_start_date.getTime());
        difference_bw_current_and_start_date = Math.ceil(difference_bw_current_and_start_date / (1000 * 3600 * 24));
    }

    var loop_starting_from = current_date - x;
    var valid_till = current_date + diff;

    var obj = new Date(actual_date_obj);
    actual_date_obj.setDate(valid_till);

    var next_days = 6 - actual_date_obj.getDay();
    var loop_end_at = valid_till + next_days;

    var overall_counter = selectable_counter = 0;

    for (let i = loop_starting_from; i <= loop_end_at; i++) {

        overall_counter++;

        let date = new Date();
        date.setDate(current_date);
        date.setMonth(obj.getMonth());
        date.setFullYear(obj.getFullYear());

        if (i < current_date) {
            diff = current_date - i;
            date.setDate(current_date - diff);
        } else if (i > current_date) {
            diff = i - current_date;
            date.setDate(current_date + diff);
        }

        current_day = full_days_array[date.getDay()];
        formatted_date = date.getDate() + ' ' + months_array[date.getMonth()] + ' ' + date.getFullYear();
        full_date = date.getDate() + '-' + months_array_int[date.getMonth()] + '-' + date.getFullYear();

        if (i < current_date) {
            calender_popup_body += '<div class="date_box previous_days">' + square_image + '<span class="number d-flex align-items-end">' + formatted_date + '</span></div>';
        } else if (i > valid_till) {
            calender_popup_body += '<div class="date_box next_days">' + square_image + '<span class="number d-flex align-items-end">' + formatted_date + '</span></div>';
        } else {
            selectable_counter++;
            calender_popup_body += '<div class="date_box"><input type="radio" data-day="' + current_day + '" class="pick_date" name="period" value="' + full_date + '"> <span class="icon_selected"></span>' + square_image + '<span class="number d-flex align-items-end">' + formatted_date + '</span></div>';
        }
        if (selectable_counter == 31) {
            if (overall_counter % 7 == 0) {
                break;
            }
        }
    }
    $('.calender_popup .calender_body').html(calender_popup_body);

</script>
</body>
</html>