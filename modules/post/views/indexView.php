<?php
get_header();
global $pagging;
?>

<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <?php
        get_breadcrumb();
        ?>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title"><?php if (isset($category) and !empty($category)) {
                                                    echo $category['title'];
                                                } else {
                                                    echo "Tất cả bài viết";
                                                } ?></h3>
                </div>
                <?php if (!empty($list_post)) {
                ?>
                    <div class="section-detail">
                        <ul class="list-item">
                            <?php foreach ($list_post as $post) {
                            ?>
                                <li class="clearfix">
                                    <a href="post/<?php echo $post['slug'] . "-" . $post['post_id'] ?>" title="" class="thumb fl-left">
                                        <img src="admin/<?php echo $post['thumb'] ?>" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="post/<?php echo $post['slug'] . "-" . $post['post_id'] ?>" title="" class="title"><?php echo $post['title'] ?></a>
                                        <span class="create-date"><?php echo timestamp_to_date_format($post['creation_time']) ?></span>
                                        <div class="desc"><?php echo !empty($post['desc']) ? $post['desc'] : html_entity_decode($post['content']) ?></p>
                                        </div>
                                </li>
                            <?php
                            } ?>

                        </ul>
                    </div>
                <?php
                } ?>

            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                    if (empty($pagging['cat_id'])) {
                        get_pagging($pagging['page'], $pagging['total_page'], "category-post/all?page=");
                    } else {
                        get_pagging($pagging['page'], $pagging['total_page'], "category-post/{$pagging['title']}-{$pagging['cat_id']}?page=");
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php get_sidebar('post') ?>
    </div>
</div>


<?php
get_footer();
?>