<?php include resource_path('views/includes/header.php'); ?>
<style>
    .price-plan-wrap.custom_option.element-selected input[type='radio'] {
        display: none;
    }

    .price-plan-wrap.custom_option.element-selected .icon_selected {
        display: none;
    }
    /*    input.error {
            border:solid 1px red !important;
        }
        #card_payment_form label.error {
            width: auto;
            display: none !important;
            color:red;
            font-size: 16px;
            float:right;
        }*/
</style>
<div class="page_overlay booking-page" style="background-image: url('<?= asset('userassets/images/image14.jpg') ?>')">
    <div class="overlay pb-0">

        <?php include resource_path('views/includes/passes.php'); ?>
        <div class="step_detail session_type_step">
            <button type="button" id="purchaseButton" class="btn btn-lg orange">Buy Now</button>
        </div>

    </div>
</div>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $('input[name="expiry_date"]').inputmask("mm/yyyy", {"placeholder": "_","baseYear": 1900 });
    $('input[name="card_number"]').mask("9999-9999-9999-9999");
    $('input[name="cvc"]').mask("999");
    $('input[name="coupon_code"]').mask("********");
    $('input[name="referral_code"]').mask("********");
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
        $('#modal_price_span').html('$' + new_amount);
        $('#message-div').html('');
        $('#card_payment_form').find('button[type="submit"]').removeAttr('disabled');
        $('#card_payment_form')[0].reset();
        $('#stripe_payment_modal').modal('show');

        e.preventDefault();
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
                        $('#pass_selector').attr('data-total', res.total);
                        $('#pass_selector').html(res.html);
                        setTimeout(function () {
                            $('#stripe_payment_modal').modal('hide');
                            $('#coupon_code_response_label').addClass('d-none');
                        }, 5000);
                    } else {
                        $('#message-div').html('<div class="alert alert-danger">' + res.error + '</div>');
                        $('#card_payment_form').find('button[type="submit"]').removeAttr('disabled');
                    }
                }
            });
        }
    });

    $('#apply_coupon_code_btn').click(function () {
        var code = $('input[name="coupon_code"]').val();
        if (code) {
            $('#coupon_code_response_label').addClass('d-none');
            $.ajax({
                type: "POST",
                url: '<?=asset('validate_coupon_code')?>',
                dataType: 'json',
                data: {'code': code},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if(data.success){
                        $('#coupon_code_response_label').addClass('alert-success');
                        $('#coupon_code_response_label').removeClass('alert-danger');
                        $('#coupon_code_response_label').html(data.success);
                        $('#coupon_code_response_label').removeClass('d-none');
                        let discount = data.discount;
                        let current_price = $('#payment_modal_price').val();
                        let new_price = (current_price*(100 - discount))/100;
                        $('#modal_price_span').html('$'+new_price);
                        $('#modal_price_span_prev').html('$'+current_price);
                        $('#modal_price_span_prev').removeClass('d-none');
                    } else if(data.error){
                        $('#coupon_code_response_label').removeClass('alert-success');
                        $('#coupon_code_response_label').addClass('alert-danger');
                        $('#coupon_code_response_label').html(data.error);
                        $('#coupon_code_response_label').removeClass('d-none');
                        let current_price = $('#payment_modal_price').val();
                        $('#modal_price_span').html('$'+current_price);
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
                url: '<?=asset('validate_referral_code')?>',
                dataType: 'json',
                data: {'code': code},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if(data.success){
                        $('#referral_code_response_label').addClass('alert-success');
                        $('#referral_code_response_label').removeClass('alert-danger');
                        $('#referral_code_response_label').html(data.success);
                        $('#referral_code_response_label').removeClass('d-none');
                    } else if(data.error){
                        $('#referral_code_response_label').removeClass('alert-success');
                        $('#referral_code_response_label').addClass('alert-danger');
                        $('#referral_code_response_label').html(data.error);
                        $('#referral_code_response_label').removeClass('d-none');
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

</script>
</body>
</html>