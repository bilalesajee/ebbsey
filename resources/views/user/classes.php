<?php include resource_path('views/includes/header.php'); ?>
<div class="sticky_notification">
    <div class="alert alert-success custom_alert" style="display: none">
        <div class="alert-content">            
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>        
    </div>
</div>
<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">CLASSES</h4>
                <div class="title_bar"> All Classes </div>
            </div>
        </div>
        <div class="row align-items-center mb-3">
            <div class="col-lg-9 col-md-8">
                <form name="<?= url('classes') ?>" class="d-flex">
                    <div class="search_append_btn">
                        <div class="search_field w-100">
                            <input type="text" class="form-control eb-form-control" placeholder="SEARCH" name="search" value="<?= (isset($_GET['search']) ? $_GET['search'] : '') ?>">
                            <i class="fa fa-search"></i>
                        </div>
                        <button type="submit" class="btn h-100 mx-auto orange"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="d-flex">
                    <?php if (hasRights($current_user->id, 1)) { ?>
                        <a href="<?= url('create_class'); ?>" class="btn orange small ml-md-auto btn_create_class">CREATE NEW CLASS</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <ul class="classes_listing trainer">
            <?php
            if ($result && count($result) > 0) {
                foreach ($result as $value) {
                    ?>

                    <li class="row no-gutters" id="row_<?= $value->id ?>">
                        <?php if (isset($value->getImage->path) && $value->getImage->path != '') { ?>
                            <div class="col-lg-3 class-image" style="background-image: url(<?= asset('adminassets/images/' . $value->getImage->path) ?>"></div>
                        <?php } else { ?>
                            <div class="col-lg-3 class-image" style="background-image: url(<?= asset('userassets/images/classes/default.png'); ?>)"></div>
                        <?php } ?>
                        <div class="col-lg-9">
                            <div class="class-detail">
                                <div class="class-head">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <h4><a href="<?= asset('class-view/' . $value->id) ?>" class="text-white"><?= $value->class_name; ?></a></h4>
                                            <div class="trainer_type d-flex">
                                                <div class="align-items-center"><span class="icon-trainer"></span>Certified Personal Trainer</div>
                                                <div class="align-items-center"><span class="icon-groupfitness"></span>Group Fitness Instructor</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 d-lg-block d-none">
                                            <div class="btns-group d-flex"> 
                                                    <a href="<?= url('create_class') . '/' . $value->id; ?>" class="btn btn-outline"> Edit </a>
                                               
                                                <a href="javascript:void(0)" data-id="<?= $value->id ?>" class="btn btn-outline del_clas"> Delete </a>
                                                <a href="<?= url('class-view/' . $value->id) ?>" class="btn btn-outline"> View </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 flex-column w-100 d-flex align-self-center">
                                        <div class="row">
                                            <div class="col-sm-3 col-6 mb-2">
                                                <div><strong class="text-orange">Type</strong></div>
                                                <div><?php echo $value->class_type ?></div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <strong class="text-orange">Difficulty</strong>
                                                <div> 
                                                <?php
                            if ($value->difficulty_level) {
                                if ($value->difficulty_level == 'easy') {
                                    echo 'Beginner Level';
                                } else if ($value->difficulty_level == 'medium') {
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
                                            <div class="col-sm-3 col-6">
                                                <strong class="text-orange">Calories</strong>
                                                <div><?= $value->calories ?></div>
                                            </div>

                                            <div class="col-sm-3 col-6">
                                                <strong class="text-orange">Spots</strong>
                                                <div><?= $value->spot ?></div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3 col-6">
                                                <strong class="text-orange">Start date</strong>
                                                <div><?= date('F d, Y', strtotime($value->start_date)) ?></div>
                                            </div>  
                                            <div class="col-sm-6">
                                                <strong class="text-orange">Location</strong>
                                                <div><?= $value->state ?></div>
                                            </div> 
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-8">
                                        <div class="short-desc">
                                            <strong class="text-orange">Description</strong>
                                            <p><?php echo (strlen($value->description) > 100) ? substr($value->description, 0, 170) . '...' : $value->description; ?></p> 
                                        </div>
                                    </div> <!-- col -->
                                    <div class="col-lg-4">
                                        <div class="class-time">
                                            <h6>Class schedule</h6>
                                            <div class="schedule">
                                                <?php
                                                $count_time_cls = 0;
                                                if ($value->classTimetable && count($value->classTimetable) > 0) {
                                                    foreach ($value->classTimetable as $value) {
                                                        if ($count_time_cls > 0)
                                                            break;
                                                        ?>
                                                        <div class="d-flex">
                                                            <div class="day"><?= ucfirst($value->day) ?></div>
                                                            <div class="time"><span><?= $value->start_time ?> - <?= $value->end_time ?></span></div>
                                                        </div> 

                                                        <?php
                                                        $count_time_cls++;
                                                    }
                                                }
                                                ?>
                                            </div> 
                                            <!-- schedule -->
                                        </div><!-- class time -->
                                    </div> <!--col -->
                                    <!-- button just for small screens -->
                                    <div class="col-12 d-block d-lg-none">
                                        <div class="btns-group d-flex">
                                            <a href="<?= url('create_class') . '/' . $value->id; ?>" class="btn btn-outline"> Edit </a>
                                            <a href="javascript:void(0)" data-id="<?= $value->id ?>" class="btn btn-outline del_clas"> Delete</a>
                                            <a href="<?= url('class-view/' . $value->id) ?>" class="btn btn-outline"> View </a>
                                        </div>
                                    </div>
                                    <!-- button just for small screens -->
                                </div>
                            </div>
                        </div>
                    </li><!-- list item -->
                    <?php
                }
            } else {
                ?>
                <li class="text-center pt-2 pb-2">
                    No result found
                </li>
            <?php }
            ?>
        </ul> <!-- ul -->
        <?= $result->links() ?>
    </div><!-- container -->
</div><!-- overlay -->
</div><!-- image_overlay -->        

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $('body').on('click', '.del_clas', function () {
        var id = $(this).attr('data-id');
        $('#comfirm_message').html('Are you sure to delete?');
        $('#confirm_box').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function (e) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "/delete_item",
                        data: {id: id, 'table': 'class'},
                        dataType: 'json',
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (data) {
                            $('.custom_alert').show();
                            if (data.success) {
                                $('.custom_alert').removeClass('alert-danger');
                                $('.custom_alert').addClass('alert-success');
                                $('.alert-content').html('<strong><i class="fa fa-check"></i> Success! </strong>' + data.message);
                                $('#row_' + id).remove();
                                setTimeout(function(){
                                    window.location.reload();
                                },2000);
                            } else {
                                $('.custom_alert').removeClass('alert-success');
                                $('.custom_alert').addClass('alert-danger');
                                $('.alert-content').html('<strong><i class="fa fa-info-circle"></i> Error!</strong>' + data.message);
                            }
                        },
                        error: function (data) {

                            $('.custom_alert').show();
                            var response = $.parseJSON(data.responseText);
                            $(".custom_alert").addClass("alert-danger");
                            $(".custom_alert").removeClass("alert-success");
                            $(".custom_alert").html(response.errorMessage);
                        }
                    });
                });
    });
</script>
</body>
</html>