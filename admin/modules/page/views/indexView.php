<?php
get_header();
global $filter, $pagging, $list_pages;

?>

<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách trang</h3>
                    <a href="?mod=page&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">


                    <?php
                    get_filter($filter);
                    ?>

                    <?php if (!empty($list_pages)) {
                    ?>

                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Tiêu đề</span></td>
                                        <!-- <td><span class="thead-text">Danh mục</span></td> -->
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 1;
                                    foreach ($list_pages as $page) {
                                    ?>
                                        <tr>
                                            <td><input data-id="<?php echo $page['page_id'] ?>" type="checkbox" name="checkItem" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $pagging['index']; ?></h3></span>
                                            <td class="">
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $page['title'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=page&action=update&id=<?php echo $page['page_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=page&action=delete&id=<?php echo $page['page_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <!-- <td><span class="tbody-text">Danh mục 1</span></td> -->
                                            <td class="text-center d-flex align-center"><span class="tbody-text text-white <?php echo strtolower($page['status']) ?> status status-<?php echo $page['page_id'] ?>"><?php echo $page['status'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $page['creator'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($page['creation_time']) ?></span></td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    <?php
                    } ?>



                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>

                    <?php
                    get_pagging($pagging['page'], $pagging['total_page'], "?mod=page&action=index&page=", $pagging['key_search'], $pagging['status'])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
?>