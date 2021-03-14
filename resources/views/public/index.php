<?php include resource_path('views/includes/header.php'); ?>
<div class="home_banner">
    <div class="owl-carousel bannerCarousel owl-theme">
        <div class="item">
            <div class="slide_img" style="background-image: url('<?= asset('userassets/images/home-slide.jpg'); ?>')">
            </div>
        </div>
    </div>
    <div class="overlay d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="banner_content">
                        <div class="content">
                            <h2>Be Persistent</h2>
                            <p>Change your routines. Train with professionals that<br/> lives and breathes a healthy and fitness lifestyle.</p>
                            <!--<a href="#" class="btn orange">Explore More <span class="arrow"></span></a>-->
                            <a href="<?= url('search?search_type=trainer'); ?>" class="btn orange">Book Today <span class="arrow"></span></a>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container-->
    </div> <!-- overlay-->
</div><!-- section -->

<div class="trial_offer">
    <div class="overlay">
        <div class="container">
            <h2>Try it. Do it. Live it.</h2>
            <a href="<?= url('search?search_type=trainer'); ?>" class="btn white">BOOK NOW <span class="arrow"></span></a>
        </div>
    </div>
</div><!-- section -->

<div class="get_personal_trainer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <h2>Connect with Real <span class="text-orange"> Professionals  </span> </h2>
                    <p>Detach yourself from inexperience and attach yourself with professionals that lives and breathe a healthy and fit lifestyle.</p>
                    <a href="<?= url('search?search_type=trainer'); ?>" class="btn orange">Find Professionals <span class="arrow"></span></a>                    
                </div>
            </div> <!-- col 12 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div><!-- section -->

