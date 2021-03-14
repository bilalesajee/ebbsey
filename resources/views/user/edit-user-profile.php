<?php include resource_path('views/includes/header.php'); ?>
<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">EDIT PROFILE</h4>
            </div>

            <?php if (session()->has('success')) { ?>
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <strong><i class="fa fa-check"></i> Success!</strong> <?= Session::get('success'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <script>
                    setTimeout(function () {
                        $('.alert').css("display", "none");
                    }, 5000);
                </script>
            <?php } ?>

            <?php if (session()->has('error')) { ?>
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-check"></i> Error !</strong> <?= Session::get('error'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                </div> 

                <script>
                    setTimeout(function () {
                        $('.alert').css("display", "none");
                    }, 5000);
                </script>
            <?php } ?> 

        </div>
        <div class="row no-gutters edit_profile_tabs">
            <div class="col-md-3 col-12">
                <div class="nav flex-column">
                    <a class="active" data-toggle="pill" href="#v-pills-home">Basic Information</a>
                    <a data-toggle="pill" href="#v-pills-profile">Fitness Goals & Questionnaire</a>
                    <a data-toggle="pill" href="#v-pills-change-password">Change Password</a>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="v-pills-home">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Basic Information</h5>
                        </div>
                        <form id="first_form" action="<?= asset('/edit-user-profile') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="form_name" value="basic_form">
                            <div class="form_section">
                                <h5><strong>- Profile Picture</strong></h5>
                                <div class="edit_profile_image d-flex align-items-center">
                                    <?php
                                    $user_profile_pic = asset('public/images/users/default.jpg');
                                    if ($current_user->image) {
                                        $user_profile_pic = asset('public/images/' . $current_user->image);
                                    }
                                    ?>
                                    <div class="image_view" id="user_profile_pic_div" style="background-image: url('<?= $user_profile_pic ?>')"></div>
                                    <div class="ml-auto action_btns">
                                        <label class="btn pink" for="user_profile_pic"> Upload Photo </label>
                                        <div class="file_upload_btn2"> 
                                            <input id="user_profile_pic" type="file"> 
                                            <input name="profile_pic" type="hidden" value="<?= $current_user->image ?>">
                                            <input name="original_image" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <h5><strong>- Basic Details</strong></h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" value="<?= $current_user->first_name ?>" class="form-control eb-form-control" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" value="<?= $current_user->last_name ?>" class="form-control eb-form-control" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label>Date of Birth*</label>
                                            <input type="text" value="<?= date('F d, Y', strtotime($current_user->dob)) ?>" class="form-control eb-form-control" disabled="">
                                            <!--                                            <div class="input-group date date_of_birth" id="dob" data-target-input="nearest">
                                                                                            <input type="text" name="dob" required="" value=" <?= $current_user->dob ?>"  class="form-control datetimepicker-input eb-form-control" data-target="#dob"/>
                                                                                            <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div>
                                                                                        </div>-->
                                            <label id="dob-error" class="error" for="dob"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" value="<?= $current_user->email ?>" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="tel" name="phone" value="<?= $current_user->phone ? $current_user->phone : '' ?>" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <h5><strong>- Other Information</strong></h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Street Address</label>
                                            <input type="text" id="autocomplete" name="address" value="<?= $current_user->address ?>" class="form-control eb-form-control" required="">
                                            <label id="invalid_address_error" class="error" style="display: none;">This is not a valid address</label>
                                            <input type="hidden" id="lat" name="lat" value="<?= $current_user->lat ?>"/>
                                            <input type="hidden" id="lng" name="lng" value="<?= $current_user->lng ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <input type="text" id="country" name="country" value="<?= $current_user->country ?>" class="form-control eb-form-control" required=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" id="locality" value="<?= $current_user->city ?>" name="city" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" id="administrative_area_level_1" name="state" value="<?= $current_user->state ?>" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="number" id="postal_code" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "5" value="<?= $current_user->postal_code ?>" class="form-control eb-form-control" required=""/>
                                            <!--<input type="text" id="postal_code" name="postal_code" value="<?= $current_user->postal_code ?>" placeholder="Postal Code" class="form-control eb-form-control" required="">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <input type="submit" value="Save" class="btn orange btn-lg" />
                            </div>
                        </form>
                    </div> <!-- Basic Info tab -->

                    <div class="tab-pane fade" id="v-pills-profile">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Fitness Goals & Questionnaire</h5>
                        </div>
                        <form name="edit_user_form" id="edit_user_form" action="<?= asset('/edit-user-profile') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="form_name" value="goals_form">
                            <div class="form_section">
                                <h5><strong>- Choose your fitness goals <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                <div class="row">
                                    <input type="hidden" name="fitness_goals_changed" value="0" id="fitness_goals_changed">
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
                                                    <input type="checkbox" class="custom-control-input fitness_goals_checkbox" name="fitness_goals[<?= $fitness_goal->id ?>]" id="checkbox<?= $counter ?>"
                                                    <?php
                                                    if (isset($selected_fitness_goals)) {
                                                        foreach ($selected_fitness_goals as $selected_fitness_goal) {
                                                            ?>
                                                            <?= $selected_fitness_goal->fitness_goal_id == $fitness_goal->id ? 'checked' : '' ?> <?php
                                                        }
                                                    }
                                                    ?> >
                                                    <label class="custom-control-label" for="checkbox<?= $counter ?>" > <?= $fitness_goal->title ?> </label>
                                                </div>
                                            </div>
                                            <?php
                                            $counter++;
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div> <!-- section -->
                            <span style="display : none;" id="edit_fitness_goal_error" class="error text-danger">At least one fitness goal is required !</span>
                            <div class="form_section">
                                <h5><strong>- Others</strong></h5>
                                <input type="hidden" name="other_fitness_goal_changed" value="0" id="other_fitness_goal_changed">
                                <input type="hidden" name="user_other_fitness_goal_id" value="<?= $other_fitness_goal ? $other_fitness_goal->id : '' ?>">
                                <textarea name="other_fitness_goal" placeholder="If the top list does not specify what you are looking for. Enter reason here....." class="form-control eb-form-control other_reason other_fitness_goal" maxlength="255"><?= $other_fitness_goal ? $other_fitness_goal->goal->title : '' ?></textarea>
                            </div>
                            <div class="form_section">
                                <h5><strong>- Questionnaire </strong></h5>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        Do you feel pain in your chest or other parts of your body when you perform physical activity? 
                                        <label id="user_question1-error" class="error" for="user_question1" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input question_yes" id="radio1" name="user_question1" value="yes" required <?= isset($questionnaire1->choice) && $questionnaire1->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio1">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio2" name="user_question1" value="no" required <?= isset($questionnaire1->choice) && $questionnaire1->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        In the past month, have you had chest pain when you were not performing any physical activity?
                                        <label id="user_question6-error" class="error" for="user_question6" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input question_yes" id="radio11" name="user_question6" value="yes" required="" <?= isset($questionnaire6->choice) && $questionnaire6->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio11">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio12" name="user_question6" value="no" required="" <?= isset($questionnaire6->choice) && $questionnaire6->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio12">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        Do you lose your balance because of dizziness or do you ever lose consciousness? 
                                        <label id="user_question2-error" class="error" for="user_question2" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input question_yes" id="radio3" name="user_question2" value="yes" required="" <?= isset($questionnaire2->choice) && $questionnaire2->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio3">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio4" name="user_question2" value="no" required="" <?= isset($questionnaire2->choice) && $questionnaire2->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio4">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        Is your doctor currently prescribing any medication for your blood pressure or for a heart condition?
                                        <label id="user_question3-error" class="error" for="user_question3" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input question_yes" id="radio5" name="user_question3" value="yes" required="" <?= isset($questionnaire3->choice) && $questionnaire3->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio5">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio6" name="user_question3" value="no" required="" <?= isset($questionnaire3->choice) && $questionnaire3->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio6">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        Do you know of any other reason why you should not engage in physical activity? 
                                        <label id="user_question4-error" class="error" for="user_question4" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" class="custom-control-input question_yes" id="radio7" name="user_question4" value="yes" required="" <?= isset($questionnaire4->choice) && $questionnaire4->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio7">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio8" name="user_question4" value="no" required="" <?= isset($questionnaire4->choice) && $questionnaire4->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio8">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> 
                                        Have your ever had any surgeries? (If yes, please explain). 
                                        <label id="user_question5-error" class="error" for="user_question5" style="display: none"></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <span id="choice5_error" class="error text-danger" style="display:none">This question is required</span>
                                                <input type="radio" class="custom-control-input question_yes" id="radio9" name="user_question5" value="yes" required="" <?= isset($questionnaire5->choice) && $questionnaire5->choice == 'yes' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio9">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="radio10" name="user_question5" value="no" required="" <?= isset($questionnaire5->choice) && $questionnaire5->choice == 'no' ? 'checked' : '' ?> >
                                                <label class="custom-control-label" for="radio10">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <span id="medical_detail_error" class="error text-danger" style="display : none;">Please explain about your surgeries!</span>
                                <?php if (session()->has('medical_detail_message')) { ?>
                                    <div class="text-danger"><?php echo Session::get('medical_detail_message'); ?></div>
                                <?php } ?>
                                <textarea <?php if (isset($questionnaire5->choice) && $questionnaire5->choice == 'no') { ?> style="display : none;" <?php } ?> id="user_medical_detail" name="medical_detail" placeholder="Please explain in detail about your past surgeries so it helps us make customizable solution for you." class="form-control eb-form-control other_reason"><?= isset($questionnaire5->answer_detail) ? $questionnaire5->answer_detail : '' ?></textarea>
                            </div>
                            <div class="form_section">
                                <input type="submit" value="Save" class="btn orange btn-lg" id="edit_user_form_submit" />
                            </div>
                        </form>
                    </div> <!-- Fitness Goals tab -->

                    <div class="tab-pane fade" id="v-pills-change-password">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Change Password</h5>
                        </div>
                        <div class="container">
                            <div class="form-container">
                                <form action="<?= asset('change_password') ?>" id="change_password" method="post">
                                    <?php if (session()->has('password_error')) { ?>
                                        <div class="text-danger"><?php echo Session::get('password_error'); ?></div>
                                    <?php } ?>
                                    <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                    <div class="form_section">
                                        <div class="form-group">
                                            <input type="password" name="current_password" required placeholder="Enter Current Password" class="form-control eb-form-control" />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" name="password" required id="password" placeholder="New Password" class="form-control eb-form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" name="password_confirmation" required placeholder="Confirm Password" class="form-control eb-form-control" />
                                                </div>
                                            </div>
                                        </div> <!-- row -->
                                        <div class="form-group">
                                            <button type="submit" id="edit_user_btn" class="btn orange btn-lg"> SUBMIT <span class="arrow"></span> </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> <!-- Change Password tab -->

                </div> <!-- tab content -->
            </div> <!--col9 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- wrapper -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $("#radio9").click(function () {
        if ($(this).is(":checked")) {
            $("#user_medical_detail").show();
        } else {
            $("#user_medical_detail").hide();
        }
    });
    $("#radio10").click(function () {
        if ($(this).is(":checked")) {
            $("#user_medical_detail").hide();
        } else {
            $("#user_medical_detail").show();
        }
    });
</script>
<script>
    $('#edit_user_form_submit').click(function(event) {
//    $('#edit_user_form').submit(function (event) {
        event.preventDefault();
        
        numberOfChecked = $('input:checkbox:checked').length;
        if (numberOfChecked === 0) {
            $("#edit_fitness_goal_error").show();
            return;
        } else {
            $("#edit_fitness_goal_error").hide();
        }
        if (!$("input:radio[name='user_question5']").is(":checked")) {
            return;
            $("#choice5_error").show();
        } else {
            surgery_question = $("input:radio[name='user_question5']:checked").val();
            if (surgery_question === 'yes') {
                medical_detail = $("#user_medical_detail").val();
                if (!$.trim($("#user_medical_detail").val())) {
                    $("#medical_detail_error").show();
                    return;
                }
            } else {
                $("#medical_detail_error").hide();
            }
            $("#choice5_error").hide();
        }
        
        if ($(".question_yes").is(":checked")) {
            $('#confirmComplete').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#yes_proceed', function (e) {
                $('#edit_user_form').submit();
            });
        } else {
            $('#edit_user_form').submit();
        }

    });

    $('#autocomplete').keyup(function () {
        $('#lat').val('');
        $('#lng').val('');
        $('#invalid_address_error').hide();
    });

    $("#first_form").validate({
        rules: {
            dob: {
                required: true,
                date: true
            },
            phone: {
                required: true
            },
            address: {
                required: true
            },
            country: {
                required: true
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            postal_code: {
                required: true
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
            form.submit();
        }
    });

    $("#change_password").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 6
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                equalTo: "#password",
            }
        }
    });


    $('#user_profile_pic').change(handleProfilePicSelect);
    function handleProfilePicSelect(event)
    {
        var input = this;
        var filename = $("#user_profile_pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#user_profile_pic').val('');
            $('input[name="profile_pic"]').val('');
            return;
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

    $(".fitness_goals_checkbox").change(function () {
        $("#fitness_goals_changed").val("1");
    });
    $(".other_fitness_goal").change(function () {
        $("#other_fitness_goal_changed").val("1");
    });
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;
    var componentForm = {
//        street_number: 'short_name',
//        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    window.initAutocomplete = function () {
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