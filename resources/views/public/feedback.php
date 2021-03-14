<?php include resource_path('views/includes/header.php'); ?>
<style>
    .rating {
        float:left;
    }
    .rating span { 
        float:right; 
        position:relative; 
    }
    .rating span input {
        position: absolute;
        top: 0px;
        left: 0px;
        opacity: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    .rating span .fa-star {
        display:inline-block;
        width:30px;
        height:30px;
        text-align:center;
        color:#FFF;
        font-size:30px;
        margin-right:2px;
        line-height:30px;
        border-radius:50%;
        -webkit-border-radius:50%;
        font-size: 25px;
    }
    .rating span:hover ~ span .fa-star,
    .rating span:hover .fa-star,
    .rating span.checked .fa-star,
    .rating span.checked ~ span .fa-star {
        color:#F90;
    }
</style>
<div class="login_wrapper align-items-center d-flex">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form_title">
                    <h5 class="text-white"><strong>Give us feedback</strong></h5>
                </div>
            </div>

            <?php if (Session::has('error')) { ?>
            
                <div class="col-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                    <?php echo Session::get('error') ?>
                </div>
                </div>
            <?php } ?>

            <?php if (Session::has('success')) { ?>
                <div class="col-12">
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                    <?php echo Session::get('success') ?>
                </div>
                </div>
            <?php } ?>
        </div> <!--row -->
        <div class="row">
            <form action="<?= url('feedback') ?>" method="post" class="rating w-100">
                <?= csrf_field(); ?>
                <div class="col-12">
                    
                    <div class="form-group clearfix d-flex align-items-center">
                        <label class="mr-3 mb-0">Choose Rating</label>
                        <div class="rating">
                            <span>
                                <input type="radio" name="rating" id="str5" value="5" required>
                                <i class="fa fa-star"></i>
                            </span>
                            <span>
                                <input type="radio" name="rating" id="str4" value="4" required>
                                <i class="fa fa-star"></i>
                            </span>
                            <span>
                                <input type="radio" name="rating" id="str3" value="3" required>
                                <i class="fa fa-star"></i>
                            </span>
                            <span>
                                <input type="radio" name="rating" id="str2" value="2" required>
                                <i class="fa fa-star"></i>
                            </span>
                            <span>
                                <input type="radio" name="rating" id="str1" value="1" required>
                                <i class="fa fa-star"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Write a Review</label>
                        <textarea class="form-control eb-form-control other_reason" name="reviews" placeholder="Reviews" rows="10" cols="80" required></textarea>
                        <input type="hidden" name="rated_by" value="<?= $rated_by ?>" >
                        <input type="hidden" name="user_id" value="<?= $user_id ?>" >
                        <input type="hidden" name="appointment_id" value="<?= $appointment_id ?>" >
                    </div>
                    <div class="form-group mt-4">
                        <input type="submit" value="Submit Review" class="btn orange btn-lg">
                    </div>
            </form>
        </div> <!--row -->
    </div>
</div>
</div>

<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
<script>
    $(document).ready(function () {
        // Check Radio-box
        $(".rating input:radio").attr("checked", false);

        $('.rating input').click(function () {
            $(".rating span").removeClass('checked');
            $(this).parent().addClass('checked');
        });

        $('input:radio').change(
                function () {
                    var userRating = this.value;
                });
    });
</script>

</body>
</html>
