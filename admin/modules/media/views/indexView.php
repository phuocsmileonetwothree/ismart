<?php
get_header();
global $filter, $pagging, $list_media;
?>

<div id="main-content-wp" class="list-product-page list-slider">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách media</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php get_filter($filter) ?>
                    <div class="table-responsive">
                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><span class="thead-text">Được tải lên cùng</span></td>
                                    <td><span class="thead-text">Hình ảnh</span></td>
                                    <td><span class="thead-text">Danh mục</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Thời gian</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list_media as $media) {
                                ?>
                                    <tr>
                                        <td class="title-media">
                                            <a href="?mod=<?php echo $media['type'] ?>&action=update&id=<?php echo $media['relation_id'] ?>"><?php echo $media['title'] ?></a>
                                        </td>
                                        <td class="d-flex">
                                            <div class="tbody-thumb flex-30">
                                                <img src="<?php echo $media['url'] ?>" alt="">
                                            </div>
                                            <div class="tbody-info-thumb d-flex flex-wrap flex-70">
                                                <span class="thumb-name flex-100 color-0093e9"><?php echo $media['name'] ?></span>
                                                <span class="thumb-url flex-100"><?php echo $media['url'] ?></span>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=media&action=update&id=<?php echo $media['id'] ?>" title="Đổi tên ảnh" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <td><span class="tbody-text color-0093e9"><?php echo convert_media($media['type']) ?></span></td>
                                        <td><span class="tbody-text"><?php echo $media['creator'] ?></span></td>
                                        <td><span class="tbody-text"><?php echo timestamp_to_date_format($media['creation_time']) ?></span></td>
                                    </tr>
                                <?php
                                } ?>


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <?php get_pagging($pagging['page'], $pagging['total_page'], "?mod=media&action=index&page=", $pagging['key_search']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer()
?>