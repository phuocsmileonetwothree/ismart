<?php
get_header();
?>


<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm khối</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tên khối</label>
                        <input type="text" name="title" id="title" <?php echo class_error('title') ?> value="<?php echo set_value('title') ?>">
                        <?php echo form_error('title') ?>
                        <?php echo note('widget', 'title') ?>

                        <label for="code">Mã khối</label>
                        <input type="text" name="code" id="code" <?php echo class_error('code') ?> value="<?php echo set_value('code') ?>">
                        <?php echo form_error('code') ?>
                        <?php echo note('widget', 'code') ?>

                        <label for="content">Nội dung khối</label>
                        <textarea name="content" id="content" class="ckeditor" <?php echo class_error('content') ?>><?php echo set_value('content') ?></textarea>
                        <?php echo form_error('content') ?>
                        <?php echo note('widget', 'content') ?>

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