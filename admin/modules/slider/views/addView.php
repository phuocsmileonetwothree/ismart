<?php
get_header();
?>

<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">

                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title') ?>" <?php echo class_error('title') ?>>
                        <?php echo form_error('title') ?>
                        <?php echo note('slider', 'title') ?>
                        
                        <label for="slug">Link</label>
                        <input type="text" name="link" id="slug" value="<?php echo set_value('link') ?>" <?php echo class_error('link') ?>>
                        <?php echo form_error('link') ?>
                        <?php echo note('slider', 'link') ?>

                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor" <?php echo class_error('desc') ?>><?php echo set_value('title') ?></textarea>
                        <?php echo form_error('desc') ?>
                        <?php echo note('slider', 'desc') ?>

                        <label for="num-order">Thứ tự</label>
                        <input type="text" name="order" id="num-order" value="<?php echo set_value('order') ?>" <?php echo class_error('order') ?>>
                        <?php echo form_error('order') ?>
                        <?php echo note('slider', 'order') ?>

                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="url_slider" id="upload-thumb" <?php echo class_error('url_slider') ?>>
                            <input type="submit" name="btn-upload-thumb" value="Upload" id="btn-upload-thumb">
                            <img src="public/images/img-thumb.png">
                        </div>
                        <?php echo form_error('url_slider') ?>
                        <?php echo note('slider', 'url_slider') ?>


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