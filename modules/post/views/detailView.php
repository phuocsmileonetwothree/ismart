<?php
get_header();
?>
<style>
    .detail h2{
        font-size: 20px;
        margin: 10px 0;
    }
    .detail p{
        font-size: 15px;
    }
</style>
<div id="main-content-wp" class="clearfix detail-blog-page">
    <div class="wp-inner">

        <?php
        get_breadcrumb()
        ?>

        <div class="main-content fl-right">
            <?php if (!empty($post)) {
            ?>
                <!-- Bài viết -->
                <div class="section" id="detail-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title"><?php echo $post['title'] ?></h3>
                    </div>
                    <div class="section-detail">
                        <span class="create-date"><?php echo timestamp_to_date_format($post['creation_time']) ?></span>
                        <div class="detail">
                            <?php echo html_entity_decode($post['content']) ?>
                        </div>
                    </div>
                </div>

                <!-- Bình luận đánh giá -->
                <div class="section" id="social-wp">
                    <div class="section-detail">
                        <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                        <div class="g-plusone-wp">
                            <div class="g-plusone" data-size="medium"></div>
                        </div>
                        <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                    </div>
                </div>
            <?php
            } ?>

        </div>

        <?php get_sidebar('post') ?>

    </div>
</div>

<?php
get_footer();
?>