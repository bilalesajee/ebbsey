<?php include resource_path('views/includes/header.php'); ?>
<div class="signup_user_wrapper full_viewport">
    <div class="overlay full_viewport">
        <div class="container">
            <h5 class="text-center text-uppercase mb-2"><strong>Create USER Account</strong></h5>
            <p class="text-center">Set up an account in three easy steps</p>
        </div>
        <div class="tabs_outer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 ml-auto mr-auto">
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li>
                                <a class="active" id="home-tab" data-toggle="tab" href="#home"><span class="step_number"> 1 </span> <span class="hidden_tab_info">Basic</span> Information</a></a>
                            </li>
                            <li>
                                <a class="disabled" id="profile-tab" data-toggle="tab" data-title="You need to fill basic info first" href="#profile" ><span class="step_number"> 2 </span> Fitness Goals</a>
                            </li>
                            <li>
                                <a class="disabled" id="contact-tab" data-toggle="tab" data-title="Select some fitness goals first" href="#contact"><span class="step_number"> 3 </span> <span class="hidden_tab_info">Readiness</span> Questionnaire</a>
                            </li>
                        </ul>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 ml-auto mr-auto">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home">
                            <form method="post" action="<?= asset('user-register-basic') ?>" id="first_form" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                <div class="form_section">
                                    <h5><strong>- Profile Picture</strong></h5>
                                    <div class="edit_profile_image d-flex align-items-center">
                                        <div class="image_view" id="user_profile_pic_div" style="background-image: url('<?php echo asset('public/images/users/default.jpg'); ?>')"></div>
                                        <div class="ml-auto action_btns">
                                            <label class="btn pink" for="user_profile_pic"> Upload Photo </label>
                                            <div class="file_upload_btn2"> 
                                                <input id="user_profile_pic" type="file"> 
                                                <input name="profile_pic" type="text" required>
                                                <input name="original_image" type="text" required>
                                            </div>
                                        </div>
                                    </div>
                                    <label id="profile_pic-error" class="error" for="profile_pic"></label>
                                </div>
                                <div class="form_section">
                                    <h5><strong>- Basic Details</strong></h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" id="first_name" name="first_name" placeholder="First Name*" value="<?= old('first_name') ?>" class="form-control eb-form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" id="last_name" name="last_name" placeholder="Last Name*" value="<?= old('last_name') ?>" class="form-control eb-form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" id="email" placeholder="Email ID*" value="<?= old('email') ?>" class="form-control eb-form-control" required=""/>
                                                <label style="display:none" id="emailerrormessage" class="error" for="">This email has already been taken !</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <div class="d-flex">
                                                    <div class="pr-2 w-100">
                                                        <select name="dob_day" class="form-control eb-form-control" required="">
                                                            <option selected="" value="" disabled="">Day</option>
                                                            <?php for($i = 1 ; $i <= 31 ; $i++) { ?>
                                                                <option value="<?=$i?>"><?=$i?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="pr-2 w-100">
                                                        <select name="dob_month" class="form-control eb-form-control" required="">
                                                            <option selected="" value="" disabled="">Month</option>
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                    <div class="pr-0 w-100">
                                                        <select name="dob_year" class="form-control eb-form-control" required="">
                                                            <option selected="" value="" disabled="">Year</option>
                                                            <?php for($i = date('Y') ; $i >= 1905 ; $i--) { ?>
                                                                <option value="<?=$i?>"><?=$i?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="error text-danger d-none" id="dob_error"></div>
                                            </div>        
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" id="password" placeholder="Password*" class="form-control eb-form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" placeholder="Confirm Password*" class="form-control eb-form-control" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form_section">
                                    <h5><strong>- Other Information</strong></h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" id="autocomplete" name="address" placeholder="Street Address"  value="<?= old('address') ?>" class="form-control eb-form-control" required=""/>
                                                <label id="invalid_address_error" class="error" style="display: none;">This is not a valid address</label>
                                                <input type="hidden" id="lat" name="lat"/>
                                                <input type="hidden" id="lng" name="lng"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="country" name="country" placeholder="Country" value="<?= old('country') ?>" class="form-control eb-form-control" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="administrative_area_level_1" name="state" placeholder="State" value="<?= old('state') ?>" class="form-control eb-form-control" required=""/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="locality" name="city" placeholder="City" value="<?= old('city') ?>" class="form-control eb-form-control" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="number" id="postal_code" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "5" value="<?= old('postal_code') ?>" placeholder="Postal Code" class="form-control eb-form-control" required=""/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="phone" placeholder="Phone Number" value="<?= old('phone') ?>" class="form-control eb-form-control phonemask" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn orange" id="first_form_submit_btn"> PROCEED TO NEXT STEP<span class="arrow"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>        
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <form method="post" action="<?= asset('/user-register-fitnessgoals') ?>" id="second_form" enctype="multipart/form-data">
                                <div class="form_section">
                                    <h5><strong>- Choose your fitness goals <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                    <div class="row" id="fitness_goal_checkboxes">
                                        <?php
                                        $users_fitness_goals = fitnessGoals();
                                        $fitness_goals = $users_fitness_goals['fitness_goals'];
                                        ?>
                                        <?php
                                        if ($fitness_goals) {
                                            $counter = 1;
                                            ?>
                                            <?php foreach ($fitness_goals as $fitness_goal) { ?>
                                                <div class="col-sm-4">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input fitness-goals" name="fitness_goals[<?= $fitness_goal->id ?>]" id="checkbox<?= $counter ?>">
                                                        <label class="custom-control-label" for="checkbox<?= $counter ?>" > <?= $fitness_goal->title ?> </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <label style="display:none" id="fitness_goal_error" class="error text-danger">At least one fitness goal is required !</label>
                                <div class="form_section">
                                    <h5><strong>- Others</strong></h5>
                                    <textarea name="other_fitnessgoal" placeholder="If the top list doesn’t specify what you’re looking for. Enter reason here....." class="form-control eb-form-control other_reason"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn orange" id="fitness_goal_btn"> PROCEED TO NEXT STEP<span class="arrow"></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="contact">

                            <form method="post" action="<?= asset('/user-register-full') ?>" id="third_form" enctype="multipart/form-data">
                                <div class="form_section">
                                    <h5><strong>- Readiness Questionnaire</strong></h5>
                                    <div class="row">
                                        <div class="col-sm-9"> Do you feel pain in your chest or other parts of your body when you perform physical activity? </div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="qtn custom-control-input" id="radio1" name="choice1" value="yes" required >
                                                    <label class="custom-control-label" for="radio1">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio2" name="choice1" value="no" required >
                                                    <label class="custom-control-label" for="radio2">No</label>
                                                </div>
                                            </div>
                                            <label id="choice1-error" class="error" for="choice1" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9"> 
                                            In the past month, have you had chest pain when you were not performing any physical activity?</div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="qtn custom-control-input" id="radio11" name="choice6" value="yes" required >
                                                    <label class="custom-control-label" for="radio11">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio12" name="choice6" value="no" required >
                                                    <label class="custom-control-label" for="radio12">No</label>
                                                </div>
                                            </div>
                                            <label id="choice6-error" class="error" for="choice6" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9"> Do you lose your balance because of dizziness or do you ever lose consciousness? </div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="qtn custom-control-input" id="radio3" name="choice2" value="yes" required >
                                                    <label class="custom-control-label" for="radio3">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio4" name="choice2" value="no" required >
                                                    <label class="custom-control-label" for="radio4">No</label>
                                                </div>
                                            </div>
                                            <label id="choice2-error" class="error" for="choice2" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9"> Is your doctor currently prescribing any medication for your blood pressure or for a heart condition? </div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="qtn custom-control-input" id="radio5" name="choice3" value="yes" required >
                                                    <label class="custom-control-label" for="radio5">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio6" name="choice3" value="no" required >
                                                    <label class="custom-control-label" for="radio6">No</label>
                                                </div>
                                            </div>
                                            <label id="choice3-error" class="error" for="choice3" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9"> Do you know of any other reason why you should not engage in physical activity?</div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="qtn custom-control-input" id="radio7" name="choice4" value="yes" required >
                                                    <label class="custom-control-label" for="radio7">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio8" name="choice4" value="no" required >
                                                    <label class="custom-control-label" for="radio8">No</label>
                                                </div>
                                            </div>
                                            <label id="choice4-error" class="error" for="choice4" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9"> Have you ever had any surgeries? (If yes, please explain).</div>
                                        <div class="col-sm-3">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="custom-control custom-radio mr-4">
                                                    <span id="choice5_error" class="error text-danger" style="display:none">This question is required</span>
                                                    <input type="radio" class="custom-control-input" id="radio9" name="choice5" value="yes" required >
                                                    <label class="custom-control-label" for="radio9">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio10" name="choice5" value="no" required >
                                                    <label class="custom-control-label" for="radio10">No</label>
                                                </div>
                                            </div>
                                            <label id="choice5-error" class="error" for="choice5" style="display: none;">This field is required.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_section">
                                    <textarea style="display : none;" id="medical_detail" name="medical_detail" placeholder="Please explain in detail about your past surgeries so it helps us make customizable solution for you." class="form-control eb-form-control other_reason"></textarea>
                                    <span id="medical_detail_error" class="error text-danger" style="display : none;">Please explain about your surgeries!</span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="custom-control custom-checkbox font-13">
                                            <input type="checkbox" name="terms_agree" class="custom-control-input" id="accept" required="">
                                            <label class="custom-control-label" for="accept">I accept to the <a href="<?=url('page/terms-of-service')?>" target="_blank">terms and conditions</a>.</label>
                                        </div>
                                        <span id="terms_agree_error" class="error text-danger" style="display:none">You have to accept the terms and conditions of Ebbsey for creating account !</span>
                                        <label id="terms_agree-error" class="error" for="terms_agree" style="display: none;">This field is required.</label>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn orange" id="complete_user_profile_btn"> COMPLETE MY PROFILE<span class="arrow"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--col -->
            </div> <!-- row -->
        </div> <!-- container -->
    </div>
</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
  
    
    $('body').on('click', '#yes_proceed', function () {
//        $('#third_form').submit();
    });
     var currentMonthTimePicker = monthNamesTimepicker[new Date().getMonth()];
                                                $('.date_of_birth').datetimepicker({
                                                    format: 'MMMM DD, YYYY',
                                                    maxDate: new Date().getFullYear() - 18 + '-' + currentMonthTimePicker + '-' + new Date().getDate()
                                                });
    $("#radio9").click(function () {
        if ($(this).is(":checked")) {
            $("#medical_detail").show();
        } else {
            $("#medical_detail").hide();
        }
    });
    $("#radio10").click(function () {
        if ($(this).is(":checked")) {
            $("#medical_detail").hide();
            $('#medical_detail_error').hide();
        } else {
            $("#medical_detail").show();
        }
    });

    $(window).bind("pageshow", function() {
        $('form').each(function(){
            $(this)[0].reset();
        });
    });
    
    $('#autocomplete').keyup(function () {
        $('#lat').val('');
        $('#lng').val('');
        $('#invalid_address_error').hide();
    });
    
    $("#first_form").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
                alphanumeric: true
            },
            last_name: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
                alphanumeric: true
            },
            email: {
                required: true,
                email: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                equalTo: "#password"
            },
            dob_day: {
                required: true,
            },
            dob_month: {
                required: true,
            },
            dob_year: {
                required: true,
            },
            phone: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            address: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            country: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            city: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            state: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            postal_code: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            profile_pic: {
                required: true
            }
        },
        messages: {
            profile_pic: {
                required: 'You must upload your profile picture'
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            if (!lat || !lng) {
                $('#invalid_address_error').html('This is not a valid address');
                $('#invalid_address_error').show();
                return;
            } else {
                $('#invalid_address_error').hide();
            }
            $("#dob_error").html('');
            $("#dob_error").addClass('d-none');
            let day = $("select[name=dob_day]").val();
            let month = $("select[name=dob_month]").val();
            let year = $("select[name=dob_year]").val();
            if(!validateDate(day, month, year)) {
                $("#dob_error").html('Please enter a valid date of birth');
                $("#dob_error").removeClass('d-none');
                return;
            }
            if(!checkAge(day, month, year)) {
                $("#dob_error").html('Your age must be 18+');
                $("#dob_error").removeClass('d-none');
                return;
            }
            $("#profile-tab").removeClass("disabled").addClass("active");
            $("#profile-tab").removeAttr("data-title");
            $("#profile").removeClass("disabled").addClass("show active");
            $("#home-tab").removeClass("active").addClass("disabled");
            $("#home").removeClass("show active");
            $('.nav-tabs li:first-child a').addClass('step_completed');
        }
    });

    $("#second_form").validate({
        submitHandler: function (form, event) {
            event.preventDefault();
            let other = $('textarea[name=other_fitnessgoal]').val();
            var numberOfChecked = $('input:checkbox:checked').length;
            if (numberOfChecked === 0 && other == '') {
                $("#fitness_goal_error").html('At least one fitness goal is required !');
                $("#fitness_goal_error").show();
            } else {
                $("#contact-tab").removeClass("disabled").addClass("active");
                $("#contact-tab").removeAttr("data-title");
                $("#contact").removeClass("disabled").addClass("show active");
                $("#profile-tab").removeClass("active").addClass("disabled");
                $("#profile").removeClass("show active");
                $('.nav-tabs li:nth-child(2) a').addClass('step_completed');
            }
        }
    });
    
    $("#third_form").validate({
        rules: {
            terms_agree: {
                required: true,
            }
        },
        messages: {
            terms_agree: {
                required: 'You must accept terms and conditions',
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            surgery_question = $("input:radio[name='choice5']:checked").val();
            medical_detail = $("textarea[name='medical_detail']").val();
            if (surgery_question === 'yes' && medical_detail === '') {
                $('#medical_detail_error').show();
            } else {
                $('#confirmComplete').modal({
                    backdrop: 'static',
                    keyboard: false
                }).one('click', '#yes_proceed', function (e) {
                    $('#confirmComplete').modal('hide');
                    showLoading();
                    submitAllForms();
                });
            }
        }
    });
    
    function submitAllForms(){
        $.ajax({
            url: "<?php echo asset('user-register-full'); ?>",
            type: "POST",
            data: $('#first_form, #second_form, #third_form').serialize(),
            success: function (data) {
                window.location.href = base_url + 'login';
            }
        });
    }

    $('#email').focusout(function () {
        email = $(this).val();
        $.ajax({
            type: "GET",
            data: {"email": email},
            url: "<?php echo asset('check_email'); ?>",
            success: function (data) {
                if (data) {
                    $('#emailerrormessage').hide();
                    $('#first_form_submit_btn').attr('disabled', false);
                } else {
                    $('#emailerrormessage').show();
                    $('#first_form_submit_btn').attr('disabled', true);
                }
            }
        });
    });
    
    $('#user_profile_pic').change(handleProfilePicSelect);
    
    function handleProfilePicSelect(event) {
        var input = this;
        var filename = $("#user_profile_pic").val();
        var fileType = input.files[0]['type'];
        var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
//        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#user_profile_pic').val('');
            $('input[name="profile_pic"]').val('');
            return false;
        }
//        if (input.files[0].size < 2000000) {

            var data = new FormData();
            data.append('gallery_images', input.files[0]);
            data.append('is_original_image_required', 1);
            $.ajax({
                type: "POST",
                url: "<?php echo asset('add_gallery_images'); ?>",
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if(data.error){
                        alert(data.error);
                    } else {
                        $('#user_profile_pic').val('');
                        var results = JSON.parse(data);
                        $('#user_profile_pic_div').css("background-image", "url(" + results.complete_path + ")");
                        $('input[name="profile_pic"]').val(results.path);
                        $('input[name="original_image"]').val(results.original_image_path);
                    }
                }
            });

//        } else {
//            alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
//        }
    }

    $("#myTab a").hover(
        function () {
                var title = $(this).attr("data-title");
                if (title) {
                    $('<div/>', {
                        text: title,
                        class: 'box'
                    }).appendTo($(this).parent('li'));
                }
        }, function () {
            $(document).find("div.box").remove();
    });


    var placeSearch, autocomplete;
    var componentForm = {
//        street_number: 'short_name',
//        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    window.initAutocomplete = function(){
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            //          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&libraries=places&callback=initAutocomplete"
async defer></script>
</body>
</html>
