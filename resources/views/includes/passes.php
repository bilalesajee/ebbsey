<div class="step_detail session_type_step">
    <div class="title">
        <h5>PRICING PLAN</h5>
        <p>We have the pricing plans just like what you would have wanted</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="price-plan-wrap custom_option">
                <span class="icon-money"></span>
                <h5>Flex</h5>
                <div class="passes_info">
                    Make your own Package
                </div>
                <div class="info_wrap">
                    <div class="info">
                        <ul>
                            <li>No monthly contract</li>
                            <li>Full Rate</li>
                            <li>Personalize Workout</li>
                            <li>Expires 45 days (buy to reset)</li>
                            <li>No additional fees</li>
                            <li>Individual sessions</li>
                            <li>Couples session</li>
                            <li>Group session</li>
                            <li>Private class session</li>
                        </ul>
                    </div>
                    <div class="mobile_info_button d-block d-lg-none"> 
                        <span class="show_info">Show Info</span>
                        <span class="hide_info">Hide Info</span>
                    </div>
                </div>
                <div class="form-group">
                    <select name="no_of_passes" id="no_of_passes" class="form-control eb-form-control">
                        <option disabled="">No of Passes</option>
                        <?php for($count = 1 ; $count <= 25 ; $count++) { ?>
                            <option <?= $count == 1 ? 'selected=""' : '' ?> value="<?=$count?>"><?=$count?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" id="pas_price" name="pas_price" value="<?= rand($pass_price->lowest_base_rate, $pass_price->highest_base_rate) ?>" />
                    <input type="hidden" id="total_pas_price" name="total_pas_price" value="" />
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="font-weight-bold text-orange pr-4" style="font-size: 20px">$<span id="custom_price">0</span></div>
                </div>
                <input type="radio" id="custome_value" class="package_plan" name="package" data-package-name="Flex" value="custome">
            </div> 
        </div> <!-- col -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="price-plan-wrap">
                <span class="icon-money"></span>
                <h5>Active</h5>
                <div class="passes_info">
                    Purchase <span id="option_1_passes_count"></span> passes for just 
                    <span class="price">$<span id="option_1_price"></span></span>
                </div>
                <div class="info_wrap">
                    <div class="info">
                        <ul>
                            <li>No monthly contract</li>
                            <li>5% off included</li>
                            <li>Personalize Workout</li>
                            <li>Expires 45 days (buy to reset)</li>
                            <li>No additional fees</li>
                            <li>Individual sessions</li>
                            <li>Couples session</li>
                            <li>Group session</li>
                            <li>Class session</li>
                        </ul>
                    </div>
                    <div class="mobile_info_button d-block d-lg-none"> 
                        <span class="show_info">Show Info</span>
                        <span class="hide_info">Hide Info</span>
                    </div>
                </div>
                <span class="icon_selected"></span>
                <input type="radio" class="package_plan" name="package" data-package-name="Active" id="option_1_package" value="">
            </div>
        </div><!-- col -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="price-plan-wrap">
                <span class="icon-money"></span>
                <h5>Ultimate</h5>
                <div class="passes_info">
                    Purchase <span id="option_bronze_passes_count"></span> passes for just 
                    <span class="price">$<span id="option_bronze_price"></span></span>
                </div>
                <div class="info_wrap">
                    <div class="info">
                        <ul>
                            <li>No monthly contract</li>
                            <li>10% off included</li>
                            <li>Personalize Workout</li>
                            <li>Expires 45 days (buy to reset)</li>
                            <li>No additional fees</li>
                            <li>Individual sessions</li>
                            <li>Couples session</li>
                            <li>Group session</li>
                            <li>Class session</li>
                        </ul>
                    </div>
                    <div class="mobile_info_button d-block d-lg-none"> 
                        <span class="show_info">Show Info</span>
                        <span class="hide_info">Hide Info</span>
                    </div>
                </div>
                <span class="icon_selected"></span>
                <input type="radio" class="package_plan" name="package" data-package-name="Ultimate" id="option_bronze_package" value="">
            </div>
        </div><!-- col -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="price-plan-wrap">
                <span class="icon-money"></span>
                <h5>Sedentary</h5>
                <div class="passes_info">
                    Purchase <span id="option_gold_passes_count"></span> passes for just
                    <span class="price">$<span id="option_gold_price"></span></span>
                </div>
                <div class="info_wrap">
                    <div class="info">
                        <ul>
                            <li>No monthly contract</li>
                            <li>15% off included</li>
                            <li>Personalize Workout</li>
                            <li>Expires 45 days (buy to reset)</li>
                            <li>No additional fees</li>
                            <li>Individual sessions</li>
                            <li>Couples session</li>
                            <li>Group session</li>
                            <li>Class session</li>
                        </ul>
                    </div>
                    <div class="mobile_info_button d-block d-lg-none"> 
                        <span class="show_info">Show Info</span>
                        <span class="hide_info">Hide Info</span>
                    </div>
                </div>
                <span class="icon_selected"></span>
                <input type="radio" class="package_plan" name="package" data-package-name="Sedentary" id="option_gold_package" value=""/>
            </div>
        </div><!-- col -->
    </div> <!-- row -->
</div>

<script>
    var passes_array = [
        {
            'plan_2_passes': 4, 'plan_2_price': 179, 
            'plan_3_passes': 6, 'plan_3_price': 239, 
            'plan_4_passes': 8, 'plan_4_price': 279 
        },
        {
            'plan_2_passes': 4, 'plan_2_price': 179, 
            'plan_3_passes': 6, 'plan_3_price': 239, 
            'plan_4_passes': 8, 'plan_4_price': 279 
        },
        {
            'plan_2_passes': 4, 'plan_2_price': 179, 
            'plan_3_passes': 6, 'plan_3_price': 239, 
            'plan_4_passes': 8, 'plan_4_price': 279 
        },
        
        {
            'plan_2_passes': 6, 'plan_2_price': 270, 
            'plan_3_passes': 8, 'plan_3_price': 319, 
            'plan_4_passes': 10, 'plan_4_price': 349 
        },
        {
            'plan_2_passes': 6, 'plan_2_price': 270, 
            'plan_3_passes': 8, 'plan_3_price': 319, 
            'plan_4_passes': 10, 'plan_4_price': 349 
        },
        
        {
            'plan_2_passes': 8, 'plan_2_price': 359, 
            'plan_3_passes': 10, 'plan_3_price': 399, 
            'plan_4_passes': 12, 'plan_4_price': 420 
        },
        {
            'plan_2_passes': 8, 'plan_2_price': 359, 
            'plan_3_passes': 10, 'plan_3_price': 399, 
            'plan_4_passes': 12, 'plan_4_price': 420 
        },
        
        {
            'plan_2_passes': 10, 'plan_2_price': 449, 
            'plan_3_passes': 12, 'plan_3_price': 479, 
            'plan_4_passes': 14, 'plan_4_price': 489 
        },
        {
            'plan_2_passes': 10, 'plan_2_price': 449, 
            'plan_3_passes': 12, 'plan_3_price': 479, 
            'plan_4_passes': 14, 'plan_4_price': 489 
        },
        
        {
            'plan_2_passes': 12, 'plan_2_price': 524, 
            'plan_3_passes': 14, 'plan_3_price': 545, 
            'plan_4_passes': 16, 'plan_4_price': 559 
        },
        {
            'plan_2_passes': 12, 'plan_2_price': 524, 
            'plan_3_passes': 14, 'plan_3_price': 545, 
            'plan_4_passes': 16, 'plan_4_price': 559 
        },
        
        {
            'plan_2_passes': 14, 'plan_2_price': 602, 
            'plan_3_passes': 16, 'plan_3_price': 614, 
            'plan_4_passes': 18, 'plan_4_price': 630 
        },
        {
            'plan_2_passes': 14, 'plan_2_price': 602, 
            'plan_3_passes': 16, 'plan_3_price': 614, 
            'plan_4_passes': 18, 'plan_4_price': 630 
        },
        
        {
            'plan_2_passes': 16, 'plan_2_price': 724, 
            'plan_3_passes': 18, 'plan_3_price': 715, 
            'plan_4_passes': 20, 'plan_4_price': 699 
        },
        {
            'plan_2_passes': 16, 'plan_2_price': 724, 
            'plan_3_passes': 18, 'plan_3_price': 715, 
            'plan_4_passes': 20, 'plan_4_price': 699 
        },
        
        {
            'plan_2_passes': 18, 'plan_2_price': 812, 
            'plan_3_passes': 20, 'plan_3_price': 799, 
            'plan_4_passes': 22, 'plan_4_price': 769 
        },
        {
            'plan_2_passes': 18, 'plan_2_price': 812, 
            'plan_3_passes': 20, 'plan_3_price': 799, 
            'plan_4_passes': 22, 'plan_4_price': 769 
        },
        
        {
            'plan_2_passes': 20, 'plan_2_price': 898, 
            'plan_3_passes': 22, 'plan_3_price': 880, 
            'plan_4_passes': 24, 'plan_4_price': 840 
        },
        {
            'plan_2_passes': 20, 'plan_2_price': 898, 
            'plan_3_passes': 22, 'plan_3_price': 880, 
            'plan_4_passes': 24, 'plan_4_price': 840 
        },
        
        {
            'plan_2_passes': 22, 'plan_2_price': 989, 
            'plan_3_passes': 24, 'plan_3_price': 959, 
            'plan_4_passes': 26, 'plan_4_price': 910
        },
        {
            'plan_2_passes': 22, 'plan_2_price': 989, 
            'plan_3_passes': 24, 'plan_3_price': 959, 
            'plan_4_passes': 26, 'plan_4_price': 910
        },
        
        {
            'plan_2_passes': 24, 'plan_2_price': 1079, 
            'plan_3_passes': 26, 'plan_3_price': 1040, 
            'plan_4_passes': 28, 'plan_4_price': 980
        },
        {
            'plan_2_passes': 24, 'plan_2_price': 1079, 
            'plan_3_passes': 26, 'plan_3_price': 1040, 
            'plan_4_passes': 28, 'plan_4_price': 980
        },
        
        {
            'plan_2_passes': 26, 'plan_2_price': 1169, 
            'plan_3_passes': 28, 'plan_3_price': 1119, 
            'plan_4_passes': 30, 'plan_4_price': 1050
        },
        {
            'plan_2_passes': 26, 'plan_2_price': 1169, 
            'plan_3_passes': 28, 'plan_3_price': 1119, 
            'plan_4_passes': 30, 'plan_4_price': 1050
        }
    ];
    
    var check_for_morning = 0;
    var trainer_travelling_distance = 0;
    
    function updatePackages(){
        var no_of_passes = parseInt($('#no_of_passes').val());
        var pass_price = parseInt($('#pas_price').val());
        var total_price = pass_price;
        
        if(check_for_morning){
            total_price = pass_price + 10;
        }
        total_price = total_price * no_of_passes;

        var distance_fee = trainer_travelling_distance * 1.6 * no_of_passes;        
        total_price = total_price + distance_fee;
        
        var ebbsey_earning = total_price * 0.039;
        var booking_fee = 0.3 * no_of_passes;
        total_price = total_price + booking_fee + ebbsey_earning;
        
        console.log('base_rate: '+pass_price);
        console.log('distance fee: '+trainer_travelling_distance * 1.6 * no_of_passes);
        console.log('distance: '+trainer_travelling_distance);
        console.log('booking_fee: '+booking_fee);
        console.log('ebbsey_earning fee: '+ebbsey_earning);
        console.log('total_price: '+total_price.toFixed());
        
        total_price = total_price.toFixed();
        
        $('#custom_price').html(total_price);
        $('#total_pas_price').val(total_price);

        let price_of_one_pass = total_price / no_of_passes;
        let plan_2_passes = passes_array[no_of_passes-1]['plan_2_passes'];
        let plan_3_passes = passes_array[no_of_passes-1]['plan_3_passes'];
        let plan_4_passes = passes_array[no_of_passes-1]['plan_4_passes'];

        let option_1_price = ((plan_2_passes * price_of_one_pass) * 0.95).toFixed();
        let option_bronze_price = ((plan_3_passes * price_of_one_pass) * 0.90).toFixed();
        let option_gold_price = ((plan_4_passes * price_of_one_pass) * 0.85).toFixed();
        
        $('#option_1_passes_count').html(plan_2_passes);
        $('#option_1_price').html(option_1_price);
        $('#option_1_package').val(option_1_price);
        
        $('#option_bronze_passes_count').html(plan_3_passes);
        $('#option_bronze_price').html(option_bronze_price);
        $('#option_bronze_package').val(option_bronze_price);
        
        $('#option_gold_passes_count').html(plan_4_passes);
        $('#option_gold_price').html(option_gold_price);
        $('#option_gold_package').val(option_gold_price);
    }
</script>
