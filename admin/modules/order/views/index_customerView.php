<?php
get_header();
global $filter, $pagging, $list_customer;
?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách khách hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    get_filter($filter);
                    ?>
                    <?php if (!empty($list_customer)) {
                    ?>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <!-- <td><input type="checkbox" name="checkAll" id="checkAll"></td> -->
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Đơn hàng</span></td>
                                        <td><span class="thead-text">Số lượng sản phẩm</span></td>
                                        <td><span class="thead-text">Thời gian</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list_customer as $customer) {
                                    ?>
                                        <tr>
                                            <!-- <td><input type="checkbox" name="checkItem" class="checkItem"></td> -->
                                            <td><span class="tbody-text"><?php echo $pagging['index']; ?></h3></span>
                                            <td>
                                                <div class="fl-left">
                                                    <span class="tbody-text"><?php echo $customer['fullname'] ?></span>
                                                </div>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $customer['phone'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['email'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['address'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['total_order'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo $customer['total_qty'] ?></span></td>
                                            <td><span class="tbody-text"><?php echo timestamp_to_date_format($customer['order_time']) ?></span></td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    } ?>


                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                        echo "<p style='text-align='center'>Đang cập nhật</p>";
                    } ?>

                </div>
            </div>


            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <?php
                    get_pagging($pagging['page'], $pagging['total_page'], "?mod=order&action=customer&page=", $pagging['key_search']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>