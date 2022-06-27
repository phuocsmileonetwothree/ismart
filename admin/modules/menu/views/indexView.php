<?php
get_header();
global $list_page, $list_category_product, $list_category_post, $next_order, $error;
global $title, $slug, $page, $category_product, $category_post, $order;
global $list_menu;
?>
<div id="main-content-wp" class="add-cat-page menu-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách Menu</h3>
                    <!-- <a href="?mod=widget&action=add" title="" id="add-new" class="fl-left">Thêm mới</a> -->

                </div>
                <?php echo note('menu', 'main') ?>
            </div>
            <div class="section-detail clearfix">
                <div id="list-menu" class="fl-left">
                    <form method="POST" action="">

                        <div class="form-group">
                            <label for="title">Tên menu</label>
                            <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                            <?php echo form_error('title') ?>
                            <?php echo note('menu', 'title') ?>
                        </div>

                        <div class="form-group">
                            <label for="url-static">Đường dẫn tĩnh</label>
                            <input type="text" name="slug" id="url-static" value="<?php echo set_value('slug') ?>" <?php echo class_error('slug') ?>>
                            <?php echo form_error('slug') ?>
                            <?php echo note('menu', 'slug') ?>
                        </div>

                        <!-- Trang -->
                        <div class="form-group clearfix">
                            <label>Trang</label>
                            <select class="choose-only-one" name="page" <?php echo class_error('page') ?>>
                                <option value="-1">-- Chọn --</option>
                                <option value="0" style="font-weight: bold;">Trang chủ</option>
                                <?php if (!empty($list_page)) {
                                    foreach ($list_page as $page) {
                                ?>
                                        <option value="<?php echo $page['page_id'] ?>"><?php echo $page['title'] ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                            <?php echo form_error('connect_id') ?>
                            <?php echo note('menu', 'page') ?>
                        </div>

                        <!-- Danh mục sản phẩm -->
                        <div class="form-group clearfix">
                            <label>Danh mục sản phẩm</label>
                            <select class="choose-only-one" name="category_product" <?php echo class_error('category_product') ?>>
                                <option value="-1">-- Chọn --</option>
                                <option value="0" style="font-weight: bold;">Liên kết với tất cả danh mục sản phẩm</option>
                                <?php if (!empty($list_category_product)) {
                                    foreach ($list_category_product as $cat_product) {
                                ?>
                                        <option value="<?php echo $cat_product['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $cat_product['level']) . $cat_product['title'] ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                            <?php echo form_error('connect_id') ?>
                            <?php echo note('menu', 'category_product') ?>
                        </div>

                        <!-- Danh mục bài viết -->
                        <div class="form-group clearfix">
                            <label>Danh mục bài viết</label>
                            <select class="choose-only-one" name="category_post" <?php echo class_error('category_post') ?>>
                                <option value="-1">-- Chọn --</option>
                                <option value="0" style="font-weight: bold;">Liên kết với tất cả danh mục bài viết</option>
                                <?php if (!empty($list_category_product)) {
                                    foreach ($list_category_post as $cat_post) {
                                ?>
                                        <option value="<?php echo $cat_post['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $cat_post['level']) . $cat_post['title'] ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                            <?php echo form_error('connect_id') ?>
                            <?php echo note('menu', 'category_post') ?>
                        </div>

                        <!-- <div class="form-group clearfix">
                            <label>Danh mục cha</label>
                            <select name="parent_id">
                                <option value="0">-- Chọn --</option>
                            </select>
                            <p>Danh mục sản phẩm liên kết đến menu</p>
                        </div> -->

                        <div class="form-group">
                            <label for="menu-order">Thứ tự</label>
                            <input type="number" max=100 name="order" id="menu-order" value="<?php echo set_value('next_order') ?>" <?php echo class_error('order') ?>>
                            <?php echo form_error('order') ?>
                            <?php echo note('menu', 'order') ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="btn_add" id="btn-save-list">Tạo menu</button>
                        </div>
                    </form>
                </div>




                <div id="category-menu" class="fl-right">
                    <div class="actions">
                        <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="">Tác vụ</option>
                                <option value="delete">Xóa vĩnh viễn</option>
                            </select>
                            <input mod="<?php echo get_module(); ?>" type="submit" name="sm_action" value="Áp dụng" class="action-ajax">
                    </div>
                    <?php if (!empty($list_menu)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Tên menu</span></td>
                                        <td style="text-align: center;"><span class="thead-text">Slug</span></td>
                                        <td style="text-align: center;"><span class="thead-text">Thứ tự</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $index = 1;
                                    foreach ($list_menu as $menu) {
                                    ?>
                                        <tr>
                                            <td><input data-id="<?php echo $menu['menu_id'] ?>" type="checkbox" name="checkItem" class="checkItem" value="1"></td>
                                            <td><span class="tbody-text"><?php echo $index; ?></span>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $menu['title'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=menu&action=update&id=<?php echo $menu['menu_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=menu&action=delete&id=<?php echo $menu['menu_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td style="text-align: center;"><span class="tbody-text"><?php echo $menu['slug'] ?></span></td>
                                            <td style="text-align: center;"><span class="tbody-text"><?php echo $menu['order'] ?></span></td>
                                        </tr>
                                    <?php
                                    $index++;} ?>

                                </tbody>

                            </table>
                        </div>
                    <?php
                    } else {
                        echo "Danh sách menu trống . Hãy thêm ngay";
                    } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>