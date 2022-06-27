<?php
get_header();
?>

<div id="main-content-wp" class="info-account-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar('admin');
        ?>
        <div id="content" class="fl-right">
            <div class="section-head">
                <h1>Cập nhật thông tin</h1>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="fullname">Tên hiển thị</label>
                        <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" <?php echo class_error('fullname') ?>>
                        <?php echo form_error('fullname') ?>

                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" readonly="readonly" placeholder="<?php echo set_value('username') ?>" <?php echo class_error('username') ?>>

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo set_value('email') ?>" <?php echo class_error('email') ?>>
                        <?php echo form_error('email') ?>

                        <label for="tel">Số điện thoại</label>
                        <input type="tel" name="phone" id="tel" value="<?php echo set_value('phone') ?>"  <?php echo class_error('phone') ?>>
                        <?php echo form_error('phone') ?>

                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address" <?php echo class_error('address') ?>><?php echo set_value('address') ?></textarea>
                        <?php echo form_error('address') ?>

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