<?php include resource_path('views/includes/header.php'); ?>
<div class="page_overlay booking-page" style="background-image: url('<?= asset('userassets/images/slide1.jpg') ?>')">
    <div class="overlay full_viewport" style="background-color: rgba(14, 11, 22, 0.7)">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-9 mx-auto">
                    <div class="text-center mb-4">
                        <h5 class="mb-1"><span id="formname" >Fitness Card</span></h5>
                        <!--<p>Please select an option to continue</p>-->
                    </div>
                    <form name="" action="" id="card_order_form">
                        <div class="form-group mb-4"> 
                            <input type="hidden" name="user_id" id="user_id" value=""/>
                        </div> 
                        <div class="order_form_wrap">
                            <!--                            <div class="order_form_head d-flex">
                                                            <div>
                                                                <strong>- Partners Business Card</strong>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <div class="custom-control custom-checkbox mb-0 font-weight-bold text-orange">
                                                                    <input type="checkbox" name="simple_order" value="1" class="custom-control-input simple_form" id="order_form">
                                                                    <label class="custom-control-label" for="order_form"> Choose Form </label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <div class="order_form_body11">
                                <div class="form_section mb-3" id="simple_order11">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="">First Name</label>
                                            <div class="form-group">
                                                <input type="text" name="first_name" id="first_name" value="<?= $current_user->first_name; ?>" placeholder="First Name" class="form-control eb-form-control"  required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" name="last_name" id="last_name" value="<?= $current_user->last_name; ?>" placeholder="Last Name" class="form-control eb-form-control"  required/>
                                            </div>
                                        </div> 
                                        <div class="col-sm-12">
                                            <label for=""> Trainer Type </label>
                                            <div class="form-group"> 
                                                <input type="text" name="trainer_type" placeholder="Trainer Type" class="form-control eb-form-control t_type" value="<?= isset($trainer_type)?$trainer_type:''?>"  readonly/>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="address">Session Location</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= $current_user->address; ?>" name="address" id="address" placeholder="Location" class="form-control eb-form-control" value="1240 9th St NW, Washington, DC 20001"  required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="phone">Phone</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= $current_user->phone; ?>" name="phone" id="phone" placeholder="Phone" class="form-control eb-form-control phonemask"  required/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Email</label>
                                            <div class="form-group">
                                                <input type="email" value="<?= $current_user->email; ?>" name="email" placeholder="Email" class="form-control eb-form-control"  required/>
                                                <input type="hidden" value="" name="card_first_name" id="card_first_name"/>
                                                <input type="hidden" value="" name="card_last_name" id="card_last_name"/>
                                                <input type="hidden" value="" name="card_email" id="card_email"/>
                                                <input type="hidden" value="" name="card_number" id="card_number"/>
                                                <input type="hidden" value="" name="card_expiry_date" id="card_expiry_date"/>
                                                <input type="hidden" value="" name="cvc" id="cvc"/>
                                                <input type="hidden" value="" name="amount" id="amount"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="referral_code">Referral code</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= $code; ?>" name="referral_code" id="referral_code" placeholder="Referral code" class="form-control eb-form-control disabled"  readonly=""/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="referral_code">Profile url</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= asset('profile/' . Auth::user()->first_name . '_' . Auth::user()->last_name . '_' . Auth::id()) ?>" name="url" placeholder="URL" class="form-control eb-form-control disabled"  readonly=""/>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                </div>
                            </div>
                        </div>

                        <div class="order_form_wrap">
                            <!--                            <div class="order_form_head d-flex">
                                                            <div>
                                                                <strong>- Partners Profile Shoot Form</strong>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <div class="custom-control custom-checkbox mb-0 font-weight-bold text-orange">
                                                                    <input type="checkbox" name="custom_order" value="1" class="custom-control-input custom_form" id="custom_form">
                                                                    <label class="custom-control-label" for="custom_form"> Choose Form </label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <div class="order_form_body">
                                <div class="form_section mb-3" id="simple_order">
                                    <div id="custom_order">
                                        <div class="form-group">
                                            <input autocomplete="off" id="shoot_date" data-toggle="datetimepicker" data-target="#shoot_date" type="text" class="form-control  eb-form-control" name="set_date" placeholder="Select Date" value="" required="">
                                            <div>
                                                <label id="start_date-error" class="error" for="start_date" style="display: none">This field is required.</label>
                                            </div>
                                        </div> 
                                        <div class="session_time" id="time_slot"> 
                                        </div>
                                        <label id="time-error" class="error" style="display: none;" for="time">Time slot field is required.</label>
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input" id="radio1" name="shot_location" value="1" required="" checked="">
                                                <label class="custom-control-label" for="radio1"> Studio Photoshoot </label>
                                            </div>
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input" id="radio2" name="shot_location" value="2" required="">
                                                <label class="custom-control-label" for="radio2"> Location </label>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3 admin_location">
                                            <label for="">Studio Photoshoot</label>
                                            <input type="text" value="1240 9th St NW, Washington, DC 20001" name="admin_location" class="form-control eb-form-control" placeholder="Location" readonly/>
                                        </div> 
                                        <div class="form-group mt-3 client_location" style="display: none;">
                                            <label for="">Location</label>
                                            <input type="text" class="form-control eb-form-control" name="client_location" value="<?= $current_user->address; ?>" placeholder="Location"/>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="price_section">
                            <div class="pay-now-section d-flex align-items-center mb-5" id="pay_now_div">
                                <div class="payment_label">
                                    <span class="btn" id="pay_now_price">$14.85</span>
                                </div>
                                <div class="payment_content">
                                    <h6>Pay Now</h6>
                                    <p>With discounted Price</p>
                                </div>
                                <div class="payment_selected">
                                    <span class="icon_selected"></span>
                                </div>
                                <input type="radio" name="payment"  class="amount_option" value="1" id="purchaseButton"  required/>
                            </div>
                            <!--element-selected-->
                            <div class="pay-now-section d-flex align-items-center mb-4" id="pay_later_div">
                                <div class="payment_label">
                                    <span class="btn" id="pay_later_price">$19.85</span>
                                    <input type="hidden" name="certified_amount" value="19.85">
                                </div>
                                <div class="payment_content">
                                    <h6>Pay Later</h6>
                                    <p>Deduct from payout at full price</p>
                                </div>
                                <div class="payment_selected">
                                    <span class="icon_selected"></span>
                                </div>
                                <input type="radio" name="payment" id="pay_later_radio" class="amount_option" value="19.95" required />
                            </div>
                            <label id="payment-error" style="display: none;" class="error" for="payment">This field is required.</label>
                        </div>

                        <div class="form-section">
                            <div class="form_section">
