<?php
get_header()
?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật trang</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                        <?php echo form_error('title') ?>
                        <?php echo note('page', 'title') ?>

                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug') ?>" <?php echo class_error('slug') ?>>
                        <?php echo form_error('slug') ?>
                        <?php echo note('page', 'slug') ?>

                        <label for="desc">Mô tả</label>
                        <textarea name="content" id="desc" class="ckeditor" <?php echo class_error('content') ?>><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content') ?>
                        <?php echo note('page', 'content') ?>

                        <button type="submit" name="btn_update" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
get_footer()
?>