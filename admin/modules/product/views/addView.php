<?php
get_header();
global $list_category;
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">

                        <label for="product-name">Tên sản phẩm</label>
                        <input type="text" name="name" id="product-name" value="<?php echo set_value('name') ?>" <?php echo class_error('name') ?>>
                        <?php echo form_error('name') ?>
                        <?php echo note('product', 'name') ?>

                        <label for="product-code">Mã sản phẩm</label>
                        <input readonly  type="text" name="code" id="product-code" value="<?php echo set_value('code_auto') ?>">
                        <?php echo note('product', 'code') ?>

                        <label for="price">Giá sản phẩm</label>
                        <input type="text" name="price" id="price" value="<?php echo set_value('price') ?>" <?php echo class_error('price') ?>>
                        <?php echo form_error('price') ?>
                        <?php echo note('product', 'price') ?>

                        <label for="desc">Mô tả ngắn</label>
                        <textarea name="desc" id="desc"><?php echo set_value('desc') ?></textarea>
                        <?php echo form_error('desc') ?>
                        <?php echo note('product', 'desc') ?>
                        
                        <label for="content">Chi tiết</label>
                        <textarea name="content" id="content" class="ckeditor"><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content') ?>
                        <?php echo note('product', 'content') ?>

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input multiple="" type="file" name="thumb[]" id="thumb" <?php echo class_error('thumb') ?>>
                            <input type="submit" name="btn_upload_thumb" value="Upload" id="btn-upload-thumb">
                        </div>
                        <?php echo form_error('thumb') ?>
                        <?php echo note('product', 'thumb') ?>

                        <label>Danh mục sản phẩm</label>
                        <select name="cat_id" <?php echo class_error('cat_id') ?>>
                            <option value="">-- Chọn danh mục --</option>
                            <?php if (!empty($list_category)) {
                                foreach ($list_category as $category) {
                            ?>
                                <option <?php if(empty($category['parent_id'])) echo "disabled='disabled'" ?> value="<?php echo $category['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $category['level']) . $category['title'] ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('cat_id') ?>
                        <?php echo note('product', 'product_cat') ?>

                        <button type="submit" name="btn_add" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>