<!--                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="agred" id="businesscard">
                                    <label class="custom-control-label" for="businesscard"> I am aware that my business card order of either $16 or 22 including shipping will be deducted  
                                        one time only from my weekly payout.   </label>
                                </div>-->
                                
                                 <div class="custom-control custom-radio">
                                    <input required type="checkbox" class="custom-control-input" id="terms" name="terms_and_conditions" value="1" required>
                                    <label class="custom-control-label" for="terms"> I have read and agree to the <a href="<?=url('page/terms-of-service');?>" target="_blank">terms</a> and <a href="<?=url('page/privacy-policy')?>" target="_blank">privacy</a>.</label>
                                </div>
                                
                                <label id="agred-error" class="error" for="agred" style="display: none;">This field is required.</label>
                                <label id="terms_and_conditions-error" class="error" for="terms_and_conditions" style="display: none">This field is required.</label>
                            </div>
                            <div class="form_section text-center">
                                <button type="button" class="btn orange btn-lg disabled" id="submit_btn"> 
                                    <span class="icon_loading" id="btn_loading" style="display: none;"></span> SUBMIT NOW <span class="arrow"></span></button>
                            </div>
                            
                        </div>
                    </form>  

                </div>
            </div> <!-- row -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- overlay -->
</div>

<div class="modal fade" id="order_form_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Purchase Order</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="payment_form" action="<?= asset('save_response') ?>" method="POST" id="payment_form_id">
                    <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                    <input type="hidden" name="amount" id="payment_modal_price">
                    <input type="hidden" name="trainer_id" id="payment_modal_trainer_id">
                    <div id="message-div"></div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_first_name" class="form-control eb-form-control" value="" placeholder="First Name" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_last_name" class="form-control eb-form-control" value="" placeholder="Last Name" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_address" value="" class="form-control eb-form-control" placeholder="Address" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_city" class="form-control eb-form-control" value="" placeholder="City" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_state" value="" class="form-control eb-form-control" placeholder="State" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_country" class="form-control eb-form-control" value="" placeholder="Country" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_zip_code" value="" class="form-control eb-form-control" placeholder="Zip Code" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->


                    <div class="form-group">
                        <div class="field_wrap">
                            <input type="email" name="email" id="modal_email" autocomplete="off" class="form-control eb-form-control" value="" placeholder="Email" required/>
                            <div class="icon d-flex justify-content-end align-items-center">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_number" id="modal_card_number" class="form-control eb-form-control" value="" placeholder="Card Number" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-credit-card-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="expiry_date" id="modal_expiry_date" value="" class="form-control eb-form-control" placeholder="MM/YYYY" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->
                    <div class="form-group">
                        <div class="field_wrap">
                            <input type="text" name="cvc" id="modal_cvc" required class="form-control eb-form-control" placeholder="CVC" />
                            <div class="icon d-flex justify-content-end align-items-center">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                    </div> 
                    <button type="submit" class="btn orange">Pay <span id="modal_price_span"></span> <span class="arrow"></span></button>
                </form>
            </div> <!-- modal-body -->
        </div>
    </div>
