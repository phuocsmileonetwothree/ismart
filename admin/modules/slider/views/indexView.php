<?php
get_header();
global $filter, $pagging, $list_slider;
?>

<div id="main-content-wp" class="list-product-page list-slider">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách slider</h3>
                    <a href="?mod=slider&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <?php if (!empty($list_slider)) {
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
                                    <?php foreach ($list_slider as $slider) {
                                    ?>
                                        <tr>
                                            <td><input data-id="<?php echo $slider['slider_id'] ?>" type="checkbox" name="checkItem" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $pagging['index'] ?></h3></span>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <img src="<?php echo $slider['url_slider'] ?>" alt="">
                                                </div>
                                            </td>
                                            <td class="">
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $slider['link'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=slider&action=update&id=<?php echo $slider['slider_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=slider&action=delete&id=<?php echo $slider['slider_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $slider['order'] ?></span></td>
                                            <td class="text-center d-flex align-center"><span class="tbody-text text-white <?php echo strtolower($slider['status']) ?> status status-<?php echo $slider['slider_id'] ?>"><?php echo $slider['status'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $slider['creator'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($slider['creation_time']) ?></span></td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        echo "Danh sách slider đang trống . Hãy thêm ngay";
                    } ?>

                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <?php get_pagging($pagging['page'], $pagging['total_page'], "?mod=slider&action=index&page=", $pagging['key_search'], $pagging['status']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>