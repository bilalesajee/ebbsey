<script src="<?= asset("userassets/js/jquery.mCustomScrollbar.concat.min.js") ?>"></script>
<script src="<?= asset("userassets/js/popper.min.js") ?>"></script>
<script src="<?= asset("userassets/js/moment-with-locales.min.js") ?>"></script>
<script src="<?= asset("userassets/js/tempusdominus-bootstrap-4.js") ?>"></script>
<script src="<?= asset("userassets/js/owl.carousel.min.js") ?>"></script>
<script src="<?= asset("userassets/js/bootstrap.min.js") ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="<?= asset('userassets/js/jquery.validate.js') ?>"></script>
<script src="<?= asset('userassets/js/additional-methods.js') ?>"></script>
<script src="<?= asset('userassets/js/jquery.validate.min.js') ?>"></script>
<script src="<?= asset('userassets/js/additional-methods.min.js') ?>"></script>
<script src="<?= asset('userassets/js/phone-mask.js'); ?>"></script>
<script src="<?= asset('userassets/js/jquery.fancybox.js'); ?>"></script>
<script src="<?= asset("userassets/js/form_validation.js") ?>"></script>
<script src="<?php echo asset('public/js/phone-mask.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js"></script>

<script src="<?= asset("userassets/js/customScripts.js") ?>"></script>

<script>
    function readMessage(css_class) {
        $('.' + css_class).html('');
        $('.' + css_class).hide;
        $.ajax({
            type: "GET",
            url: "<?php echo asset('read_messages'); ?>"
        });
    }

    function makeAppointmentsSeenForTrainer(css_class) {
        $('.' + css_class).html('');
        $('.' + css_class).hide;
        $.ajax({
            type: "GET",
            url: "<?php echo asset('make_appointments_seen_for_trainer'); ?>"
        });
    }

    $(function () {
        $(".phonemask").mask("(999) 999-9999");
        $(".phonemask").on("blur", function () {
            var last = $(this).val().substr($(this).val().indexOf("-") + 1);
            if (last.length == 5) {
                var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                var lastfour = last.substr(1, 4);
                var first = $(this).val().substr(0, 9);
                $(this).val(first + move + '-' + lastfour);
            }
        });
    });

