<?php include resource_path('views/includes/header.php'); ?>


<div class="blog_page bg_blue full_viewport">
    <div class="overlay full_viewport" style="background-color: rgba(14, 11, 22, 0.85)">
        <div class="blog_header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center mb-2 text-orange text-uppercase">Blog</h4>
                    </div> <!-- col -->
                    <div class="col-md-6 text-center mx-auto">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- blog_header -->
        <div class="container">
            <div class="row">
                <?php if($result && count($result) > 0){
                    foreach($result as $val) { 
                    ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="blog_post">
                        <div class="image">
                            <img src="<?= asset('userassets/images/spacer1.png') ?>" alt="" />
                            <div class="img" style="background-image: url('<?=($val->image)? asset('public/images/'.$val->image): asset('public/images/blogs/default.png'); ?>')"></div>
                        </div>
                        <div class="content">
                            <h5 class="title"><?=$val->title;?></h5>
                            <p><?=(strlen($val->description)>50)?substr($val->description, 0,50):$val->description;;?></p>
                        </div>
                        <a href="<?=url('blog_detail/'.$val->id);?>" class="btn btn-block orange">read More <span class="arrow"></span></a>
                    </div>
                </div> <!-- col -->
                <?php } } else {echo 'Not found';}?>
            </div> <!-- row -->
            <div class="blog_pagination">
                
            </div>
             <?=$result->links();?>
        </div> <!-- container -->
    </div> <!-- overlay -->
</div> <!-- page_overlay -->


<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>