<?php
get_header();
global $list_page, $list_category_product, $list_category_post, $error;
global $title, $slug, $order, $connect_page, $connect_category_post, $connect_category_product;

?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật menu</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">

                        <!-- TITLE -->
                        <label for="title">Tên menu</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                        <?php echo form_error('title') ?>
                        <?php echo note('menu', 'title') ?>

                        <!-- SLUG -->
                        <label for="url-static">Đường dẫn tĩnh</label>
                        <input type="text" name="slug" id="url-static" value="<?php echo set_value('slug') ?>" <?php echo class_error('slug') ?>>
                        <?php echo form_error('slug') ?>
                        <?php echo note('menu', 'slug') ?>

                        <!-- PAGE -->
                        <label>Trang</label>
                        <select class="choose-only-one" name="page" <?php echo class_error('connect_id') ?>>
                            <option value="">-- Chọn --</option>
                            <?php if (!empty($list_page)) {
                                foreach ($list_page as $page) {
                            ?>
                                    <option <?php if (!empty($connect_page) and $connect_page == $page['cat_id']) echo "selected" ?> value="<?php echo $page['page_id'] ?>"><?php echo $page['title'] ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('connect_id') ?>
                        <?php echo note('menu', 'page') ?>

                        <!-- PRODUCT -->
                        <label>Danh mục sản phẩm</label>
                        <select class="choose-only-one" name="category_product" <?php echo class_error('connect_id') ?>>
                            <option value="">-- Chọn --</option>
                            <?php if (!empty($list_category_product)) {
                                foreach ($list_category_product as $cat_product) {
                            ?>
                                    <option <?php if (!empty($connect_category_product) and $connect_category_product == $cat_product['cat_id']) echo "selected" ?> value="<?php echo $cat_product['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $cat_product['level']) . $cat_product['title'] ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('connect_id') ?>
                        <?php echo note('menu', 'category_product') ?>

                        <!-- POST -->
                        <label>Danh mục bài viết</label>
                        <select class="choose-only-one" name="category_post" <?php echo class_error('connect_id') ?>>
                            <option value="">-- Chọn --</option>
                            <?php if (!empty($list_category_product)) {
                                foreach ($list_category_post as $cat_post) {
                            ?>
                                    <option <?php if (!empty($connect_category_post) and $connect_category_post == $cat_post['cat_id']) echo "selected" ?> value="<?php echo $cat_post['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $cat_post['level']) . $cat_post['title'] ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('connect_id') ?>
                        <?php echo note('menu', 'category_post') ?>

                        <!-- ORDER -->
                        <label for="menu-order">Thứ tự</label>
                        <input type="number" max=100 name="order" id="menu-order" value="<?php echo set_value('order') ?>" <?php echo class_error('order') ?>>
                        <?php echo form_error('order') ?>
                        <?php echo note('menu', 'order') ?>

                        <button type="submit" name="btn_update" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
get_footer()
?>