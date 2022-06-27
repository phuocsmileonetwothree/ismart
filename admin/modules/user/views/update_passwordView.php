<?php
get_header();
?>
<div id="main-content-wp" class="change-pass-page">

    <div class="wrap clearfix">
        <?php
        get_sidebar('admin');
        ?>
        <div id="content" class="fl-right">
            <div class="section-head" id="title-page">
                <h1>Cập nhật mật khẩu</h1>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <?php echo form_error('password') ?>
                        <label for="old-pass">Mật khẩu cũ</label>
                        <input type="password" name="old_password" id="old-pass"  <?php echo class_error('old_password') ?>>
                        <?php echo form_error('old_password') ?>

                        <label for="new-pass">Mật khẩu mới</label>
                        <input type="password" name="new_password" id="new-pass" <?php echo class_error('new_password') ?>>
                        <?php echo form_error('new_password') ?>

                        <label for="confirm-pass">Xác nhận mật khẩu</label>
                        <input type="password" name="re_password" id="confirm-pass" <?php echo class_error('re_password') ?>>
                        <?php echo form_error('re_password') ?>

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