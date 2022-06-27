<?php
get_header();
global $list_module, $list_permission, $error, $fullname, $admin_module_permission;
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
                                <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>">

                                <label for="role">Vai trò</label>
                                <select name="role" id="role">
                                    <option value="Biên tập viên" selected>Biên tập viên</option>
                                </select>

                                <button type="submit" name="btn_update" id="btn_update">Cập nhật</button>
                                <button title="Hủy sẽ không lưu những gì bạn thay đổi" type="submit" name="btn_cancel" id="btn_cancel">Hủy</button>
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
                                            <?php 
                                            $index = 1;
                                            foreach ($list_module as $module) {
                                            ?>
                                                <tr>
                                                    <!-- <td><input type="checkbox" name="checkItem" class="checkItem"></td> -->
                                                    <td><span class="tbody-text"><?php echo $index; ?></h3></span>
                                                    <td><span class="tbody-text"><?php echo $module['title']; ?></span></td>
                                                    <?php foreach ($list_permission as $per) {
                                                        if (strtolower($per['title']) != 'all') {
                                                    ?>
                                                            <td><input <?php if(array_key_exists($module['module_id'], $admin_module_permission) and in_array($per['permission_id'], $admin_module_permission[$module['module_id']])) echo "checked='checked'" ?> value="<?php echo $per['permission_id'] ?>" data-id="<?php echo $module['module_id'] ?>" type="checkbox" name="check_permission[<?php echo $module['module_id'] ?>][]" class="checkItemRow"></td>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td><input <?php if(array_key_exists($module['module_id'], $admin_module_permission) and in_array($per['permission_id'], $admin_module_permission[$module['module_id']])) echo "checked='checked'" ?>  value="<?php echo $per['permission_id'] ?>" data-id="<?php echo $module['module_id'] ?>" type="checkbox" name="check_permission[<?php echo $module['module_id'] ?>]" class="checkAllRow"></td>

                                                    <?php
                                                        }
                                                    } ?>
                                                </tr>
                                            <?php
                                            $index++;} ?>

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
    #left button{
        display: inline-block!important;
        margin-right: 10px;
    }
    #left #btn_cancel{
        background: #e63434!important;
        color: #fff!important;
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