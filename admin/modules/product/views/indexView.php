<?php
get_header();
global $filter, $pagging, $list_product;


?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách sản phẩm</h3>
                    <a href="?mod=product&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <?php if (!empty($list_product)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Mã sản phẩm</span></td>
                                        <td><span class="thead-text">Hình ảnh</span></td>
                                        <td><span class="thead-text">Tên sản phẩm</span></td>
                                        <td><span class="thead-text">Giá</span></td>
                                        <td><span class="thead-text">Danh mục</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Tồn kho</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list_product as $product) {
                                    ?>
                                        <tr>
                                            <td><input data-id='<?php echo $product['product_id'] ?>' type="checkbox" name="checkItem" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $pagging['index'] ?></h3></span>
                                            <td><span class="tbody-text"><?php echo $product['code'] ?></h3></span>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <?php if (!empty($product['url'])) {
                                                    ?>
                                                        <img src="<?php echo $product['url'] ?>" alt="">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="public/images/img-product.png" alt="">

                                                    <?php
                                                    } ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="?mod=product&action=detail&id=<?php echo $product['product_id'] ?>" title=""><?php echo $product['name'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=product&action=update&id=<?php echo $product['product_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=product&action=delete&id=<?php echo $product['product_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo current_format($product['price']) ?></span></td>
                                            <td><span class="tbody-text"><?php echo $product['category_name'] ?></span></td>
                                            <td class="text-center d-flex align-center"><span title="Tình trạng sản phẩm" class="tbody-text text-white <?php echo strtolower($product['status']) ?> status status-<?php echo $product['product_id'] ?>"><?php echo $product['status'] ?></span></td>
                                            <td class="text-center" style="padding: 14px;"><span title="Tồn kho sản phẩm" style="padding: 7.5px" class="tbody-text text-white <?php echo strtolower($product['stocking']) ?> status stocking-<?php echo $product['product_id'] ?>"><?php echo $product['stocking'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $product['creator'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($product['creation_time']) ?></span></td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        if (empty($pagging['key_search'])) {
                            echo "<span class='note'>Danh sách sản phẩm trống . Hãy thêm sản phẩm!!!</span>";
                        } else {
                            echo "<span class='note'>Không tìm thấy sản phẩm</span>";
                        }
                    } ?>

                </div>
            </div>
            <?php if (!empty($list_product)) {
            ?>
                <div class="section" id="paging-wp">
                    <div class="section-detail clearfix">
                        <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                        <?php get_pagging($pagging['page'], $pagging['total_page'], "?mod=product&action=index&page=", $pagging['key_search'], $pagging['status'], $pagging['stocking']) ?>
                    </div>
                </div>
            <?php
            } ?>


        </div>
    </div>
</div>

<?php
get_footer();
?>