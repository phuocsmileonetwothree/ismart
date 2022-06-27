<?php
get_header();
global $list_role, $list_module, $list_permission;

?>


<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm thành viên</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <div id="content-access">

                            <div id="left">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" <?php echo class_error('fullname') ?>>
                                <?php echo form_error('fullname') ?>

                                <label for="susername">Tên đăng nhập</label>
                                <input type="text" name="username" id="susername" value="<?php echo set_value('username') ?>" <?php echo class_error('username') ?>>
                                <?php echo form_error('username') ?>

                                <label for="password">Mật khẩu</label>
                                <input type="text" name="password" id="password" value="<?php echo set_value('password') ?>" <?php echo class_error('password') ?>>
                                <?php echo form_error('password') ?>

                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" value="<?php echo set_value('phone') ?>" <?php echo class_error('phone') ?>>
                                <?php echo form_error('phone') ?>


                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="<?php echo set_value('email') ?>" <?php echo class_error('email') ?>>
                                <?php echo form_error('email') ?>


                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" id="address" value="<?php echo set_value('address') ?>">


                                <label for="role">Vai trò</label>
                                <?php if (!empty($list_role)) {
                                ?>
                                    <select name="role" id="role">
                                        <option disabled>Quản trị hệ thống - Liên hệ quản lý để thêm</option>

                                        <?php foreach ($list_role as $role) {
                                        ?>
                                            <option value="<?php echo $role['role_id'] ?>" selected><?php echo $role['title'] ?></option>
                                        <?php
                                        } ?>
                                        <option disabled>Cộng tác viên - Tính năng đang hoàn thiện</option>

                                    </select>
                                <?php
                                } ?>


                                <button type="submit" name="btn_add" id="btn-submit">Thêm mới</button>
                            </div>

                            <div id="right">
                                <div class="table-responsive">
                                    <?php echo form_error('check_permission') ?>
                                    <table class="table list-table-wp">
                                        <thead>
                                            <tr>
                                                <!-- <td><input type="checkbox" name="checkAll" id="checkAll"></td> -->
                                                <td><span class="thead-text">STT</span></td>
                                                <td><span class="thead-text">Module</span></td>
                                                <?php foreach ($list_permission as $per) {
                                                    if (strtolower($per['title']) != 'all') {
                                                ?>
                                                        <td><span class="thead-text"><?php echo $per['title'] ?></span></td>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td><span class="thead-text">Tất cả quyền</span></td>

                                                <?php
                                                    }
                                                } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($list_module as $module) {
                                            ?>
                                                <tr>
                                                    <!-- <td><input type="checkbox" name="checkItem" class="checkItem"></td> -->
                                                    <td><span class="tbody-text">1</h3></span>
                                                    <td><span class="tbody-text"><?php echo $module['title']; ?></span></td>
                                                    <?php foreach ($list_permission as $per) {
                                                        if (strtolower($per['title']) != 'all') {
                                                    ?>
                                                            <td><input value="<?php echo $per['permission_id'] ?>" data-id="<?php echo $module['module_id'] ?>" type="checkbox" name="check_permission[<?php echo $module['module_id'] ?>][]" class="checkItemRow"></td>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td><input value="<?php echo $per['permission_id'] ?>" data-id="<?php echo $module['module_id'] ?>" type="checkbox" name="check_permission[<?php echo $module['module_id'] ?>]" class="checkAllRow"></td>

                                                    <?php
                                                        }
                                                    } ?>
                                                </tr>
                                            <?php
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #content-access {
        display: flex;
        flex-wrap: nowrap;
    }

    #left {
        flex-basis: 40%;
    }

    #left p.error {
        margin-top: -20px;
        margin-bottom: 20px;
    }

    #left input,
    select {
        width: 80% !important;
        margin-bottom: 20px !important;
    }

    #right {
        flex-basis: 60%;
    }
</style>
<?php
get_footer();
?>