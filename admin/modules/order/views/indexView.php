<?php
get_header();
global $filter, $pagging, $list_order;
?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách đơn hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <?php if (!empty($list_order)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Mã đơn hàng</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Số sản phẩm</span></td>
                                        <td><span class="thead-text">Tổng giá</span></td>
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                        <td><span class="thead-text">Chi tiết</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($list_order as $order) {
                                    ?>
                                        <tr>
                                            <td><input data-id="<?php echo $order['order_id'] ?>" type="checkbox" name="checkItem" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $pagging['index'] ?></h3></span>
                                            <td><span class="tbody-text"><?php echo $order['order_code'] ?></h3></span>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $order['fullname'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=order&action=update&id=<?php echo $order['order_id'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=order&action=delete&id=<?php echo $order['order_id'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $order['total_qty'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo current_format($order['total_price'], " VND") ?></span></td>
                                            <td class="text-center d-flex align-center"><span class="status-<?php echo $order['order_id'] ?> tbody-text status-order <?php echo $order['status'] ?> text-white"><?php echo convert_status($order['status']) ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format_($order['order_time']) ?><br><?php echo timestamp_to_date_format($order['order_time']) ?></span></td>
                                            <td><a href="?mod=order&action=update&id=<?php echo $order['order_id'] ?>" title="" class="tbody-text">Chi tiết</a></td>
                                        </tr>
                                    <?php
                                    $pagging['index']++;} ?>

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
                    get_pagging($pagging['page'], $pagging['total_page'], "?mod=order&action=index&page=", $pagging['key_search'], $pagging['status']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>