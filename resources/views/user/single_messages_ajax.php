<?php
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
                                                            <?php if($chat_messages->file_type == 'image') { ?>
                                                            <img  src="<?php echo asset('public/images/'.$chat_messages->file_path); ?>" alt="" />
                                                            <?php }else{ ?>
                                                               <video controls src="<?php echo asset('public/videos/'.$chat_messages->file_path); ?>" ></video> 
                                                            <?php } ?>
                                                        </div> 
                                                    </div>
                                                    <div class="send_time text-right"><?= timeago($chat_messages->created_at) ?></div>
                                                </div>
                                            </div>                                       
                                        </li>
                                    <?php } ?>