<?php include resource_path('views/includes/header.php'); ?>


<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">Update your Image and Documents</h4>
            </div>
            <?php if (session()->has('success')) { ?>
                <div class="col-12">
                    <div class="alert alert-success">
                        <strong><i class="fa fa-check"></i> Success!</strong> <?= Session::get('success'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <script>
                    setTimeout(function () {
                        $('.alert').css("display", "none");
                    }, 5000);
                </script>
            <?php } ?>

            <?php if (session()->has('error')) { ?>
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-check"></i> Error !</strong> <?= Session::get('error'); ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                </div> 
            <?php } ?>   
            <div class="col-12">
                <div class="alert alert-danger">
                    The things visible below are those which got disapproved by team ebbsey, please update them
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
            </div>

            <?php if ($errors->any()) { ?>
                <div class="alert-danger alert">
                    <ul>
                        <?php foreach ($errors->all() as $error) { ?>
                            <li><?= $error ?></li>
                        <?php }
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="py-3 px-3" style="background-color: #1b1823">
                    <form id="form" action="<?= asset('update_image_and_documents') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <?php if ($is_image_disapproved) { ?>
                            <div class="form_section">
                                <h5><strong>- Update Profile Picture</strong></h5>
                                <div class="edit_profile_image d-flex align-items-center">
                                    <?php
                                    $user_profile_pic = asset('public/images/users/default.jpg');
                                    if ($current_user->image) {
                                        $user_profile_pic = asset('public/images/' . $current_user->image);
                                    }
                                    ?>
                                    <div class="image_view" id="user_profile_pic_div" style="background-image: url('<?= $user_profile_pic ?>')"></div>
                                    <div class="ml-auto action_btns">
                                        <label class="btn pink" for="user_profile_pic"> Upload Photo </label>
                                        <div class="file_upload_btn2"> 
                                            <input id="user_profile_pic" type="file"> 
                                            <input name="profile_pic" type="text" value="<?= $current_user->image ?>">
                                            <input name="original_image" type="text">
                                        </div>
                                    </div>
                                </div>
                                <label id="profile_pic-error" class="error" for="profile_pic"></label>
                            </div>
                        <?php } ?>
                        <?php if ($dispproved_documents->count()) { ?>
                            <?php foreach ($dispproved_documents as $dispproved_document) { ?>
                                <input type="hidden" name="disapproved_document_ids[]" value="<?= $dispproved_document->id ?>">
                            <?php } ?>
                            <div class="form_section">
                                <h5><strong>- Update Documents</strong></h5>
                                <div id="type_checkboxes" class="row">
                                    <script>
                                        var documents = [];
                                    </script> 
                                    <?php
                                    $training_types = trainingTypes();
                                    $training_types = $training_types['training_types'];
                                    if ($training_types) {
                                        $counter = 1;
                                        foreach ($training_types as $training_type) {
                                            ?>
                                            <?php
                                            $certificates_array = [];
                                            $certificates_string = '';
                                            $cvs_array = [];
                                            $cvs_string = '';
                                            if (in_array($training_type->id, $training_type_ids)) {
                                                $certificates_array = explode(',', $documents[$training_type->id]['certificates']);
                                                $certificates_string = $documents[$training_type->id]['certificates'];
                                                $cvs_array = explode(',', $documents[$training_type->id]['cvs']);
                                                $cvs_string = $documents[$training_type->id]['cvs'];
                                                ?>
                                                <script>
                                                    documents[<?= $counter - 1 ?>] = {'certificates': [], 'certificates_counter': 0, 'cvs': [], 'cvs_counter': 0};
                                                </script>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="trainer_type type_personal_trainer">
                                                        <div class="trainer_header">
                                                            <div class="icon" style="background-image: url(<?= asset('public/images/' . $training_type->image) ?>);"></div>
                                                            <div class="custom-control custom-checkbox"> 
                                                                <input <?= in_array($training_type->id, $training_type_ids) ? 'checked' : '' ?> name="trainer_type[<?= str_replace(' ', '', $training_type->title) ?>]" type="checkbox" value="<?= $training_type->id ?>" class="custom-control-input training_type_checkbox" id="ptt<?= $counter ?>">
                                                                <label class="custom-control-label" <?php // if (!in_array($training_type->id, $training_type_ids)) {    ?> for="ptt<?= $counter ?>" <?php // }    ?>><?= $training_type->title ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="trainer_body">
                                                            <?php if (!empty($documents)) { ?>
                                                                <?php if ($certificates_string) { ?>
                                                                    <div class="upload-documents">
                                                                        <div class="upload-header">
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-12">
                                                                                    <h6><span class="icon-certificate"></span> <strong>Certifications </strong></h6>
                                                                                    <label id="certificates<?= $counter - 1 ?>-error" class="error" for="certificates<?= $counter - 1 ?>"></label>
                                                                                </div>
                                                                                <div class="col-xl-4 col-12">
                                                                                    <div class="file_upload_btn">
                                                                                        Upload 
                                                                                        <input class="file_input" file-category="certificates" training-type-id="<?= $training_type->id ?>" array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                        <input class="file_input_certificates document_input" name="certificates[<?= str_replace(' ', '', $training_type->id) ?>]" id="certificates<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($certificates_string ? $certificates_string : '' ) : '' ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="uploaded_certificates">
                                                                            <ul id="ul_certificates<?= $counter - 1 ?>" class="document_list d-flex flex-wrap">
                                                                                <?php if (!empty($documents)) { ?>
                                                                                    <?php if ($certificates_string) { ?>
                                                                                        <?php foreach ($certificates_array as $certificate) { ?>
                                                                                            <script>
                                                                                                documents[<?= $counter - 1 ?>]['certificates'].push('<?= $certificate ?>');
                                                                                                documents[<?= $counter - 1 ?>]['certificates_counter']++;
                                                                                            </script>
                                                                                            <li>
                                                                                                <?php
                                                                                                $file_image = asset('public/documents/' . $certificate);
                                                                                                $extension = pathinfo($certificate, PATHINFO_EXTENSION);
                                                                                                if ($extension == 'pdf') {
                                                                                                    $file_image = asset('userassets/images/pdf.png');
                                                                                                } else if ($extension == 'docx') {
                                                                                                    $file_image = asset('userassets/images/docx.png');
                                                                                                }
                                                                                                ?>
                                                                                                <div class="thumbnail <?= !in_array($certificate, $disapproved_documents_names) ? 'approved-doc' : '' ?>" style="background-image: url('<?= $file_image ?>')">
                                                                                                    <img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid">
                                                                                                    <div class="actions align-items-center justify-content-center">
                                                                                                        <?php if (in_array($certificate, $disapproved_documents_names)) { ?>
                                                                                                            <i class="fa fa-trash delete_document" path="<?= $certificate ?>" array-counter="<?= $counter - 1 ?>" file-category="certificates"></i>
                                                                                                            <i class="fa fa-download download_document" path="<?= asset('public/documents/' . $certificate) ?>"></i>
                                                                                                        <?php } else { ?>
                                                                                                            <div class="align-items-center flex-column justify-content-center">
                                                                                                                <div>
                                                                                                                    <i class="fa fa-check"></i>
                                                                                                                    <i class="fa fa-download download_document" path="<?= asset('public/documents/' . $certificate) ?>"></i>
                                                                                                                </div>
                                                                                                                <div>Approved</div>
                                                                                                            </div>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if ($cvs_string) { ?>
                                                                    <div class="upload-documents">
                                                                        <div class="upload-header">
                                                                            <div class="row">
                                                                                <div class="col-xl-8 col-12">
                                                                                    <h6><span class="icon-certificate"></span> <strong>CV </strong></h6>
                                                                                    <label id="cvs<?= $counter - 1 ?>-error" class="error" for="cvs<?= $counter - 1 ?>"></label>
                                                                                </div>
                                                                                <div class="col-xl-4 col-12">
                                                                                    <div class="file_upload_btn"> Upload 
                                                                                        <input class="file_input" file-category="cvs" training-type-id="<?= $training_type->id ?>" array-counter="<?= $counter - 1 ?>" type="file" multiple /> 
                                                                                        <input class="file_input_cv document_input" name="cv[<?= str_replace(' ', '', $training_type->id) ?>]" id="cvs<?= $counter - 1 ?>" type="hidden" value="<?= !empty($documents) ? ($cvs_string ? $cvs_string : '' ) : '' ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="uploaded_certificates">
                                                                            <ul id="ul_cvs<?= $counter - 1 ?>" class="document_list d-flex flex-wrap">
                                                                                <?php if (!empty($documents)) { ?>
                                                                                    <?php if ($cvs_string) { ?>
                                                                                        <?php foreach ($cvs_array as $cv) { ?>
                                                                                            <script>
                                                                                                documents[<?= $counter - 1 ?>]['cvs'].push('<?= $cv ?>');
                                                                                                documents[<?= $counter - 1 ?>]['cvs_counter']++;
                                                                                            </script>
                                                                                            <li>
                                                                                                <?php
                                                                                                $file_image = asset('public/images/' . $cv);
                                                                                                $extension = pathinfo($cv, PATHINFO_EXTENSION);
                                                                                                if ($extension == 'pdf') {
                                                                                                    $file_image = asset('userassets/images/pdf.png');
                                                                                                } else if ($extension == 'docx') {
                                                                                                    $file_image = asset('userassets/images/docx.png');
                                                                                                }
                                                                                                ?>
                                                                                                <div class="thumbnail <?= !in_array($cv, $disapproved_documents_names) ? 'approved-doc' : '' ?>" style="background-image: url('<?= $file_image ?>')">
                                                                                                    <img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid">
                                                                                                    <div class="actions align-items-center justify-content-center">
                                                                                                        <?php if (in_array($cv, $disapproved_documents_names)) { ?>
                                                                                                            <i class="fa fa-trash delete_document" path="<?= $cv ?>" array-counter="<?= $counter - 1 ?>" file-category="cvs"></i>
                                                                                                            <i class="fa fa-download download_document" path="<?= asset('public/documents/' . $cv) ?>"></i>
                                                                                                        <?php } else { ?>
                                                                                                            <div class="align-items-center flex-column justify-content-center">
                                                                                                                <div>
                                                                                                                    <i class="fa fa-check"></i>
                                                                                                                    <i class="fa fa-download download_document" path="<?= asset('public/documents/' . $certificate) ?>"></i>                                                                                                                    
                                                                                                                </div>
                                                                                                                <div>Approved</div>
                                                                                                            </div>
                                                                                                        <?php } ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php
                                                $counter++;
                                            }
                                        }
                                    }
                                    ?>
                                </div> <!-- row -->
                            </div> <!-- section -->
                            <div id="training_type_error" class="error text-danger" style="display : none;">You have to choose at least one training type</div>
                        <?php } ?>
                        <?php if ($dispproved_documents->count() || $is_image_disapproved) { ?>
                            <div class="form_section">
                                <button type="submit" class="btn orange btn-lg" /><span class="icon_loading" style="display : none;"></span> Save</button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div> <!--col9 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- wrapper -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>

<script>
    
    $('body').on('change', '.file_input', function () {
        certificatesPreview(this);
    });

    function certificatesPreview(input) {
        var array_counter = $(input).attr('array-counter');
        var file_category = $(input).attr('file-category');
        if (input.files) {
            for (var x = 0; x < input.files.length; x++) {
                var filePath = input.value;
                var filename = input.files[x].name;
                var fileType = filename.replace(/^.*\./, '');
                var validTypes = ["pdf", "docx"];
                if (file_category == 'certificates') {
                    validTypes = ["jpg", "jpeg", "png", "pdf", "docx"];
                }
                if ($.inArray(fileType, validTypes) < 0) {
                    if (file_category == 'certificates') {
                        alert('Please upload file having extensions .jpg/.jpeg/.png/.pdf/.docx only.');
                    } else if (file_category == 'cvs') {
                        alert('Please upload file having extensions .pdf/.docx only.');
                    }
                    $(input).val('');
                    return false;
                }
            }
            if (parseInt(input.files.length) > 5 - documents[array_counter][file_category + '_counter']) {
                alert('You can only upload maximum 5 files');
                $(input).val('');
                return false;
            }
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var data = new FormData();
                data.append('documents', input.files[i]);
                data.append('file_category', file_category);
                documents[array_counter][file_category + '_counter']++;
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_documents'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function (request) {
                        $('#form').find('input[type="submit"]').attr('disabled', '');
                        $('.icon_loading').show();
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (successdata) {
                        $(input).val('');
                        var results = JSON.parse(successdata);
                        let image = results.complete_path;
                        if (results.file_type == 'pdf') {
                            image = 'userassets/images/pdf.png';
                        } else if (results.file_type == 'docx') {
                            image = 'userassets/images/docx.png';
                        }
                        $('ul#ul_' + file_category + array_counter).append(
                                '<li>' +
                                '<div class="image_wrap">' +
                                '<div class="thumbnail" style="background-image: url(\'' + image + '\')">' +
                                '<img src="<?= asset('userassets/images/spacer.png') ?>" class="img-fluid" />' +
                                '<div class="actions align-items-center justify-content-center">' +
                                '<i class="fa fa-trash delete_document" path="' + results.path + '" array-counter="' + array_counter + '" file-category="' + file_category + '"></i>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</li>');
                        documents[array_counter][file_category].push(results.path);
                        $('#' + file_category + array_counter).val(documents[array_counter][file_category]);
                        $('#form').find('input[type="submit"]').removeAttr('disabled');
                        $('.icon_loading').hide();
                    }
                });
            }
        }
    }

    $('body').on('click', '.delete_document', function () {
        var ref = $(this);
        let path = $(this).attr('path');
        let array_counter = $(this).attr('array-counter');
        let file_category = $(this).attr('file-category');
        let index = documents[array_counter][file_category].indexOf(path);
        if (index != -1) {
            $('#' + file_category + array_counter).val('');
            documents[array_counter][file_category].splice(index, 1);
            documents[array_counter][file_category + '_counter']--;
            $('#' + file_category + array_counter).val(documents[array_counter][file_category]);
            ref.parents('li').remove();
        }
    });

    $('body').on('click', '.download_document', function () {
        var url = $(this).attr('path');
        var link = document.createElement('a');
        link.href = url;
        link.download = 'download';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
//        var win = window.open(url, '_blank');
//        win.focus();
    });

    $("#form button[type='submit']").click(function (event) {
        var count = 0;
        var items = document.getElementsByClassName('training_type_checkbox');
        if(items.length > 0){
            for (var i = 0; i < items.length; i++) {
                var name = items[i].name;
                var atLeastOneIsChecked = $('input[name="' + name + '"]:checked').length > 0;
                if (atLeastOneIsChecked === true) {
                    count++;
                }
            }
            if (count === 0) {
                event.preventDefault();
                $("#training_type_error").css("display", "block");
                $("#training_type_error").focus();
            } else {
                $("#training_type_error").css("display", "none");
            }
        }
        $("#form").validate({
            ignore: [],
            rules: {
                profile_pic: {
                    required: true,
                }
            },
            messages: {
                profile_pic: {
                    required: 'You must upload your profile picture'
                }
            }
        });
    });

    $('#form').on('submit', function (event) {
        $('.document_input').each(function () {
            $(this).rules('remove', 'required');
        });
        var certificates = $('.training_type_checkbox:checked').parents('.trainer_type').find('.file_input_certificates');
        $(certificates).each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please upload atleast one certificate"
                }
            });
        });
        var cvs = $('.training_type_checkbox:checked').parents('.trainer_type').find('.file_input_cv');
        $(cvs).each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please upload atleast one cv"
                }
            });
        });
    });

    $('#user_profile_pic').change(handleProfilePicSelect);
    function handleProfilePicSelect(event)
    {
        var input = this;
        var filename = $("#user_profile_pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#user_profile_pic').val('');
            $('input[name="profile_pic"]').val('');
            return;
        }
        var data = new FormData();
        data.append('gallery_images', input.files[0]);
        data.append('is_original_image_required', 1);
        $.ajax({
            type: "POST",
            url: "<?php echo asset('add_gallery_images'); ?>",
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function (request) {
                $('#form').find('input[type="submit"]').attr('disabled', '');
                $('.icon_loading').show();
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if(data.error){
                    alert(data.error);
                } else {
                    $('#user_profile_pic').val('');
                    var results = JSON.parse(data);
                    $('#user_profile_pic_div').css("background-image", "url(" + results.complete_path + ")");
                    $('input[name="profile_pic"]').val(results.path);
                    $('input[name="original_image"]').val(results.original_image_path);
                    $('#form').find('input[type="submit"]').removeAttr('disabled');
                }
                $('.icon_loading').hide();
            }
        });
    }

</script>
</body>
</html>