<?php
get_header();
global $url, $name;
?>


<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật thông tin ảnh</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <img src="<?php echo set_value('url') ?>" alt="">
                    <form method="POST">
                        <label for="name">Tên ảnh</label>
                        <input type="text" name="name" id="title" value="<?php echo set_value('name') ?>"><br><br>
                        <?php echo form_error('name') ?>
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