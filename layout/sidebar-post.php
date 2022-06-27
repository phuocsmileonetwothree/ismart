<?php
$list_category_post = db_fetch_array("SELECT `cat_id`, `title`, `parent_id` FROM `tbl_category` WHERE NOT `parent_id` = '999999' AND `type` = 'post'");
$list_product_best_seller = db_fetch_array("SELECT `tp`.`product_id`, `tp`.`name`, `tp`.`price`, `tp`.`old_price`, `tp`.`purchased`, `tp`.`creation_time`, `ti`.`url`
                                            FROM `tbl_product` as `tp`
                                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                                            GROUP BY `tp`.`product_id`
                                            ORDER BY `tp`.`purchased` DESC
                                            LIMIT 10");
$list_banner = db_fetch_array("SELECT `ti`.`url`, `tb`.`link`, `tb`.`title`
                               FROM `tbl_banner` as `tb`
                               LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                               LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                               WHERE `tb`.`status` = 'ON' AND `ui`.`type` = 'banner'
                               ORDER BY `tb`.`order`
                               LIMIT 5");
?>
<div class="sidebar fl-left">
    <!-- Danh mục -->
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục bài viết</h3>
        </div>
        <div class="secion-detail">
            <?php
            if (!empty($list_category_post)) {
                show_category_data_tree($list_category_post, "category-post/");
            }
            ?>
        </div>
    </div>

    <!-- Sản phẩm nổi bật - Link đã full -->
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <?php
        if (!empty($list_product_best_seller)) {
        ?>
            <div class="section-detail">
                <ul class="list-item">
                    <?php foreach ($list_product_best_seller as $product) {
                    ?>
                        <li class="clearfix">
                            <a href="product/<?php echo create_slug($product['name']) . '-' . $product['product_id'] ?>" title="" class="thumb fl-left">
                                <img src="admin/<?php echo $product['url'] ?>" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="product/<?php echo create_slug($product['name']) . '-' . $product['product_id'] ?>" title="" class="product-name"><?php echo $product['name'] ?></a>
                                <div class="price">
                                    <span class="new"><?php echo current_format($product['price']) ?></span>
                                    <span class="old"><?php echo current_format($product['old_price']) ?></span>
                                </div>
                                <a href="checkout/buy-now-<?php echo $product['product_id'] ?>" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    <?php
                    } ?>


                </ul>
            </div>
        <?php
        }
        ?>

    </div>

    <!-- Banner -->
    <?php if (!empty($list_banner)) {
    ?>
        <div class="section" id="banner-wp">
            <div class="section-detail">
                <?php foreach ($list_banner as $banner) {
                ?>
                    <a href="" title="" class="thumb" style="margin-bottom: 10px; display: block;">
                        <img src="admin/<?php echo $banner['url'] ?>" alt="">
                    </a>
                <?php
                } ?>

            </div>
        </div>
    <?php
    } ?>
    
</div>