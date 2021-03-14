<?php include resource_path('views/includes/header.php'); ?>
<div class="bg_blue full_viewport">
    <div class="owl-carousel trainer_slider owl-theme">
        <div class="item">
            <img src="<?= asset('userassets/images/spacer1.png'); ?>" class="spacer" alt="" />
            <div class="slide_img" style="background-image: url('<?= (isset($classData->getImage->path) && $classData->getImage->path != '') ? asset('adminassets/images/' . $classData->getImage->path) : asset('adminassets/images/class_gallery/default.png'); ?>')"></div>
        </div> 
    </div>
    <div class="row no-gutters">
        <div class="col-md-6 col-12"></div>
        <div class="col-md-6 col-12">
            <div class="trainer_details_wrap">
                <div class="d-flex flex-column flex-lg-row trainer-header">
                    <div class="left_side">
                        <h1><?= isset($classData->class_name) ? $classData->class_name : '' ?></h1>
                    </div>
                </div>
                <div class="class_trainer_info align-items-center d-flex">
                    <div class="profile_info d-flex align-items-center">
                        <div class="image">
                            <div class="img" style="background-image: url(<?= getUserImage($classData->classtTrainer->image) ?>);"></div>
                        </div>
                        <div class="info">
                            <div class="type">Instructor</div>
                            <div class="name">
                                <?php if (isset($classData->classtTrainer->id) && $classData->classtTrainer->id) { ?>
                                    <a href="<?= asset('trainer-public-profile/' . $classData->classtTrainer->id) ?>"> <?= isset($classData->classtTrainer) ? $classData->classtTrainer->first_name . ' ' . $classData->classtTrainer->last_name : '' ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="msg_btn"> 
                        <?php if (isset($classData->classtTrainer->id) && $classData->classtTrainer->id != Auth::id()) { ?>
                            <a href="javascript:void(0)" onclick="openMessageModal(<?= $classData->classtTrainer->id ?>)" class="btn_message"> <i class="fa fa-envelope"></i> Message</a>
                        <?php } ?> 
                    </div>
                </div>
                <div class="short_info">
                    <p><?= isset($classData->description) ? $classData->description : 'N/A' ?></p>
                </div>
                <div class="trainer_details_list">
                    <h6 style="color: #8b8893"><strong>OTHER DETAILS</strong></h6>                    
                    <div>
                        <div class="left-side"> Type </div>
                        <div class="right-side"> <?= isset($classData->class_type) ? $classData->class_type : 'N/A' ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Difficulty </div>
                        <div class="right-side"> <?php
                            if (isset($classData->difficulty_level)) { 
                                    if ($classData->difficulty_level == 'easy') {
                                        echo 'Beginner Level';
                                    } else if ($classData->difficulty_level == 'medium') {
                                        echo 'Intermediate Level';
                                    } else {
                                        echo 'Advance Level';
                                    } 
                            } else {
                                echo 'N/A';
                            }
                            ?> </div>
                    </div>
                    <div>
                        <div class="left-side"> Calories </div>
                        <div class="right-side"> <?= isset($classData->calories) ? $classData->calories : 'N/A' ?> K.Cal </div>
                    </div> 

                    <div>
                        <div class="left-side"> Available spots </div>
                        <div class="right-side"> <?= isset($classData->spot) ? $classData->spot : 'N/A' ?> </div>
                    </div>

                    <div>
                        <div class="left-side"> Location </div>
                        <div class="right-side"> <?= isset($classData->location) ? $classData->location : 'N/A' ?> </div>
                    </div>

                    <div>
                        <div class="left-side"> Date </div>
                        <div class="right-side"> <?= date('F d, Y', strtotime($classData->start_date)) ?> </div>
                    </div>

                    <div>
                        <div class="left-side"> Duration </div>
                        <div class="right-side"> <?= isset($classData->duration) ? $classData->duration . ' minutes' : 'N/A' ?> </div>
                    </div>
                    <?php if ($today_schedule) { ?>
                        <div>
                            <div class="left-side"> Start Time </div>
                            <div class="right-side">  <?= $today_schedule->start_time ?></div>
                        </div> 
                    <?php } ?>
                </div>
                <?php if (isset($current_user->user_type) && $current_user->user_type == 'trainer' && $classData->status == 'completed') { ?>
                    <div class="trainer_details_list">
                        <h6 style="color: #8b8893"><strong>SUMMERY</strong></h6>
                        <?php if (isset($classData->countSpot) && count($classData->countSpot) > 0) { ?>
                            <div><div class="left-side">Student Name</div>
                                <div class="right-side text-orange">No of passes </div>
                            </div>
                            <?php foreach ($classData->countSpot as $summery) {
                                ?>
                                <div>
                                    <div class="left-side"> <?= $summery->appointmentClient->first_name . ' ' . $summery->appointmentClient->last_name ?> </div>
                                    <div class="right-side text-orange"> <?= $summery->number_of_passes ?> </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div> 
                <?php } ?>
                <div class="trainer_details_list">
                    <h6 style="color: #8b8893"><strong>CLASS SCHEDULE</strong></h6>
                    <?php
                    if (isset($classData->classTimetable) && count($classData->classTimetable) > 0) {
                        foreach ($classData->classTimetable as $Timetable) {
                            ?>
                            <div>
                                <div class="left-side"> <?= ucfirst($Timetable->day) ?> </div>
                                <div class="right-side text-orange"> <?= $Timetable->start_time ?> - <?= $Timetable->end_time ?> </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div> 
                <?php if ($current_user_type == 'user' && $isGroupTrainer) { ?>
                    <a href="<?= url('booking') . '/' . $id; ?>" class="btn orange"><?= ($is_already_enrolled) ? 'Book class again' : 'Count me in' ?> <span class="arrow"></span></a>
                    <?php } ?>
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