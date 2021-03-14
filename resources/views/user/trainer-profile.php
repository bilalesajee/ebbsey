<?php include resource_path('views/includes/header.php'); ?>
<div class="bg_blue full_viewport">
    <div class="owl-carousel trainer_slider owl-theme">
        <div class="item">
            <img src="<?= asset('userassets/images/spacer1.png'); ?>" class="spacer" alt="" />
            <div class="slide_img" style="background-image: url('<?= $current_user->original_image ? asset(image_fix_orientation('public/images/'.$current_user->original_image)) : $current_photo ?>')"></div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-6 col-12"></div>
        <div class="col-md-6 col-12">
            <div class="trainer_details_wrap">
                <div class="d-flex flex-column flex-lg-row trainer-header">
                    <div class="left_side">
                        <div class="d-flex align-items-center">
                            <h1><?= ucwords($current_name) ?></h1>
                            <ul class="social_media2 justify-content-center">
                                <?php if (isset($current_user->fb_url)) { ?>
                                    <li><a href="<?= $current_user->fb_url ?>" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                                <?php } ?>
                                <?php if (isset($current_user->insta_url)) { ?>
                                    <li><a href="<?= $current_user->insta_url ?>" target="_new"> <i class="fa fa-instagram"></i> </a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="trainer_type d-flex">
                            <?php if (isset($current_user->trainerTrainingTypes)) { ?>
                                <?php
                                $types_count = $current_user->trainerTrainingTypes->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($current_user->trainerTrainingTypes as $trainer_training_type) { ?>

                                        <?php if ($trainer_training_type->trainingTypes->title == 'Group Fitness Instructor') { ?>
                                            &nbsp;&nbsp;&nbsp;<span class="icon-groupfitness"></span>Group Fitness Instructor
                                        <?php } else if ($trainer_training_type->trainingTypes->title == 'Certified Personal Trainer') { ?>
                                            &nbsp;&nbsp;&nbsp;<span class="icon-trainer"></span>Certified Personal Trainer
                                        <?php } ?>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
<!--                            <div class="align-items-center"><span class="icon-trainer"></span>Certified Personal Trainer</div>
                        <div class="align-items-center"><span class="icon-groupfitness"></span>Group Fitness Instructor</div>-->
                        </div>
                    </div>
                    <div class="right_side ml-lg-auto d-flex flex-lg-column flex-row">
                        <div class="d-flex align-items-center justify-content-lg-end">
                            <?php 
                            $rate_class = 'rate1';
                            if($average_rating >= 0 && $average_rating < 1) {
                                $rate_class = 'rate1';
                            } else if($average_rating >= 1 && $average_rating < 2) { 
                                $rate_class = 'rate2';
                            } else if($average_rating >= 2 && $average_rating < 3) { 
                                $rate_class = 'rate3';
                            } else if($average_rating >= 3 && $average_rating < 4) {
                                $rate_class = 'rate4';
                            } else if($average_rating >= 4 && $average_rating <= 5) {
                                $rate_class = 'rate5';
                            } 
                            ?>
                            <span class="icon-star <?=$rate_class?>"></span>
                            <strong class="rate_number"><?= $average_rating ? round($average_rating, 2) : ' No Ratings Yet!' ?></strong>
                        </div>
                    </div>
                </div>
                <!--                <div class="short_info">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>-->
                <div class="trainer_details_list">
                    <h6 style="color: #8b8893"><strong>OTHER DETAILS</strong></h6>                    
                    <div>
                        <div class="left-side"> Age </div>
                        <div class="right-side"> <?= date_diff(date_create($current_user->dob), date_create('today'))->y; ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Gender </div>
                        <div class="right-side"> <?= ucfirst($current_user->gender); ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Date Of Birth </div>
                        <div class="right-side"> <?= $current_user->dob ? date('F d, Y', strtotime($current_user->dob)) : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Experience </div>
                        <div class="right-side"> <?= $current_user->years_of_experience ? $current_user->years_of_experience . ' years' : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Qualifications </div>
                        <div class="right-side">
                            <?php if (isset($current_user->trainerQualifications)) { ?>
                                <?php
                                $count = $current_user->trainerQualifications->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($current_user->trainerQualifications as $qualification) { ?>
                                        <?= $qualification->getQualification->title . ($i < $count ? ', ' : '') ?>
                                        <?php // if($trainer_training_type->trainingTypes->title == 'Group Fitness Instructor'){    ?>
                                                                                <!--<div class="align-items-center"><span class="icon-groupfitness"></span>Group Fitness Instructor</div>-->
                                        <?php // } else {    ?>
                                                                                <!--<div class="align-items-center"><span class="icon-trainer"></span>Certified Personal Trainer</div>-->
                                        <?php // } ?>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <div class="left-side"> Discipline </div>
                        <div class="right-side">
                            <?php if (isset($current_user->trainerSpecializations)) { ?>
                                <?php
                                $count = $current_user->trainerSpecializations->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($current_user->trainerSpecializations as $skill) { ?>
                                        <?= $skill->getSpecialization->title . ($i < $count ? ', ' : '') ?>
                                        <?php // if($trainer_training_type->trainingTypes->title == 'Group Fitness Instructor'){ ?>
                                                                                <!--<div class="align-items-center"><span class="icon-groupfitness"></span>Group Fitness Instructor</div>-->
                                        <?php // } else { ?>
                                                                                <!--<div class="align-items-center"><span class="icon-trainer"></span>Certified Personal Trainer</div>-->
                                        <?php // }  ?>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <div class="left-side"> Type of Session </div>
                        <div class="right-side">
                            <?php if (isset($current_user->trainerTrainingTypes)) { ?>
                                <?php
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($current_user->trainerTrainingTypes as $trainer_training_type) { ?>    
                                        <?php if ($trainer_training_type->trainingTypes->title == 'Certified Personal Trainer') { ?>
                                            Individual, Couples<?= $i < 2 ? ', ' : '' ?>
                                        <?php } else if ($trainer_training_type->trainingTypes->title == 'Group Fitness Instructor') { ?>
                                            Groups<?= $i < 2 ? ', ' : '' ?>
                                        <?php } ?>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <div class="left-side"> License Expiration Date </div>
                        <div class="right-side"> <?= $current_user->license_expire_date ? $current_user->license_expire_date : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Do you have a facility to teach your class? </div>
                        <div class="right-side"> <?= $current_user->trainerQuestion1 ? ucfirst($current_user->trainerQuestion1->choice) : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Do you own a vehicle? </div>
                        <div class="right-side"> <?= $current_user->trainerQuestion2 ? ucfirst($current_user->trainerQuestion2->choice) : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Do you have personal trainer insurance?  </div>
                        <div class="right-side"> <?= $current_user->trainerQuestion3 ? ucfirst($current_user->trainerQuestion3->choice) : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Referral code  </div>
                        <div class="right-side"> <?= $current_user->referral_code ? $current_user->referral_code : 'N/A' ?> </div>
                    </div>
                </div>
                <a href="<?= asset('/edit-trainer-profile') ?>" class="btn orange">Edit Profile <span class="arrow"></span></a>
            </div>
        </div>
    </div>
</div>


<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $(document).ready(function () {
        
        
        function scrollSticky() {
            var window_width = window.innerWidth;
            var $sticky = $('.trainer_slider');
            var $stickyrStopper = $('.footer');
            if (!!$sticky.offset()) { // make sure ".sticky" element exists
                if (window_width > 767) {
                    var generalSidebarHeight = $sticky.innerHeight();
                    var stickyTop = $sticky.offset().top;
                    var stickOffset = 0;
                    var stickyStopperPosition = $stickyrStopper.offset().top;
                    var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
                    var diff = stopPoint + stickOffset;

                    $(window).scroll(function () { // scroll event
                        var windowTop = $(window).scrollTop(); // returns number
                        if (stopPoint < windowTop) {
                            $sticky.css({position: 'absolute', top: diff});
                        } else if (stickyTop < windowTop + stickOffset) {
                            $sticky.css({position: 'fixed', top: stickOffset});
                        } else {
                            $sticky.css({position: 'absolute', top: 'initial'});
                        }
                    });
                }
            }
        }
        scrollSticky();
        $(window).resize(function () {
            scrollSticky();
        });
    });
</script>

</body>
</html>