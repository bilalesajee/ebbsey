
<?php include resource_path('views/includes/header.php'); ?>

<div class="page_overlay full_viewport" style="background-image: url('<?= asset('userassets/images/image14.jpg') ?>')">
    <div class="overlay full_viewport">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 ml-auto mr-auto">
                    <div class="mb-4 text-center">
                        <h4 class="mb-2"><?= $title; ?></h4>
                        <p>Take just a few steps to create your class</p>
                    </div>
                    <form method="post" action="<?= url('create_class'); ?>" id="create_class_form">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="edit_id" value="<?= isset($edit_id) ? $edit_id : '' ?>">

                        <div class="form_section">
                            <h5><strong>- Add a Class</strong></h5>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="class_name" placeholder="Name of class" class="form-control eb-form-control" value="<?= (old('class_name')) ? old('class_name') : (isset($result->class_name) ? $result->class_name : '') ?>" required>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?php $old_val = (old('difficulty_level')) ? old('difficulty_level') : (isset($result->difficulty_level) ? $result->difficulty_level : ''); ?>
                                        <select class="form-control eb-form-control" name="difficulty_level"  required>
                                            <option value="">Difficulty</option>
                                            <option value="easy" <?= ($old_val == 'easy') ? 'selected' : '' ?>>Beginner Level</option>
                                            <option value="medium" <?= ($old_val == 'medium') ? 'selected' : '' ?>>Intermediate Level</option>
                                            <option value="hard" <?= ($old_val == 'hard') ? 'selected' : '' ?>>Advance Level</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select id="class_duration" name="duration" class="form-control eb-form-control">
                                            <option value="" disabled="">Select Duration</option>
                                            <option value="30" <?= (old('duration') && (old('duration') == '30')) ? 'selected' : (isset($result) && $result->duration == '30' ? 'selected' : '') ?>>30 minutes</option>
                                            <option value="45" <?= (old('duration') && (old('duration') == '45')) ? 'selected' : (isset($result) && $result->duration == '45' ? 'selected' : '') ?>>45 minutes</option>
                                            <option value="60" <?= (old('duration') && (old('duration') == '60')) ? 'selected' : (isset($result) && $result->duration == '60' ? 'selected' : '') ?>>60 minutes</option>
                                            <option value="90" <?= (old('duration') && (old('duration') == '90')) ? 'selected' : (isset($result) && $result->duration == '90' ? 'selected' : '') ?>>90 minutes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" name="location" id="autocomplete" value="<?= (old('location')) ? old('location') : (isset($result->location) ? $result->location : '') ?>" placeholder="Address" class="form-control eb-form-control"/>
                                        <input type="hidden" id="lat" name="lat"/>
                                        <input type="hidden" id="lng" name="lng"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" id="administrative_area_level_1" name="state" value="<?= old('result') ?>" placeholder="State" class="form-control eb-form-control"/>
