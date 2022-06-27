<?php
get_header();
global $dashboard_status, $dashboard_sales;
global $pagging, $list_order;

?>
<style>
    .notify{
        font-size: 14px;
        text-transform: uppercase;
        font-weight: bold;
    }
    .blur-permission {
        cursor: pointer;
        filter: grayscale(50%) blur(5px);
    }

    .auto-hide {
        position: relative;
    }

    a#hover-list-order {
        position: relative;
        padding: 10px;
    }

    a#hover-list-order #table-hover-list-order {
        position: absolute;
        border: 1px solid #333;
        top: 24px;
        left: 20px;
        width: 400px;
        max-height: 155px;
        z-index: 999;
        overflow: scroll;
        overflow-x: hidden;
    }

    .min-height-120 {
        min-height: 120px;
    }

    .card-header {
        padding: 0.75rem 0.25rem !important;

    }

    a {
        color: #787272;
    }

    a:hover {
        text-decoration: none;
    }

    .topnav .navbar-brand {
        width: 15rem;
        padding-left: 1rem;
        padding-right: 1rem;
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .topnav {
        padding-left: 0;
        padding: 10px 0px;
        z-index: 1039;
    }

    /* #sidebar-toggle {
        outline: none;
        border: 0;
        background-color: transparent;
    } */

    .plus-icon {
        font-size: 25px;
        color: #8f8f8f;
    }

    .nav-right {
        flex: 1;
        justify-content: space-between;
        display: flex;
    }

    /* #sidebar {
        width: 15rem;
        height: 100vh;
        z-index: 500;
        padding-top: 3.625rem;
        position: fixed;
        top: 0px;
        left: 0;
    } */

    #wp-content {
        flex: auto;
        /* height: calc(100vh - 58px); */
        min-height: 100vh;
        /* padding-top: 3.625rem; */
        padding-left: 15rem;
    }

    #content {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    #content .card-header {
        text-transform: uppercase;
    }

    .nav-fixed .topnav {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030;
    }

    /* ul#sidebar-menu * {
        list-style: none;
        padding-left: 0;
    }

    #sidebar-menu {
        padding: 20px 15px;
    } */

    /* .nav-link {
        display: block;
        padding: .5rem 1rem;
        position: relative;
    }

    .nav-link.active>a,
    .nav-link:hover>li>a {
        color: #0061f2;
    }

    .nav-link>li>a>i {
        color: #787272;
        font-size: 18px;
    }

    .nav-link .arrow {
        position: absolute;
        right: 10px;
        cursor: pointer;
    }

    #sidebar-menu .sub-menu {
        padding-left: 22px;
        border-left: 1px dashed #b8b8b8;
        margin-left: 6px;
        display: none;
    }

    #sidebar-menu .sub-menu li a {
        display: block;
        padding: 5px 0px;
    } */

    #page-body {
        background-color: #e5e9f0;
    }

    .form-search {
        width: 300px;
    }

    .table tr td {
        vertical-align: middle;
    }

    .table-checkall input[type='checkbox'] {
        cursor: pointer;
    }

    .analytic a {
        position: relative;
        padding-right: 5px;
        margin-right: 5px;
    }

    .analytic a:not(:last-child):after {
        position: absolute;
        content: '|';
        top: -1px;
        right: -5px;
        color: #8c8c8c;
    }
