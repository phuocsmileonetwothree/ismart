<?php
get_header();
global $type, $filter;
?>

<div id="main-content-wp" class="list-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách danh mục <?php echo convert_category($type) ?></h3>
                    <a href="?mod=category&type=<?php echo $type ?>&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
                <?php echo note("{$type}_category", 'delete') ?>

            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <div class="table-responsive">
                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Tên</span></td>
                                    <td><span class="thead-text">Mô tả</span></td>
                                    <td><span class="thead-text">Đường dẫn</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                foreach ($list_category as $category) {
                                ?>
                                    <tr>
                                        <td><input data-id="<?php echo $category['cat_id'] ?>" type="checkbox" name="checkItem" class="checkItem"></td>
                                        <td><span class="tbody-text"><?php echo $index; ?></h3></span>
                                        <td class="clearfix">
                                            <div class="tb-title fl-left">
                                                <a href="" title=""><?php echo str_repeat('— ', $category['level']) . $category['title'] ?></a>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=category&type=<?php echo $type ?>&action=update&id=<?php echo $category['cat_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                <li><a href="?mod=category&type=<?php echo $type ?>&action=delete&id=<?php echo $category['cat_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <td style="width: 25%; font-size: 13px;"><span class="tbody-text"><?php if (!empty($category['desc'])) {
                                                                                                                echo $category['desc'];
                                                                                                            } else {
                                                                                                                echo "—";
                                                                                                            } ?></span></td>
                                        <td style="font-size: 13px;"><span class="tbody-text"><?php echo $category['slug'] ?></span></td>
                                        <td style="font-size: 13px;"><span class="tbody-text"><?php echo $category['creator'] ?></span></td>
                                    </tr>
                                <?php
                                    $index++;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <!-- <ul id="list-paging" class="fl-right">
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
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>