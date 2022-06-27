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
                <h1>Thông tin cá nhân</h1>
                <span class="note">Kiểm tra ảnh, tên và các thông tin khác trong Tài khoản Admin Ismart của bạn</span>
            </div>
            <div class="section-detail">
                <div class="box">
                    <div class="box-head">
                        <h1>Thông tin cơ bản</h1>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($info)) {
                        ?>
                            <ul id="list-info">
                                <li class="first-child">
                                    <span class="label">Ảnh</span>
                                    <span class="note">Thêm ảnh để cá nhân hóa tài khoản của bạn</span>
                                    <span class="thumb">
                                        <?php
                                        if (!empty($info['thumb'])) {
                                        ?>
                                            <img src="<?php echo $info['thumb'] ?>">

                                        <?php
                                        } else {
                                        ?>
                                            <img src="public/images/avatar.jpg">

                                        <?php
                                        }
                                        ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="file" name="thumb" id="thumb_avatar">
                                        </form>
                                    </span>

                                </li>
                                <li>
                                    <span class="label">Tên</span>
                                    <span class="result"><?php echo $info['fullname'] ?></span>
                                </li>
                                <li>
                                    <span class="label">Địa chỉ</span>
                                    <span class="result"><?php echo $info['address'] ?></span>
                                </li>
                                <li>
                                    <span class="label">Quyền truy cập</span>
                                    <span class="result"><?php echo $info['title'] ?></span>
                                </li>
                            </ul>

                        <?php
                        } else {
                            echo "Trống";
                        } ?>

                    </div>
                </div>
            </div>

            <div class="section-detail">
                <div class="box">
                    <div class="box-head">
                        <h1>Thông tin liên hệ</h1>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($info)) {
                        ?>
                            <ul id="list-info">
                                <li>
                                    <span class="label">Email</span>
                                    <span class="result"><?php echo $info['email'] ?></span>
                                </li>
                                <li>
                                    <span class="label">Điện thoại</span>
                                    <span class="result"><?php echo $info['phone'] ?></span>
                                </li>
                            </ul>

                        <?php
                        } else {
                            echo "Trống";
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
?>