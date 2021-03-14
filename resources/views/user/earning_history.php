<?php include resource_path('views/includes/header.php'); ?>
<div class="edit_profile_wrapper bg_blue full_viewport">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mb-4">Earning History</h4>
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
                <?php if ($results && count($results) > 0) { ?>
                <div class="table-responsive">
                <table class="table table_payment">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Client Name</th>
                                <th>Class Name</th>
                                <th>Session Location</th>
                                <th>Passes Used</th>
                                <th>Earning</th>
                                <th>Reason</th>
                            <tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td><?= date('F d, Y', strtotime($result->created_at)) ?></td>
                                    <td><?= date('g:i A', strtotime($result->created_at)) ?></td>
                                    <td><?= ucfirst($result->appointment->type);?>
                                    </td>
                                    <td><?= $result->client->first_name . ' ' . $result->client->last_name ?></td>
                                    <td>
                                        <?php if($result->class_id) { ?>
                                            <a href="<?= asset('class-view/' . $result->classData->id) ?>"><?= $result->classData->class_name ?></a>
                                        <?php } else { echo 'N/A'; } ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if($result->class_id) { 
                                            echo $result->classData->location;
                                        } else {
                                            echo $result->appointment->client_location;
                                        } 
                                        ?>
                                    </td>
                                    <td><?= $result->number_of_passes ?></td>
                                    <td><?= '$'.number_format(round($result->amount, 2), 2) ?></td>
                                    <td>
                                        <?php if($result->cancel_by == 'user'){
                                            echo 'user canceled the appointment within 24 hour before appointment start time';
                                        } else if($result->cancel_by == 'trainer'){
                                            echo 'You canceled the appointment';
                                        } else if($result->cancel_by == 'refund'){
                                            echo 'Refund';
                                        } else {
                                            echo 'Appointment completed';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    No record found
                <?php } ?>
                <?= $results->appends(request()->query())->links() ?>
            </div> <!--col9 -->
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- wrapper -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>