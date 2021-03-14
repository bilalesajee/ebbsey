<?php include resource_path('views/includes/header.php'); ?>
<div class="bg_blue full_viewport">
    <div class="owl-carousel trainer_slider owl-theme">
        <div class="item">
            <img src="<?= asset('userassets/images/spacer1.png'); ?>" class="spacer" alt="" />
            <div class="slide_img" style="background-image: url('<?= $trainerData->original_image ? asset(image_fix_orientation('public/images/'.$trainerData->original_image)) : getUserImage($trainerData->image) ?>')"></div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-6 col-12"></div>
        <div class="col-md-6 col-12">
            <div class="trainer_details_wrap">
                <div class="d-flex flex-column flex-lg-row trainer-header">
                    <div class="left_side">
                        <div class="d-flex align-items-center">
                            <h1><?= $trainerData ? $trainerData->first_name . ' ' . $trainerData->last_name : 'N/A' ?></h1>                            
                            <ul class="social_media2 justify-content-center">
                                <?php if (isset($trainerData->fb_url)) { ?>
                                    <li><a href="<?= $trainerData->fb_url ?>" target="_blank"> <i class="fa fa-facebook-f"></i> </a></li>
                                <?php } ?>
                                <?php if (isset($trainerData->insta_url)) { ?>
                                    <li><a href="<?= $trainerData->insta_url ?>" target="_blank"> <i class="fa fa-instagram"></i> </a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="trainer_type d-flex">
                            <?php if (isset($trainerData->trainerTrainingTypes)) { ?>
                                <?php
                                $types_count = $trainerData->trainerTrainingTypes->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($trainerData->trainerTrainingTypes as $trainer_training_type) { ?>

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
                            if ($average_rating >= 0 && $average_rating < 1) {
                                $rate_class = 'rate1';
                            } else if ($average_rating >= 1 && $average_rating < 2) {
                                $rate_class = 'rate2';
                            } else if ($average_rating >= 2 && $average_rating < 3) {
                                $rate_class = 'rate3';
                            } else if ($average_rating >= 3 && $average_rating < 4) {
                                $rate_class = 'rate4';
                            } else if ($average_rating >= 4 && $average_rating <= 5) {
                                $rate_class = 'rate5';
                            }
                            ?>
                            <span class="icon-star <?= $rate_class ?>"></span>
                            <strong class="rate_number"><?= ($average_rating) ? round($average_rating, 2) : ' No Ratings Yet!' ?></strong>
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
                        <div class="right-side"><?= date_diff(date_create($trainerData->dob), date_create('today'))->y; ?></div>
                    </div>
                    <div>
                        <div class="left-side"> Gender </div>
                        <div class="right-side"><?= ucfirst($trainerData->gender); ?></div>
                    </div>
                    <div>
                        <div class="left-side"> Experience </div>
                        <div class="right-side"> <?= $trainerData->years_of_experience ? $trainerData->years_of_experience . ' years' : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Qualifications </div>
                        <div class="right-side">
                            <?php if (isset($trainerData->trainerQualifications)) { ?>
                                <?php
                                $count = $trainerData->trainerQualifications->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($trainerData->trainerQualifications as $qualification) { ?>
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
                        <div class="left-side"> Disciplines </div>
                        <div class="right-side">
                            <?php if (isset($trainerData->trainerSpecializations)) { ?>
                                <?php
                                $count = $trainerData->trainerSpecializations->count();
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($trainerData->trainerSpecializations as $skill) { ?>
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
                            <?php if (isset($trainerData->trainerTrainingTypes)) { ?>
                                <?php
                                $i = 1;
                                ?>
                                <div class="align-items-center">
                                    <?php foreach ($trainerData->trainerTrainingTypes as $trainer_training_type) { ?>    
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

                    <!--                    <div>
                                            <div class="left-side"> Own a vehicle? </div>
                                            <div class="right-side"> <?= $trainerData->trainerQuestion2 ? ucfirst($trainerData->trainerQuestion2->choice) : 'N/A' ?> </div>
                                        </div>-->
                    <div>
                        <div class="left-side"> Have personal trainer insurance? </div>
                        <div class="right-side"> <?= $trainerData->trainerQuestion3 ? ucfirst($trainerData->trainerQuestion3->choice) : 'N/A' ?> </div>
                    </div>

                </div>
                <?php if ($current_user_type == 'user' && ($isPersonalTrainer || $isGroupTrainer)) { ?>
                    <a href="<?= url('booking-session') . '/' . $trainerData->id; ?>" class="btn orange mb-4">Book Session Now <span class="arrow"></span></a>
                <?php } ?>
                <div class="trainer_reviews_section">
                    <h4 class="review-title">Reviews</h4>
                    <?php if (!$trainerData->getTrainerRating->isEmpty()) { ?>
                        <ul class="trainer_reviews_list">
                            <?php $counter = 0; ?>
                            <?php
                            foreach ($trainerData->getTrainerRating as $review) {
                                $counter++;
                                if ($counter > 5) {
                                    break;
                                }
                                ?>
                                <li class="d-flex">
                                    <div class="profile_info d-flex mb-2">
                                        <div class="image">
                                            <div class="img" style="background-image: url(<?= getUserImage($review->ratedBy->image) ?>);"></div>
                                        </div>
                                    </div>
                                    <div class="review_body">
                                        <div class="info mb-2">
                                            <div class="name font-weight-normal"><?= $review->ratedBy->first_name . ' ' . $review->ratedBy->last_name ?></div>
                                            <div class="my-rating-<?= $review->id ?>"></div>
                                            <script>
                                                $(".my-rating-<?= $review->id ?>").starRating({
                                                    starSize: 24,
                                                    totalStars: 5,
                                                    starShape: 'rounded',
                                                    emptyColor: '#585858',
                                                    hoverColor: '#f26824',
                                                    activeColor: '#f26824',
                                                    initialRating: <?= $review->rating ?>,
                                                    strokeWidth: 0,
                                                    useGradient: false,
                                                    readOnly: true
                                                });
                                            </script>
                                        </div>
                                        <div class="review_text">
                                            <?= $review->reviews ?>
                                        </div>
                                        <div class="date"><?= date('F d, Y g:i A', strtotime($review->created_at)) ?></div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>No review found</p>
                    <?php } ?>
                    <?php if ($trainerData->getTrainerRating->count() > 5) { ?>
                        <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#reviews_modal"> View All Reviews </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- reviews modal -->
<div class="modal fade" id="reviews_modal" tabindex="-1" role="dialog" aria-labelledby="reviews_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">Reviews List</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (!$trainerData->getTrainerRating->isEmpty()) { ?>
                    <ul class="trainer_reviews_list">
                        <?php foreach ($trainerData->getTrainerRating as $review) { ?>
                            <li class="d-flex">
                                <div class="profile_info d-flex">
                                    <div class="image">
                                        <div class="img" style="background-image: url(<?= getUserImage($review->ratedBy->image) ?>);"></div>
                                    </div>

                                </div>
                                <div class="review_body">
                                    <div class="info mb-2">
                                        <div class="name font-weight-normal"><?= $review->ratedBy->first_name . ' ' . $review->ratedBy->last_name ?></div>
                                        <div id="my-rating-<?= $review->id ?>"></div>
                                        <script>
                                            $("#my-rating-<?= $review->id ?>").starRating({
                                                starSize: 24,
                                                totalStars: 5,
                                                starShape: 'rounded',
                                                emptyColor: '#585858',
                                                hoverColor: '#f26824',
                                                activeColor: '#f26824',
                                                initialRating: <?= $review->rating ?>,
                                                strokeWidth: 0,
                                                useGradient: false,
                                                readOnly: true
                                            });
                                        </script>
                                    </div>
                                    <div class="review_text">
                                        <?= $review->reviews ?>
                                    </div>
                                    <div class="date"><?= date('F d, Y g:i A', strtotime($review->created_at)) ?></div>
                                </div>
                            </li>
                        <?php } ?>

                    </ul>
                <?php } else { ?>
                    <p>No review found</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- reviews modal -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $(document).ready(function () {

        jQuery("#reviews_modal .trainer_reviews_list").mCustomScrollbar({});


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