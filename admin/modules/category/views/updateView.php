<?php
get_header();
global $type, $list_category, $info_category, $title, $slug, $parent_id;
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa danh mục <?php echo convert_category($type) ?></h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tên danh mục</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                        <?php echo form_error('title') ?>
                        <?php echo note("{$type}_category", 'title') ?>

                        <label for="slug">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug') ?>" <?php echo class_error('slug') ?>>
                        <?php echo form_error('slug') ?>
                        <?php echo note("{$type}_category", 'slug') ?>

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" <?php echo class_error('desc') ?>><?php echo set_value('desc') ?></textarea>
                        <?php echo form_error('desc') ?>
                        <?php echo note("{$type}_category", 'desc') ?>

                        <label>Danh mục cha</label>
                        <select name="parent_id" <?php echo class_error('parent_id') ?>>
                            <option value="">-- Chọn danh mục --</option>
                            <option <?php if (empty($info_category['parent_id'])) echo "selected='selected'" ?> value="0" style="font-weight: bold;">Trống (Không có danh mục cha)</option>
                            <?php
                            if (!empty($info_category['parent_id'])) {
                                foreach ($list_category as $category) {
                                    if ($category['cat_id'] != $info_category['cat_id']) {
                            ?>
                                        <option <?php if (!empty($category) and $category['cat_id'] == $info_category['parent_id']) echo "selected='selected'" ?> value="<?php echo $category['cat_id'] ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['level']) . $category['title'] ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <?php echo form_error('parent_id') ?>
                        <?php echo note("{$type}_category", 'parent_cat') ?>

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