<?php 
get_header();
global $pagging, $sort_by;
?>

<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">

        <?php
        get_breadcrumb();
        ?>

        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">


                <div class="section-head clearfix">
                    <h3 class="section-title fl-left"><?php echo !empty($category['title']) ? $category['title'] : "Tất cả sản phẩm" ?></h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị <?php echo !empty($list_product_by_cat_id) ? count($list_product_by_cat_id) : "0" ?> trên tổng số sản phẩm</p>
                        <div class="form-filter">
                            <form method="GET" action="" id="sort-now">
                                <select name="sort-by">
                                    <option value="0">Sắp xếp</option>
                                    <option value="price-ascending" <?php if(isset($sort_by) and $sort_by == "price-ascending") echo "selected" ?>>Giá tăng dần</option>
                                    <option value="price-descending" <?php if(isset($sort_by) and $sort_by == "price-descending") echo "selected" ?>>Giá giảm dần</option>
                                    <option value="name-ascending" <?php if(isset($sort_by) and $sort_by == "name-ascending") echo "selected" ?>>Tên A-Z</option>
                                    <option value="name-descending" <?php if(isset($sort_by) and $sort_by == "name-descending") echo "selected" ?>>Tên Z-A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if (!empty($list_product_by_cat_id)) {
                ?>
                    <div class="section-detail">
                        <ul class="list-item clearfix" id="list-data-ajax">
                            <?php foreach ($list_product_by_cat_id as $item) {
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
                                        <a href="add/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" data-id="<?php echo $item['product_id'] ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="checkout/buy-now-<?php echo $item['product_id'] ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            } ?>

                        </ul>
                    </div>
                <?php
                } else {
                    echo "<p style='text-align:center;'>Đang cập nhật sản phẩm...</p>";
                } ?>



            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php 
                    if(empty($pagging['cat_id'])){
                        get_pagging($pagging['page'], $pagging['total_page'], "category-product/all?page=", '', $sort_by);
                    }else{
                        get_pagging($pagging['page'], $pagging['total_page'], "category-product/{$pagging['title']}-{$pagging['cat_id']}?page=", '', $sort_by);
                    }?>
                </div>
            </div>
        </div>

        <?php
        get_sidebar('filter');
        ?>


    </div>
</div>


<?php get_footer() ?>