</style>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="container-fluid py-5">
                <div class="row">
                    <div class="col">
                        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                            <div class="card-header text-center hide-permission">ĐƠN HÀNG THÀNH CÔNG</div>
                            <div class="card-body min-height-120 auto-hide" data-num="<?php echo !empty($dashboard_status['successful']) ? $dashboard_status['successful'] : 0; ?>">
                                <h5 class="card-title auto-hide-num"><?php echo !empty($dashboard_status['successful']) ? $dashboard_status['successful'] : 0; ?></h5>
                                <p class="card-text">Đơn hàng giao dịch thành công</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                            <div class="card-header text-center hide-permission">ĐANG XỬ LÝ</div>
                            <div class="card-body min-height-120 auto-hide" data-num="<?php echo !empty($dashboard_status['processing']) ? $dashboard_status['processing'] : 0; ?>">
                                <h5 class="card-title auto-hide-num"><?php echo !empty($dashboard_status['processing']) ? $dashboard_status['processing'] : 0; ?></h5>
                                <p class="card-text">Đơn hàng đang xử lý</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                            <div class="card-header text-center hide-permission">DOANH SỐ</div>
                            <div class="card-body min-height-120 auto-hide" data-num="<?php echo !empty($dashboard_sales) ? current_format($dashboard_sales) : current_format(0); ?>">
                                <h5 class="card-title auto-hide-num"><?php echo !empty($dashboard_sales) ? current_format($dashboard_sales) : current_format(0); ?></h5>
                                <p class="card-text">Doanh số hệ thống</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-header text-center hide-permission">ĐƠN HÀNG HỦY</div>
                            <div class="card-body min-height-120 auto-hide" data-num="<?php echo !empty($dashboard_status['cancelled']) ? $dashboard_status['cancelled'] : 0; ?>">
                                <h5 class="card-title auto-hide-num"><?php echo !empty($dashboard_status['cancelled']) ? $dashboard_status['cancelled'] : 0; ?></h5>
                                <p class="card-text">Đơn hàng bị hủy trong hệ thống</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end analytic  -->


                <div class="card position-relative order-list">
                    <?php if (empty($list_order)) {
                    ?>
                        <h1 class="notify position-absolute">Liên hệ quản lý hoặc quản trị viên để biết thêm thông tin</h1>
                    <?php
                    } ?>
                    <div class="card-header font-weight-bold">
                        ĐƠN HÀNG MỚI
                    </div>
                    <div class="card-body <?php if (empty($list_order)) echo "blur-permission" ?>" onselectstart="return false" onCopy="return false" onCut="return false">
                        <table class="table table-striped" style="margin-bottom: 20px!important;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Khách hàng</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Tổng giá trị</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <?php if (!empty($list_order)) {
                            ?>
                                <tbody>
                                    <?php foreach ($list_order as $order) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $pagging['index'] ?></th>
                                            <td><?php echo $order['order_code'] ?></td>
                                            <td>
                                                <?php echo $order['fullname'] . "<br>" . $order['phone'] ?>
                                            </td>
                                            <td>
                                                <a href="#" id="hover-list-order" class="text-primary" data-id="<?php echo $order['order_id'] ?>">
                                                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>1</td>
                                            <td><?php echo current_format($order['total_price']) ?></td>
                                            <td><span class="badge badge-warning <?php echo $order['status'] ?> text-white"><?php echo $order['status'] ?></span></td>
                                            <td><?php echo timestamp_to_date_format_His($order['order_time'], array('d', 'm', 'Y', 'H', 'i', 's')) ?></td>
                                            <td>
                                                <a href="?mod=order&action=update&id=<?php echo $order['order_id'] ?>" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $pagging['index']++;
                                    } ?>

                                </tbody>
                            <?php
                            } else {
                            ?>
                                <tbody>
                                    <?php foreach (array(1, 2, 3, 4, 5) as $value) {
                                    ?>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>NONE PERMISSION</td>
                                            <td>
                                                NONE
                                            </td>
                                            <td>
                                                <a href="#" id="hover-list-order" class="text-primary">
                                                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>1</td>
                                            <td>NONE</td>
                                            <td><span class="badge badge-warning processing text-white">NONE</span></td>
                                            <td>NONE </td>
                                            <td>
                                                <a href="" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>

                                </tbody>
                            <?php
                            } ?>

                        </table>
                        <?php
                        if (!empty($list_order)) {
                            get_pagging($pagging['page'], $pagging['total_page'], "?mod=dashboard&action=index&page=");
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>