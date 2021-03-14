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
                </div> <!-- row -->
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
                        <div>
                            <?php
                            if ($record->difficulty_level) {
                                if ($record->difficulty_level == 'easy') {
                                    echo 'Beginner Level';
                                } else if ($record->difficulty_level == 'medium') {
                                    echo 'Intermediate Level';
                                } else {
                                    echo 'Advance Level';
                                }
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </div>
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