<?php
$segment = Request::segment(1);
$current_id = '';
$current_name = '';
$current_user = '';
$current_user_type = '';
$current_photo = asset('public/images/users/default.jpg');
$current_email = '';
//$full_name = '';
if (Auth::user()) {
    $current_id = Auth::user()->id;
    $current_email = Auth::user()->email;
    $current_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
    $current_user = Auth::user();
    $current_user_type = Auth::user()->user_type;
    if (Auth::user()->image) {
        $current_photo = asset('public/images/' . Auth::user()->image);
    } else {
        $current_photo = asset('public/images/users/default.jpg');
    }
//    $full_name = $current_user->first_name . ' ' . $current_user->last_name;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
        <title><?= $title ?></title> 
        <link rel="stylesheet" href="<?= asset("userassets/css/bootstrap.min.css") ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= asset("userassets/css/jquery.mCustomScrollbar.min.css") ?>" />
        <link rel="stylesheet" href="<?= asset("userassets/css/owl.carousel.min.css") ?>" />
        <link rel="stylesheet" href="<?= asset("userassets/css/tempusdominus-bootstrap-4.css") ?>" />
        <link rel="stylesheet" href="<?= asset("userassets/css/jquery.fancybox.css") ?>" />
        <link rel="stylesheet" href="<?= asset("userassets/css/style.css") ?>" />
        <script src="<?= asset("userassets/js/jquery-3.3.1.min.js") ?>"></script>
        <script src="<?= asset("userassets/js/jquery.star-rating-svg.js") ?>"></script>
        <script src="<?= asset('userassets/js/jquery.fancybox.js'); ?>"></script>
        <script>
            jQuery(document).ready(function () {
                jQuery('.fancybox').fancybox();
            });
        </script>
    </head>

    <body style="background-color: #0e0b16; ">


        <!--        <div class="loader_absolute">
                    <div class="inner d-flex align-items-center justify-content-center">
                        <div class="icon_loader"></div>
                    </div>
                </div>
                <div class="loader_fixed">
                    <div class="inner d-flex align-items-center justify-content-center">
                        <div class="icon_loader"></div>
                    </div>
                </div>-->

        <div class="container pt-5 pb-5">
            <div class="form_section">
                <h5><strong>- Profile Picture</strong></h5>
                <div class="edit_profile_image d-flex align-items-center">
                    <div class="image_view" style="background-image: url('<?php echo asset('userassets/images/profile-images.jpg'); ?>')"></div>
                    <div class="ml-auto action_btns">
                        <label class="btn pink" for="trainer-images"> Upload Photo </a>
                            <div class="file_upload_btn2"> <input name="image" id="trainer-images" type="file" multiple=""> </div>
                    </div>
                </div>
            </div>

            <div class="form_section">
                <h5><strong>- Picture Gallery</strong></h5>
                <div class="row">
                    <div class="col-sm-2">
                        <a class="fancybox" href="<?php echo asset('userassets/images/profile-images.jpg'); ?>">
                            <img src="<?php echo asset('userassets/images/profile-images.jpg'); ?>" alt="" class="img-fluid" />
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="fancybox" href="<?php echo asset('userassets/images/image15.jpg'); ?>">
                            <img src="<?php echo asset('userassets/images/image15.jpg'); ?>" alt="" class="img-fluid" />
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="fancybox" href="<?php echo asset('userassets/images/image14.jpg'); ?>">
                            <img src="<?php echo asset('userassets/images/image14.jpg'); ?>" alt="" class="img-fluid" />
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="fancybox" href="<?php echo asset('userassets/images/image2.jpg'); ?>">
                            <img src="<?php echo asset('userassets/images/image2.jpg'); ?>" alt="" class="img-fluid" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="form_section">
                <h5><strong>- Upload Images for Gallery & Profile Picture</strong></h5>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="upload_gallery d-flex">
                            <div class="profile_pic">
                                <div class="image" style="background-image: url('<?php echo asset('userassets/images/image9.jpg'); ?>')"></div>
                                <div class="file_upload_btn">
                                    Upload 
                                    <input name="PersonalInstructorCertificates" type="file" multiple=""> 
                                </div>

                            </div>
                            <div class="profile_gallery">
                                <ul class="d-flex flex-wrap">
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image9.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image8.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image10.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/profile-images1.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image14.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image15.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image16.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image17.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image18.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image1.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image2.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/image13.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image_wrap">
                                            <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/profile-images4.jpg'); ?>')">
                                                <div class="hover d-flex align-items-center justify-content-center">Set as Profile Picture</div>
                                            </div>
                                            <div class="delete_pic">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky_notification" hidden>
                <div class="alert alert-success custom_alert">
                    <strong><i class="fa fa-check"></i> Success!</strong> Indicates a successful or positive action.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-info custom_alert">
                    <strong><i class="fa fa-info"></i> Info!</strong> Indicates a neutral informative change or action.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-warning custom_alert">
                    <strong><i class="fa fa-exclamation-triangle"></i> Warning!</strong> Indicates a warning that might need attention.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger custom_alert">
                    <strong><i class="fa fa-info-circle"></i> Danger!</strong> Indicates a dangerous or potentially negative action.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="alert alert-success custom_alert">
                <strong><i class="fa fa-check"></i> Success!</strong> Indicates a successful or positive action.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-info custom_alert">
                <strong><i class="fa fa-info"></i> Info!</strong> Indicates a neutral informative change or action.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-warning custom_alert">
                <strong><i class="fa fa-exclamation-triangle"></i> Warning!</strong> Indicates a warning that might need attention.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-danger custom_alert">
                <strong><i class="fa fa-info-circle"></i> Danger!</strong> Indicates a dangerous or potentially negative action.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="records_found">327 result found</div>
            <div class="records_found dark" style="background-color: #19191e">All Sessions</div>
            <div class="trainer_details_list mb-5">
                <h6 style="color: #8b8893"><strong>OTHER DETAILS</strong></h6>                    
                <div>
                    <div class="left-side"> Type </div>
                    <div class="right-side"> Dancing </div>
                </div>
                <div>
                    <div class="left-side"> Dificulty </div>
                    <div class="right-side"> Beginner Level </div>
                </div>
                <div>
                    <div class="left-side"> Calories </div>
                    <div class="right-side"> 500 K.Cal </div>
                </div>
                <div>
                    <div class="left-side"> Duration </div>
                    <div class="right-side"> 60 mins </div>
                </div>

                <div>
                    <div class="left-side"> Location </div>
                    <div class="right-side"> San Francisco </div>
                </div>
                <div>
                    <div class="left-side"> Spots </div>
                    <div class="right-side"> Availability </div>
                </div>
            </div>

            <div class="pt-3 mb-5">
                <h6 class="mb-3">Popup</h6>
                <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#exampleModalCenter"> Refer </a>
                <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#addavailability"> Add Availability </a>
                <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#addavailability1"> Conformation </a>
                <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#stripe_payment_modal"> Stripe</a>
                <a href="#" class="btn orange round small btn-lg" data-toggle="modal" data-target="#reviews_modal"> Reviews </a>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLongTitle">Refer a Trainer</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col-sm-7">
                                        <div class="search_field dark">
                                            <input type="text" placeholder="SEARCH" class="form-control eb-form-control">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control select_radius eb-form-control ">
                                            <option> Build Muscles </option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="refer_trainer_list">
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">James Neves</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Tim Halter</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">James Neves</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Tim Halter</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">James Neves</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Tim Halter</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">James Neves</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Tim Halter</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">James Neves</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images3.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Tim Halter</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message refered"><i class="fa fa-check"></i> Refered</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/image9.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Kyle Poe</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="profile_info d-flex align-items-center">
                                            <div class="image">
                                                <div class="img" style="background-image: url(<?php echo asset('userassets/images/image15.jpg'); ?>);"></div>
                                            </div>
                                            <div class="info">
                                                <div class="name">Gregory Tyler</div>
                                                <div class="type">Age 26 years</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <a href="#" class="btn_message">Refer</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer justify-content-start">
                                <button type="button" class="btn btn-lg orange">Save</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- reviews modal -->
                <div class="modal fade" id="reviews_modal" tabindex="-1" role="dialog" aria-labelledby="reviews_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-custom" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLongTitle">Refer a Trainer</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">


                            </div>
                            <div class="modal-footer justify-content-start">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- reviews modal -->

                <div class="modal fade" id="addavailability" tabindex="-1" role="dialog">
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
                                    <div class="col-sm-6">
                                        <label>From</label>
                                        <div class="input-group date" id="timefrom" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input eb-form-control" data-target="#timefrom"/>
                                            <div class="input-group-append" data-target="#timefrom" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>To</label>
                                        <div class="input-group date" id="timeto" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input eb-form-control" data-target="#timeto"/>
                                            <div class="input-group-append" data-target="#timeto" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-start">
                                <button type="button" class="btn btn-lg orange">Save</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="addavailability1" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-sm modal-sm-custom" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLongTitle">Delete Class</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="font-12 mb-4 mt-2">
                                    <p>Are you sure to delete this class? After deleting this you cannot get back
                                        all class data again. We recommend to deactive class.</p>
                                </div>
                                <div class="row mb-2">                                    
                                    <div class="col-sm-12">
                                        <div class="d-flex ">
                                            <div class="w-100 mr-1">
                                                <a href="#" class="btn orange btn-block mr-1">Yes</a>
                                            </div>
                                            <div class="w-100 ml-1">
                                                <a href="#" class="btn white btn-block">No</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="stripe_payment_modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalLongTitle">Purchase Passes</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="payment_form">
                                    <div class="form-group">
                                        <div class="field_wrap">
                                            <input type="text" class="form-control eb-form-control" placeholder="Email" />
                                            <div class="icon d-flex justify-content-end align-items-center">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="field_wrap">
                                                    <input type="text" class="form-control eb-form-control" placeholder="Card Number" />
                                                    <div class="icon d-flex justify-content-end align-items-center">
                                                        <i class="fa fa-credit-card-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- col -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="field_wrap">
                                                    <input type="text" class="form-control eb-form-control" placeholder="MM / YY" />
                                                    <div class="icon d-flex justify-content-end align-items-center">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="form-group">
                                        <div class="field_wrap">
                                            <input type="text" class="form-control eb-form-control" placeholder="CVC" />
                                            <div class="icon d-flex justify-content-end align-items-center">
                                                <i class="fa fa-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn orange">Pay Now <span class="arrow"></span></button>
                                </form>
                            </div> <!-- modal-body -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile_info d-flex align-items-center mb-3">
                <div class="image">
                    <div class="img" style="background-image: url(<?php echo asset('userassets/images/profile-images.jpg'); ?>);"></div>
                </div>
                <div class="info">
                    <div class="type">Trainer</div>
                    <div class="name">Jerry Delgado</div>
                </div>
            </div>
            <div class="icon_loader"></div>
            <div class="form_section">
                <h5 class="mb-3"><strong>Buttons</strong></h5>
                <a href="#" class="btn orange">Explore More <span class="arrow"></span></a>
                <a href="#" class="btn orange round">Explore More <span class="arrow"></span></a>
                <a href="#" class="btn white">Explore More <span class="arrow"></span></a> 
                <a href="#" class="btn_message"> <i class="fa fa-envelope"></i> Message</a>
                <a href="#" class="btn_message small"> <i class="fa fa-envelope"></i> Message</a>
                <a href="#" class="btn btn-outline"> Cancel Session </a>
                <a href="#" class="btn btn-purple"> View Detail </a>
                <br/><br/>
                <a href="#" class="btn white btn-block"> <span class="icon_loading"></span> Explore More <span class="arrow"></span></a>
                <br/>
                <a href="#" class="btn orange btn-block"> <span class="icon_loading"></span> Explore More <span class="arrow"></span></a>
                <br/>
                <a href="#" class="btn orange btn-lg"> Explore More</a>
                <br/>
            </div>

            <div class="form_section">
                <h5 class="mb-3"><strong>Form Element</strong></h5>
                <div class="mt-3">
                    <div class="form-group">
                        <div class="input-group date" id="dateandtime" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input eb-form-control" data-target="#dateandtime"/>
                            <div class="input-group-append" data-target="#dateandtime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="dateonly" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input eb-form-control" data-target="#dateonly"/>
                            <div class="input-group-append" data-target="#dateonly" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group date" id="timeonly" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input eb-form-control" data-target="#timeonly"/>
                            <div class="input-group-append" data-target="#timeonly" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>                

                <div class="form-group">
                    <div class="search_field">
                        <input type="text" placeholder="SEARCH" class="form-control eb-form-control" />
                        <i class="fa fa-search"></i>
                    </div>
                </div>
                <div class="form-group">
                    <div class="search_field dark">
                        <input type="text" placeholder="SEARCH" class="form-control eb-form-control" />
                        <i class="fa fa-search"></i>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Email" class="form-control eb-form-control" />
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control eb-form-control" />
                </div>
                <div class="form-group">
                    <select class="form-control eb-form-control">
                        <option> 1 Year </option>
                        <option> 2 Year </option>
                        <option> 3 Year </option>
                        <option> 4 Year </option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control eb-form-control select_radius">
                        <option> 1 Year </option>
                        <option> 2 Year </option>
                        <option> 3 Year </option>
                        <option> 4 Year </option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea placeholder="Please explain in detail about your past surgeries so it helps us make customizable solution for you." class="form-control eb-form-control other_reason"></textarea>
                </div>
                <div class="form-group">
                    <div class="file_upload_btn">
                        Upload 
                        <input name="PersonalInstructorCertificates" type="file" multiple=""> 
                    </div>
                    <div class="file_upload_btn2">
                        Upload 
                        <input name="PersonalInstructorCertificates" type="file" multiple=""> 
                    </div>
                </div>
            </div>

            <div class="form_section">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox1">
                    <label class="custom-control-label" for="checkbox1"> Check Box 1 </label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox2">
                    <label class="custom-control-label" for="checkbox2"> Check Box 2 </label>
                </div>

                <div class="custom-control custom-radio mr-4">
                    <input type="radio" class="custom-control-input" id="radio1" name="choice1" required>
                    <label class="custom-control-label" for="radio1"> Radio 1 </label>
                </div>
                <div class="custom-control custom-radio mr-4">
                    <input type="radio" class="custom-control-input" id="radio2" name="choice1" required>
                    <label class="custom-control-label" for="radio2"> Radio 2 </label>
                </div>
            </div>

            <br/>
            <p class="text-white">Go back to <a href="#" class="txt-link">Login</a></p>

            <ul class="social_media">
                <li><a href="#"><img src="<?php echo asset('userassets/images/icons/facebook.jpg') ?>" alt="Facebook"/></a></li>
                <li><a href="#"><img src="<?php echo asset('userassets/images/icons/instagram.png') ?>" alt="Instagram"/></a></li>
                <li><a href="#"><img src="<?php echo asset('userassets/images/icons/twitter.png') ?>" alt="Twitter"/></a></li>
            </ul>
            <ul class="social_media2 mt-3">
                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                <li><a href="#"><i class="fa fa-deviantart"></i></a></li>
            </ul>

            <div class="form_section mt-5">
                <h5 class="mb-3"><strong>Icons</strong></h5>
            </div>
            <span class="icon-calender"></span>
            <span class="icon-calender grey"></span>
            <span class="icon_selected"></span>
            <div class="element-selected d-inline">
                <span class="icon_selected"></span>
            </div>
            <span class="icon-clock"></span>
            <div class="element-selected d-inline">
                <span class="icon-clock"></span>
            </div>

            <span class="icon-sun"></span>
            <span class="icon-cloud"></span>
            <span class="icon-night"></span>
            <span class="icon-money"></span>
            <div class="element-selected d-inline">
                <span class="icon-money"></span>
            </div>
            <span class="icon-star"></span>
            <span class="icon-trainer"></span>
            <span class="icon-groupfitness"></span>
            <span class="icon-groupfitness grey"></span>
            <span class="icon-attachment"></span>
            <span class="icon-submit"></span>
            <span class="arrow-white"></span>
            <span class="arrowback"></span>
            <img src="<?= asset("userassets/images/icons/favicon.png") ?>">
        </div>
        <br/><br/><br/><br/><br/><br/>

        <div class="flash_message" hidden>
            <i class="flash_close">×</i>

            <a href="#">
                <div class="msg_body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="image" style="background-image: url('<?php echo asset('userassets/images/profile-images.jpg'); ?>')"></div>
                        </div>
                        <div>
                            <span class="title">First User</span>
                            <p class="mb-0"> First User sent you message</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="container">
            <div style="overflow:hidden;">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <div id="datetimepicker13"></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#datetimepicker13').datetimepicker({
                            inline: true,
                            sideBySide: true
                        });
                    });
                </script>
            </div>
        </div>


        <?php include resource_path('views/includes/footerassets.php'); ?>
        <script>
            $(function () {
                $('#dateandtime').datetimepicker();
                $('#dateonly').datetimepicker({format: 'LT'});
                $('#timeonly').datetimepicker({format: 'L'});
            });
        </script>
    </body>
</html>
