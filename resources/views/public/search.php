<?php include resource_path('views/includes/header.php'); ?>
<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">SEARCH</h4>
            </div>
        </div> <!-- row -->
        <div class="row mb-3">
            <div class="col-lg-3 col-md-12">
                <?php
                $search = '';
                if (isset($_GET['keyword']) && $_GET['keyword']) {
                    $search = $_GET['keyword'];
                }
                $trainer_location = '';
                if (isset($_GET['trainer_search_location']) && $_GET['trainer_search_location']) {
                    $trainer_location = $_GET['trainer_search_location'];
                }
                $class_location = '';
                if (isset($_GET['class_search_location']) && $_GET['class_search_location']) {
                    $class_location = $_GET['class_search_location'];
                }
                $type = '';
                if (isset($_GET['search_type']) && $_GET['search_type']) {
                    $type = $_GET['search_type'];
                }
                $experience = '';
                if (isset($_GET['experience']) && $_GET['experience']) {
                    $experience = $_GET['experience'];
                }

                $difficulty_level = '';
                if (isset($_GET['difficulty_level']) && $_GET['difficulty_level']) {
                    $difficulty_level = $_GET['difficulty_level'];
                }
                $duration = '';
                if (isset($_GET['duration']) && $_GET['duration']) {
                    $duration = $_GET['duration'];
                }
                $gender_male = '';
                if (isset($_GET['gender_male']) && $_GET['gender_male']) {
                    $gender_male = $_GET['gender_male'];
                }

                $gender_female = '';
                if (isset($_GET['gender_female']) && $_GET['gender_female']) {
                    $gender_female = $_GET['gender_female'];
                }

                $postal_code = '';
                if (isset($_GET['postal_code']) && $_GET['postal_code']) {
                    $postal_code = $_GET['postal_code'];
                }

                $class_date = '';
                if (isset($_GET['class_date']) && $_GET['class_date']) {
                    $class_date = $_GET['class_date'];
                }
                ?>
                <div class="search_sidebar">
                    <div class="search_header mb-4 d-lg-none d-block">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="arrowback mr-auto close_mobile_search"></span>
                            <h5 class="mb-0 mr-auto">Search</h5>
                        </div>
                    </div>
                    <form>
                        <div class="form_section">
                            <h6><strong>- Search Type</strong></h6>
                            <select  onchange="searchFunction()" id="search_type" class="form-control eb-form-control" >
                                <option value="trainer" <?= $type == 'trainer' ? 'selected' : '' ?>>Personal Trainer </option>
                                <option value="class" <?= $type == 'class' ? 'selected' : '' ?>>Class</option>
                            </select>
                        </div>
                        <div class="form_section trainer_show" style="<?= $type != 'trainer' ? 'display: none' : '' ?>">
                            <h6><strong>- Location</strong></h6>
                            <select onchange="searchFunction()" name="trainer_location" class="form-control eb-form-control">
                                <option value="">Select Location</option>
                                <?php foreach($trainers_states as $state) { ?>
                                    <option value="<?=$state?>" <?= $trainer_location == $state ? 'selected' : '' ?>><?= ucwords($state)?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form_section class_show" style="<?= $type != 'class' ? 'display: none' : '' ?>">
                            <h6><strong>- Location</strong></h6>
                            <select onchange="searchFunction()" name="class_location" class="form-control eb-form-control">
                                <option value="">Select Location</option>
                                <?php foreach($classes_states as $state) { ?>
                                    <option value="<?=$state?>" <?= $class_location == $state ? 'selected' : '' ?>><?= ucwords($state)?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form_section">
                            <h6><strong>- Zip Code</strong></h6>
                            <input onchange="searchFunction()" type="number" id="postal_code" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength="5" placeholder="Zip Code" class="form-control eb-form-control" value="<?= $postal_code ?>"/>
                        </div>
                        <div style="<?= $type != 'trainer' ? 'display: none' : '' ?>" class="form_section trainer_show">
                            <h6><strong>- Years Of Experience</strong></h6>
                            <select onchange="searchFunction()" id="experience" class="form-control eb-form-control" >
                                <option value="">Select Experience</option>
                                <option value="0-3" <?= ($experience == '0-3') ? 'selected' : '' ?>>0-3 Years</option>
                                <option value="4-6" <?= ($experience == '4-6') ? 'selected' : '' ?>>4-6 Years</option>
                                <option value="7-9" <?= ($experience == '7-9') ? 'selected' : '' ?>>7-9 Years</option>
                                <option value="10" <?= ($experience == '10') ? 'selected' : '' ?>>10+ Years</option>
                            </select>
                        </div>
                        <div style="<?= $type == 'trainer' ? 'display: none' : '' ?>" class="form_section class_show">
                            <h6><strong>- Date</strong></h6> 
                            <input type="text" name="class_date" id="class_date" data-toggle="datetimepicker" data-target="#class_date" placeholder="Choose Date" class="form-control eb-form-control datetimepicker-input">
                        </div>
                        <div style="<?= $type != 'trainer' ? 'display: none' : '' ?>" class="form_section trainer_show">
                            <h6><strong>- Gender</strong></h6>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <div class="custom-control custom-radio">
                                        <input onchange="searchFunction()" type="checkbox" class="custom-control-input" id="male" name="gender_male" value="male" <?= ($gender_male != '') ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="male"> Male </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-control custom-radio">
                                        <input onchange="searchFunction()" type="checkbox" class="custom-control-input" id="female" name="gender_female" value="female"  <?= ($gender_female != '') ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="female"> Female </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form_section class_show" style="<?= $type == 'trainer' ? 'display: none' : '' ?>">
                            <h6><strong>- Difficulty</strong></h6>
                            <select id="difficulty_level" onchange="searchFunction()" class="form-control eb-form-control" >
                                <option value="">Select Difficulty</option>
                                <option value="easy" <?= ($difficulty_level == 'easy') ? 'selected' : '' ?>>Beginner Level</option>
                                <option value="medium" <?= ($difficulty_level == 'medium') ? 'selected' : '' ?>>Intermediate Level</option>
                                <option value="hard" <?= ($difficulty_level == 'hard') ? 'selected' : '' ?>>Advance Level</option>
                            </select>
                        </div> 
                        <div class="form_section class_show" style="<?= $type == 'trainer' ? 'display: none' : '' ?>">
                            <h6><strong>- Duration</strong></h6>
                            <select id="duration" onchange="searchFunction()" class="form-control eb-form-control" >
                                <option value="">Select Duration</option>
                                <option value="30" <?= ($duration == '30') ? 'selected' : '' ?>>30 minutes</option>
                                <option value="45" <?= ($duration == '45') ? 'selected' : '' ?>>45 minutes</option>
                                <option value="60" <?= ($duration == '60') ? 'selected' : '' ?>>60 minutes</option>
                                <option value="90" <?= ($duration == '90') ? 'selected' : '' ?>>90 minutes</option> 
                            </select>
                        </div>
                        <div class="form_section class_show" style="<?= $type == 'trainer' ? 'display: none' : '' ?>">
                            <h6><strong>- Class Types</strong></h6>
                            <select onchange="searchFunction()" name='class_type' class="form-control eb-form-control" >
                                <option value="">Select Class Type</option>
                                <?php
                                if ($class_types) {
                                    foreach ($class_types as $val) {
                                        ?> 
                                        <option value="<?= $val->title ?>" ><?= ucfirst($val->title) ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form_section d-lg-none d-block">
                            <a href="#" class="btn orange close_mobile_search"> Search <span class="arrow"></span> </a>
                        </div>
                    </form>
                </div> <!-- search sidebar -->                    
            </div>            
            <div class="col-lg-9 col-md-12">
                <div class="d-flex">
                    <div class="search_field search_result w-100">
                        <input value="<?= $search ?>" type="text" id="search_query" placeholder="SEARCH" class="form-control eb-form-control" />
                        <i class="fa fa-search"></i>
                        <i class="fa fa-times-circle"></i>
                    </div>
                    <div class="search_filter_btn d-lg-none d-block">
                        <span class="d-flex align-items-center justify-content-center"><i class="icon"></i></span>
                    </div>
                </div>
                <div id="total_record_count" class="records_found">
                    <?php
                    if ($type == 'trainer') {
                        echo isset($total) ? $total . ' Fitness Professional Found' : '';
                    } else {
                        echo isset($total) ? $total . ' Classes Found' : '';
                    }
                    ?>
                </div>
                <div class="search_record_listing_wrap position-relative">
                    <ul class="search_record_listing" id="data_to_append">
                        <?php
                        foreach ($records as $record) {
                            if ($type == 'trainer') {
                                ?>
                                <li class="d-flex flex-wrap class">
                                    <div class="class-image" style="background-image: url(<?php echo getUserImage($record->image); ?>)"></div>
                                    <div class="class-detail">
                                        <div class="class-head">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h4><?= ucfirst($record->first_name) . ' ' . ucfirst($record->last_name) ?></h4>
                                                    <!--<div class="trainer_type d-flex"><span class="icon-trainer"></span>Certified Personal Trainer</div>-->
                                                    <ul class="social_media">
                                                        <?php if ($record->fb_url) { ?>
                                                            <li><a target="_blank" href="<?= $record->fb_url ?>"><img src="<?= asset('userassets/images/icons/facebook.jpg') ?>" alt="Facebook"></a></li>
                                                        <?php } if ($record->insta_url) { ?>
                                                            <li><a target="_blank" href="<?= $record->insta_url ?>"><img src="<?= asset('userassets/images/icons/instagram.png') ?>" alt="Instagram"></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-4 d-lg-block d-none">
                                                    <div class="btns-group d-flex">
                                                        <a href="<?= asset('trainer-public-profile/' . $record->id); ?>" class="btn btn-purple"> View Detail </a>
                                                    </div>
                                                </div>
                                            </div> <!-- row -->
                                        </div> <!-- head -->
                                        <div class="row no-gutters w-100">
                                            <div class="col-sm-6">
                                                <div><strong class="text-orange">Discipline</strong></div>
                                                <?php if (!$record->trainerSpecializations->isEmpty()) { ?>
                                                    <?php
                                                    foreach ($record->trainerSpecializations as $key => $specialization) {
                                                        if ($key > 1) {
                                                            echo '...';
                                                            break;
                                                        }
                                                        ?>
                                                        <div><?= $specialization->getSpecialization->title ?></div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div>N/A</div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong class="text-orange">Experience</strong>
                                                <div><?= $record->years_of_experience ? $record->years_of_experience . ' Years' : 'N/A' ?></div>
                                            </div>
                                        </div> <!-- row -->
                                        <div class="row no-gutters w-100">

                                            <div class="col-sm-6">
                                                <strong class="text-orange">State</strong>
                                                <div><?= $record->state ? $record->state : 'N/A' ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-block d-lg-none">
                                                <div class="btns-group d-flex">
                                                    <a href="<?= asset('trainer-public-profile/' . $record->id); ?>" class="btn btn-purple"> View Detail </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- class detail -->
                                </li><!-- list item -->
                            <?php } else {
                                ?>
                                <li class="d-flex flex-wrap class">
                                    <div class="class-image" style="background-image: url(<?= isset($record->getImage->path) ? asset('adminassets/images/' . $record->getImage->path) : asset('adminassets/images/class_gallery/default.png') ?>)"></div>

                                    <div class="class-detail">
                                        <div class="class-head">
                                            <div class="row">
                                                <div class="col-lg-8 col-12">
                                                    <h4><?= ucfirst($record->class_name) ?></h4>
                                                    <!--<div class="trainer_type d-flex"><span class="icon-trainer"></span>Certified Personal Trainer</div>-->
                                                </div>
                                                <div class="col-lg-4 d-lg-block d-none">
                                                    <div class="btns-group d-flex">
                                                        <a href="<?= asset('class-view/' . $record->id) ?>" class="btn btn-purple"> View Detail </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb-3">
                                                <strong class="text-orange">Type</strong>
                                                <div><?= $record->class_type ? $record->class_type : 'N/A' ?></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong class="text-orange">Calories</strong>
                                                <div><?= $record->calories ? $record->calories : 'N/A' ?></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong class="text-orange">Difficulty</strong>
                                                <div><?php
                                                    if ($record->difficulty_level) {
                                                        if($record->difficulty_level == 'easy'){
                                                            echo 'Beginner Level';
                                                        } else if($record->difficulty_level == 'medium'){
                                                            echo 'Intermediate Level';
                                                        } else {
                                                            echo 'Advance Level';
                                                        }
                                                    } else {
                                                       echo 'N/A';
                                                    }
                                                    ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong class="text-orange">Spot</strong>
                                                <div><?= $record->spot ? $record->spot : '' ?></div>
                                            </div>
                                            <div class="col-sm-8">
                                                <strong class="text-orange">Location</strong>
                                                <div><?= $record->location ? $record->location : '' ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-block d-lg-none">
                                                <div class="btns-group d-flex">
                                                    <a href="<?= asset('class-view/' . $record->id) ?>" class="btn btn-purple"> View Detail </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- class-detail -->
                                </li><!-- list item -->

                                <?php
                            }
                        }
                        ?> 
                        <?= $records->appends(request()->query())->links(); ?>
                    </ul>

                    <div id="main_loader" style="display: none" class="loader_absolute">
                        <div class="inner d-flex align-items-center justify-content-center">
                            <div class="icon_loader"></div>
                        </div>
                    </div>
                </div>
                <div id="lazy_loader" style="display: none" class="pt-2 pb-2 text-center">
                    <div class="icon_loader"></div>
                </div>
            </div> <!-- col -->
        </div> <!-- row -->
    </div><!-- container -->
</div><!-- overlay -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>

//    ajax_search
    $(document).ready(function () {
        $('#date_class').datetimepicker({
            buttons: {
                showClear: true
            },
            icons: {
                clear: 'fa fa-trash'
            },
            format: 'MMMM DD, YYYY'
        });

        $('#class_date').datetimepicker({
            buttons: {
                showClear: true
            },
            icons: {
                clear: 'fa fa-trash'
            },
            format: 'MMMM DD, YYYY',
            pickTime: false,
            autohide: true
        });



        $('.search_filter_btn').click(function () {
            $('.search_sidebar').toggleClass('open');
        });
        $('.close_mobile_search').click(function () {
            $('.search_sidebar').toggleClass('open');
        });
    });
    var count = 1;
    var ajaxcall = 1;
    $("#class_date").on("blur.datetimepicker", function (e) {
        $(this).datetimepicker("hide");
        searchFunction();
    });

    $("#search_query").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            searchFunction();
        }
    });
    function searchFunction() {
        $('#data_to_append').html('');
        query = $('#search_query').val();
        search_type = $('#search_type').val();
        difficulty_level = $('#difficulty_level').val();
        duration = $('#duration').val();
        experience = $('#experience').val();
        class_date = $('#class_date').val();
        gender_male = $("input[name='gender_male']:checked").val();
        gender_female = $("input[name='gender_female']:checked").val();
        trainer_search_location = $("select[name='trainer_location']").val();
        class_search_location = $("select[name='class_location']").val();
        postal_code = $("input[name='postal_code']").val();
        class_type = $("select[name='class_type']").val();
        var param = '';
        //$('#lazy_loader').show(); 
        if (search_type)
            param += '?search_type=' + search_type;
        (query) ? param += '&keyword=' + query : '';
        if (experience)
            param += '&experience=' + experience;

        if (gender_male)
            param += '&gender_male=' + gender_male;
        if (gender_female)
            param += '&gender_female=' + gender_female;

        if (postal_code)
            param += '&postal_code=' + postal_code;
        if (duration)
            param += '&duration=' + duration;
        if (class_type)
            param += '&class_type=' + class_type;

        //if(search_type == 'class'){
        if (trainer_search_location)
            param += '&trainer_search_location=' + trainer_search_location;
        if (class_search_location)
            param += '&class_search_location=' + class_search_location;
        if (class_date)
            param += '&class_date=' + class_date;
        if (difficulty_level)
            param += '&difficulty_level=' + difficulty_level;
        // }

        window.history.pushState("", "", 'search' + param);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('search'); ?>" + param,
            url: "<?php // echo asset('ajax_search');    ?>" + param,
            success: function (data) {
                result = JSON.parse(data);
                let found_msg = '';
                if (search_type == 'trainer') {
                    found_msg = ' Fitness Professional Found';
                } else if (search_type == 'class') {
                    found_msg = ' Classes Found';
                }
                if (result.append) {
                    ajaxcall = 1;
                    $('#main_loader').hide();
                    $('#lazy_loader').hide();
                    $('#data_to_append').append(result.append);
                    if (result.total_record > 1) {
                        $('#total_record_count').html(result.total_record + found_msg);
                    } else {
                        $('#total_record_count').html(result.total_record + found_msg);
                    }
                } else {
                    ajaxcall = 0;
                    $('#main_loader').hide();
                    $('#lazy_loader').hide();
                    $('#total_record_count').html(result.total_record + found_msg);
                }
            }
        });
    }

    $('#search_type').change(function () {
        type_val = ($(this).val());
        if (type_val == 'class') {
            $('.class_show').show();
            $('.trainer_show').hide();
        } else {
            $('.class_show').hide();
            $('.trainer_show').show();
        }
    });

</script>

</body>
</html>