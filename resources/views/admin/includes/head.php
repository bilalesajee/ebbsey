<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/all.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/jquery.fancybox.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/skins/skin-blue.css') ?>">
<!--    <link rel="stylesheet" href="<? = asset('adminassets/plugins/iCheck/square/blue.css') ?>">-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?= asset('adminassets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    
     <script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    <link rel="shortcut icon" type="image/png" href="<?= asset('userassets/images/icons/favicon.png') ?>"/>
</head>
<script>
    base_url = "<?php echo asset('/'); ?>";
</script>
