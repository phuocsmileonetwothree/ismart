<?php
get_header();
global $data__;
?>

<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <!-- Slider -->
            <?php if (!empty($data__['list_slider'])) {
            ?>
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        <?php foreach ($data__['list_slider'] as $slider) {
                        ?>
                            <div class="item">
                                <img src="admin/<?php echo $slider['url'] ?>" alt="">
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            <?php
            } ?>

            <!-- Free shipping -->
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Newest product -->
            <?php if (!empty($data__['list_product_newest'])) {
            ?>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm mới nhất</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            <?php foreach ($data__['list_product_newest'] as $product) {
                            ?>
                                <li>
                                    <a href="product/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" title="" class="thumb">
                                        <img src="admin/<?php echo $product['url'] ?>">
                                    </a>
                                    <a href="product/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" title="" class="product-name"><?php echo $product['name'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo current_format($product['price']) ?></span>
                                        <span class="old"><?php echo current_format($product['old_price']) ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="add/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" data-id="<?php echo $product['product_id'] ?>" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="checkout/buy-now-<?php echo $product['product_id'] ?>" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            } ?>

                        </ul>
                    </div>
                </div>
            <?php
            } ?>




            <!-- List product by category -->
            <?php if (!empty($data__['list_product_by_category'])) {
                foreach ($data__['list_product_by_category'] as $item) {
            ?>
                    <div class="section" id="list-product-wp">
                        <div class="section-head">
                            <h3 class="section-title"><a href="category-product/<?php echo create_slug($item['title']) . "-" . $item['cat_id'] ?>"><?php echo $item['title'] ?></a></h3>
                        </div>

                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                <?php if (!empty($item['list_product'])) {
                                    foreach ($item['list_product'] as $product) {
                                ?>
                                        <li>
                                            <a href="product/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" title="" class="thumb">
                                                <img src="admin/<?php echo $product['url'] ?>">
                                            </a>
                                            <a href="product/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" title="" class="product-name"><?php echo $product['name'] ?></a>
                                            <div class="price">
                                                <span class="new"><?php echo current_format($product['price']) ?></span>
                                                <span class="old"><?php echo current_format($product['old_price']) ?></span>
                                            </div>
                                            <div class="action clearfix">
                                                <a href="add/<?php echo create_slug($product['name']) . "-" . $product['product_id'] ?>" data-id="<?php echo $product['product_id'] ?>"  title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                                <a href="checkout/buy-now-<?php echo $product['product_id'] ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                            </div>
                                        </li>
                                <?php
                                    }
                                } else {
                                    echo "Đang cập nhật...";
                                } ?>

                            </ul>
                        </div>


                    </div>
            <?php
                }
            } ?>






        </div>
        <?php get_sidebar() ?>
    </div>
</div>

<?php
get_footer();
?>