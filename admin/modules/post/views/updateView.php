<?php
get_header();
global $list_category, $cat_id;
?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật bài viết</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">

                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                        <?php echo form_error('title') ?>
                        <?php echo note('post', 'title') ?>


                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug') ?>" <?php echo class_error('slug') ?>>
                        <?php echo form_error('slug') ?>
                        <?php echo note('post', 'slug') ?>

                        <label for="desc">Mô tả</label>
                        <textarea name="content" id="desc" class="ckeditor" <?php echo class_error('content') ?>><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content') ?>
                        <?php echo note('post', 'content') ?>


                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="thumb" id="upload-thumb">
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img src="<?php echo set_value('thumb') ?>" alt="">
                        </div>
                        <?php echo note('post', 'thumb') ?>


                        <label>Danh mục cha</label>
                        <select name="cat_id" <?php echo class_error('cat_id') ?>>
                            <option value="">-- Chọn danh mục --</option>
                            <?php if (!empty($list_category)) {
                                foreach ($list_category as $category) {
                            ?>
                                    <option <?php if($category['cat_id'] == $cat_id) echo "selected='selected'" ?> <?php if (empty($category['parent_id'])) echo "disabled='disabled'" ?> value="<?php echo $category['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;', $category['level']) . $category['title'] ?></option>

                            <?php
                                }
                            } ?>
                        </select>
                        <?php echo form_error('cat_id') ?>
                        <?php echo note('post', 'parent_cat') ?>


                        <button type="submit" name="btn_update" id="btn-submit">Cập nhật bài viết</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
get_footer();
?>