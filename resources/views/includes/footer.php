<footer class="footer">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="footer-logo">
                        <img src="<?= asset('userassets/images/logo.png') ?>" class="img-fluid" alt="Ebbsey" />
                    </div>
                </div>
                <div class="col-xl-8 col-lg-10">
                    <div class="footer_menu">

                        <a href="<?= asset('about') ?>">About</a>
                        <a href="<?= asset('search?search_type=class') ?>">Book Now</a> 
                        <a href="<?= asset('contact') ?>">Contact Us</a>
                    </div>
                    <div class="copyright d-lg-flex flex-lg-row-reverse justify-content-between">
                        <div class="mb-4">
                            <?php
                            if (getPage()) {
                                foreach (getPage() as $page_links) {
                                    ?>
                                    <a href="<?= url('page/' . $page_links->slug) ?>"><?= $page_links->title ?></a>

                                <?php
                                }
                            }
                            ?> 
                            <span class="company">Made with love at <a href="http://codingpixel.com/" target="_blank">CodingPixel</a></span>
                        </div>
                        <div>
                            <span>&copy; Ebbsey 2018 &reg;. All Rights Reserved.</span>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--Model-->
<div class="modal fade" id="confirm_box" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal_title">Confirmation?</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="font-12 mb-4 mt-2">
                    <p id="comfirm_message"></p>
                </div>
                <div class="row mb-2">                                    
                    <div class="col-sm-12">
                        <div class="d-flex ">
                            <div class="w-100 mr-1">
                                <a href="javascript:void(0)"  data-dismiss="modal" id="delete" class="btn orange btn-lg mr-1">Yes</a>
                            </div>
                            <div class="w-100 ml-1">
                                <a href="javascript:void(0)" data-dismiss="modal" class="btn white btn-lg" data-dismiss="modal">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<!--End Model-->

<div class="modal fade" id="send_message_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Message</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 message_modal_success_div" style="display:none">
                        <textarea class="form-control eb-form-control other_reason" id="send_message_modal_textarea" placeholder="Write new message"></textarea>
                        <input type="hidden" id="send_message_modal_other_user_id" value="">
                    </div>
                    <div class="col-sm-12 message_modal_error_div pt-3 text-center my-5" style="display:none"></div>
                </div>

            </div>
            <div class="modal-footer justify-content-start">
                <button onclick="sendMessageModal()" type="button" class="btn btn-lg orange">Send</button>
            </div>
        </div>
    </div>
</div>

<div class="flash_message" id="flash_message" style="display:none;"></div>

<div class="modal fade" id="alertQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-sm-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Alert</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="font-12 mb-4 mt-2">
                    <p>Are you sure with this <a href="<?= url('page/terms-of-service'); ?>" target="_blank">condition</a> you want to proceed?</p>
                </div>
                <div class="row mb-2"> 
                </div>
            </div> 
        </div>
    </div>
</div>

<!--Confirmation Dialog Box-->
<div class="modal fade" id="confirmComplete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-sm-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Confirmation</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="font-12 mb-4 mt-2">
                    <p>Are you sure with this <a href="<?= url('page/terms-of-service'); ?>" target="_blank">condition</a> you want to proceed?</p>
                </div>
                <div class="row mb-2">                                    
                    <div class="col-sm-12">
                        <div class="d-flex ">
                            <div class="w-100 mr-1">
                                <a href="javascript:void(0)" id="yes_proceed" class="btn orange btn-block mr-1">Yes Proceed</a>
                            </div>
                            <div class="w-100 ml-1">
                                <button type="button" class="btn btn-block white" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<!--End Confirmation Dialog Box-->

