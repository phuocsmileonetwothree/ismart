<?php
get_header();
global $list_checkout;
?>
<style>
    span.obligatory {
        color: red;
        margin-right: 5px;
    }

    .input-error {
        outline: 2px solid transparent;
        border-radius: 4px !important;
        border-color: #d63638 !important;
        box-shadow: 0 0 2px rgb(214 54 56 / 80%);
    }
</style>
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="checkout/" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper" class="wp-inner clearfix">
        <form method="POST" action="" name="form-checkout">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname"><span class="obligatory">(*)</span>Họ tên</label>
                            <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" placeholder="<?php echo strip_tags(form_error('fullname')) ?>" <?php echo class_error('fullname') ?>>
                        </div>
                        <div class="form-col fl-right">
                            <label for="email"><span class="obligatory">(*)</span>Email</label>
                            <input type="email" name="email" id="email" value="<?php echo set_value('email') ?>" placeholder="<?php echo strip_tags(form_error('email')) ?>" <?php echo class_error('email') ?>>
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address"><span class="obligatory">(*)</span>Địa chỉ</label>
                            <input type="text" name="address" id="address" value="<?php echo set_value('address') ?>" placeholder="<?php echo strip_tags(form_error('address')) ?>" <?php echo class_error('address') ?>>
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone"><span class="obligatory">(*)</span>Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="<?php echo set_value('phone') ?>" placeholder="<?php echo strip_tags(form_error('phone')) ?>" <?php echo class_error('phone') ?>>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="notes"><?php echo set_value('notes') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <!-- danh sách đơn hàng -->
                    <?php if (!empty($list_checkout)) {
                    ?>
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td></td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list_checkout['buy'] as $item) {
                                ?>
                                    <tr class="cart-item">
                                        <td><img width="75px" height="75px" src="admin/<?php echo $item['url'] ?>" alt=""></td>
                                        <td style="text-align: left;" class="product-name"><?php echo $item['name'] ?><strong class="product-quantity" style="color: #f12a43;">x <?php echo $item['qty'] ?></strong></td>
                                        <td class="product-total" style="color: #f12a43;"><?php echo current_format($item['sub_total']) ?></td>
                                    </tr>
                                <?php
                                } ?>

                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td></td>
                                    <td><strong class="total-price" style="color: #f12a43;"><?php echo current_format($list_checkout['info']['total_price']) ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php
                    } ?>

                    <!-- input cod store -->
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input checked type="radio" id="payment-home" name="payment_method" value="cod">
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                            <li>
                                <input type="radio" id="direct-payment" name="payment_method" value="store">
                                <label for="direct-payment">Thanh toán online qua thẻ</label>
                            </li>
                        </ul>
                    </div>
                    <!-- input submit -->
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" name="btn_checkout" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
get_footer();
?>