</div>

<script src="https://checkout.stripe.com/checkout.js"></script>
<style>
    #order_form_modal input.error {
        border:solid 1px red !important;
    }
    #order_form_modal label.error {
        width: auto;
        display: none !important;
        color:red;
        font-size: 16px;
        float:right;
    }
</style>
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>

    $('input[name="expiry_date"]').inputmask("mm/yyyy", {"placeholder": "_", "baseYear": 1900});
    $('input[name="card_number"]').mask("9999-9999-9999-9999");
    $('input[name="cvc"]').mask("999");
    $('input[name="card_zip_code"]').mask("99999");

    $('#shoot_date').datetimepicker({
        format: 'MMMM DD, YYYY',
        pickTime: false,
        minDate: moment(new Date(), "DD-MM-YYYY").add(1, 'days'),
        authide: true
    });

    $("#shoot_date").on("blur.datetimepicker", function (e) {
        var date = $(this).val();
        $.ajax({
            url: "<?php echo asset('get_shot_time'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {'date': date},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    $('#time_slot').html('');
                    $('#time_slot').html(data.html);
                }
            }
        });
    });

    $(document).ready(function () {

        $('body').on('change', '#businesscard', function () {
            if ($(this).is(':checked') && $('#terms').is(':checked')) {
                $(this).parents('.form-section').find('#submit_btn').removeClass('disabled');
            } else {
                $(this).parents('.form-section').find('#submit_btn').addClass('disabled');
            }
        });
        
        $('body').on('change', '#terms', function () {
            if ($(this).is(':checked')) {
                $(this).parents('.form-section').find('#submit_btn').removeClass('disabled');
            } else {
                $(this).parents('.form-section').find('#submit_btn').addClass('disabled');
            }
        });
        var simple_card_price_now = '14.85',
                simple_card_price_later = '19.95',
                custom_card_price_now = '139',
                custom_card_price_later = '199';

        $('body').on('change', 'input:radio[name="shot_location"]', function () {
            var val = $(this).val();
            if (val == 1) {
                $('.admin_location').show();
                $('.client_location').hide();

                //Start here
                custom_card_price_now = '139',
                        custom_card_price_later = '199';
                $('#price_section').find('#pay_now_price').html('');
                $('#price_section').find('#pay_later_price').html('');

                if ($('.simple_form').is(':checked')) {
                    if ($('.custom_form').is(':checked')) {
                        var sum_now = (parseFloat(simple_card_price_now) + parseFloat(custom_card_price_now));
                        var sum_later = (parseFloat(simple_card_price_later) + parseFloat(custom_card_price_later));
                        $('#price_section').find('#pay_now_price').html('$' + sum_now);
                        $('#price_section').find('#pay_later_price').html('$' + sum_later);
                        $('#pay_later_div').find('#pay_later_radio').val(sum_later);
                        $('#order_form_modal #modal_price_span').html('$' + sum_now);
                    } else {
                        $('#price_section').find('#pay_now_price').html('$' + simple_card_price_now);
                        $('#price_section').find('#pay_later_price').html('$' + simple_card_price_later);
                        $('#pay_later_div').find('#pay_later_radio').val(simple_card_price_now);
                        $('#order_form_modal #modal_price_span').html('$' + simple_card_price_now);
                    }
                } else {
                    if ($('.custom_form').is(':checked')) {
                        $('#price_section').find('#pay_now_price').html('$' + custom_card_price_now);
                        $('#price_section').find('#pay_later_price').html('$' + custom_card_price_later);
                        $('#pay_later_div').find('#pay_later_radio').val(custom_card_price_later);
                        $('#order_form_modal #modal_price_span').html('$' + custom_card_price_now);
                    } else {
                        $('#price_section').hide();
                        $('#submit_btn').addClass('disabled');
                        $('#price_section').find('#pay_now_price').html('');
                        $('#price_section').find('#pay_later_price').html('');
                        $('#order_form_modal #modal_price_span').html('');
                    }
                }
                //End here
            } else {
                $('.admin_location').hide();
                $('.client_location').show();
                //Start here
                custom_card_price_now = '359',
                        custom_card_price_later = '495';
                $('#price_section').find('#pay_now_price').html('');
                $('#price_section').find('#pay_later_price').html('');
                if ($('.simple_form').is(':checked')) {
                    if ($('.custom_form').is(':checked')) {
                        var sum_now = (parseFloat(simple_card_price_now) + parseFloat(custom_card_price_now));
                        var sum_later = (parseFloat(simple_card_price_later) + parseFloat(custom_card_price_later));
                        $('#price_section').find('#pay_now_price').html('$' + sum_now);
                        $('#price_section').find('#pay_later_price').html('$' + sum_later);
                        $('#pay_later_div').find('#pay_later_radio').val(sum_later);
                        $('#order_form_modal #modal_price_span').html('$' + sum_now);
                    } else {
                        $('#price_section').find('#pay_now_price').html('$' + simple_card_price_now);
                        $('#price_section').find('#pay_later_price').html('$' + simple_card_price_later);
                        $('#pay_later_div').find('#pay_later_radio').val(simple_card_price_now);
                        $('#order_form_modal #modal_price_span').html('$' + simple_card_price_now);
                    }
                } else {
                    if ($('.custom_form').is(':checked')) {
                        $('#price_section').find('#pay_now_price').html('$' + custom_card_price_now);
                        $('#price_section').find('#pay_later_price').html('$' + custom_card_price_later);
                        $('#pay_later_div').find('#pay_later_radio').val(custom_card_price_later);
                        $('#order_form_modal #modal_price_span').html('$' + custom_card_price_now);
                    } else {
                        $('#price_section').hide();
                        $('#submit_btn').addClass('disabled');
                        $('#price_section').find('#pay_now_price').html('');
                        $('#price_section').find('#pay_later_price').html('');
                        $('#order_form_modal #modal_price_span').html('');
                    }
                }
                //End here
            }
        });
        $('body').on('change', '.simple_form', function () {
            $('#price_section').show();
            $('#submit_btn').removeClass('disabled');
            $('#price_section').find('#pay_now_price').html('');
            $('#price_section').find('#pay_later_price').html('');
            if ($(this).is(':checked')) {
                if ($('.custom_form').is(':checked')) {
                    var sum_now = (parseFloat(simple_card_price_now) + parseFloat(custom_card_price_now));
                    var sum_later = (parseFloat(simple_card_price_later) + parseFloat(custom_card_price_later));
                    $('#price_section').find('#pay_now_price').html('$' + sum_now);
                    $('#price_section').find('#pay_later_price').html('$' + sum_later);
                    $('#pay_later_div').find('#pay_later_radio').val(sum_later);
                    $('#order_form_modal #modal_price_span').html('$' + sum_now);
                } else {
                    $('#price_section').find('#pay_now_price').html('$' + simple_card_price_now);
                    $('#price_section').find('#pay_later_price').html('$' + simple_card_price_later);
                    $('#pay_later_div').find('#pay_later_radio').val(simple_card_price_now);
                    $('#order_form_modal #modal_price_span').html('$' + simple_card_price_now);
                }
            } else {
                if ($('.custom_form').is(':checked')) {
                    $('#price_section').find('#pay_now_price').html('$' + custom_card_price_now);
                    $('#price_section').find('#pay_later_price').html('$' + custom_card_price_later);
                    $('#pay_later_div').find('#pay_later_radio').val(custom_card_price_later);
                    $('#order_form_modal #modal_price_span').html('$' + custom_card_price_now);
                } else {
                    $('#price_section').hide();
                    $('#submit_btn').addClass('disabled');
                    $('#price_section').find('#pay_now_price').html('');
                    $('#price_section').find('#pay_later_price').html('');
                    $('#order_form_modal #modal_price_span').html('');
                }
            }
        });

        $('body').on('change', '.custom_form', function () {
            $('#price_section').show();
            $('#submit_btn').removeClass('disabled');
            $('#price_section').find('#pay_now_price').html('');
            $('#price_section').find('#pay_later_price').html('');
            if ($(this).is(':checked')) {
                if ($('.simple_form').is(':checked')) {
                    var sum_now = (parseFloat(simple_card_price_now) + parseFloat(custom_card_price_now));
                    var sum_later = (parseFloat(simple_card_price_later) + parseFloat(custom_card_price_later));
                    $('#price_section').find('#pay_now_price').html('$' + sum_now);
                    $('#price_section').find('#pay_later_price').html('$' + sum_later);
                    $('#pay_later_div').find('#pay_later_radio').val(sum_later);
                    $('#order_form_modal #modal_price_span').html('$' + sum_now);
                } else {
                    $('#price_section').find('#pay_now_price').html('$' + custom_card_price_now);
                    $('#price_section').find('#pay_later_price').html('$' + custom_card_price_later);
                    $('#pay_later_div').find('#pay_later_radio').val(custom_card_price_later);
                    $('#order_form_modal #modal_price_span').html('$' + custom_card_price_now);
                }
            } else {
                if ($('.simple_form').is(':checked')) {
                    $('#price_section').find('#pay_now_price').html('$' + simple_card_price_now);
                    $('#price_section').find('#pay_later_price').html('$' + simple_card_price_later);
                    $('#pay_later_div').find('#pay_later_radio').val(simple_card_price_later);
                    $('#order_form_modal #modal_price_span').html('$' + simple_card_price_now);
                } else {
                    $('#price_section').hide();
                    $('#submit_btn').addClass('disabled');
                    $('#price_section').find('#pay_now_price').html('');
                    $('#price_section').find('#pay_later_price').html('');
                    $('#order_form_modal #modal_price_span').html('');
                }
            }
        }
        );
        $('.order_form_wrap input[type="checkbox"]').click(function () {
            $(this).parents('.order_form_wrap').find('.order_form_body').toggle();
        });
        jQuery.validator.addMethod(
                "trioDate",
                function (value, element) {
                    return value.match(/^\d{1,2}\/\d{4}$/);
                },
                "Please enter a date in the format mm/yyyy"
                );
        $("#payment_form_id").submit(function (e) {
            e.preventDefault();
        }).validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                cvc: {
                    required: true
                },
                expiry_date: {
                    trioDate: true
                }
            },
            submitHandler: function (event) {
                fname = $('#payment_form_id').find('input[name="card_first_name"]').val();
                lname = $('#payment_form_id').find('input[name="card_last_name"]').val();
                var email = $('#payment_form_id').find('input[name="email"]').val();
                var card_number = $('#payment_form_id').find('input[name="card_number"]').val();
                var expiry_date = $('#payment_form_id').find('input[name="expiry_date"]').val();
                var cvc = $('#payment_form_id').find('input[name="cvc"]').val();
                $('#card_first_name').val(fname);
                $('#card_last_name').val(lname);
                $('#card_email').val(email);
                $('#card_number').val(card_number);
                $('#card_expiry_date').val(expiry_date);
                $('#card_cvc').val(cvc);
                $('#order_form_modal').modal('hide');
            }
        });

    });

    //Book Form Validation
    $('body').on('click', '#submit_btn', function () {
        $form = $(this).parents('form');
        if ($('.simple_form').is(':checked')) {

            //Basic 
            $('#card_order_form').validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    location: {
                        required: true
                    },
                    payment: {
                        required: true
                    },
                    agred: {
                        required: true
                    },
                    terms_and_conditions: {
                        required: true
                    }
                },
                messages: {
                    payment: {
                        required: 'You must select a payment method'
                    },
                    agred: {
                        required: 'You must accept the terms and conditions'
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass('has_error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").removeClass('has_error');
                }
            });

        }
        if ($('.custom_form').is(':checked')) {
            console.log('custom_form');
//            $('#address').rules("add", {required: true});
            $('#card_order_form').validate({
                rules: {
                    time: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    payment: {
                        required: true
                    },
                    agred: {
                        required: true
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass('has_error');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".form-group").removeClass('has_error');
                }
            });
        }
        if ($("#card_order_form").valid()) {
            let card_number = $('#card_number').val();
            if ($form.find('input[name="payment"]:checked').val() == 1 && (!card_number)) {
                $('#order_form_modal').modal('show');
                return false;
            }
            showLoading();
            var formData = new FormData($('#card_order_form')[0]);
            $.ajax({
                type: "POST",
                url: base_url + "order_card_ajax",
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
                        $('#card_order_form')[0].reset();
                        $('.pay-now-section').removeClass('element-selected');
                        $('#referral_code').val(Math.floor(Math.random() * 600) + 1);

                        $('.custom_alert').show();
                        $('.custom_alert').removeClass('alert-danger');
                        $('.custom_alert').addClass('alert-success');
                        $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong> ' + data.message);
                        $('html').animate({scrollTop: 0}, 1000);
                        hideLoading();
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);

                    } else {
                        $('.custom_alert').removeClass('alert-success');
                        $('.custom_alert').addClass('alert-danger');
                        $('.alert-content').html('<strong><i class="fa fa-check"></i> Error! </strong> ' + data.error);
                        $('.custom_alert').show();
                        if (data.card_error) {
                            $('#order_form_modal').modal('show');
                        }
                        hideLoading();
                    }
                }
            });
        } else {
//            $('html').animate({scrollTop: 0}, 1000);
        }
    });
</script>
</body>
</html>

