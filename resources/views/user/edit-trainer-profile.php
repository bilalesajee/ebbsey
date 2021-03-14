<?php include resource_path('views/includes/header.php'); ?>


<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">EDIT PROFILE</h4>
            </div>

            <?php if (session()->has('success')) { ?>
                <div class="col-12">
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
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-check"></i> Error !</strong> <?= Session::get('error'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                </div> 
            <?php } ?>    

            <?php if ($errors->any()) { ?>
                <div class="alert-danger alert">
                    <ul>
                        <?php foreach ($errors->all() as $error) { ?>
                            <li><?= $error ?></li>
                        <?php }
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="row no-gutters edit_profile_tabs">
            <div class="col-md-3 col-12">
                <div class="nav flex-column">
                    <a class="<?= isset($alert_for_bank) ? '' : 'active' ?>" data-toggle="pill" href="#v-pills-home">Basic Information</a>
                    <a data-toggle="pill" href="#v-pills-profile">Qualifications</a>
                    <a data-toggle="pill" href="#v-pills-messages">Hours & Availability</a>
                    <a class="<?= isset($alert_for_bank) ? 'active' : '' ?>" data-toggle="pill" href="#v-pills-settings">Earning & Payments</a>
                    <a data-toggle="pill" href="#v-pills-change-password">Change Password</a>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="tab-content">
                    <div class="tab-pane fade <?= isset($alert_for_bank) ? '' : 'show active' ?>" id="v-pills-home">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Basic Information</h5>
                        </div>
                        <form id="basic_form" action="<?= asset('/edit-trainer-profile') ?>" method="post" enctype="multipart/form-data">
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
                                        <label class="btn pink" id="upload_profile_pic_btn"> Upload Photo </label>
                                        <label class="btn pink" id="upload_profile_pic_label" for="user_profile_pic" style="display:none;"> Upload Photo </label>
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
                                            <input type="text" name="first_name" value="<?= old('first_name') ? old('first_name') : $current_user->first_name ?>" class="form-control eb-form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" value="<?= $current_user->last_name ?>" class="form-control eb-form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="text" value="<?= date('F d, Y', strtotime($current_user->dob)) ?>" class="form-control eb-form-control" disabled="">
                                            <!--                                            <div class="input-group date date_of_birth" id="dob" data-target-input="nearest">
                                                                                            <input type="text" name="dob" id="date_of_birth" value="<?= $current_user->dob ? $current_user->dob : '' ?>" class="form-control datetimepicker-input eb-form-control" data-target="#dob" required=""/>
                                                                                            <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div>
                                                                                        </div>-->
                                            <label id="date_of_birth-error" class="error" for="date_of_birth" style="display: none;"></label>
                                            <label id="dob-error" class="error" for="dob"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" value="<?= $current_user->email ?>" class="form-control eb-form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="tel" name="phone" value="<?= $current_user->phone ? $current_user->phone : '' ?>" class="form-control eb-form-control phonemask" required="">
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
                                            <input type="text" name="address" id="autocomplete"  value="<?= $current_user->address ?>" class="form-control eb-form-control location" required="">
                                            <label id="invalid_address_error" class="error" style="display: none;">This is not a valid address</label>
                                            <input type="hidden" id="lat" name="lat" value="<?= $current_user->lat ?>"/>
                                            <input type="hidden" id="lng" name="lng" value="<?= $current_user->lng ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <input readonly="" type="text" id="country" name="country" value="<?= $current_user->country ?>" class="form-control eb-form-control" required=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input readonly="" type="text" id="locality" value="<?= $current_user->city ?>" name="city" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input readonly="" type="text" name="state" id="administrative_area_level_1" value="<?= $current_user->state ?>" class="form-control eb-form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input readonly="" type="number" id="postal_code" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "5" value="<?= $current_user->postal_code ?>" class="form-control eb-form-control" required=""/>
                                            <!--<input type="text" name="postal_code" id="postal_code" value="<?= $current_user->postal_code ?>" placeholder="Postal Code" class="form-control eb-form-control">-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <h5><strong>- Social Media</strong></h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-3 col-sm-3 col-md-3 mb-2 d-flex align-items-center">
                                            <span class="icon_social icon_facebook"></span> Facebook
                                        </div>
                                        <div class="col-xl-10 col-lg-9 col-sm-9 col-md-9">
                                            <input type="url" name="fb_link" value="<?= isset($current_user->fb_url) ? $current_user->fb_url : '' ?>" placeholder="Enter your facebook URL" class="form-control eb-form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-3 col-sm-3 col-md-3 mb-2 d-flex align-items-center">
                                            <span class="icon_social icon_instagram"></span> Instagram
                                        </div>
                                        <div class="col-xl-10 col-lg-9 col-sm-9 col-md-9">
                                            <input type="url" name="insta_link" value="<?= isset($current_user->insta_url) ? $current_user->insta_url : '' ?>" placeholder="Enter your instagram ID" class="form-control eb-form-control">
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
                            <h5>Qualifications</h5>
                        </div>
                        <form id="qualifications_form" action="<?= asset('/edit-trainer-profile') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="form_name" value="qualifications_form">
                            <div class="form_section">
                                <h5><strong>- Qualifications</strong></h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-3 d-flex align-items-center">
                                        <label>Years of experience</label>
                                        <?php if ($errors->has('trainer_experience')) { ?>
                                            <div class="error text-danger"><?= $errors->first('trainer_experience') ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <select name="trainer_experience" class="form-control eb-form-control">
                                            <option value="0-3" <?= $current_user->years_of_experience == '0-3' ? 'selected' : '' ?> > 0-3 Year </option>
                                            <option value="4-6" <?= $current_user->years_of_experience == '4-6' ? 'selected' : '' ?> > 4-6 Years </option>
                                            <option value="7-9" <?= $current_user->years_of_experience == '7-9' ? 'selected' : '' ?> > 7-9 Years </option>
                                            <option value="10+" <?= $current_user->years_of_experience == '10+' ? 'selected' : '' ?> > 10+ Years </option>
                                        </select>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- section -->
                            <div class="form_section">
                                <h5><strong> - Choose your qualifications <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                <div class="row">
                                    <input type="hidden" name="qualification_changed" value="0" id="qualification_changed">
                                    <?php
                                    $qualifications = trainerQualifications();
                                    $trainer_qualifications = $qualifications['qualifications'];
                                    if ($trainer_qualifications) {
                                        $counter = 1;
                                        foreach ($trainer_qualifications as $qualification) {
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input qualification-checkbox qualifications_checkboxes" name="qualifications[<?= $qualification->id ?>]" id="checkbox<?= $counter ?>" 
                                                    <?php
                                                    if (isset($selected_qualifications)) {
                                                        foreach ($selected_qualifications as $selected_qualification) {
                                                            ?>
                                                            <?= $selected_qualification->qualification_id == $qualification->id ? 'checked' : '' ?> <?php
                                                        }
                                                    }
                                                    ?> >
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
                            <label style="display:none" id="edit_qualifications_error" class="error text-danger">At least one qualifications is required !</label>
                            <div class="form_section">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5><strong>- Others</strong></h5>
                                        <input type="hidden" name="other_qualification_changed" value="0" id="other_qualification_changed">
                                        <input name="qualification_other" value="<?= $trainer_other_qualification ? $trainer_other_qualification->getQualification->title : '' ?>" placeholder="Please enter your qualifications if its not there in the list above" class="form-control eb-form-control qualification_other" />
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- section -->
                            <div class="form_section">
                                <!--<h5><strong>- Choose Training Type</strong></h5>-->
                                <h5><strong>- Training Type</strong></h5>
                                <div id="type_checkboxes" class="row">
                                    <script>
                                        var documents = [];
                                    </script> 
                                    <?php
                                    $training_types = trainingTypes();
                                    $training_types = $training_types['training_types'];
                                    if ($training_types) {
                                        $counter = 1;
                                        foreach ($training_types as $training_type) {
                                            if (in_array($training_type->id, $training_type_ids)) {
                                                ?>
                                                <?php
                                                $certificates_array = [];
                                                $certificates_string = '';
                                                $cvs_array = [];
                                                $cvs_string = '';
                                                if (in_array($training_type->id, $training_type_ids)) {
                                                    $certificates_array = explode(',', $documents[$training_type->id]['certificates']);
                                                    $certificates_string = $documents[$training_type->id]['certificates'];
                                                    $cvs_array = explode(',', $documents[$training_type->id]['cvs']);
                                                    $cvs_string = $documents[$training_type->id]['cvs'];
                                                }
                                                ?>
                                                <script>
                                                    documents[<?= $counter - 1 ?>] = {'certificates': [], 'certificates_counter': 0, 'cvs': [], 'cvs_counter': 0};
                                                </script>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="trainer_type type_personal_trainer">
                                                        <div class="trainer_header">
                                                            <div class="icon" style="background-image: url(<?= asset('public/images/' . $training_type->image) ?>);"></div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input <?= in_array($training_type->id, $training_type_ids) ? 'checked' : '' ?> name="trainer_type[<?= str_replace(' ', '', $training_type->title) ?>]" type="checkbox" value="<?= $training_type->id ?>" class="custom-control-input training_type_checkbox" id="ptt<?= $counter ?>">
                                                                <label class="custom-control-label" <?php if (!in_array($training_type->id, $training_type_ids)) { ?> for="ptt<?= $counter ?>" <?php } ?>><?= $training_type->title ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="trainer_body">
                                                            <div class="upload-documents">
                                                                <div class="upload-header">
                                                                    <div class="row">
                                                                        <div class="col-xl-8 col-12">
                                                                            <h6><span class="icon-certificate"></span> <strong>Certifications </strong></h6>
                                                                            <label id="certificates<?= $counter - 1 ?>-error" class="error" for="certificates<?= $counter - 1 ?>"></label>
                                                                        </div>
                                                                        <div class="col-xl-4 col-12">
                                                                            <?php if (!in_array($training_type->id, $training_type_ids)) { ?>
                                                                                <div class="file_upload_btn">
                                                                                    Upload 
                                                                                    <input class="file_input" file-category="certificates" training-type-id="<?= $training_type->id ?>" array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                    <input class="file_input_certificates document_input" name="certificates[<?= str_replace(' ', '', $training_type->id) ?>]" id="certificates<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($certificates_string ? $certificates_string : '' ) : '' ?>">
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <input class="file_input_certificates document_input" name="certificates[<?= str_replace(' ', '', $training_type->id) ?>]" id="certificates<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($certificates_string ? $certificates_string : '' ) : '' ?>">
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploaded_certificates">
                                                                    <ul id="ul_certificates<?= $counter - 1 ?>" class="document_list d-flex flex-wrap">
                                                                        <?php if (!empty($documents)) { ?>
                                                                            <?php if ($certificates_string) { ?>
                                                                                <?php foreach ($certificates_array as $certificate) { ?>
                                                                                    <script>
                                                                                        documents[<?= $counter - 1 ?>]['certificates'].push('<?= $certificate ?>');
                                                                                        documents[<?= $counter - 1 ?>]['certificates_counter']++;
                                                                                    </script>
                                                                                    <li>
                                                                                        <?php
                                                                                        $file_image = asset('public/documents/' . $certificate);
                                                                                        $extension = pathinfo($certificate, PATHINFO_EXTENSION);
                                                                                        if ($extension == 'pdf') {
                                                                                            $file_image = asset('userassets/images/pdf.png');
                                                                                        } else if ($extension == 'docx') {
                                                                                            $file_image = asset('userassets/images/docx.png');
                                                                                        }
                                                                                        ?>
                                                                                        <div class="thumbnail" style="background-image: url('<?= $file_image ?>')">
                                                                                            <img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid">
                                                                                            <?php if (!in_array($training_type->id, $training_type_ids)) { ?>
                                                                                                <div class="actions align-items-center justify-content-center">
                                                                                                    <i class="fa fa-trash delete_document" path="<?= $certificate ?>" array-counter="<?= $counter - 1 ?>" file-category="certificates"></i>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="upload-documents">
                                                                <div class="upload-header">
                                                                    <div class="row">
                                                                        <div class="col-xl-8 col-12">
                                                                            <h6><span class="icon-certificate"></span> <strong>CV </strong></h6>
                                                                            <label id="cvs<?= $counter - 1 ?>-error" class="error" for="cvs<?= $counter - 1 ?>"></label>
                                                                        </div>
                                                                        <div class="col-xl-4 col-12">
                                                                            <?php if (!in_array($training_type->id, $training_type_ids)) { ?>
                                                                                <div class="file_upload_btn"> Upload 
                                                                                    <input class="file_input" file-category="cvs" training-type-id="<?= $training_type->id ?>" array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                    <input class="file_input_cv document_input" name="cv[<?= str_replace(' ', '', $training_type->id) ?>]" id="cvs<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($cvs_string ? $cvs_string : '' ) : '' ?>">
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <input class="file_input_cv document_input" name="cv[<?= str_replace(' ', '', $training_type->id) ?>]" id="cvs<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($cvs_string ? $cvs_string : '' ) : '' ?>">
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="uploaded_certificates">
                                                                    <ul id="ul_cvs<?= $counter - 1 ?>" class="document_list d-flex flex-wrap">
                                                                        <?php if (!empty($documents)) { ?>
                                                                            <?php if ($cvs_string) { ?>
                                                                                <?php foreach ($cvs_array as $cv) { ?>
                                                                                    <script>
                                                                                        documents[<?= $counter - 1 ?>]['cvs'].push('<?= $cv ?>');
                                                                                        documents[<?= $counter - 1 ?>]['cvs_counter']++;
                                                                                    </script>
                                                                                    <li>
                                                                                        <?php
                                                                                        $file_image = asset('public/images/' . $cv);
                                                                                        $extension = pathinfo($cv, PATHINFO_EXTENSION);
                                                                                        if ($extension == 'pdf') {
                                                                                            $file_image = asset('userassets/images/pdf.png');
                                                                                        } else if ($extension == 'docx') {
                                                                                            $file_image = asset('userassets/images/docx.png');
                                                                                        }
                                                                                        ?>
                                                                                        <div class="thumbnail" style="background-image: url('<?= $file_image ?>')">
                                                                                            <img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid">
                                                                                            <?php if (!in_array($training_type->id, $training_type_ids)) { ?>
                                                                                                <div class="actions align-items-center justify-content-center">
                                                                                                    <i class="fa fa-trash delete_document" path="<?= $cv ?>" array-counter="<?= $counter - 1 ?>" file-category="cvs"></i>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </li>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                        }
                                    }
                                    ?>
                                </div> <!-- row -->
                            </div> <!-- section -->
                            <div id="training_type_error" class="error text-danger" style="display : none;">You have to choose at least one training type</div>
                            <div class="form_section">
                                <input type="submit" value="Save" class="btn orange btn-lg" />
                            </div>
                        </form>

                    </div> <!-- qualification tab -->

                    <div class="tab-pane fade" id="v-pills-messages">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Hours & Availability</h5>
                        </div>
                        <form id="availability_form" action="<?= asset('/edit-trainer-profile') ?>" method="post" enctype="multipart/form-data">
<?= csrf_field(); ?>
                            <input type="hidden" name="form_name" value="availability_form">
                            <div class="form_section">
                                <h5><strong> - Specialization <span class="text-orange">(You can choose multiple)</span></strong></h5>
                                <div class="row">
                                    <input type="hidden" name="specializations_changed" value="0" id="specializations_changed">
                                    <?php
                                    $trainerSpecializations = trainerSpecializations();
                                    $trainerSpecializations = $trainerSpecializations['specializations'];
                                    if ($trainerSpecializations) {
                                        $counter = 1;
                                        foreach ($trainerSpecializations as $specialization) {
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input specialization-checkbox" name="specializations[<?= $specialization->id ?>]" value="<?= $specialization->id ?>" id="specializations_checkbox<?= $counter ?>" 
                                                    <?php
                                                    if (isset($selected_specializations)) {
                                                        foreach ($selected_specializations as $selected_specialization) {
                                                            ?>    
                                                            <?= $selected_specialization->specialization_id == $specialization->id ? 'checked' : '' ?> 
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                           >
                                                    <label class="custom-control-label" for="specializations_checkbox<?= $counter ?>"> <?= $specialization->title ?> </label>
                                                </div>
                                            </div>
                                            <?php
                                            $counter++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>  <!-- section -->
                            <label style="display:none" id="edit_specialization_error" class="error text-danger">At least one specialization is required !</label>
                            <div class="form_section">
                                <h5><strong> - Others</strong></h5>
                                <input type="hidden" name="other_specializations_changed" value="0" id="other_specialization_changed">
                                <textarea name="other_specialization" id="other_specializationc" placeholder="Please enter your discipline if its not there in the list above." class="form-control eb-form-control oter_reason specialization_other"><?= $trainer_other_specializations ? $trainer_other_specializations->getSpecialization->title : '' ?></textarea>      
                            </div> <!-- section -->
                            <div class="form_section">
                                <h5><strong> - How far you are willing to travel to a job?</strong></h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                            <?php $miles_arr = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50] ?>
                                        <select name="distance" class="form-control eb-form-control">
                                            <?php foreach ($miles_arr as $arr) { ?>
                                                <option value="<?= $arr ?>" <?= $arr == $current_user->distance ? 'selected' : '' ?>> <?= $arr ?> mile </option>
<?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form_section">
                                <h5><strong> - Readiness Questionnaire</strong></h5>
                                <div class="row">
                                    <div class="col-sm-9"> Do you have a facility to teach your class? </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <?php if (isset($questionnaire1)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio101" name="trainer_question1" value="yes" <?= isset($questionnaire1->choice) && $questionnaire1->choice == 'yes' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio101" name="trainer_question1" value="yes" >
<?php } ?>
                                                <label class="custom-control-label" for="radio101">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <?php if (isset($questionnaire1)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio102" name="trainer_question1" value="no" <?= isset($questionnaire1->choice) && $questionnaire1->choice == 'no' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio102" name="trainer_question1" value="no" >
<?php } ?>
                                                <label class="custom-control-label" for="radio102">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> Do you own a vehicle? </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <?php if (isset($questionnaire2)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio103" name="trainer_question2" value="yes" <?= isset($questionnaire2->choice) && $questionnaire2->choice == 'yes' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio103" name="trainer_question2" value="yes" >
<?php } ?>
                                                <label class="custom-control-label" for="radio103">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <?php if (isset($questionnaire2)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio104" name="trainer_question2" value="no" <?= isset($questionnaire2->choice) && $questionnaire2->choice == 'no' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio104" name="trainer_question2" value="no" >
<?php } ?>
                                                <label class="custom-control-label" for="radio104">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9"> Do you have a personal trainer insurance? </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="custom-control custom-radio mr-4">
                                                <?php if (isset($questionnaire2)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio105" name="trainer_question3" value="yes" <?= isset($questionnaire3->choice) && $questionnaire3->choice == 'yes' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio105" name="trainer_question3" value="yes" >
<?php } ?>
                                                <label class="custom-control-label" for="radio105">Yes</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <?php if (isset($questionnaire3)) { ?>
                                                    <input type="radio" class="custom-control-input" id="radio106" name="trainer_question3" value="no" <?= isset($questionnaire3->choice) && $questionnaire3->choice == 'no' ? 'checked' : '' ?> >
                                                <?php } else { ?>
                                                    <input type="radio" class="custom-control-input" id="radio106" name="trainer_question3" value="no" >
<?php } ?>
                                                <label class="custom-control-label" for="radio106">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  <!-- section -->
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
                                        <?php if ($timetable_array_size) { ?>
                                                <?php for ($i = 0; $i < $timetable_array_size; $i++) { ?>
                                                <tr>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['monday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['monday'][$i]['start_time'] . ' - ' . $timetable['monday'][$i]['end_time'];
                                                        $timeForInput = $timetable['monday'][$i]['start_time'] . '-' . $timetable['monday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="monday<?= $i + 1 ?>" day-name="monday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="monday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['tuesday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['tuesday'][$i]['start_time'] . ' - ' . $timetable['tuesday'][$i]['end_time'];
                                                        $timeForInput = $timetable['tuesday'][$i]['start_time'] . '-' . $timetable['tuesday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="tuesday<?= $i + 1 ?>" day-name="tuesday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="tuesday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['wednesday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['wednesday'][$i]['start_time'] . ' - ' . $timetable['wednesday'][$i]['end_time'];
                                                        $timeForInput = $timetable['wednesday'][$i]['start_time'] . '-' . $timetable['wednesday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="wednesday<?= $i + 1 ?>" day-name="wednesday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="wednesday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['thursday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['thursday'][$i]['start_time'] . ' - ' . $timetable['thursday'][$i]['end_time'];
                                                        $timeForInput = $timetable['thursday'][$i]['start_time'] . '-' . $timetable['thursday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="thursday<?= $i + 1 ?>" day-name="thursday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="thursday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['friday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['friday'][$i]['start_time'] . ' - ' . $timetable['friday'][$i]['end_time'];
                                                        $timeForInput = $timetable['friday'][$i]['start_time'] . '-' . $timetable['friday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="friday<?= $i + 1 ?>" day-name="friday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="friday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['saturday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['saturday'][$i]['start_time'] . ' - ' . $timetable['saturday'][$i]['end_time'];
                                                        $timeForInput = $timetable['saturday'][$i]['start_time'] . '-' . $timetable['saturday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="saturday<?= $i + 1 ?>" day-name="saturday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="saturday[]" value="<?= $timeForInput ?>">
                                                    <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                    <?php
                                                    $check = array_key_exists($i, $timetable['sunday']);
                                                    $timeForSpan = '';
                                                    $timeForInput = '';
                                                    if ($check) {
                                                        $timeForSpan = $timetable['sunday'][$i]['start_time'] . ' - ' . $timetable['sunday'][$i]['end_time'];
                                                        $timeForInput = $timetable['sunday'][$i]['start_time'] . '-' . $timetable['sunday'][$i]['end_time'];
                                                    }
                                                    ?>
                                                    <td id="sunday<?= $i + 1 ?>" day-name="sunday" counter="<?= $i + 1 ?>">
                                                        <span><?= $timeForSpan ?></span>
                                                        <input type="hidden" name="sunday[]" value="<?= $timeForInput ?>">
        <?= $check ? '<i class="fa fa-close close_time"></i>' : '' ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
<?php } else { ?>
                                            <tr>
                                                <td id="monday1" day-name="monday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="monday[]">
                                                </td>
                                                <td id="tuesday1" day-name="tuesday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="tuesday[]">
                                                </td>
                                                <td id="wednesday1" day-name="wednesday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="wednesday[]">
                                                </td>
                                                <td id="thursday1" day-name="thursday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="thursday[]">
                                                </td>
                                                <td id="friday1" day-name="friday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="friday[]">
                                                </td>
                                                <td id="saturday1" day-name="saturday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="saturday[]">
                                                </td>
                                                <td id="sunday1" day-name="sunday" counter="1">
                                                    <span></span>
                                                    <input type="hidden" name="sunday[]">
                                                </td>
                                            </tr>
<?php } ?>
                                    </tbody>
                                </table>
                                <span class="add_availability_btn" id="add_availability_btn">+ Add Availability</span>
                                <!--<a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#addavailability"> Add Availability </a>-->
                                <div class="modal fade" id="addavailability" tabindex="-1" role="dialog" day-name="" counter="">
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
                            </div> <!-- section -->
                            <div class="form_section">
                                <input type="submit" value="Save" class="btn orange btn-lg" />
                            </div>
                        </form>
                    </div> <!-- hours & Availability Tab -->

                    <div class="tab-pane fade <?= isset($alert_for_bank) ? 'show active' : '' ?>" id="v-pills-settings">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Earning & Payments</h5>
                        </div>
                        <div class="form_section">
                            <h5><strong>Earning & Payments</strong></h5>
                        </div>
<?php if (!$current_user->is_bank_account_verified) { ?>
                            <p class="alert alert-info">If you don't have stipe account then, connect to stripe.<p>
                                <a target="_blank" class="btn orange btn-lg stripe_btn" href="https://connect.stripe.com/express/oauth/authorize?redirect_uri=<?= asset('stripe_redirect_uri') ?>&client_id=<?= env('STRIPE_TEST_CLIENT_ID') ?>&scope=read_write&state=<?= csrf_token() ?>&email=<?= $current_email ?>"><span>Connect Stripe</span></a>
<?php } else { ?>
                            <div class="earning_box_wrap d-flex flex-wrap">
                                <div class="total_earning">
                                    <a href="<?= asset('earning_history?type=earning'); ?>">
                                        <div class="earning_label">Total Earning</div>
                                        <div class="earning_payment">$<?= number_format(round($total_earning, 2), 2) ?></div>
                                    </a>
                                </div>
                                <div class="previous_earning d-flex ml-lg-auto">
                                    <div class="earning_box <?= $this_month_earning > $last_month_earning ? 'current_month' : 'previous_month' ?>">
                                        <a href="<?= asset('earning_history?type=earning&month=current_month'); ?>">
                                            <div class="earning_label">This Month</div>
                                            <div class="earning_payment d-flex align-items-center"><span class="icon"></span> $<?= number_format(round($this_month_earning, 2), 2) ?></div>
                                        </a>
                                    </div>
                                    <div class="earning_box <?= $this_month_earning > $last_month_earning ? 'previous_month' : 'current_month' ?>">
                                        <a href="<?= asset('earning_history?type=earning&month=last_month'); ?>">
                                            <div class="earning_label">Last Month</div>
                                            <div class="earning_payment d-flex align-items-center"><span class="icon"></span> $<?= number_format(round($last_month_earning, 2), 2) ?></div>
                                        </a>
                                    </div>
                                </div>
                            </div><br>
                            <div class="earning_box_wrap d-flex flex-wrap">
                                <div class="total_earning">
                                    <a href="<?= asset('earning_history?type=balance'); ?>">
                                        <div class="earning_label">Total Balance</div>
                                        <div class="earning_payment">$<?= number_format(round($current_user->total_cash, 2), 2) ?></div>
                                    </a>
                                </div>
                            </div>
                            <a target="_blank" class="btn orange btn-lg stripe_btn" href="<?= $current_user->stripe_express_dashboard_url ?>">View Payouts</a>
<?php } ?>

                    </div> <!-- Earning & Payments  -->

                    <div class="tab-pane fade" id="v-pills-change-password">
                        <div class="mobile_edit_profile_tab_head">
                            <a href="#" class="back"> <span class="arrowback"></span></a>
                            <h5>Change Password</h5>
                        </div>
                        <div class="form-container">
                            <form action="<?= asset('change_password') ?>" id="change_password" method="post">
                                <?php if (session()->has('password_error')) { ?>
                                    <div class="text-danger"><?php echo Session::get('password_error'); ?></div>
<?php } ?>
                                <input name="_token" type="hidden" value="<?= csrf_token() ?>">
                                <div class="form_section">
                                    <div class="form-group">
                                        <label>Enter Current Password</label>
                                        <input type="password" name="current_password" required class="form-control eb-form-control" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="password" required id="password" class="form-control eb-form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirmation" required class="form-control eb-form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn orange"> SUBMIT <span class="arrow"></span> </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div> <!-- Change Password tab -->
                </div> <!-- tab content -->
            </div> <!--col9 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- wrapper -->
<table style="display: none;" id="row_to_be_cloned">
    <tr>
        <td id="monday1" day-name="monday" counter="1">
            <span></span>
            <input type="hidden" name="monday[]">
        </td>
        <td id="tuesday1" day-name="tuesday" counter="1">
            <span></span>
            <input type="hidden" name="tuesday[]">
        </td>
        <td id="wednesday1" day-name="wednesday" counter="1">
            <span></span>
            <input type="hidden" name="wednesday[]">
        </td>
        <td id="thursday1" day-name="thursday" counter="1">
            <span></span>
            <input type="hidden" name="thursday[]">
        </td>
        <td id="friday1" day-name="friday" counter="1">
            <span></span>
            <input type="hidden" name="friday[]">
        </td>
        <td id="saturday1" day-name="saturday" counter="1">
            <span></span>
            <input type="hidden" name="saturday[]">
        </td>
        <td id="sunday1" day-name="sunday" counter="1">
            <span></span>
            <input type="hidden" name="sunday[]">
        </td>
    </tr>
</table>

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

//    $(document).ready(function(){
//        $('.custom_alert').removeClass('alert-success');
//        $('.custom_alert').addClass('alert-danger');
//        $('.alert-content').html('a');
//        $('.custom_alert').show();
//        setTimeout(function () {
//            $('.custom_alert').fadeOut();
//        }, 5000);
//    });

    $(function () {
        var dob = $('#date_of_birth').val();
        if (typeof dob != 'undefined' && dob != '') {
            $('.date_of_birth').datetimepicker({
                format: 'MMMM DD, YYYY',
                setDate: dob
            });
        } else {
            $('.date_of_birth').datetimepicker({
                format: 'MMMM DD, YYYY',
                maxDate: new Date()
            });
        }
        $('.date_of_birth_2').datetimepicker({
            format: 'MMMM DD, YYYY',
            maxDate: new Date()
        });
        showLocationOnplace();
    });
    
    $('#autocomplete').keyup(function () {
        $('#lat').val('');
        $('#lng').val('');
        $('#invalid_address_error').hide();
    });

    $("#basic_form").validate({
        rules: {
            dob: {
                required: true,
                date: true
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

    $('body').on('change', '.file_input', function () {
        certificatesPreview(this);
    });

    function certificatesPreview(input) {
//        $('#trainer_second_step').prop('disabled', true);
//        $('.icon_loading').show();
        var array_counter = $(input).attr('array-counter');
        var file_category = $(input).attr('file-category');

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
                                '<div class="image_wrap">' +
                                '<div class="thumbnail" style="background-image: url(\'' + image + '\')">' +
                                '<img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid" />' +
                                '<div class="actions align-items-center justify-content-center">' +
                                '<i class="fa fa-trash delete_document" path="' + results.path + '" array-counter="' + array_counter + '" file-category="' + file_category + '"></i>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</li>');

                        documents[array_counter][file_category].push(results.path);
                        $('#' + file_category + array_counter).val(documents[array_counter][file_category]);

//                        $('#trainer_second_step').prop('disabled', false);
//                        $('.icon_loading').hide();
                    }
                });
            }
        }
    }

    $('body').on('click', '.delete_document', function () {

        var ref = $(this);
        let path = $(this).attr('path');
        let array_counter = $(this).attr('array-counter');
        let file_category = $(this).attr('file-category');

        let index = documents[array_counter][file_category].indexOf(path);
        if (index != -1) {
            $('#' + file_category + array_counter).val('');
            documents[array_counter][file_category].splice(index, 1);
            documents[array_counter][file_category + '_counter']--;
            $('#' + file_category + array_counter).val(documents[array_counter][file_category]);
            ref.parents('li').remove();
        }
    });


    $("#availability_form input[type='submit']").click(function (event) {
        //  start  for qualification
        numberOfChecked = $('.specialization-checkbox:checkbox:checked').length;
        //        alert(numberOfChecked);
        if (numberOfChecked == 0) {
            event.preventDefault();
            $("#edit_specialization_error").show();
        }
        //end for qualification
    });
    $("#qualifications_form input[type='submit']").click(function (event) {
        //  start  for qualification
        numberOfChecked = $('.qualifications_checkboxes:checkbox:checked').length;
        //        alert(numberOfChecked);
        if (numberOfChecked == 0) {
            event.preventDefault();
            $("#edit_qualifications_error").show();
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
        $("#qualifications_form").validate({
            ignore: ":hidden:not(.document_input)",
        });
    });

    $('#qualifications_form').on('submit', function (event) {

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
    });

    $(".qualification-checkbox").change(function () {
        $("#qualification_changed").val("1");
    });
    $(".qualification_other").change(function () {
        $("#other_qualification_changed").val("1");
    });
    $(".specialization-checkbox").change(function () {
        $("#specializations_changed").val("1");
    });
    $(".specialization_other").change(function () {
        $("#other_specialization_changed").val("1");
    });


    $("#legal_personal_id_image").change(function () {
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var fileType = input.files[0]['type'];
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                $('#invalid_img').show();
                alert('only gif, jpg, png images allow to upload.');
                return false;
            }

            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image_view').css('background-image', 'url(' + e.target.result + ')');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#upload_profile_pic_btn').click(function(){
        $('#modal_title').html('Update Image');
        $('#modal_body').html('If you update this image then you will be logged out until ebbsey team approve this image. Are you sure that you want to do this?');
        $('#modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#modal_yes_btn', function (e) {
            $('#modal').modal('hide');
            $('#upload_profile_pic_label').trigger('click');
        });
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

        console.log(input.files[0]);
    
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

    var placeSearch, autocomplete, autofill;
    var componentForm = {
//        street_number: 'short_name',
//        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    window.initAutocomplete = function () {
        autocomplete = new google.maps.places.Autocomplete(
                /* (document.getElementsByClassName('location')),*/
                        (document.getElementById('autocomplete')),
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

    var componentElement = {
        contact_location: 'long_name',
        contact_state: 'short_name',
        contact_city: 'short_name',
        contact_state: 'short_name',
        contact_postalcode: 'short_name'
    };
    function showLocationOnplace() {
        autofill = new google.maps.places.Autocomplete(
                (document.getElementById('contact_location')),
                {types: ['geocode']});
    }

    $('#add_availability_btn').click(function () {
        var number_of_rows = $('#timetablerows tr').length;
        var counter = number_of_rows + 1;
        var cloned_html = $('#row_to_be_cloned tr').clone();

        $(cloned_html['0'].cells).each(function () {
            var day_name = $(this).attr('day-name');
            $(this).attr('counter', counter);
            $(this).attr('id', day_name + counter);
        });
        $('#timetablerows').append(cloned_html);
    });

    $('body').on('click', 'td', function (e) {
        e.stopPropagation;
        if (e.target.tagName != 'I') {
            $('#error_div').html('');
            var day_name = $(this).attr('day-name');
            var counter = $(this).attr('counter');
            var time = $(this).find('input').val();
            time = time.split("-");
            $('#from').val(time[0]);
            $('#to').val(time[1]);
            $('#addavailability').modal('show');
            $('#addavailability').attr('day-name', day_name);
            $('#addavailability').attr('counter', counter);
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

        var day_name = $('#addavailability').attr('day-name');
        var counter = $('#addavailability').attr('counter');
        if (from && to) {
            var selected_row = $('#timetablerows').find('td[day-name="' + day_name + '"] span:empty').first().parent('td');

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
//                        console.log($(this).parent('td').attr('id'));
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
        var day_name = $(this).parent('td').attr('day-name');

        var next_rows = $(this).parent('td').parent('tr').nextAll('tr').find('td[day-name="' + day_name + '"]');

        $(next_rows).each(function () {
            var counter = $(this).attr('counter');
            counter = counter - 1;
            var day_name = $(this).attr('day-name');

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
</script>


<script src="https://js.stripe.com/v2/"></script>

<script>

    Stripe.setPublishableKey('<?= env('STRIPE_PUBLIC_KEY') ?>');
    $(function () {
        var $form = $('#bank_account_form');
        $form.submit(function (event) {
            // Disable the submit button to prevent repeated clicks:
            $form.find('input[type="submit"]').prop('disabled', true);
            //                
            // Request a token from Stripe:
            Stripe.bankAccount.createToken({
                country: 'US',
                currency: 'USD',
                routing_number: $('.routing-number').val(),
                account_number: $('.account-number').val()
            }, stripeResponseHandler);

            // Prevent the form from being submitted:
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        // Grab the form:
        var $form = $('#bank_account_form');

        if (response.error) { // Problem!

            // Show the errors on the form:

            $form.find('.bank-errors').show().text(response.error.message);
            $form.find('button').prop('disabled', false); // Re-enable submission

        } else { // Token created!
            $form.find('.bank-errors').hide();
            // Get the token ID:
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server:
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));

            // Submit the form:
            $form.get(0).submit();

        }
    }

    jQuery.validator.addMethod("ssn", function (value, element) {
        return this.optional(element) || /^\d{3}-?\d{2}-?\d{4}$/.test(value);
    }, "Please enter a valid ssn number");

    jQuery.validator.addMethod("ssn_last_four", function (value, element) {
        return this.optional(element) || /^(?!0{4})\d{4}$/.test(value);
    }, "Please enter valid ssn last four");

    jQuery.validator.addMethod("postal_code", function (value, element) {
        return this.optional(element) || /^([0-9]{5}|[a-zA-Z][a-zA-Z ]{0,49})$/.test(value);
    }, "Please enter a valid postal code");

    $("#validate-form").validate({
        rules: {
            ssn: {
                number: true,
                ssn: true,
            },
            postal_code: {
                number: true,
                postal_code: true,
            },
            ssn_last_4: {
                number: true,
                ssn_last_four: true,
            },
        },
    });
    $("#bank_account_form").validate({});

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&libraries=places&callback=initAutocomplete"
async defer></script>
</body>
</html>