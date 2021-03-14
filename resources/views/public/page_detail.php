<?php include resource_path('views/includes/header.php'); ?>


<div class="single_blog_page bg_blue full_viewport" style="background-image: url('<?= asset('userassets/images/image22.jpg') ?>')">
    <div class="overlay full_viewport" style="background-color: rgba(14, 11, 22, 0.85)">
        <div class="blog_body">
            <div class="container">
                <div class="title">
                    <h1><?=$result->title;?></h1> 
                </div> 
                <div class="text_content">
                <?=$result->content;?>   
                </div>
            </div> <!-- container -->
        </div> <!-- blog_header -->
    </div> <!-- overlay -->
</div> <!-- page_overlay -->


<?php include resource_path('views/includes/footer.php'); ?>
<?php include resource_path('views/includes/footerassets.php'); ?>
</body>
</html>