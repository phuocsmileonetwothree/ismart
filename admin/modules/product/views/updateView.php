<?php
get_header();
global $list_category, $list_thumb, $status, $cat_id, $product_id;

?>
<style>
    ul#list-thumb{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    ul#list-thumb li {
        display: inline-block;
        margin-right: 10px;
        padding: 10px;

    }
    ul#list-thumb li:last-child {
        margin-right: 0;
    }

    ul#list-thumb li img {
        margin-top: 0;
    }

    ul.list-update-thumb {
        display: inline-block;
        display: flex;
        justify-content: space-evenly;
        margin: 0 40px;
    }
    #input-upload-image{
        display: flex;
        justify-content: center;
    }
    .add-image {
        display: inline-block;
        background: #ddd;
        cursor: pointer;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        opacity: 0.5;
    }

    div.plus {
        display: block;
        width: 45px;
        height: 45px;
        font-size: 40px;
        color: #fff;
    }

    .plus span {
        position: absolute;
        top: 25%;
        left: 25%;
    }

    .add-list-image {
        width: 45px;
        height: 45px;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        top: 0;
    }
    .border-2px{
        border: 2px solid #0093E9!important;
    }
</style>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật sản phẩm</h3>
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
                        <input type="text" name="code" id="product-code" value="<?php echo set_value('code') ?>" disabled='disabled'>
                        <?php echo note('product', 'code') ?>

                        <label for="price">Giá sản phẩm</label>
                        <input type="text" name="price" id="price" value="<?php echo set_value('price') ?>" <?php echo class_error('price') ?>>
                        <?php echo form_error('price') ?>
                        <?php echo note('product', 'price') ?>

                        <label for="desc">Mô tả ngắn</label>
                        <textarea <?php echo class_error('desc') ?> name="desc" id="desc"><?php echo set_value('desc') ?></textarea>
                        <?php echo form_error('desc') ?>
                        <?php echo note('product', 'desc') ?>

                        <label for="content">Chi tiết</label>
                        <textarea <?php echo class_error('content') ?> name="content" id="content" class="ckeditor"><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content') ?>
                        <?php echo note('product', 'content') ?>

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <ul id="list-thumb">
                                <?php
                                if (!empty($list_thumb)) {
                                    foreach($list_thumb as $item){
                                ?>
                                        <li>
                                            <img data-image="<?php echo $item['id'] ?>" src="<?php echo $item['url'] ?>" alt="">
                                            <ul class="list-update-thumb">
                                                <li><a class="delete" href="" data-image="<?php echo $item['id'] ?>" title="Xóa hình ảnh" class="edit"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>

                                        </li>
                                <?php
                                    }
                                } ?>
                            </ul>
                            <div id="input-upload-image">
                                <div class="add-image">
                                    <div class="plus">
                                        <span>+</span>
                                        <input title="Thêm 1 hoặc nhiều ảnh" data-id="<?php echo $product_id ?>" multiple type="file" name="files[]" class="add-list-image" id="files">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php echo note('product', 'thumb') ?>


                        <label>Trạng thái</label>
                        <select name="status" <?php echo class_error('status') ?>>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="ON" <?php if (!empty($status) and $status == "ON") echo "selected='selected'" ?>>Public - ON</option>
                            <option value="OFF" <?php if (!empty($status) and $status == "OFF") echo "selected='selected'" ?>>Private - OFF</option>
                        </select>
                        <?php echo form_error('status') ?>
                        <?php echo note('product', 'status') ?>

                        <label>Danh mục sản phẩm</label>
                        <select name="cat_id" <?php echo class_error('cat_id') ?>>
                            <option value="">-- Chọn danh mục --</option>
                            <?php if (!empty($list_category)) {
                                foreach ($list_category as $category) {
                            ?>
                                    <option <?php if ($category['cat_id'] == $cat_id) echo "selected='selected'" ?> <?php if (empty($category['parent_id'])) echo "disabled='disabled'" ?> value="<?php echo $category['cat_id'] ?>"><?php echo str_repeat('&nbsp;', $category['level']) . $category['title'] ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('cat_id') ?>
                        <?php echo note('product', 'product_cat') ?>

                        <button type="submit" name="btn_update" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>