<?php include resource_path('views/includes/header.php'); ?>
<style>
    .form_field_error {
        border-color: red;
    }
</style>
<div class="signup_user_wrapper full_viewport">
    <div class="overlay full_viewport">
        <div class="container">
            <div class="title">
                <h5>Create Professional Trainer Account</h5>
                <p>Set up an account in three easy steps</p>
            </div>
        </div>
        <div class="tabs_outer">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 ml-auto mr-auto">
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li>
                                <a class="active" id="home-tab" data-toggle="tab" href="#home"><span class="step_number"> 1 </span> <span class="hidden_tab_info">Basic</span> Information</a>
                            </li>
                            <li>
                                <a class="disabled" id="profile-tab" data-toggle="tab"  data-title="You need to fill basic info first" href="#profile" ><span class="step_number"> 2 </span> Qualifications</a>
                            </li>
                            <li>
                                <a class="disabled" id="contact-tab" data-toggle="tab" data-title="Please fill basic info & and qualification first !" href="#contact"  ><span class="step_number"> 3 </span> <span class="hidden_tab_info">Hours &</span> Availability</a>
                            </li>
                            <li>
                                <a class="disabled" id="order-tab" data-toggle="tab" data-title="" href="#order"  ><span class="step_number"> 4 </span> Fitness Card </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 ml-auto mr-auto">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home">
                            <?php if (session()->has('success')) { ?>
                                <div class="text-success"><?php echo Session::get('success'); ?></div>
                            <?php } ?>
                            <?php if (Session::get('message')) { ?>
                                <div class="text-danger"><?= Session::get('message') ?></div>
                            <?php } ?>
                            <span id="basic_info_error" class="text text-danger" style="display: none;">Error has been occurred,You have entered some wrong data!</span>
                            <span id="basic_info_success" class="text text-success" style="display: none;">Account has been created successfully ,Please confirmation your account from email ! </span>
                            <form method="post" id="trainer_basic_form" action="<?= asset('trainer-register-basic') ?>" enctype="multipart/form-data">
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
                                                <input type="text" id="first_name" name="first_name" placeholder="First Name*" value="<?= old('first_name') ?>" class="form-control eb-form-control" required/>
                                            </div>
                                            <?php if ($errors->has('first_name')) { ?>
                                                <div class="error text-danger"><?= $errors->first('first_name') ?></div>
                                            <?php } ?>
                                            <span id="first_name_error" class="text text-danger" style="display: none;"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" id="last_name" name="last_name" placeholder="Last Name*" value="<?= old('last_name') ?>" class="form-control eb-form-control" required/>
                                            </div>
                                            <?php if ($errors->has('last_name')) { ?>
                                                <div class="error text-danger"><?= $errors->first('last_name') ?></div>
                                            <?php } ?>
                                            <span id="last_name_error" class="text text-danger" style="display: none;"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" id="email" name="email" placeholder="Email ID*" value="<?= old('email') ?>" class="form-control eb-form-control" required/>
                                                <label style="display:none" id="errormessage" class="error">This email has already been taken !</label>
                                            </div>
                                            <?php if ($errors->has('email')) { ?>
                                                <div class="error text-danger"><?= $errors->first('email') ?></div>
                                            <?php } ?>
                                            <span id="email_error" class="text text-danger" style="display: none;"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <div class="d-flex">
                                                    <div class="pr-2 w-100">
                                                        <select name="dob_day" class="form-control eb-form-control" required="">
                                                            <option selected="" value="" disabled="">Day</option>
                                                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
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
                                                            <?php for ($i = date('Y'); $i >= 1905; $i--) { ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="error text-danger d-none" id="dob_error"></div>
                                                <?php if ($errors->has('dob')) { ?>
                                                    <div class="error text-danger"><?= $errors->first('dob') ?></div>
                                                <?php } ?>
                                            </div>   
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" id="password" name="password" placeholder="Password*" class="form-control eb-form-control" required/>
                                            </div>
                                            <?php if ($errors->has('password')) { ?>
                                                <div class="error text-danger"><?= $errors->first('password') ?></div>
                                            <?php } ?>
                                            <span id="password_error" class="text text-danger" style="display: none;"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" placeholder="Confirm Password*" class="form-control eb-form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Gender</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="radio1" name="gender" value="male" required>
                                                        <label class="custom-control-label" for="radio1"> Male </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="radio2" name="gender" value="female" required>
                                                        <label class="custom-control-label" for="radio2"> Female </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label id="gender-error" class="error" for="gender" style="display: none;">Gender field is required.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_section">
                                    <h5><strong>- Other Information</strong></h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" autocomplete="off" id="autocomplete" name="address" value="<?= old('address') ?>" placeholder="Street Address" class="form-control eb-form-control"/>
                                                <label id="invalid_address_error" class="error" style="display: none;">This is not a valid address</label>
                                                <input type="hidden" id="lat" name="lat"/>
                                                <input type="hidden" id="lng" name="lng"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="country" name="country" value="<?= old('country') ?>" placeholder="Country" class="form-control eb-form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="locality" name="city" value="<?= old('city') ?>" placeholder="City" class="form-control eb-form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="text" id="administrative_area_level_1" name="state" value="<?= old('state') ?>" placeholder="State" class="form-control eb-form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input readonly="" type="number" id="postal_code" value="<?= old('postal_code') ?>" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "5" value="<?= old('postal_code') ?>" placeholder="Postal Code" class="form-control eb-form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="phone" value="<?= old('phone') ?>" placeholder="Phone Number" id="t_phone" class="form-control eb-form-control phonemask"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_section">
                                    <h5><strong>- Social Media</strong></h5>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 mb-2 d-flex align-items-center">
                                                <span class="icon_social icon_facebook"></span> Facebook
                                            </div>
                                            <div class="col-sm-9 col-md-10">
                                                <input type="url" name="fb_link" value="<?= old('fb_link') ?>" placeholder="Enter your facebook URL" class="form-control eb-form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 mb-2 d-flex align-items-center">
                                                <span class="icon_social icon_instagram"></span> Instagram
                                            </div>
                                            <div class="col-sm-9 col-md-10">
                                                <input type="url" name="insta_link" value="<?= old('insta_link') ?>" placeholder="Enter your instagram ID" class="form-control eb-form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <button type="submit" id="trainer_basic_submit" class="btn orange"> PROCEED TO NEXT STEP<span class="arrow"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>        
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <span id="profile_error" class="text text-danger" style="display : none;"> error occurred  </span>
                            <form method="post" id="trainer_qualification_form" action="<?= asset('/trainer-register-qualifications') ?>" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                <div class="form_section">
                                    <h5><strong>- Qualifications</strong></h5>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 d-flex align-items-center">
                                            <label>Years of experience</label>
                                            <?php if ($errors->has('trainer_experience')) { ?>
                                                <div class="error text-danger"><?= $errors->first('trainer_experience') ?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-4 col-md-5">
                                            <select name="trainer_experience" class="form-control eb-form-control" required="">
                                                <option value="">Select Experience</option>
                                                <option value="0-3">0-3 Years</option>
                                                <option value="4-6">4-6 Years</option>
                                                <option value="7-9">7-9 Years</option>
                                                <option value="10+">10+ Years</option>
                                            </select>
                                        </div>
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="form_section">
                                    <h5><strong>- Choose your qualifications <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                    <div class="row">
                                        <?php
                                        $qualifications = trainerQualifications();
                                        $trainer_qualifications = $qualifications['qualifications'];
                                        if ($trainer_qualifications) {
                                            $counter = 1;
                                            foreach ($trainer_qualifications as $qualification) {
                                                ?>
                                                <div class="col-sm-4 col-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input qualifications_checkboxes" name="qualifications[<?= $qualification->id ?>]" id="checkbox<?= $counter ?>">
                                                        <label class="custom-control-label" for="checkbox<?= $counter ?>" > <?= $qualification->title == 'NASM' ? 'NASM (preferred)' : $qualification->title ?> </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                        }
                                        ?>
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <label style="display:none" id="qualifications_error" class="error text-danger">At least one qualifications is required !</label>
                                <div class="form_section">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h5><strong>- Others</strong></h5>
                                            <input name="qualification_other" placeholder="Please enter your qualifications if its not there in the list above" class="form-control eb-form-control" />
                                        </div>
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="form_section">
                                    <h5><strong>- Choose Training Type</strong></h5>
                                    <div id="type_checkboxes" class="row">
                                        <script>
                                            var documents = [];
                                        </script>
                                        <?php
                                        $training_types = trainingTypes();
                                        $training_types = $training_types['training_types'];
                                        if (isset($training_types)) {
                                            $counter = 1;
                                            foreach ($training_types as $training_type) {
                                                ?>
                                                <script>
                                                    documents[<?= $counter - 1 ?>] = {'certificates': [], 'certificates_counter': 0, 'cvs': [], 'cvs_counter': 0};
                                                </script>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="trainer_type type_personal_trainer">
                                                        <div class="trainer_header">
                                                            <div class="icon" style="background-image: url(<?= asset('public/images/' . $training_type->image) ?>);"></div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input name="trainer_type[<?= str_replace(' ', '', $training_type->title) ?>]" data-type="<?= str_replace(' ', '', $training_type->title); ?>" type="checkbox" value="<?= $training_type->id ?>" class="custom-control-input training_type_checkbox" id="ptt<?= $counter ?>">
                                                                <label class="custom-control-label" for="ptt<?= $counter ?>"><?= $training_type->title ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="trainer_body">
                                                            <div class="upload-documents">
                                                                <div class="upload-header">
                                                                    <div class="row">
                                                                        <div class="col-xl-8 col-lg-9 col-sm-8">
                                                                            <h6 class="mb-0"><span class="icon-certificate"></span> <strong>Certifications </strong></h6>
                                                                            <label id="certificates<?= $counter - 1 ?>-error" class="error" for="certificates<?= $counter - 1 ?>"></label>
                                                                        </div>
                                                                        <div class="col-xl-4 col-lg-3 col-sm-4">
                                                                            <div class="file_upload_btn">
                                                                                Upload 
                                                                                <input class="file_input" data-file-category="certificates" data-array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                <input class="file_input_certificates document_input" name="certificates[<?= str_replace(' ', '', $training_type->id) ?>]" id="certificates<?= $counter - 1 ?>" type="hidden">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploaded_certificates">
                                                                    <ul id="ul_certificates<?= $counter - 1 ?>" class="document_list d-flex flex-wrap"></ul>
                                                                </div>
                                                            </div>
                                                            <div class="upload-documents">
                                                                <div class="upload-header">
                                                                    <div class="row">
                                                                        <div class="col-xl-8 col-lg-9 col-sm-8">
                                                                            <h6 class="mb-0"><span class="icon-certificate"></span> <strong>CV </strong></h6>
                                                                            <label id="cvs<?= $counter - 1 ?>-error" class="error" for="cvs<?= $counter - 1 ?>"></label>
                                                                        </div>
                                                                        <div class="col-xl-4 col-lg-3 col-sm-4">
                                                                            <div class="file_upload_btn"> Upload 
                                                                                <input class="file_input" data-file-category="cvs" data-array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                <input class="file_input_cv document_input" name="cv[<?= str_replace(' ', '', $training_type->id) ?>]" id="cvs<?= $counter - 1 ?>" type="hidden">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploaded_certificates">
                                                                    <ul id="ul_cvs<?= $counter - 1 ?>" class="document_list d-flex flex-wrap"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                        }
                                        ?>
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div id="training_type_error" class="error text-danger" style="display : none;">You have to choose at least one training type</div>
                                <div class="form_section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5><strong>- License Expiration Date</strong></h5>
                                            <div class="input-group date lic_exp_date flex-column" id="lic" data-target-input="nearest">
                                                <div class="d-flex"> 
                                                    <input type="text" autocomplete="off" name="license_expire_date" placeholder="License Expiration Date*"  value="<?= old('license_expire_date') ?>" class="form-control datetimepicker-input eb-form-control" data-target="#lic"/>
                                                    <div class="input-group-append" data-target="#lic" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                <label id="lic-error" class="error" for="lic" style="display: none;">This field is required.</label>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="trainer_second_step" class="btn orange"><span class="icon_loading" style="display : none;"></span> PROCEED TO NEXT STEP<span class="arrow"></span></button>
                                    </div>
                                </div> <!-- row -->
                            </form>
                        </div> <!-- tab -->
                        <div class="tab-pane fade" id="contact">
                            <form method="post" id="trainer_full_form" action="<?= asset('/trainer-register-full') ?>" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                <div class="form_section">
                                    <h5><strong> - Discipline <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                    <div class="row">
                                        <?php
                                        $trainerSpecializations = trainerSpecializations();
                                        $trainerSpecializations = $trainerSpecializations['specializations'];
                                        if ($trainerSpecializations) {
                                            $counter = 1;
                                            foreach ($trainerSpecializations as $specialization) {
                                                ?>
                                                <div class="col-sm-4">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input specialization-checkbox" name="specializations[<?= $specialization->id ?>]" value="<?= $specialization->id ?>" id="specializations_checkbox<?= $counter ?>">
                                                        <label class="custom-control-label" for="specializations_checkbox<?= $counter ?>"> <?= $specialization->title ?> </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <label style="display:none" id="specialization_error" class="error text-danger">At least one discipline is required !</label>
                                <div class="form_section">
                                    <h5><strong> - Others</strong></h5>
                                    <input type="text" name="other_specialization" placeholder="Please enter your discipline if its not there in the list above" class="form-control eb-form-control other_reason">
                                </div>
                                <div class="form_section">
                                    <h5><strong> - How far you are willing to travel to a job?</strong></h5>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <select name="distance" class="form-control eb-form-control">
                                                <option value="5"> 5 mile </option>
                                                <option value="10"> 10 mile </option>
                                                <option value="15"> 15 mile </option>
                                                <option value="20"> 20 mile </option>
                                                <option value="25"> 25 mile </option>
                                                <option value="30"> 30 mile </option>
                                                <option value="35"> 35 mile </option>
                                                <option value="40"> 40 mile </option>
                                                <option value="45"> 45 mile </option>
                                                <option value="50"> 50 mile </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_section">
                                    <h5><strong> - Readiness Questionnaire</strong></h5>
                                    <div class="row d-none readiness_question_group_trainer">
                                        <div class="col-sm-10"> 
                                            Do you have a facility to teach your class?
                                            <label id="trainer_question1-error" class="error" for="trainer_question1" style="display: none;">This field is required.</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="custom-control-input readiness_question_group_trainer_input" id="rd11" name="trainer_question1" value="yes">
                                                    <label class="custom-control-label" for="rd11">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input readiness_question_group_trainer_input" id="rd2" name="trainer_question1" value="no">
                                                    <label class="custom-control-label" for="rd2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10"> 
                                            Do you own a vehicle? 
                                            <label id="trainer_question2-error" class="error" for="trainer_question2" style="display: none;">This field is required.</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="custom-control-input" id="radio103" name="trainer_question2" value="yes" required="">
                                                    <label class="custom-control-label" for="radio103">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio104" name="trainer_question2" value="no" required="">
                                                    <label class="custom-control-label" for="radio104">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10"> 
                                            Do you have a personal trainer insurance? 
                                            <label id="trainer_question3-error" class="error" for="trainer_question3" style="display: none;">This field is required.</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input type="radio" class="custom-control-input" id="radio105" name="trainer_question3" value="yes" required="">
                                                    <label class="custom-control-label" for="radio105">Yes</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="radio106" name="trainer_question3" value="no" required="">
                                                    <label class="custom-control-label" for="radio106">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_section">
                                    <h5><strong> - Your Availability Slots</strong></h5>
                                    <table class="classes_schedule">
                                        <thead>
                                            <tr>
                                                <th>MONDAY</th>
                                                <th>TUESDAY</th>
                                                <th>WEDNESDAY</th>
                                                <th>THURSDAY</th>
                                                <th>FRIDAY</th>
                                                <th>SATURDAY</th>
                                                <th>SUNDAY</th>                                    
                                            </tr>
                                        </thead>
                                        <tbody id="timetablerows">
                                        </tbody>
                                    </table>
                                    <span class="add_availability_btn" id="add_availability_btn">+ Add Availability</span>
                                    <!--<a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#addavailability"> Add Availability </a>-->
                                    <div class="modal fade" id="addavailability" tabindex="-1" role="dialog" data-day-name="" data-counter="">
                                        <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLongTitle">Add Availibility</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12" id="error_div"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label>From</label>
                                                            <div class="input-group date only_time" id="timefrom" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input eb-form-control" id="from" data-target="#timefrom"/>
                                                                <div class="input-group-append" data-target="#timefrom" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label>To</label>
                                                            <div class="input-group date only_time" id="timeto" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input eb-form-control" id="to" data-target="#timeto"/>
                                                                <div class="input-group-append" data-target="#timeto" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-start">
                                                    <button type="button" class="btn btn-lg orange save_time_btn">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="trainer_final_submit" class="btn orange"> COMPLETE MY PROFILE</span><span class="arrow"></span></button> 
                                    </div>
                                </div> 
                            </form>
                        </div>
                        <div class="tab-pane fade" id="order">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 mx-auto">
                                    <div class="text-center mb-4">
                                        <h5 class="mb-1 font-weight-extrabold"><span id="formname" >Fitness Card</span></h5>
                                        <!--<p>Please select an option to continue</p>-->
                                    </div> 

                                    <form name="" action="" id="card_order_form">
                                        <div class="form-group mb-4"> 
                                            <input type="hidden" name="user_id" id="user_id" value=""/>
                                        </div> 
                                        <div class="order_form_wrap">
                                            <!--                                            <div class="order_form_head d-flex">
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
                                                <div class="form_section mb-3 simple_order" id="simple_order11">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label for="">First Name</label>
                                                            <div class="form-group">
                                                                <input type="text" name="first_name" id="order_first_name" value="" placeholder="First Name" class="form-control eb-form-control"  readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Last Name</label>
                                                            <div class="form-group">
                                                                <input type="text" name="last_name" id="order_last_name" value="" placeholder="Last Name" class="form-control eb-form-control"  readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label for="">
                                                                Trainer Type
<!--                                                                <span id="group_fitness" style="display: none"> Group Fitness Instructor  </span><span id="seperator" style="display: none">|</span>
                                                                <span id="personal_certified" style="display: none">  Certified Personal Trainer, Group Fitness Instructor</span> -->

                                                            </label>
                                                            <div class="form-group">
                                                                <input type="hidden" value="" name="address" id="address" placeholder="Location" class="form-control eb-form-control" value="1240 9th St NW, Washington, DC 20001"  readonly/>
                                                                <input type="text" name="trainer_type" value="" placeholder="Trainer Type" class="form-control eb-form-control t_type" value=""  readonly/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Phone</label>
                                                            <div class="form-group">
                                                                <input type="text" value="" name="phone" id="phone" placeholder="Phone" class="form-control eb-form-control phonemask"  required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Email</label>
                                                            <div class="form-group">
                                                                <input type="hidden" value="" name="card_first_name" id="card_first_name"/>
                                                                <input type="hidden" value="" name="card_last_name" id="card_last_name"/>
                                                                <input type="email" value="" name="email" placeholder="Email" class="form-control eb-form-control"  required/>
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
                                                                <input type="text" value="<?= $url ?>" name="url" placeholder="URL" class="form-control eb-form-control disabled"  readonly=""/>
                                                            </div>
                                                        </div>
                                                    </div> <!-- row -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order_form_wrap">
                                            <!--                                            <div class="order_form_head d-flex">
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
                                                                <input type="radio" class="custom-control-input" id="rd1" name="shot_location" value="1" required="" checked="">
                                                                <label class="custom-control-label" for="rd1"> Studio Photoshoot </label>
                                                            </div>
                                                            <div class="custom-control custom-radio mr-4">
                                                                <input type="radio" class="custom-control-input" id="loc" name="shot_location" value="2" required="">
                                                                <label class="custom-control-label" for="loc"> Location </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mt-3 admin_location">
                                                            <label for="">Studio Photoshoot</label>
                                                            <input type="text" value="1240 9th St NW, Washington, DC 20001" class="form-control eb-form-control" value="" placeholder="Location" readonly/>
                                                        </div> 
                                                        <div class="form-group mt-3 client_location" style="display: none;">
                                                            <label for="">Location</label>
                                                            <input type="text" class="form-control eb-form-control" id="location_autocom" name="client_location" value="" placeholder="Location"/>
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
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="agred" id="businesscard">
                                                    <label class="custom-control-label" for="businesscard"> I accept to the <a href="<?= asset('page/terms-of-service') ?>" target="_blank">terms and conditions</a>.</label>
                                                </div>
                                                <label id="agred-error" class="error" for="agred" style="display: none;">This field is required.</label>
                                            </div>
                                            <div class="form_section text-center">
                                                <button type="button" class="btn orange btn-lg disabled" id="submit_btn"> 
                                                    SUBMIT NOW <span class="arrow"></span></button>

                                                <button type="button" class="btn orange btn-lg" id="skip_for_now"> 
                                                    Skip <span class="arrow"></span></button>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div> <!-- row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table style="display: none;" id="row_to_be_cloned">
    <tr>
        <td id="monday1" data-day-name="monday" data-counter="1">
            <span></span>
            <input type="hidden" name="monday[]">
        </td>
        <td id="tuesday1" data-day-name="tuesday" data-counter="1">
            <span></span>
            <input type="hidden" name="tuesday[]">
        </td>
        <td id="wednesday1" data-day-name="wednesday" data-counter="1">
            <span></span>
            <input type="hidden" name="wednesday[]">
        </td>
        <td id="thursday1" data-day-name="thursday" data-counter="1">
            <span></span>
            <input type="hidden" name="thursday[]">
        </td>
        <td id="friday1" data-day-name="friday" data-counter="1">
            <span></span>
            <input type="hidden" name="friday[]">
        </td>
        <td id="saturday1" data-day-name="saturday" data-counter="1">
            <span></span>
            <input type="hidden" name="saturday[]">
        </td>
        <td id="sunday1" data-day-name="sunday" data-counter="1">
            <span></span>
            <input type="hidden" name="sunday[]">
        </td>
    </tr>
</table>

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
                                    <input type="text" name="card_first_name" id="model_first_name" class="form-control eb-form-control" placeholder="First Name" required/>
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_last_name" id="model_last_name" class="form-control eb-form-control" value="" placeholder="Last Name" required/>
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
                            <input type="email" name="email" id="modal_email" autocomplete="off" required class="form-control eb-form-control" placeholder="Email" />
                            <div class="icon d-flex justify-content-end align-items-center">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="card_number" id="modal_card_number" value="" required class="form-control eb-form-control" placeholder="Card Number" />
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-credit-card-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="field_wrap">
                                    <input type="text" name="expiry_date" id="modal_expiry_date" value="" required class="form-control eb-form-control" placeholder="MM/YYYY" />
                                    <div class="icon d-flex justify-content-end align-items-center">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->
                    <div class="form-group">
                        <div class="field_wrap">
                            <input type="text" name="cvc" id="modal_cvc" value="" required class="form-control eb-form-control" placeholder="CVC" />
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
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<style>
    #order_form_modal input.esrror {
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
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>

                                            $(document).ready(function () {

                                                $('body').on('change', '#businesscard', function () {
                                                    if ($(this).is(':checked')) {
                                                        $(this).parents('.form-section').find('#submit_btn').removeClass('disabled');
                                                    } else {
                                                        $(this).parents('.form-section').find('#submit_btn').addClass('disabled');
                                                    }
                                                });
                                            });
                                            $(window).bind("pageshow", function () {
                                                $('form').each(function () {
                                                    $(this)[0].reset();
                                                });
                                            });
                                            var simple_card_price_now = '14.85',
                                                    simple_card_price_later = '19.95',
                                                    custom_card_price_now = '139',
                                                    custom_card_price_later = '199';
                                            var user_id;
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
                                            $('.order_form_wrap input[type="checkbox"]').click(function () {
                                                $(this).parents('.order_form_wrap').find('.order_form_body').toggle();
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
                                            var g_fitnes = '';
                                            var p_certified = '';
                                            $('body').on('change', '.training_type_checkbox', function () {
                                                var type_value = '';

                                                if ($(this).attr('data-type') == 'GroupFitnessInstructor') {
                                                    if ($(this).is(':checked')) {
                                                        g_fitnes = 'Group Fitness Instructor';
                                                    } else {
                                                        g_fitnes = '';
                                                    }
                                                }
                                                if ($(this).attr('data-type') == 'CertifiedPersonalTrainer') {

                                                    if ($(this).is(':checked')) {

                                                        p_certified = 'Certified Personal Trainer';

                                                    } else {
                                                        p_certified = '';
                                                    }
                                                }
                                                if (p_certified && g_fitnes) {
                                                    $('.t_type').val(g_fitnes + ' & ' + p_certified);
                                                } else if (p_certified) {
                                                    $('.t_type').val(p_certified);
                                                } else if (g_fitnes) {
                                                    $('.t_type').val(g_fitnes);
                                                }

                                                if (g_fitnes == 'Group Fitness Instructor') {
                                                    $('.readiness_question_group_trainer').removeClass('d-none');
                                                } else {
                                                    $('.readiness_question_group_trainer').addClass('d-none');
                                                }

                                            });
                                            $('body').on('change', '#autocomplete', function () {
                                                $('body').find('input[name="address"]').val($(this).val());
                                                $('body').find('input[name="client_location"]').val($(this).val());
                                            });


                                            $('input[name="expiry_date"]').inputmask("mm/yyyy", {"placeholder": "_", "baseYear": 1900});
                                            $('input[name="card_number"]').mask("9999-9999-9999-9999");
                                            $('input[name="cvc"]').mask("999");
                                            $('input[name="card_zip_code"]').mask("99999");
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
                                                    card_first_name: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                        alphanumeric: true
                                                    },
                                                    card_last_name: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                        alphanumeric: true
                                                    },
                                                    card_address: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    card_city: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    card_state: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    card_country: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    card_zip_code: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    email: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    card_number: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    expiry_date: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    cvc: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    expiry_date: {
                                                        trioDate: true
                                                    }
                                                },
                                                submitHandler: function (e) {
                                                    var email = $('#modal_email').val();
                                                    var card_number = $('#modal_card_number').val();
                                                    var expiry_date = $('#modal_expiry_date').val();
                                                    var cvc = $('#modal_cvc').val();


                                                    $('#card_first_name').val($('#model_first_name').val());
                                                    $('#card_last_name').val($('#model_last_name').val());

                                                    $('#card_email').val(email);
                                                    $('#card_number').val(card_number);
                                                    $('#card_expiry_date').val(expiry_date);
                                                    $('#card_cvc').val(cvc);
                                                    $('#order_form_modal').modal('hide');
                                                }
                                            });
                                            $('body').on('change', '.file_input', function () {
                                                certificatesPreview(this);
                                            });

                                            function certificatesPreview(input) {
                                                $('#trainer_second_step').prop('disabled', true);
                                                $('.icon_loading').show();
                                                var array_counter = $(input).attr('data-array-counter');
                                                var file_category = $(input).attr('data-file-category');


                                                if (input.files) {
                                                    for (var x = 0; x < input.files.length; x++) {
                                                        var filePath = input.value;

                                                        var filename = input.files[x].name;
                                                        var fileType = filename.replace(/^.*\./, '');
                                                        var validTypes = ["pdf", "docx"];
                                                        if (file_category == 'certificates') {
                                                            validTypes = ["jpg", "jpeg", "png", "pdf", "docx"];
                                                        }
                                                        if ($.inArray(fileType, validTypes) < 0) {
                                                            if (file_category == 'certificates') {
                                                                alert('Please upload file having extensions .jpg/.jpeg/.png/.pdf/.docx only.');
                                                            } else if (file_category == 'cvs') {
                                                                alert('Please upload file having extensions .pdf/.docx only.');
                                                            }
                                                            $(input).val('');
                                                            return false;
                                                        }

                                                    }
                                                    if (parseInt(input.files.length) > 5 - documents[array_counter][file_category + '_counter']) {
                                                        alert('You can only upload maximum 5 files');
                                                        $(input).val('');
                                                        return false;
                                                    }

                                                    var filesAmount = input.files.length;

                                                    for (i = 0; i < filesAmount; i++) {
                                                        var data = new FormData();
                                                        data.append('documents', input.files[i]);
                                                        data.append('file_category', file_category);
                                                        documents[array_counter][file_category + '_counter']++;
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo asset('add_documents'); ?>",
                                                            data: data,
                                                            processData: false,
                                                            contentType: false,
                                                            beforeSend: function (request) {
                                                                $('#trainer_second_step').prop('disabled', true);
                                                                $('.icon_loading').show();
                                                                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                                            },
                                                            success: function (successdata) {
                                                                $(input).val('');
                                                                var results = JSON.parse(successdata);

                                                                let image = results.complete_path;

                                                                if (results.file_type == 'pdf') {
                                                                    image = 'userassets/images/pdf.png';
                                                                } else if (results.file_type == 'docx') {
                                                                    image = 'userassets/images/docx.png';
                                                                }

                                                                $('ul#ul_' + file_category + array_counter).append(
                                                                        '<li>' +
                                                                        '<div class="thumbnail" style="background-image: url(\'' + image + '\')">' +
                                                                        '<img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid" />' +
                                                                        '<div class="actions align-items-center justify-content-center">' +
                                                                        '<i class="fa fa-trash delete_document" path="' + results.path + '" data-array-counter="' + array_counter + '" data-file-category="' + file_category + '"></i>' +
                                                                        '</div>' +
                                                                        '</div>' +
                                                                        '</li>');

                                                                documents[array_counter][file_category].push(results.path);
                                                                $('#' + file_category + array_counter).val(documents[array_counter][file_category]);

                                                                $('#trainer_second_step').prop('disabled', false);
                                                                $('.icon_loading').hide();
                                                            }
                                                        });
                                                    }
                                                }
                                            }

                                            $('body').on('click', '.delete_document', function () {

                                                var ref = $(this);
                                                let path = $(this).attr('path');
                                                let array_counter = $(this).attr('data-array-counter');
                                                let file_category = $(this).attr('data-file-category');

                                                let index = documents[array_counter][file_category].indexOf(path);
                                                if (index != -1) {
                                                    $.ajax({
                                                        url: "<?php echo asset('delete_document') ?>",
                                                        type: "POST",
                                                        data: {"path": path, "_token": "<?php echo csrf_token(); ?>"},
                                                        success: function (response) {
                                                            if (response.status == 'success') {
                                                                $('#' + file_category + array_counter).val('');
                                                                documents[array_counter][file_category].splice(index, 1);
                                                                documents[array_counter][file_category + '_counter']--;
                                                                $('#' + file_category + array_counter).val(documents[array_counter][file_category]);
                                                                ref.parents('li').remove();
                                                            }
                                                        }
                                                    });
                                                }
                                            });

                                            $('#user_profile_pic').change(handleProfilePicSelect);
                                            function handleProfilePicSelect(event)
                                            {
                                                var input = this;
                                                var filename = $("#user_profile_pic").val();
                                                var fileType = input.files[0]['type'];
                                                var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
                                                if ($.inArray(fileType, ValidImageTypes) < 0) {
                                                    alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
                                                    event.preventDefault();
                                                    $('#user_profile_pic').val('');
                                                    $('input[name="profile_pic"]').val('');
                                                    return false;
                                                }

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

                                            }

                                            $('#add_availability_btn').click(function () {
                                                var number_of_rows = $('#timetablerows tr').length;
                                                var counter = number_of_rows + 1;
                                                var cloned_html = $('#row_to_be_cloned tr').clone();

                                                $(cloned_html['0'].cells).each(function () {
                                                    var day_name = $(this).attr('data-day-name');
                                                    $(this).attr('data-counter', counter);
                                                    $(this).attr('id', day_name + counter);
                                                });
                                                $('#timetablerows').append(cloned_html);
                                            });

                                            $('body').on('click', 'td', function (e) {
                                                e.stopPropagation;
                                                if (e.target.tagName != 'I') {
                                                    $('#error_div').html('');
                                                    var day_name = $(this).attr('data-day-name');
                                                    var counter = $(this).attr('data-counter');
                                                    var time = $(this).find('input').val();
                                                    time = time.split("-");
                                                    $('#from').val(time[0]);
                                                    $('#to').val(time[1]);
                                                    $('#addavailability').modal('show');
                                                    $('#addavailability').attr('data-day-name', day_name);
                                                    $('#addavailability').attr('data-counter', counter);

                                                    var monthNamesTimepicker = ["January", "February", "March", "April", "May", "June",
                                                        "July", "August", "September", "October", "November", "December"
                                                    ];

                                                    var currentMonthTimePicker = new Date().getMonth() + 1;
                                                    if (day_name == 'saturday' || day_name == 'sunday') {
                                                        $('#addavailability').find('.only_time').addClass('only_time_weekend');
                                                        $('#addavailability').find('.only_time').removeClass('only_time');
                                                        $('.only_time_weekend').datetimepicker('destroy');
                                                        $('.only_time_weekend').datetimepicker({
                                                            format: 'LT',
                                                            minDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 7:00 AM',
                                                            maxDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 9:31 PM'
                                                        });
                                                    } else {
                                                        $('#addavailability').find('.only_time_weekend').addClass('only_time');
                                                        $('#addavailability').find('.only_time_weekend').removeClass('only_time_weekend');
                                                        $('.only_time').datetimepicker('destroy');
                                                        $('.only_time').datetimepicker({
                                                            format: 'LT',
                                                            minDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 5:30 AM',
                                                            maxDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + new Date().getFullYear() + ' 9:31 PM'
                                                        });
                                                    }
                                                }
                                            });

                                            $('.save_time_btn').click(function () {
                                                var from = $('#from').val();
                                                var to = $('#to').val();

                                                var day_name = $('#addavailability').attr('data-day-name');
                                                var counter = $('#addavailability').attr('data-counter');
                                                if (from && to) {
                                                    var selected_row = $('#timetablerows').find('td[data-day-name="' + day_name + '"] span:empty').first().parent('td');

                                                    if ($('#' + day_name + counter).find('input').val()) {
                                                        selected_row = $('#' + day_name + counter);
                                                        $(selected_row).find('span').html(from + ' - ' + to);
                                                        $(selected_row).find('input').val(from + '-' + to);
                                                        $(selected_row).prepend('<i class="fa fa-close close_time"></i>');
                                                    } else if (selected_row[0] != undefined) {
                                                        $(selected_row).find('span').html(from + ' - ' + to);
                                                        $(selected_row).find('input').val(from + '-' + to);
                                                        $(selected_row).prepend('<i class="fa fa-close close_time"></i>');
                                                    } else {
                                                        selected_row = $('#' + day_name + counter);
                                                        $(selected_row).find('span').html(from + ' - ' + to);
                                                        $(selected_row).find('input').val(from + '-' + to);
                                                        $(selected_row).prepend('<i class="fa fa-close close_time"></i>');
                                                    }

                                                    var times = [];
                                                    var selected_row_id = $(selected_row).attr('id');
                                                    var selected_value = $(selected_row).find('input').val();

                                                    $('#timetablerows input[name="' + day_name + '[]"]').each(function () {
                                                        var parent_id = $(this).parent('td').attr('id');
                                                        if ($(this).val()) {
                                                            if (parent_id != selected_row_id) {
                                                                times.push($(this).val());
                                                            }
                                                        }
                                                    });

                                                    $.ajax({
                                                        url: "<?php echo asset('validate_timetable_slot'); ?>",
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: {'times': times, 'selected_value': selected_value, 'day_name': day_name},
                                                        beforeSend: function (request) {
                                                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                                        },
                                                        success: function (data) {
                                                            if (data.error) {
                                                                $(selected_row).find('span').html('');
                                                                $(selected_row).find('input').val('');
                                                                $(selected_row).find('i').remove();
                                                                $('#error_div').html('<div class="alert alert-danger custom_alert">' +
                                                                        data.error +
                                                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                                                        '<span aria-hidden="true">&times;</span>' +
                                                                        '</button>' +
                                                                        '</div>');
                                                            } else {
                                                                $('#addavailability').modal('hide');
                                                            }
                                                        }
                                                    });

                                                } else {
                                                    $('#error_div').html('<div class="alert alert-danger custom_alert">' +
                                                            'Both fields required' +
                                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                                            '<span aria-hidden="true">&times;</span>' +
                                                            '</button>' +
                                                            '</div>');
                                                }
                                            });

                                            $('body').on('click', '.close_time', function () {
                                                var day_name = $(this).parent('td').attr('data-day-name');

                                                var next_rows = $(this).parent('td').parent('tr').nextAll('tr').find('td[data-day-name="' + day_name + '"]');

                                                $(next_rows).each(function () {
                                                    var counter = $(this).attr('data-counter');
                                                    counter = counter - 1;
                                                    var day_name = $(this).attr('data-day-name');

                                                    var html = $(this).html();

                                                    $("#" + day_name + counter).html(html);

                                                    $(this).find('span').html('');
                                                    $(this).find('input').val('');
                                                    $(this).find('i').remove();
                                                });

                                                $(this).parent('td').find('span').html('');
                                                $(this).parent('td').find('input').val('');
                                                $(this).remove();
                                            });

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

                                            $('#autocomplete').keyup(function () {
                                                $('#lat').val('');
                                                $('#lng').val('');
                                                $('#invalid_address_error').hide();
                                            });

                                            $("#trainer_basic_form").validate({
                                                ignore: [],
                                                rules: {
                                                    first_name: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                        alphanumeric: true
                                                    },
                                                    last_name: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                        alphanumeric: true
                                                    },
                                                    email: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    password: {
                                                        required: true,
                                                        minlength: 6
                                                    },
                                                    password_confirmation: {
                                                        equalTo: "#password"
                                                    },
                                                    ssn: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                        minlength: 9
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
                                                    gender: {
                                                        required: true,
                                                    },
                                                    address: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    country: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    city: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    state: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    postal_code: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        },
                                                    },
                                                    phone: {
                                                        required: true,
                                                        normalizer: function (value) {
                                                            return $.trim(value);
                                                        }
                                                    },
                                                    trainer_question1: {
                                                        required: true,
                                                    },
                                                    trainer_question2: {
                                                        required: true,
                                                    },
                                                    trainer_question3: {
                                                        required: true,
                                                    },
                                                    profile_pic: {
                                                        required: true,
                                                    }
                                                },
                                                messages: {
                                                    profile_pic: {
                                                        required: 'You must upload your profile picture'
                                                    }
                                                },
                                                submitHandler: function (form, event) {
                                                    var lat = $('#lat').val();
                                                    var lng = $('#lng').val();
                                                    if (!lat || !lng) {
                                                        $('#invalid_address_error').html('This is not a valid address');
                                                        $('#invalid_address_error').show();
                                                        event.preventDefault();
                                                        return;
                                                    } else {
                                                        $('#invalid_address_error').hide();
                                                    }
                                                    //Set values in branding form 
                                                    $('.simple_order').find('input[name="first_name"]').val($('#first_name').val());
                                                    $('.simple_order').find('input[name="last_name"]').val($('#last_name').val());
                                                    $('.simple_order').find('input[name="email"]').val($('#email').val());
                                                    $('.simple_order').find('input[name="phone"]').val($('#t_phone').val());

                                                    $("#dob_error").html('');
                                                    $("#dob_error").addClass('d-none');
                                                    let day = $("select[name=dob_day]").val();
                                                    let month = $("select[name=dob_month]").val();
                                                    let year = $("select[name=dob_year]").val();
                                                    if (!validateDate(day, month, year)) {
                                                        $("#dob_error").html('Please enter a valid date of birth');
                                                        $("#dob_error").removeClass('d-none');
                                                        document.getElementById('dob_error').scrollIntoView();
                                                        return;
                                                    }
                                                    if (!checkAge(day, month, year)) {
                                                        $("#dob_error").html('Your age must be 18+');
                                                        $("#dob_error").removeClass('d-none');
                                                        document.getElementById('dob_error').scrollIntoView();
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

                                            $(function () {
                                                $("#ssn").mask("999-99-9999");
                                                $("#ssn").on("blur", function () {
                                                    var last = $(this).val().substr($(this).val().indexOf("-") + 1);
                                                    if ($("#ssn").val().length < 9) {
                                                        $('#ssnerror').show();
                                                    } else {
                                                        $('#ssnerror').hide();
                                                    }
                                                    if (last.length == 5) {
                                                        var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                                                        var lastfour = last.substr(1, 4);
                                                        var first = $(this).val().substr(0, 9);
                                                        $(this).val(first + move + '-' + lastfour);
                                                    }
                                                });


                                                $('.lic_exp_date').datetimepicker({
                                                    format: 'MMMM DD, YYYY',
                                                    minDate: new Date()
                                                });
                                                var monthNamesTimepicker = ["January", "February", "March", "April", "May", "June",
                                                    "July", "August", "September", "October", "November", "December"
                                                ];
                                                var currentMonthTimePicker = new Date().getMonth() + 1;
                                                $('.date_of_birth').datetimepicker({
                                                    ignoreReadonly: true,
                                                    format: 'MMMM DD, YYYY',
                                                    maxDate: currentMonthTimePicker + '/' + new Date().getDate() + '/' + (new Date().getFullYear() - 18)
                                                });

                                            });
                                            function myFunc() {
                                                var patt = new RegExp("\d{3}[\-]\d{2}[\-]\d{4}");
                                                var x = document.getElementById("ssn");
                                                var res = patt.test(x.value);
                                                if (!res) {
                                                    x.value = x.value
                                                            .match(/\d*/g).join('')
                                                            .match(/(\d{0,3})(\d{0,2})(\d{0,4})/).slice(1).join('-')
                                                            .replace(/-*$/g, '');
                                                }
                                            }
                                            $('#email').focusout(function () {
                                                email = $(this).val();
                                                $.ajax({
                                                    type: "GET",
                                                    data: {"email": email},
                                                    url: "<?php echo asset('check_email'); ?>",
                                                    success: function (data) {
                                                        if (data) {
                                                            $('#errormessage').hide();
                                                            $('#trainer_basic_submit').attr('disabled', false);
                                                        } else {
                                                            $('#errormessage').show();
                                                            $('#trainer_basic_submit').attr('disabled', true);
                                                        }
                                                    }
                                                });
                                            });
                                            $("#trainer_second_step").click(function (event) {

                                                var loc = $('#trainer_basic_form').find('#autocomplete').val();
                                                $('body').find('input[name="address"]').val(loc);
                                                $('body').find('input[name="client_location"]').val(loc);


                                                //  start  for qualification
                                                let other = $('input[name=qualification_other]').val();
                                                if (other == '') {
                                                    var numberOfChecked = $('.qualifications_checkboxes:checkbox:checked').length;
                                                    if (numberOfChecked === 0) {
                                                        event.preventDefault();
                                                        $("#qualifications_error").show();
                                                    }
                                                } else {
                                                    $("#qualifications_error").hide();
                                                }
                                                //end for qualification

                                                var count = 0;
                                                var items = document.getElementsByClassName('training_type_checkbox');
                                                for (var i = 0; i < items.length; i++) {
                                                    var name = items[i].name;
                                                    var atLeastOneIsChecked = $('input[name="' + name + '"]:checked').length > 0;
                                                    if (atLeastOneIsChecked === true) {
                                                        count++;
                                                    }
                                                }
                                                if (count === 0) {
                                                    event.preventDefault();
                                                    $("#training_type_error").css("display", "block");
                                                    $("#training_type_error").focus();
                                                } else {
                                                    $("#training_type_error").css("display", "none");
                                                }
                                                $("#trainer_qualification_form").validate({
                                                    ignore: ":hidden:not(.document_input)",
                                                    submitHandler: function (form) {
                                                        $("#contact-tab").removeClass("disabled").addClass("active");
                                                        $("#contact-tab").removeAttr("data-title");
                                                        $("#contact").removeClass("disabled").addClass("show active");
                                                        $("#profile-tab").removeClass("active").addClass("disabled");
                                                        $("#profile").removeClass("show active");
                                                        $('.nav-tabs li:nth-child(2) a').addClass('step_completed');
                                                    }
                                                });
                                            });

                                            $('#trainer_qualification_form').on('submit', function (event) {
                                                $('.document_input').each(function () {
                                                    $(this).rules('remove', 'required');
                                                });
                                                var certificates = $('.training_type_checkbox:checked').parents('.trainer_type').find('.file_input_certificates');
                                                $(certificates).each(function () {
                                                    $(this).rules("add", {
                                                        required: true,
                                                        messages: {
                                                            required: "Please upload atleast one certificate"
                                                        }
                                                    });
                                                });
                                                var cvs = $('.training_type_checkbox:checked').parents('.trainer_type').find('.file_input_cv');
                                                $(cvs).each(function () {
                                                    $(this).rules("add", {
                                                        required: true,
                                                        messages: {
                                                            required: "Please upload atleast one cv"
                                                        }
                                                    });
                                                });
                                                event.preventDefault();
                                            });

                                            $('body').on('click', '#trainer_final_submit', function (event) {
                                                $('.icon_loading').css("display", "block");
                                                $('.arrow').css("display", "none");

                                                if (g_fitnes == 'Group Fitness Instructor') {
                                                    $('.readiness_question_group_trainer_input').each(function () {
                                                        $(this).rules('add', 'required');
                                                    });
                                                } else {
                                                    $('.readiness_question_group_trainer_input').each(function () {
                                                        $(this).rules('remove', 'required');
                                                    });
                                                }

                                                let other = $('input[name=other_specialization]').val();
                                                if (other == '') {
                                                    var numberOfChecked = $('.specialization-checkbox:checkbox:checked').length;
                                                    console.log('numberOfChecked: ' + numberOfChecked);
                                                    if (numberOfChecked === 0) {
                                                        event.preventDefault();
                                                        $("#specialization_error").html('At least one discipline is required !');
                                                        $("#specialization_error").show();
                                                    }
                                                } else {
                                                    $("#specialization_error").hide();
                                                }
                                            });
                                            $("#trainer_full_form").validate({
                                                submitHandler: function (form) {
                                                    $.ajax({
                                                        url: "<?php echo asset('trainer-register-basic'); ?>",
                                                        type: "POST",
                                                        data: $('#trainer_basic_form').serialize(),
                                                        success: function (response1) {
                                                            if (response1.status === "success") {
                                                                showLoading();
                                                                user_id = response1.user_id;
                                                                first_name = response1.first_name;
                                                                last_name = response1.last_name;
                                                                $('input[name="url"]').val('<?= asset('profile') ?>/' + first_name + '_' + last_name + '_' + user_id);
                                                                $.ajax({
                                                                    url: "<?php echo asset('trainer-register-full'); ?>",
                                                                    type: "POST",
                                                                    data: $('#trainer_full_form').serialize() + "&user_id=" + user_id,
                                                                    success: function (response2) {
                                                                        if (response2.status === "success") {
                                                                            $("#trainer_qualification_form").append('<input type="hidden" name="user_id" value="' + user_id + '" /> ');
                                                                            var formData = new FormData($('#trainer_qualification_form')[0]);
                                                                            $.ajax({
                                                                                type: "POST",
                                                                                url: $("#trainer_qualification_form").attr('action'),
                                                                                data: formData,
                                                                                cache: false,
                                                                                contentType: false,
                                                                                processData: false,
                                                                                dataType: 'json',
                                                                                beforeSend: function (request) {
                                                                                    return request.setRequestHeader('X-CSRF-Token', "<?= csrf_token(); ?>");
                                                                                },
                                                                                success: function (data) {
                                                                                    var user_id = data.user_id;
                                                                                    hideLoading();

                                                                                    $("#contact-tab").removeClass("active").addClass("disabled");
                                                                                    $("#profile-tab").removeClass("step_completed");
                                                                                    $("#home-tab").removeClass("step_completed");
                                                                                    $("#contact").removeClass("active show");
                                                                                    $('#order').addClass('active show');
                                                                                    $('.nav-tabs li:nth-child(1) a').addClass('step_completed');
                                                                                    $('.nav-tabs li:nth-child(2) a').addClass('step_completed');
                                                                                    $('.nav-tabs li:nth-child(3) a').addClass('step_completed');
                                                                                    $('#card_order_form').find('input[name="user_id"]').val(user_id);
                                                                                },
                                                                                error: function (data) {
                                                                                    hideLoading();
                                                                                },
                                                                                complete: function () {
                                                                                    hideLoading();
                                                                                }
                                                                            });

                                                                        }
                                                                        if (response2.status === "error") {
                                                                            $("#profile-tab").removeClass("disabled").addClass("active");
                                                                            $("#profile-tab").removeAttr("data-title");
                                                                            $("#contact-tab").attr("data-title");
                                                                            $("#profile").removeClass("disabled").addClass("show active");
                                                                            $("#profile_error").css("display", "block");
                                                                            $("#profile_error").html(response2.message);
                                                                        }
                                                                    }
                                                                });
                                                            }
                                                            if (response1.status === "error") {
                                                                $("#home-tab").removeClass("disabled").addClass("active");
                                                                $("#contact-tab").removeClass("active").addClass("disabled");
                                                                $("#profile-tab").attr("data-title");
                                                                $("#contact-tab").attr("data-title");
                                                                $("#home").removeClass("disabled").addClass("show active");
                                                                $("#contact").removeClass("show active").addClass("disabled");
                                                                if (response1.errors['first_name']) {
                                                                    $("#first_name_error").html(response1.errors['first_name']);
                                                                } else if (response1.errors['last_name']) {
                                                                    $("#last_name_error").html(response1.errors['last_name']);
                                                                } else if (response1.errors['dob']) {
                                                                    $("#dob_error").html(response1.errors['dob']);
                                                                } else if (response1.errors['ssn']) {
                                                                    $("#ssn_error").html(response1.errors['ssn']);
                                                                } else if (response1.errors['email']) {
                                                                    $("#email_error").html(response1.errors['email']);
                                                                } else if (response1.errors['password']) {
                                                                    $("#password_error").html(response1.errors['password']);
                                                                } else {
                                                                    $("#basic_info_error").css("display", "block");
                                                                }
                                                            }
                                                        }
                                                    });
                                                    $('.nav-tabs li:last-child a').addClass('step_completed');
                                                }
                                            });

                                            var placeSearch, autocomplete, location_autocom;
                                            var componentForm = {
                                                locality: 'long_name',
                                                administrative_area_level_1: 'short_name',
                                                country: 'long_name',
                                                postal_code: 'short_name'
                                            };

                                            window.initAutocomplete = function () {
                                                autocomplete = new google.maps.places.Autocomplete(
                                                        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                                                        {types: ['geocode']});

                                                new google.maps.places.Autocomplete(
                                                        /** @type {!HTMLInputElement} */(document.getElementById('location_autocom')),
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
                                                        return request.setRequestHeader('X-CSRF-Token', '<?= csrf_token(); ?>');
                                                    },
                                                    success: function (data) {
                                                        if (data.success) {
                                                            $('#time_slot').html('');
                                                            $('#time_slot').html(data.html);
                                                        }
                                                    }
                                                });
                                            });



                                            //order Form Validation
                                            $('body').on('click', '#skip_for_now', function () {
                                                window.location.href = base_url + 'thank_you';
                                            });
                                            $('body').on('click', '#submit_btn', function () {
                                                $form = $(this).parents('form');
                                                var type = $('#plan_type').val();
                                                if ($('.simple_form').is(':checked')) {
                                                    //Basic 
                                                    $('#card_order_form').validate({
                                                        rules: {
                                                            first_name: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                                alphanumeric: true
                                                            },
                                                            last_name: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                                alphanumeric: true
                                                            },
                                                            address: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                            },
                                                            phone: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                            },
                                                            email: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                                email: true
                                                            },
                                                            location: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
                                                            },
                                                            payment: {
                                                                required: true
                                                            },
                                                            agred: {
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
                                                    $('#card_order_form').validate({
                                                        rules: {
                                                            time: {
                                                                required: true
                                                            },
                                                            address: {
                                                                required: true,
                                                                normalizer: function (value) {
                                                                    return $.trim(value);
                                                                },
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
                                                        url: base_url + "order_card_signup_ajax",
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
                                                                    window.location.href = base_url + 'thank_you';
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
                                                    $('html').animate({scrollTop: 0}, 1000);
                                                }
                                            });


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&libraries=places&callback=initAutocomplete"
async defer></script>
</body>
</html>