<?php if ($current_user) { ?>
    <div class="modal fade" id="stripe_payment_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle">Purchase Passes</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="custom_package_wrap">
                        <div class="package_header d-flex align-items-sm-center flex-column flex-sm-row">
                            <div>
                                <h2><span id="package_name_card_modal"></span> Package</h2>
                                <div class="number_passes"><span id="passes_count_in_card_modal"></span> Passes</div>
                            </div>
                        </div>
                        <div class="package_body">
                            
                            <form class="payment_form" action="<?= asset('save_response') ?>" method="POST" id="card_payment_form">
                                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                <input type="hidden" name="amount" id="payment_modal_price">
                                <input type="hidden" name="passes_count" id="payment_modal_passes_count">
                                <input type="hidden" name="trainer_id" id="payment_modal_trainer_id">
                                <input type="hidden" name="package_name" id="payment_modal_package_name">
                                <div id="message-div"></div>
                                <div class="form-section">
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <label>E-Mail</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="email" name="email" autocomplete="off" required class="form-control eb-form-control" placeholder="Email" />
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->   
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <label>Card Number</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="card_number" required class="form-control eb-form-control" placeholder="Card Number" />
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->   
                                    <div class="form-group">    
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <label>CVC</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="cvc" required class="form-control eb-form-control" placeholder="CVC" />
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->   
                                    <div class="form-group">    
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <label>Valid Until</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="expiry_date" required class="form-control eb-form-control" placeholder="MM/YYYY" />
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->
                                </div><!-- form-section -->
                                <div class="form-section">
                                    <div class="form-group mb-4" id="coupon_section">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="coupen-title mb-3">Enter a Coupon Code and Get Discount on purchase!</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Coupon Code</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="field_wrap">
                                                    <input type="text" onkeyup="if(this.value.length > 8) return false;" name="coupon_code" class="form-control eb-form-control"/>
                                                    <div class="btn_in_input d-flex justify-content-end align-items-center">
                                                        <button type="button" class="btn btn-success" id="apply_coupon_code_btn">Apply</button>
                                                    </div>
                                                </div>
                                                <label id="coupon_code_response_label" class="alert alert-success d-none" for="coupon_code"></label>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="coupen-title mb-3">Enter referral code of a trainer!</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Referral Code</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="field_wrap">
                                                    <input type="text" name="referral_code" class="form-control eb-form-control"/>
                                                    <div class="btn_in_input d-flex justify-content-end align-items-center">
                                                        <button type="button" class="btn btn-success" id="apply_referral_code_btn">Apply</button>
                                                    </div>
                                                </div>
                                                <label id="referral_code_response_label" class="alert alert-success d-none" for="referral_code"></label>
                                            </div>
                                        </div><!-- row -->
                                    </div><!-- form-group -->
                                </div><!-- form-section -->

                                <div class="total_payment d-flex align-items-sm-center flex-column flex-sm-row">
                                    <div>
                                        <span class="total_payment_label">Total Payment</span>
                                    </div>
                                    <div class="ml-sm-auto">
                                        <div class="price d-flex align-items-center">
                                            <span class="current" id="modal_price_span"></span>
                                            <span class="prev d-none" id="modal_price_span_prev"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input required type="checkbox" class="custom-control-input" id="terms" name="terms_and_conditions" value="1" required>
                                    <label class="custom-control-label" for="terms"> I have read and agree to the <a href="<?=url('page/terms-of-service');?>" target="_blank">terms</a> and <a href="<?=url('page/privacy-policy')?>" target="_blank">privacy</a>.</label>
                                </div>
                                <button type="submit" class="btn orange btn-lg text-uppercase font-weight-bold mt-4"><span class="icon_loading" style="display : none;"></span> Pay Now</button>
                            </form>
                            
                        </div>
                    </div>

                </div> <!-- modal-body -->
            </div>
        </div>
    </div>
    <?php if(!$current_user->is_bank_account_verified) { ?>
        <script>
            var count_x = 1,
            max_x = 2000; // Change this for number of on-off flashes

            var flash_color_notify = setInterval(function () {
            / Change the color depending if it's even(= gray) or odd(=red) /
            if (count_x % 2 === 0) { // even
            $('.blink').css('color', 'gray');
            $('.blink').css('background-color:', 'red');
            } else { // odd
            $('.blink').css('color', 'red');
            $('.blink').css('background-color:', 'gray');
            }

            / Clear the interval when completed blinking /
            if (count_x === max_x * 2) {
            clearInterval(flash_color_notify);
            } else { count_x += 1; }
            }, 500);
        </script>
    <?php } ?>
<?php } ?>

