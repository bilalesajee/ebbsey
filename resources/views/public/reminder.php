<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script> 
<script>
    var socket = io('<?= env('SOCKETS') ?>');
</script>
<?php foreach($appointments as $appointment) { ?>
    <script>
        socket.emit('notification_get', {
            "user_id": '<?=$appointment->trainer_id?>',
            "other_id": 'app',
            "other_name": '',
            "photo": '<?=asset('userassets/images/icons/favicon.png')?>',
            "text": 'Only <?=$appointment->travelling_time?> minutes left for your session to start',
            "url": '<?=asset('session_detail/'.$appointment->id)?>',
            "type": 'reminder',
            "unread_counter": ''
        });
    </script>
<?php } ?>