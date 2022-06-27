<?php
$list_category_product = db_fetch_array("SELECT `cat_id`, `title`, `parent_id` FROM `tbl_category` WHERE NOT `parent_id` = '999999' AND `type` = 'product'");
$cat_id = !empty($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
if($cat_id == 0){
    $where = "WHERE 1";
}else{
    $where = "WHERE `cat_id` = '{$cat_id}'";
}
$category = db_fetch_row("SELECT `cat_id`, `title` FROM `tbl_category` {$where}");
$list_banner = db_fetch_array("SELECT `ti`.`url`, `tb`.`link`, `tb`.`title`
                               FROM `tbl_banner` as `tb`
                               LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                               LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                               WHERE `tb`.`status` = 'ON' AND `ui`.`type` = 'banner'
                               ORDER BY `tb`.`order`
                               LIMIT 5");
?>
<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <?php
            if (!empty($list_category_product)) {
                show_category_data_tree($list_category_product, "category-product/");
            }
            ?>
        </div>
    </div>

    <div class="section" id="filter-product-wp">
        <div class="section-head">
            <h3 class="section-title">Bộ lọc</h3>
        </div>
        <div class="section-detail">
            <form method="POST" action="">

                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Giá</td>
                        </tr>
                    </thead>
                    <tbody cat_id=<?php echo $category['cat_id'] ?>>
                        <tr>
                            <td><input type="checkbox" data-id="<500" id="under-500" class="filter-price"></td>
                            <td><label for="under-500">Dưới 500.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" data-id="500-1000" id="between-500-1000" class="filter-price"></td>
                            <td><label for="between-500-1000">500.000đ - 1.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" data-id="1000-5000" id="between-1000-5000" class="filter-price"></td>
                            <td><label for="between-1000-5000">1.000.000đ - 5.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" data-id="5000-10000" id="between-5000-10000" class="filter-price"></td>
                            <td><label for="between-5000-10000">5.000.000đ - 10.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" data-id=">10000" id="over-10000" class="filter-price"></td>
                            <td><label for="over-10000">Trên 10.000.000đ</label></td>
                        </tr>
                    </tbody>
                </table>





            </form>
        </div>
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