<?php
get_header();
?>

<div id="main-content-wp" class="cart-page">

    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="cart/" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <?php if (!empty($_SESSION['cart']['buy'])) {
                ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Mã sản phẩm</td>
                                <td>Ảnh sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td colspan="2">Thành tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart']['buy'] as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['code'] ?></td>
                                    <td>
                                        <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="thumb">
                                            <img src="admin/<?php echo $item['url'] ?>" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="name-product"><?php echo $item['name'] ?></a>
                                    </td>
                                    <td><?php echo current_format($item['price']) ?></td>
                                    <td>
                                        <input min=1 type="number" product-id=<?php echo $item['product_id'] ?> name="num-order" value="<?php echo $item['qty'] ?>" class="num-order">
                                    </td>
                                    <td class="sub-total-<?php echo $item['product_id'] ?>"><?php echo current_format($item['sub_total']) ?></td>
                                    <td>
                                        <a href="delete/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="Xóa sản phẩm khỏi giỏ hàng" class="del-product"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php
                            } ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <p id="total-price" class="fl-right">Tổng giá: <span><?php echo current_format($_SESSION['cart']['info']['total_price']) ?></span></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="checkout/" title="" id="checkout-cart">Thanh toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                <?php
                } ?>


            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                <a href="index.html" title="" id="buy-more">Mua tiếp</a><br />
                <a href="delete_all/" title="" id="delete-cart">Xóa giỏ hàng</a>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
?>