<!-- Search Area -->
<div class="quicksearch">
    <div class="container-fluid px-0">
        <div class="row no-gutters">
            <div class="col-lg-4 col-md-12">
                <div class="quick_search_side">
                    <h2>Quick Search</h2>
                    <p>Whether it’s cardio dance class, a trainer to instruct & motivate you, or simply preparing for an event.</p>
                    <form method="get" action="<?= asset('search') ?>">
                        <div class="form-quicksearch d-flex flex-wrap">
                            <div class="row w-100">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input name="search_type" type="hidden" value="trainer" />
                                        <input name="keyword" type="search" autocomplete="off" placeholder="Search" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-12 d-flex">
                                    <div class="form-group w-50 mr-1">
                                        <select name="trainer_search_location" class="form-control">
                                            <option value="">Select Location</option>
                                            <?php foreach($trainers_states as $state) { ?>
                                                <option value="<?=$state?>"><?= ucwords($state)?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group w-50 ml-1">
                                        <select name="class_type" class="form-control">
                                            <option value="" selected="">Select Booking Type</option>
                                            <option value="individual">Individual</option>
                                            <option value="couples">Couples</option>
                                            <option value="groups">Groups</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn orange">Let's get this started  <span class="arrow"></span></button>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div><!-- col -->
            <div class="col-lg-8 col-md-12">
                <ul class="search_categories d-flex flex-wrap">
                    <li>

                        <a href="<?=asset('search?search_type=class&class_type=muscle+building')?>">
                            <div class="category_wrap">
                                <img src="<?= asset('userassets/images/spacer2.png'); ?>" alt="" class="spacer" />
                                <div class="image" style="background-image: url(<?= asset('userassets/images/category_1.jpg'); ?>)"></div>
                                <div class="hover d-flex align-items-end">
                                    <div class="info d-flex align-items-center">
                                        <div>
                                            <h6>Muscle Building</h6>
                                            <!--<div class="trainers"><?= number_format($indvidual_classes_count) ?> Classes</div>-->
                                        </div>
                                        <div class="ml-auto">
                                            <span class="read_more"><span class="arrow-white"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li> 
                        <a href="<?=asset('search?search_type=class&class_type=streching+balancing')?>">
                            <div class="category_wrap">
                                <img src="<?= asset('userassets/images/spacer2.png'); ?>" alt="" class="spacer" />
                                <div class="image" style="background-image: url(<?= asset('userassets/images/category_2.jpg'); ?>)"></div>
                                <div class="hover d-flex align-items-end">
                                    <div class="info d-flex align-items-center">
                                        <div>
                                            <h6>Streching & Balancing</h6>
                                            <!--<div class="trainers"><?= number_format($groups_classes_count) ?> Classes</div>-->
                                        </div>
                                        <div class="ml-auto">
                                            <span class="read_more"><span class="arrow-white"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
 
                        <a href="<?=asset('search?search_type=class&class_type=meditation')?>"> 
                            <div class="category_wrap">
                                <img src="<?= asset('userassets/images/spacer2.png'); ?>" alt="" class="spacer" />
                                <div class="image" style="background-image: url(<?= asset('userassets/images/category_3.jpg'); ?>)"></div>
                                <div class="hover d-flex align-items-end">
                                    <div class="info d-flex align-items-center">
                                        <div>
                                            <h6>Weight Management</h6> 
                                        </div>
                                        <div class="ml-auto">
                                            <span class="read_more"><span class="arrow-white"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
 
                        <a href="<?=asset('search?search_type=class&class_type=seniors')?>">
                            <div class="category_wrap">
                                <img src="<?= asset('userassets/images/spacer2.png'); ?>" alt="" class="spacer" />
                                <div class="image" style="background-image: url(<?= asset('userassets/images/category_4.jpg'); ?>)"></div>
                                <div class="hover d-flex align-items-end">
                                    <div class="info d-flex align-items-center">
                                        <div>
                                            <h6>Seniors</h6>
                                            <!--<div class="trainers"><?= number_format($youth_classes_count) ?> Classes</div>-->
                                        </div>
                                        <div class="ml-auto">
                                            <span class="read_more"><span class="arrow-white"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li> 
                </ul>
            </div>
        </div>
    </div> <!-- container fluid -->
</div> <!-- Search Area -->

<!-- About us -->
<div class="about-home">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="details">
                    <h2>ABOUT US</h2><br/>
                    <p>We are a platform, connecting the most highly passionate, experienced health and fitness professionals in the industry. More so, our services are tailored to fit each specific client’s needs and circumstances to ensure that we provide an overall transformation in their health and fitness goals.</p>
                    <p>We do not take your health or fitness goals lightly. That is why our team is made up of highly vetted health and fitness professionals. We also insist on the professionals having keen disciplines in fitness programs to ensure you reach your maximum potential in the shortest time possible regardless of your goals or location.</p>
                    <p>Connect with a team who puts the client’s health and fitness goals first and profits last. Our Fitness professionals come from all disciplines: Boxing, Natural movement, Cardio, Yoga, Weight Loss, Mediation or Athletic Performance. This diversity means we are more than just physical fitness.</p>
                    <p>Our clients train with professionals who are not only committed to keeping you healthy and fit but will counsel, motivate, encourage, and support all the way through your journey. Therefore, whatever your goals are, we are here to offer a fresh, convenient and affordable way to shed unwanted weight, build muscle, or prepare for an event, at the location of your choice; Whether at your home gym, office, hotel, university, we are here to meet your health and fitness goals.</p>
                    <br/>
                    <a href="<?= asset('about') ?>" class="btn orange">Learn More <span class="arrow"></span></a>
                </div>
            </div>
            <div class="col-md-6 d-none d-xs-none d-md-block">
                <div class="images_group">
                    <div class="image1" style="background-image: url('<?= asset('userassets/images/image5.jpg'); ?>'); "></div>
                    <div class="image2" style="background-image: url('<?= asset('userassets/images/image4.jpg'); ?>'); "></div>
                    <div class="image3" style="background-image: url('<?= asset('userassets/images/image3.jpg'); ?>'); "></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- About us -->

<div class="featured_classes_trainers">
    <div class="overlay">
        <div class="container">
            <h2>FEATURED CLASSES <br/>& PROFESSIONALS</h2>
            <div class="short_description">
                <p>Give recognition where recognition is due. Our featured Health and fitness professionals have shown a memorable and exemplary, skills, passion, knowledge for our customers.</p>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-10 ml-auto mr-auto">            
                    <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
                        <li>
                            <a class="active" data-toggle="tab" href="#all_trainers" role="tab" aria-selected="true">All Classes</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#all_classes" role="tab" aria-selected="false">All Trainers</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all_trainers" role="tabpanel">
                            <div class="row">
                                <?php if (!$featured_classes->isEmpty()) { ?>
                                    <?php foreach ($featured_classes as $class) { ?>
                                        <div class="col-sm-6">
                                            <div class="trainer_box">
                                                <a href="<?= asset('class-view/' . $class->id) ?>" class="d-flex align-items-center">
                                                    
                                                    <?php if ($class->getImage && $class->getImage->path != '') { ?>
                                                        <div class="image" style="background-image: url(<?= asset('adminassets/images/' . $class->getImage->path) ?>"></div>
                                                    <?php } else { ?>
                                                        <div class="image" style="background-image: url(<?= asset('userassets/images/classes/default.png'); ?>)"></div>
                                                    <?php } ?>
                                                    
                                                    <span class="name"><?= $class->class_name ?> </span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p>No Featured Classes to Show !</p>
                                <?php } ?>
                            </div> <!-- row -->
                        </div>
                        <div class="tab-pane fade" id="all_classes" role="tabpanel">
                            <div class="row">
                                <?php if (!$featured_trainers->isEmpty()) { ?>
                                    <?php foreach ($featured_trainers as $trainer) { ?>
                                        <div class="col-sm-6">
                                            <div class="trainer_box">
                                                <a href="<?= asset('trainer-public-profile/' . $trainer->id) ?>" class="d-flex align-items-center">
                                                    <div class="image" style="background-image: url(<?= getClassImage($trainer->image) ?>)"></div>
                                                    <span class="name"><?= $trainer->first_name . ' ' . $trainer->last_name ?> </span>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p>No Featured Trainers to Show !</p>
                                <?php } ?>
                            </div> <!-- row -->
                        </div>
                    </div>
                </div> <!-- col 10 -->
            </div> <!-- row -->
        </div>
    </div>
</div><!-- section -->


<div class="feel_good">
    <div class="overlay">
        <div class="container">
            <h2>"FEEL GOOD. LOOK GOOD. DO BETTER! <br> … TRUST THE PROCESS!"</h2>
            <a href="<?= url('search?search_type=trainer'); ?>" class="btn white">BOOK NOW <span class="arrow"></span></a>
        </div>
    </div>
</div><!-- section -->

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>
