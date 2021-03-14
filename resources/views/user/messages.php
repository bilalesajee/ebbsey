<?php include resource_path('views/includes/header.php'); ?>
<div class="page_overlay messages_page" style="background-image: url('<?= asset('userassets/images/image14.jpg') ?>')">
    <div class="overlay pt-4 pb-3">
        <div class="container">
            <div class="messages_wrap">
                <div class="row no-gutters position-relative">
                    <?php if (!$chats->isEmpty()) { ?>
                        <div class="col-md-4 col-12">
                            <div class="message_userlist_wrap">
                                <div class="search_field search_result dark">
                                    <input id="filter_chat_users" type="text" placeholder="SEARCH MESSAGES" class="form-control eb-form-control" />
                                    <i class="fa fa-search"></i>
                                    <i class="fa fa-times-circle"></i>
                                </div>
                                <div class="chat_user_list_wrap">
                                    <ul id="chat_user_filter_listing" class="chat_user_list">
                                        <?php
                                        $count_to_active = 0;
                                        foreach ($chats as $chat) {
                                            $count_to_active++;
                                            $other_user = $chat->receiver;
                                            if ($chat->sender_id != $current_id) {
                                                $other_user = $chat->sender;
                                            }
                                            ?>
                                            <li class="chat_user_listing <?php if ($count_to_active == 1) { ?> active <?php } ?>">
                                                <a href="#" class="d-flex align-items-center" id="chat_id_<?= $chat->id ?>" onclick="getOtherChat('chat_id_<?= $chat->id ?>', this, '<?= $chat->id ?>', '<?= $other_user->first_name . ' ' . $other_user->last_name ?>', '<?= $other_user->id ?>')">
                                                    <div class="image">
                                                        <div class="img" style="background-image: url(<?php echo getUserImage($other_user->image); ?>);"></div>
                                                    </div>
                                                    <div class="desc">
                                                        <h6><?= $other_user->first_name . ' ' . $other_user->last_name ?> <span class="time"><?= timeago($chat->lastMessage->created_at) ?></span></h6>
                                                        <p><?= strlen($chat->lastMessage->message) > 60 ? substr($chat->lastMessage->message, 0, 60) . '...' : $chat->lastMessage->message ?> </p>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div style="display: none" id="chat_user_listing" class="loader_absolute">
                                    <div class="inner d-flex align-items-center justify-content-center">
                                        <div class="icon_loader"></div>
                                    </div>
                                </div>
                            </div> <!-- message_userlist_wrap -->
                        </div> <!-- col -->
                        <div class="col-md-8 col-12">
                            <div class="message_chat_wrap">
                                <?php
                                if ($chat_single) {
                                    $other_user_display = $chat_single->receiver;
                                    if ($chat_single->sender_id != $current_id) {
                                        $other_user_display = $chat_single->sender;
                                    }
                                    ?>
                                    <input type="hidden" id="other_user_id" value="<?= $other_user_display->id ?>">
                                <?php } ?>
                                <div class="active_user">
                                    <div class="chat_head d-flex justify-content-center align-items-center">
                                        <span class="arrowback"></span>
                                        <span id="active_user_name" class="name ml-auto"><?= $chat_single ? $other_user_display->first_name . ' ' . $other_user_display->last_name : '' ?></span>
                                        <div class="dropdown action_dropdown ml-auto">
                                            <!--                                    <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                                                                                    <i class="fa fa-ellipsis-h"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu custom_drop_down dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                                    <a href="#">Delete</a>
                                                                                </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="active_chatBox">
                                    <ul class="chat_list" id="chat_list">
                                        <?php if ($chat_single) { ?>
                                            <?php
                                            foreach ($chat_single->messages as $chat_messages) {
                                                if ($chat_messages->message) {
                                                    ?>
                                                    <li <?php if ($chat_messages->sender_id == $current_id) { ?> class="right" <?php } ?> >
                                                        <div class="d-flex align-items-center <?php if ($chat_messages->sender_id == $current_id) { ?> flex-row-reverse <?php } ?>">
                                                            <div class="profile_image">
                                                                <div class="img" style="background-image: url(<?php echo getUserImage($chat_messages->sender->image); ?>);"></div>
                                                            </div>
                                                            <div class="chat_body">
                                                                <div class="text">
                                                                    <?= $chat_messages->message ?>
                                                                </div>
                                                                <div class="send_time text-right"><?= timeago($chat_messages->created_at) ?></div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } if ($chat_messages->file_path) { ?>
                                                    <li <?php if ($chat_messages->sender_id == $current_id) { ?> class="right" <?php } ?> >
                                                        <div class="d-flex align-items-center <?php if ($chat_messages->sender_id == $current_id) { ?> flex-row-reverse <?php } ?>">
                                                            <div class="profile_image">
                                                                <div class="img" style="background-image: url(<?php echo getUserImage($chat_messages->sender->image); ?>);"></div>
                                                            </div>
                                                            <div class="chat_body">
                                                                <div class="text">
                                                                    <div class="uploaded_image">
                                                                        <?php if ($chat_messages->file_type == 'image') { ?>
                                                                            <a class="fancybox" href="<?php echo asset('public/images/' . $chat_messages->file_path); ?>">
                                                                                <img src="<?php echo asset('public/images/' . $chat_messages->file_path); ?>" alt="" />
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <video controls src="<?php echo asset('public/videos/' . $chat_messages->file_path); ?>" ></video> 
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="send_time text-right"><?= timeago($chat_messages->created_at) ?></div>
                                                            </div>
                                                        </div>                                       
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="chat_textbox">
                                    <div class="files_upload_box tiny-div" style="display: none">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="uploaded_file">
                                                <div class="icon-close">
                                                    <span>×</span>
                                                </div>
                                                <img id="tiny-icon-spacer"  src="<?php echo asset('userassets/images/spacer.png'); ?>" class="spacer" />
                                                <div id="tiny-icon" class="image"></div>
                                                <video id="tiny-video" src="<?php echo asset('userassets/videos/vid.mp4'); ?>" class="video"></video>
                                                <div style="display: none" id="attachment_loader" class="loader_absolute">
                                                    <div class="inner d-flex align-items-center justify-content-center">
                                                        <div class="icon_loader"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="send_message_form" style="display: none;">
                                        <textarea id="chat_message" class="form-control eb-form-control" placeholder="Write new message"></textarea>
                                        <div class="btns d-flex">
                                            <div class="file_attachment">
                                                <input type="file" id="attachment"/>
                                                <span class="icon-attachment"></span>
                                            </div>
                                            <span onclick="sendMessage()" id="save_chat_message" class="icon-submit"></span>
                                        </div>
                                    </form>
                                </div>
                                <div id="chat_loader" style="display: none" class="loader_absolute">
                                    <div class="inner d-flex align-items-center justify-content-center">
                                        <div class="icon_loader"></div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-12 pt-3 text-center my-5">
                                    <p>No Message Found!</p>
                                </div>
                            <?php } ?>
                        </div><!-- message_userlist_wrap -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- messages_wrap -->
        </div><!-- container -->
    </div><!-- overlay -->
</div><!-- image_overlay -->
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    jQuery(document).ready(function () {
        jQuery('.fancybox').fancybox();
    });
    $('.chat_user_list li a').click(function () {
        $('.messages_wrap').addClass('active_user_mobile');
    });
    $('.arrowback').click(function () {
        $('.messages_wrap').removeClass('active_user_mobile');
    });
    function chatHeight() {
        var window_height = window.innerHeight;
        var window_width = window.innerWidth;
        if ($('.messages_wrap').length > 0) {
            if (window_width > 767) {

                var message_offset_top = ($('.messages_wrap').offset().top + 16);
                var chat_head = $('.chat_head').innerHeight();
                var chat_textbox = $('#send_message_form').innerHeight();
                var chat_user_list_height = (window_height - message_offset_top - chat_head);
                var chat_user_box_height = (window_height - message_offset_top - chat_head - chat_textbox);

                $('.chat_user_list_wrap').height(chat_user_list_height);
                $('.active_chatBox').height(chat_user_box_height);
            }
        }

    }
    chatHeight();

    $(window).resize(function () {
        chatHeight();
    });


    var files;
<?php if ($chat_single) { ?>
        var receiver_id = '<?= $other_user_display->id ?>';
<?php } ?>

    $('.icon-close').click(function (e) {
        e.preventDefault();

        $('.tiny-div, .upload_file_loader').hide();
        $("#tiny-video").attr("src", '');
        $("#tiny-icon").attr("src", '');

        $("#tiny-video").hide();
        $("#tiny-icon").hide();

        $("#attachment").val('');
        files = '';
    });
    $("#attachment").change(function () {
        var fileInput = document.getElementById('attachment');
        var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
        var image_type = fileInput.files[0].type;

        if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
            $('.tiny-div').show();
            var file = fileInput.files[0];
            var reader = new FileReader();
            reader.onloadend = function (e) {
                $("#tiny-video").attr("src", '');
                $("#tiny-video").hide();
                $("#tiny-icon").show();
                $("#tiny-icon-spacer").show();
                $("#tiny-icon").css({"backgroundImage": 'url(' + e.target.result + ')'});

            };
            reader.readAsDataURL(file);

        } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {

            $("#tiny-video").show();
            $("#tiny-icon").hide();
            $("#tiny-icon-spacer").hide();
            $("#tiny-icon").css({"backgroundImage": 'url()'});
            $("#tiny-video").attr("src", fileUrl);
            var myVideo = document.getElementById("tiny-video");
            myVideo.addEventListener("loadedmetadata", function ()
            {
                $('.tiny-div').show();
                duration = (Math.round(myVideo.duration * 100) / 100);
                if (duration >= 21) {
                    $('.custom_alert').removeClass('alert-success');
                    $('.custom_alert').addClass('alert-danger');
                    $('.alert-content').html('Video is greater than 20 sec');
                    $('.custom_alert').fadeIn();

                    setTimeout(function () {
                        $('.custom_alert').fadeOut();
                    }, 5000);

//                    $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Video is greater than 20 sec.').show().fadeOut(5000);

                    $("#tiny-video").attr("src", '');
                    $('.tiny-div').hide();
                }
            });
            $("#tiny-icon").attr("src", '');
            $("#tiny-icon").hide();
        } else {
            files = '';
            $('.custom_alert').removeClass('alert-success');
            $('.custom_alert').addClass('alert-danger');
            $('.alert-content').html('Please image or video only');
            $('.custom_alert').fadeIn();

            setTimeout(function () {
                $('.custom_alert').fadeOut();
            }, 5000);

//            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image or video').show().fadeOut(5000);
            $("#tiny-icon").hide();
            $(".tiny-div").hide();
        }
    });
    function getOtherChat(id, ele, chat_id, other_name, other_id) {
        receiver_id = other_id;
        verifyMessageRequest();
        if ($(ele).parents('.active').length) {

        } else {
            $('.chat_user_listing').removeClass('active');
            $(ele).closest('li').addClass('active');
            $('#chat_list').html('');
            $('#chat_loader').show();
            $('#other_user_id').val(other_id);
            $.ajax({
                type: "GET",
                data: {"chat_id": chat_id},
                async: false,
                url: "<?php echo asset('get_chat_data'); ?>",
                success: function (data) {
                    $('#chat_list').append(data);
                    $('#active_user_name').html(other_name);
                    setTimeout(function () {
                        $('#chat_loader').hide();
                        $('.active_chatBox').mCustomScrollbar("scrollTo", 'bottom');
                    }, 5000);

//                    setTimeout(function () {
//                        $('#chat_loader').hide();
//                        $('.active_chatBox').mCustomScrollbar(
//                                'scrollTo', 'bottom',
//                                {
//                                    callbacks: {
//                                        onUpdate: function () {
//                                            console.log("Scrollbars updated");
//                                        }
//                                    }
//                                }
//                        );
//                    }, 1000);
                }
            });
        }
    }
    $('#chat_message').keypress(function (e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
//            e.stopPropagation();
        }
    });
    function sendMessage() {
        $('#save_chat_message').css("pointer-events", "none");
        var otherid = $('#other_user_id').val();
        var message = $('#chat_message').val();
        $('#chat_message').val('');
        if (message || files) {
            if (files) {
                $('#attachment_loader').show();
            }
            var data = new FormData();
            $.each(files, function (key, value)
            {
                data.append('file', value);
            });
            data.append('message', message);
            data.append('receiver_id', otherid);
            data.append('_token', '<?= csrf_token() ?>');
            $("#attachment").val('');
            $('#attachment').attr('src', "");

            $.ajax({
                type: "POST",
                url: "<?php echo asset('add_message'); ?>",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    files = '';
                    $('.tiny-div').hide();
                    if (data) {
                        $('#attachment_loader').hide();
                        $('#tiny-video').attr('src', "");
                        $('#tiny-icon').attr('src', "");
                        result = JSON.parse(data);
                        let unread_counter = result.unread_counter;
                        result = result.message;
                        $('#chat_list').append(result.append);
                        str = result.append.replace('flex-row-reverse', '');
                        socket.emit('message_get', {
                            "user_id": otherid,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '',
                            "text": str.replace('class="right"', '')
                        });
                        socket.emit('notification_get', {
                            "user_id": otherid,
                            "other_id": '<?= $current_id ?>',
                            "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                            "photo": '<?= $current_photo ?>',
                            "text": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>' + ' sent you a message',
                            "url": '<?= asset('messages') ?>',
                            "type": 'message',
                            "unread_counter": unread_counter
                        });
                        $('.active_chatBox').mCustomScrollbar("scrollTo", 'bottom');
                    }
                    $('#save_chat_message').css("pointer-events", "auto");
                }
            });
        }
    }
    socket.on('message_send', function (data) {
        current_id = '<?php echo $current_id; ?>';
        var otherid = $('#other_user_id').val();
        if (data.user_id == current_id && otherid == data.other_id) {
            $('#chat_list').append(data.text);
        }
        $('.active_chatBox').mCustomScrollbar("scrollTo", 'bottom');
    });

    $('#attachment').on('change', prepareUpload);
    function prepareUpload(event)
    {

        files = event.target.files;

        var input = document.getElementById('attachment');
        var filePath = input.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.ogv)$/i;
        if (!allowedExtensions.exec(filePath)) {
            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image or video').show().fadeOut(5000);
            $('#attachment').val('');
            $('#imagePreview').html('');
            $('.tiny-div').hide();
            files = '';
            return false;
        }
    }

    $(document).ready(function () {
        $("#filter_chat_users").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#chat_user_filter_listing li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        verifyMessageRequest();
        $('.active_chatBox').mCustomScrollbar("scrollTo", 'bottom');
    });

    function verifyMessageRequest() {
        $.ajax({
            type: "POST",
            url: "<?php echo asset('verify_message_request'); ?>",
            data: {'id': receiver_id},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    $('#send_message_form').show();
                } else {
                    $('#send_message_form').hide();
                }
            }
        });
    }
</script>
</body>
</html>