<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small>Ebbsey</small>
                        Class Gallery
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content clearfix">
                    <form action="<?= asset('add_image') ?>" method="post" enctype="multipart/form-data">
                        <?php if (Session::has('success')) { ?>
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('success') ?>
                            </div>
                        <?php } ?>
                        <?php if (Session::has('error')) { ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('error') ?>
                            </div>
                        <?php } ?>
                        <?php if ($errors->any()) { ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors->all() as $error) { ?>
                                        <li><?= $error ?></li>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <div class="medias editmedia clearfix" id="medas">
                            <ul id="uploadimages" class="clearfix" style="margin : 0">
                                <?php
                                if (!$gallery_images->isEmpty()) {
                                    foreach ($gallery_images as $gallery_image) {
                                        ?>
                                        <li class="image_li row_<?= $gallery_image->id ?>">
                                            <div class="image_wrap">
                                                <div class="image" style="background-image:url('<?= asset('adminassets/images/' . $gallery_image->thumbnail_path) ?>')"></div>
                                                <img src="<?= asset('adminassets/images/spacer.png') ?>" alt="" class="spacer" />
                                                <a href="javascript:void(0)" data-id ="<?= $gallery_image->id ?>" data-img-name="<?= $gallery_image->path; ?>" class="remove remove_media"><img src="<?php echo asset('adminassets/images/deleteicon.png') ?>"/></a>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <li id="uploader">
                                    <img src="<?= asset('adminassets/images/spacer.png') ?>" alt="" class="spacer" />
                                    <div class="form-group uploading" style="margin : 0">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                        <label for="mediasupload" class="uploadssmedia"><img src="<?php echo asset('adminassets/images/addbtn.png'); ?>"/></label>
                                        <input type="file" class="mediasupload" id="mediasupload" name="mediafiles[]" multiple style="display: none;">
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div style="margin-top: 20px;">
                            <button type="submit" class="gallery hide btn btn-primary">Save</button>
                            <a href="<?= asset('class_gallery') ?>" id="cancel_btn" class="gallery hide btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </section> 
            </div>
        </div>
        <script>
            /*********** Add Media ****************/
            $(".uploadssmedia").click(function () {
                $("#uploader").hide();
                $(".remove_media").hide();
                $(".gallery").removeClass("hide");
                var filterVal = 'blur(3px)';
                $('.image_li')
                        .css('filter', filterVal)
                        .css('webkitFilter', filterVal)
                        .css('mozFilter', filterVal)
                        .css('oFilter', filterVal)
                        .css('msFilter', filterVal);
            });
            if (window.File && window.FileList && window.FileReader) {
                $("#mediasupload").on("change", function (e) {
                    var files = e.target.files,
                            filesLength = files.length;
                    var images_count = $("#uploadimages").children().length;
                    filesLength_final = filesLength + images_count;
                    //                    alert(filesLength_final);
                    if (filesLength_final > 20) {
                        alert("You can add only 20 images!");
                    } else {
                        var myFile = $('#mediasupload').prop('files');
                        //                    console.log("sdfsd"+$("#uploadimages").children().length);
                        //                    console.log(filesLength);

                        for (var i = 0; i < filesLength; i++) {
                            var f = files[i];
                            console.log(f);
                            var fileReader = new FileReader();
                            fileReader.onload = (function (e) {
                                var file = e.target;
                                console.log($("#uploadimages"));
                                $("#uploadimages").append('<li><div class="image_wrap"><div class="image" style="background-image:url(' + e.target.result + ')">' +
                                        '</div><img src="<?= asset('adminassets/images/spacer.png') ?>" alt="" class="spacer" /></div></li>');
                                $(".remove_media").click(function () {
                                    $(this).parent().remove();
                                });
                            });
                            fileReader.readAsDataURL(f);
                        }
                    }
                });
            } else {
                alert("Your browser doesn't support to File API");
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#output').css('background-image', 'url(' + e.target.result + ')');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#upload").change(function () {
                readURL(this);
            });
            /*********** Add Media ****************/
            /*********** Delete Media ****************/
            $('body').on('click', '.remove_media', function () {
                var id = $(this).attr('data-id');
                var img_name = $(this).attr('data-img-name');

                $('.confirm_message').html('Are you sure to delete this?');
                $('#confirmModal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).one('click', '#delete', function (e) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "delete_image",
                        data: {'id': id, image_name: img_name},
                        beforeSend: function (request) {
                            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                        },
                        success: function (data) {
                            $('.row_' + id).remove();
                        }
                    });

                });
            });
            /*********** Delete Media ****************/
        </script>
        <?php include 'includes/footer_dashboard.php'; ?>
    </div>
</body>
</html>
