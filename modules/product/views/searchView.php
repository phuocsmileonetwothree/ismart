<?php
get_header();
global $pagging;
?>

<style>
    #list-data-ajax li {
        width: 18.25% !important;
    }

    .main-content #list-product-wp .section-detail .list-item li:nth-child(4n) {
        margin-right: 1%!important;
    }
</style>
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title=""></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content" style="width: 100%;">
            <div class="section" id="list-product-wp">


                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">Tìm kiếm</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị <?php echo !empty($list_product_search) ? count($list_product_search) : "0" ?> trên tổng số sản phẩm</p>
                        <!-- <div class="form-filter">
                            <form method="POST" action="">
                                <select name="select">
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Từ A-Z</option>
                                    <option value="2">Từ Z-A</option>
                                    <option value="3">Giá cao xuống thấp</option>
                                    <option value="3">Giá thấp lên cao</option>
                                </select>
                                <button type="submit">Lọc</button>
                            </form>
                        </div> -->
                    </div>
                </div>

                <?php if (!empty($list_product_search)) {
                ?>
                    <div class="section-detail">
                        <ul class="list-item clearfix" id="list-data-ajax">
                            <?php foreach ($list_product_search as $item) {
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
                                        <a href="add/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="checkout/buy-now-<?php echo $item['product_id'] ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            <?php
                            } ?>

                        </ul>
                    </div>
                <?php
                } else {
                    echo "<p style='text-align:center;'>Không tìm thấy sản phẩm...</p>";
                } ?>



            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                    $pagging['key_search'] = htmlentities($_GET['key']);
                    get_pagging($pagging['page'], $pagging['total_page'], "search/?key={$pagging['key_search']}&page=");
                    ?>
                </div>
            </div>
        </div>

        <?php
        //get_sidebar('filter');
        ?>


    </div>
</div>


<?php get_footer() ?>