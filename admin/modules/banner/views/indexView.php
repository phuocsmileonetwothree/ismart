<?php
get_header();
global $filter, $pagging, $list_banner;
?>

<div id="main-content-wp" class="list-product-page list-banner">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách banner</h3>
                    <a href="?mod=banner&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <?php if (!empty($list_banner)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Hình ảnh</span></td>
                                        <td><span class="thead-text">Link</span></td>
                                        <td><span class="thead-text">Thứ tự</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_banner as $banner) {
                                    ?>
                                        <tr>
                                            <td><input data-id="<?php echo $banner['banner_id'] ?>" type="checkbox" name="checkItem" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $pagging['index'] ?></h3></span>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <img src="<?php echo $banner['url_banner'] ?>" alt="">
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $banner['link'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=banner&action=update&id=<?php echo $banner['banner_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=banner&action=delete&id=<?php echo $banner['banner_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $banner['order'] ?></span></td>
                                            <td class="text-center d-flex align-center"><span class="tbody-text text-white <?php echo strtolower($banner['status']) ?> status status-<?php echo $banner['banner_id'] ?>"><?php echo $banner['status'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $banner['creator'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($banner['creation_time']) ?></span></td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        echo "Danh sách banner đang trống . Hãy thêm ngay";
                    } ?>

                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <?php get_pagging($pagging['page'], $pagging['total_page'], "?mod=banner&action=index&page=", $pagging['key_search'], $pagging['status']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>