<!--                                        <select name="state" class="form-control eb-form-control">
                                            <option value="" disabled="">Select Location</option>
                                            <option value="maryland" <?= (old('result') && (old('result') == 'maryland')) ? 'selected' : (isset($result->result) && $result->result == 'maryland' ? 'selected' : '') ?>>Maryland</option>
                                            <option value="virginia" <?= (old('result') && (old('result') == 'virginia')) ? 'selected' : (isset($result->result) && $result->result == 'virginia' ? 'selected' : '') ?>>Virginia</option>
                                            <option value="dc" <?= (old('result') && (old('result') == 'dc')) ? 'selected' : (isset($result->result) && $result->result == 'dc' ? 'selected' : '') ?>>DC</option>
                                        </select>-->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="number" id="postal_code" name="postal_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength = "5" value="<?= (old('postal_code')) ? old('postal_code') : (isset($result->postal_code) ? $result->postal_code : '') ?>" placeholder="Postal Code" class="form-control eb-form-control" required="" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?php
                                        $old_val = '';
                                        if (isset($result)) {
                                            $old_val = $result->class_type;
                                        }
                                        ?>
                                        <select class="form-control eb-form-control" name="clas_type" required>
                                            <option disabled="" selected="">Class Type</option>
                                            <?php
                                            if ($class_types) {
                                                foreach ($class_types as $val) {
//                                                    
                                                    ?> 
                                                    <option value="<?= $val->title ?>" <?= ($old_val == $val->title) ? 'selected' : '' ?>><?= ucfirst($val->title) ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="calories" placeholder="Calories" class="form-control eb-form-control" value="<?= (old('calories')) ? old('calories') : (isset($result->calories) ? $result->calories : '') ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="spot" placeholder="Available Spot" class="form-control eb-form-control" value="<?= (old('spot')) ? old('spot') : (isset($result->spot) ? $result->spot : ''); ?>" required>
                                    </div>
                                </div>             
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <input autocomplete="off"  id="date_class_start_set" type="hidden" value="<?= (isset($result->start_date) && $result->start_date != '') ? date('F d, Y', strtotime($result->start_date)) : ''; ?>" />
                                        <input autocomplete="off"  id="date_class_start" data-toggle="datetimepicker" data-target="#date_class_start" type="text" class="form-control  eb-form-control" name="start_date" placeholder="Class Starting From" value="<?= (old('start_date')) ? old('start_date') : (isset($result->start_date) && $result->start_date != '') ? $result->start_date : ''; ?>" required/>
                                        <div>
                                            <label id="start_date-error" class="error" for="start_date" style="display: none">This field is required.</label>
                                        </div>
                                    </div>
                                </div>

                            </div> 
                        </div> 
                        <div class="form_section">
                            <h5><strong>- About the Class</strong></h5>
                            <div class="form-group">
                                <textarea class="form-control eb-form-control other_reason" name="description" placeholder="Please type briefly about your class..." required><?= (old('description')) ? old('description') : (isset($result->description) ? $result->description : '') ?></textarea>
                            </div>
                        </div><!-- form_section --> 
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
                                    <?php if (isset($timetable_array_size) && $timetable_array_size) { ?>
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
                        </div>    

                        <div class="form_section">
                            <div class="label mb-3">
                                <i class="fa fa-image"></i> Select Gallery images 
                            </div>
                            <div class="upload_multiple_photos flex-wrap d-flex align-items-center">
                                <?php
                                $previous_img = isset($result->image_id) ? $result->image_id : '';
                                if ($gallery) {
                                    foreach ($gallery as $value) {
                                        ?>
                                        <div class="image_wrap_outer">
                                            <div class="image_wrap">
                                                <img src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                                <div class="custom-control custom-checkbox">
                                                    <input type="radio" class="custom-control-input" id="checkbox<?= $value->id; ?>"  value="<?= $value->id; ?>" name="gallery_images" <?= ($value->id == $previous_img) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="checkbox<?= $value->id; ?>"></label>
                                                </div>
                                                <div class="image" style="background-image: url('<?= asset('adminassets/images') . '/' . $value->path; ?>')"></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div> <!-- section -->
                        <div class="form_section">
                            <button type="submit" class="btn orange create_class"><span class="btn_loading"></span>Submit Class <span class="arrow"></span></button>
                        </div> <!-- section -->
                    </form>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div><!-- overlay -->
</div>
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

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var fileType = input.files[0]['type'];
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                $('#invalid_img').show();
                $('#invalid_img').html('Invalid image selected');
                return false;
            }
            $('#invalid_img').hide();
            reader.onload = function (e) {
                $('.image_view').css('background-image', 'url(' + e.target.result + ')');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#trainer-images").change(function () {
        readURL(this);
    });
    
    $('#create_class_form').validate({
        rules: {
            class_name: {
                normalizer: function(value) {
                    return $.trim(value);
                },
                alphanumeric: true
            },
            location: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            state: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            postal_code: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            calories: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            spot: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            start_date: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            },
            description: {
                normalizer: function(value) {
                    return $.trim(value);
                },
            }
        },
        submitHandler: function (e) {
            $form = $('.create_class').parents('form');
            console.log($form);
            $button = $('.create_class');
//            if ($form.valid()) {
                $button.find('.btn_loading').addClass('icon_loading');
                var formData = new FormData($form[0]);
                $.ajax({
                    type: "POST",
                    url: $form.attr('action'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('.custom_alert').show();
                        if (data.success) {
                            $('.custom_alert').removeClass('alert-danger');
                            $('.custom_alert').addClass('alert-success');
                            $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                            $form[0].reset();
                            setTimeout(function () {
                                window.location.href = base_url + 'classes';
                            }, 2000);
                        } else {
                            $('.custom_alert').removeClass('alert-success');
                            $('.custom_alert').addClass('alert-danger');
                            $('.alert-content').html('<strong><i class="fa fa-info-circle"></i> Error! </strong>' + data.message);
                        }
                        $button.find('.btn_loading').removeClass('icon_loading');
                        $('html').animate({scrollTop: 0}, 1000);
                    }
                });
//            } else {
//                $('html').animate({scrollTop: 0}, 1000);
//            }
        }
    });
            
//    $('body').on('click', '.create_class', function (e) {
//        $form = $(this).parents('form');
//        console.log($form);
//        $button = $(this);
//        var validator = $($form).validate();
//        if ($form.valid()) {
//            $button.find('.btn_loading').addClass('icon_loading');
//            var formData = new FormData($form[0]);
//            $.ajax({
//                type: "POST",
//                url: $form.attr('action'),
//                data: formData,
//                dataType: 'json',
//                cache: false,
//                contentType: false,
//                processData: false,
//                success: function (data) {
//                    $('.custom_alert').show();
//                    if (data.success) {
//                        $('.custom_alert').removeClass('alert-danger');
//                        $('.custom_alert').addClass('alert-success');
//                        $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
//                        $form[0].reset();
//                        setTimeout(function () {
//                            window.location.href = base_url + 'classes';
//                        }, 2000);
//                    } else {
//                        $('.custom_alert').removeClass('alert-success');
//                        $('.custom_alert').addClass('alert-danger');
//                        $('.alert-content').html('<strong><i class="fa fa-info-circle"></i> Error! </strong>' + data.message);
//                    }
//                    $button.find('.btn_loading').removeClass('icon_loading');
//                    $('html').animate({scrollTop: 0}, 1000);
//                }
//            });
//        } else {
//            $('html').animate({scrollTop: 0}, 1000);
//        }
//    });

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

//            var currentMonthTimePicker = monthNamesTimepicker[new Date().getMonth()];
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
            let class_duration = $('#class_duration').val();
            $.ajax({
                url: "<?php echo asset('validate_timetable_slot'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {'times': times, 'selected_value': selected_value, 'day_name': day_name, 'type': 'class', 'class_duration': class_duration},
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
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete, location_autocom;
    var componentForm = {
        administrative_area_level_1: 'short_name'
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
</script>

<script type="text/javascript">
    $(function () {
        var startdate = moment();
        startdate = startdate.subtract(1, "days");
        $('#date_class_start').datetimepicker({
            format: 'MMMM DD, YYYY',
            pickTime: false,
            minDate: startdate,
        });
        var set_Date = $('#date_class_start_set').val();
        if (typeof set_Date != 'undefined') {
            $('#date_class_start').datetimepicker({
                setDate: set_Date
            });
        }

        $("#date_class_start").on("change.datetimepicker", function (e) {
            $('#date_class_end').datetimepicker('minDate', e.date);
        });
        $("#date_class_end").on("change.datetimepicker", function (e) {
            $('#date_class_start').datetimepicker('maxDate', e.date);
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_API_KEY') ?>&libraries=places&callback=initAutocomplete"
async defer></script>
</body>
</html>