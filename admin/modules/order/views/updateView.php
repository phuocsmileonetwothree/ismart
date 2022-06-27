<?php
get_header();
global $list_order_detail;
?>


<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar()
        ?>
        <div id="content" class="detail-exhibition fl-right">
            <!-- Thông tin khách hàng -->
            <div class="section" id="info">
                <div class="section-head">
                    <h3 class="section-title">Thông tin đơn hàng</h3>
                </div>
                <?php if (!empty($list_order_detail['info'])) {
                ?>
                    <ul class="list-item">
                        <li>
                            <h3 class="title">Mã đơn hàng</h3>
                            <span class="detail"><?php echo $list_order_detail['info']['order_code'] ?></span>
                        </li>
                        <li>
                            <h3 class="title">Địa chỉ nhận hàng</h3>
                            <span class="detail"><?php echo $list_order_detail['info']['address'] ?></span>
                        </li>
                        <li>
                            <h3 class="title">Số điện thoại người nhận</h3>
                            <a class="detail" href="tel:<?php echo $list_order_detail['info']['phone'] ?>"><?php echo $list_order_detail['info']['phone'] ?></a>
                        </li>
                        <li>
                            <h3 class="title">Thông tin vận chuyển</h3>
                            <span class="detail"><?php echo convert_payment($list_order_detail['info']['payment']) ?></span>
                        </li>
                        <form method="POST" action="">
                            <li>
                                <h3 class="title">Tình trạng đơn hàng</h3>
                                <select name="status">
                                    <option value='processing' <?php if ($list_order_detail['info']['status'] == 'processing') echo "selected" ?>>Đang xử lý</option>
                                    <option value='cancelled' <?php if ($list_order_detail['info']['status'] == 'cancelled') echo "selected" ?>>Đã hủy</option>
                                    <option value='transported' <?php if ($list_order_detail['info']['status'] == 'transported') echo "selected" ?>>Đang vận chuyển</option>
                                    <option value='successful' <?php if ($list_order_detail['info']['status'] == 'successful') echo "selected" ?>>Giao hàng thành công</option>
                                </select>
                                <input type="submit" name="btn_update" value="Cập nhật đơn hàng">
                            </li>
                        </form>
                    </ul>
                <?php
                } else {
                    echo "Đang cập nhật...";
                } ?>

            </div>


            <!-- Thông tin chi tiết đơn hàng -->
            <div class="section">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm đơn hàng</h3>
                </div>
                <?php if (!empty($list_order_detail['detail'])) {
                ?>
                    <div class="table-responsive">
                        <table class="table info-exhibition">
                            <thead>
                                <tr>
                                    <td class="thead-text">STT</td>
                                    <td class="thead-text">Ảnh sản phẩm</td>
                                    <td class="thead-text">Tên sản phẩm</td>
                                    <td class="thead-text">Đơn giá</td>
                                    <td class="thead-text">Số lượng</td>
                                    <td class="thead-text">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 1;
                                foreach ($list_order_detail['detail'] as $item) {
                                ?>
                                    <tr>
                                        <td class="thead-text"><?php echo $index; ?></td>
                                        <td class="thead-text">
                                            <div class="thumb">
                                                <img src="<?php echo $item['url'] ?>" alt="">
                                            </div>
                                        </td>
                                        <td class="thead-text"><?php echo $item['name'] ?></td>
                                        <td class="thead-text"><?php echo current_format($item['price']) ?></td>
                                        <td class="thead-text"><?php echo $item['qty'] ?></td>
                                        <td class="thead-text"><?php echo current_format($item['qty'] * $item['price'], " VND") ?></td>
                                    </tr>
                                <?php
                                    $index++;
                                } ?>

                            </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    echo "Đang cập nhật...";
                } ?>

            </div>

            <!-- Thông tin tổng đơn hàng -->
            <div class="section">
                <h3 class="section-title">Giá trị đơn hàng</h3>
                <div class="section-detail">
                    <?php if (!empty($list_order_detail['info'])) {
                    ?>
                        <ul class="list-item clearfix">
                            <li>
                                <span class="total-fee">Tổng số lượng</span>
                                <span class="total">Tổng đơn hàng</span>
                            </li>
                            <li>
                                <span class="total-fee"><?php echo $list_order_detail['info']['total_qty'] ?> sản phẩm</span>
                                <span class="total"><?php echo current_format($list_order_detail['info']['total_price'], " VND") ?></span>
                            </li>
                        </ul>
                    <?php
                    } ?>

                </div>
            </div>


        </div>
    </div>
</div>



<?php
get_footer();
?>