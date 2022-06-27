<?php get_header() ?>

<style>
    .product-content h2{
        font-size: 21px;
        margin: 20px 0;
        font-weight: normal;
    }
    .product-content p{
        font-size: 16px;
    }
    #list-thumb a:hover{
        cursor: pointer;
    }
</style>
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <?php
        get_breadcrumb();
        ?>
        <div class="main-content fl-right">

            <?php if (!empty($product)) {
            ?>
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <?php if (!empty($product['url_image'])) {
                        ?>
                            <div class="thumb-wp fl-left">
                                <a title="" id="main-thumb">
                                    <img id="zoom" src="admin/<?php echo $product['url_image'][0] ?>" data-zoom-image="admin/<?php echo $product['url_image'][0] ?>" />
                                </a>
                                <div id="list-thumb">
                                    <?php foreach ($product['url_image'] as $image) {
                                    ?>
                                        <a data-image="admin/<?php echo $image ?>" data-zoom-image="admin/<?php echo $image ?>">
                                            <img id="zoom" src="admin/<?php echo $image ?>" />
                                        </a>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                            <div class="thumb-respon-wp fl-left">
                                <img src="admin/<?php echo $product['url_image'][0] ?>" alt="">
                            </div>
                        <?php
                        } ?>

                        <div class="info fl-right">
                            <h3 class="product-name"><?php echo $product['name'] ?></h3>
                            <div class="desc">
                                <?php echo !empty($product['desc']) ? $product['desc'] : "Đang cập nhật..." ?>
                            </div>
                            <div class="num-product">
                                <span class="title">Sản phẩm: </span>
                                <span class="status <?php echo strtolower($product['stocking']) ?>"><?php echo convert_stocking($product['stocking']) ?></span>
                            </div>
                            <p class="price"><?php echo current_format($product['price']) ?></p>
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" data-id="<?php echo $product['product_id'] ?>" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <a href="" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                        </div>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail product-content">
                        <div class="fit-product-content">
                            <?php echo !empty($product['content']) ? html_entity_decode($product['content']) : "Đang cập nhật..." ?>
                            <a class="extend-content" href="">Xem thêm <span>&#8595;</span></a>
                            <a class="collapse-content" href="">Thu gọn <span>&#8593;</span></a>
                            <div class="opacity"></div>

                        </div>
                    </div>
                </div>
            <?php
            } ?>

            <?php if (!empty($list_related_product)) {
            ?>
                <div class="section" id="same-category-wp">
                    <div class="section-head">
                        <h3 class="section-title">Cùng chuyên mục</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            <?php foreach ($list_related_product as $item) {
                            ?>
                                <li>
                                    <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="thumb">
                                        <img src="admin/<?php echo $item['url'] ?>">
                                    </a>
                                    <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                    <div class="price">
                                        <span class="new"><?php echo current_format($item['price']) ?></span>
                                        <span class="old"><?php echo current_format($item['old_price']) ?></span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="add/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="checkout/buy-now-<?php echo $item['product_id'] ?>" title="" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            } ?>

                    </div>
                </div>
            <?php
            } ?>



        </div>
        <?php
        get_sidebar()
        ?>
    </div>
</div>

<?php get_footer() ?>