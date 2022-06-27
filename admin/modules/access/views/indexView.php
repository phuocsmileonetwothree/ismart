<?php
get_header();
global $list_admin;
?>

<style>
    .color-0093E9 {
        color: #0093E9;
    }
</style>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar('admin');
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách thành viên</h3>
                    <a href="?mod=access&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <!-- <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(69)</span></a> |</li>
                            <li class="publish"><a href="">Đã đăng <span class="count">(51)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt<span class="count">(0)</span> |</a></li>
                            <li class="pending"><a href="">Thùng rác<span class="count">(0)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form>
                    </div>
                    <div class="actions">
                        <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option value="1">Công khai</option>
                                <option value="1">Chờ duyệt</option>
                                <option value="2">Bỏ vào thủng rác</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form>
                    </div> -->

                    <?php if (!empty($list_admin)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><span class="thead-text">Ảnh đại diện</span></td>
                                        <td><span class="thead-text">Họ tên</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Ngày tham gia</span></td>
                                        <td><span class="thead-text">Người thêm</span></td>
                                        <td><span class="thead-text">Vai trò</span></td>
                                        <td><span class="thead-text">Chi tiết</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_admin as $admin) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <?php if (!empty($admin['thumb'])) {
                                                    ?>
                                                        <img src="<?php echo $admin['thumb'] ?>" alt="">

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img src="public/images/avatar.jpg" alt="">

                                                    <?php
                                                    } ?>
                                                </div>
                                            </td>
                                            <td><span class="tbody-text color-0093E9"><?php echo $admin['fullname'] ?></h3></span>
                                            <td><span class="tbody-text"><?php echo $admin['phone'] ?></h3></span>
                                            <td><span class="tbody-text"><?php echo $admin['email'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $admin['address'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($admin['creation_time']) ?></span></td>
                                            <td><span class="tbody-text"><?php echo $admin['creator'] ?></span></td>
                                            <td><span class="tbody-text color-0093E9"><?php echo $admin['title'] ?></span></td>
                                            <td class="clearfix">
                                                <ul class="list-operation">
                                                    <li><a href="?mod=access&action=update&id=<?php echo $admin['users_id'] ?>" title="Chi tiết và cập nhật thành viên" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=access&action=delete&id=<?php echo $admin['users_id'] ?>" title="Xóa thành viên" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    <?php
                    } ?>

                </div>
            </div>
            <!-- <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging" class="fl-right">
                        <li>
                            <a href="" title="">
                                << /a>
                        </li>
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                        <li>
                            <a href="" title="">></a>
                        </li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</div>



<?php
get_footer();
?>