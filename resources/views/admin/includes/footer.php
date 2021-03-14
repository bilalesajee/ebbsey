<script src="<?= asset('adminassets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!--<script src="<?= asset('adminassets/plugins/iCheck/icheck.min.js') ?>"></script>-->
<script src="<?= asset('adminassets/dist/js/all.min.js') ?>"></script>
<script src="<?= asset('adminassets/dist/js/jquery.fancybox.js') ?>"></script>
<script src="<?= asset('adminassets/dist/js/pages/admin.js') ?>"></script>
<script src="<?= asset('adminassets/dist/js/demo.js') ?>"></script>
<script>
    jQuery(document).ready(function () {
        jQuery('.fancybox').fancybox();
    });
    $(function () {
//        $('input').iCheck({
//            checkboxClass: 'icheckbox_square-blue',
//            radioClass: 'iradio_square-blue',
//            increaseArea: '20%' /* optional */
//        });
        $('#datatable').DataTable({
            'paging': true,
            'responsive': true
        });
//        $('#datatable').DataTable({
////            "sScrollX": '200%'
//            'paging': true,
////            'lengthChange': false,
//            'searching': true,
//            'ordering': true,
//            'responsive': true
////            'info': true,
////            'autoWidth': false
//        });
    });
</script>