<?php if (Auth::user()) { ?>
        function openMessageModal(id) {
            $.ajax({
                type: "POST",
                url: "<?php echo asset('verify_message_request'); ?>",
                data: {'id': id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    if (data.success) {
                        $('#send_message_modal').find('.message_modal_success_div').show();
                        $('#send_message_modal').find('.message_modal_error_div').hide();
                        $('#send_message_modal').find('.message_modal_error_div').html('');
                        $('#send_message_modal').find('.modal-footer').show();
                        $('#send_message_modal_other_user_id').val(id);
                        $('#send_message_modal').modal('show');
                    } else {
                        $('#send_message_modal').find('.message_modal_success_div').hide();
                        $('#send_message_modal').find('.modal-footer').hide();
                        $('#send_message_modal').find('.message_modal_error_div').show();
                        $('#send_message_modal').find('.message_modal_error_div').html('<p>' + data.error + '</p>');
                        $('#send_message_modal_other_user_id').val('');
                        $('#send_message_modal').modal('show');
                    }
                }
            });
        }
        $('#send_message_textarea').keypress(function (e) {
            if (e.which === 13) {
                sendMessageModal();
            }
        });
        function sendMessageModal() {

            var otherid = $('#send_message_modal_other_user_id').val();
            var message = $('#send_message_modal_textarea').val();
            var message_length = message.replace(/\s/g, '').length;
            $('#send_message_modal_textarea').val('');
            
            if (message_length > 0) {
                var data = new FormData();
                data.append('message', message);
                data.append('receiver_id', otherid);
                data.append('_token', '<?= csrf_token() ?>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_message'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data) {
                            result = JSON.parse(data);
                            let unread_counter = result.unread_counter;
                            result = result.message;
                            $('#chat_list').append(result.append);
                            str = result.append.replace('flex-row-reverse', '');
                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?= isset($current_id) ? $current_id : '' ?>',
                                "other_name": '<?= isset($current_user) ? $current_user->first_name . ' ' . $current_user->last_name : '' ?>',
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
                        }
                        $('#send_message_modal').modal('hide');
                    }
                });
            }
        }
        
        function generateThread(otherid) {

                var data = new FormData();
                data.append('message', 'Hey ,Your appointment has been scheduled with me. <br/>If you have questions you can contact me.');
                data.append('receiver_id', otherid);
                data.append('_token', '<?= csrf_token() ?>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_message'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data) {
                            result = JSON.parse(data);
                            let unread_counter = result.unread_counter;
                            result = result.message;
                            $('#chat_list').append(result.append);
                            str = result.append.replace('flex-row-reverse', '');
                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?= isset($current_id) ? $current_id : '' ?>',
                                "other_name": '<?= isset($current_user) ? $current_user->first_name . ' ' . $current_user->last_name : '' ?>',
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
                        }
                        $('#send_message_modal').modal('hide');
                    }
                });
            
        }

        $('#withdraw_cash').click(function () {
            $('.custom_alert').hide();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('withdraw_cash'); ?>",
                success: function (data) {
                    if (data.success) {
                        $('.custom_alert').removeClass('alert-danger');
                        $('.custom_alert').addClass('alert-success');
                        $('.alert-content').html(data.success);
                        $('.custom_alert').fadeIn();
                        $('#total_amount').html('$0');
                        $('#withdraw_cash').remove();
                    } else {
                        $('.custom_alert').removeClass('alert-success');
                        $('.custom_alert').addClass('alert-danger');
                        $('.alert-content').html(data.error);
                        $('.custom_alert').fadeIn();
                    }
                    setTimeout(function () {
                        $('.custom_alert').fadeOut();
                    }, 5000);
                }
            });
        });

        socket.on('notification_send', function (data) {
            console.log(data);
            current_id = '<?= $current_id ?>';
            if (data.other_id == 'app' && data.user_id == current_id) {
                $('#flash_message').html(
                        '<i class="flash_close">×</i>' +
                        '<a href="' + data.url + '">' +
                        '<div class="msg_body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div class="mr-3">' +
                        '<div class="image" style="background-image: url(\'' + data.photo + '\')"></div>' +
                        '</div>' +
                        '<div>' +
                        '<p class="mb-0">' + data.text + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>');
                $('.flash_message').fadeIn(200);
                setTimeout(function () {
                    $('.flash_message').fadeOut(1000);
                }, 10000);
            } else if (data.user_id == current_id && data.other_id != current_id) {
                $('#flash_message').html(
                        '<i class="flash_close">×</i>' +
                        '<a href="' + data.url + '">' +
                        '<div class="msg_body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div class="mr-3">' +
                        '<div class="image" style="background-image: url(\'' + data.photo + '\')"></div>' +
                        '</div>' +
                        '<div>' +
                        '<span class="title">' + data.other_name + '</span>' +
                        '<p class="mb-0">' + data.text + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>');
                $('.flash_message').fadeIn(200);
                setTimeout(function () {
                    $('.flash_message').fadeOut(1000);
                }, 10000);

                let segment = '<?= $segment ?>';
                if (segment != 'messages') {
                    if (data.type == 'message') {
                        $('.unread_messages').html(data.unread_counter);
                    }
                } else {
                    readMessage('unread_messages');
                }

                if (segment != 'appointments') {
                    if (data.type == 'appointment') {
                        $('.unseen_appointments').html(data.unread_counter);
                    }
                } else {
                    makeAppointmentsSeenForTrainer('unseen_appointments');
                }

            }

        });

<?php } ?>
</script>