<?php
$list_menu = db_fetch_array("SELECT * FROM `tbl_menu` ORDER BY `order` ASC");
foreach ($list_menu as &$menu) {
    if ($menu['connect_page'] >= 0) {
        if ($menu['connect_page'] == 0) {
            $menu['slug'] = "index.html";
        } else {
            $menu['slug'] = "page/{$menu['slug']}-{$menu['connect_page']}";
        }
    }
    if ($menu['connect_category_product'] >= 0) {
        if ($menu['connect_category_product'] == 0) {
            $menu['slug'] = "category-product/all";
        } else {
            $cat_id = $menu['connect_category_product'];
            $title = db_fetch_row("SELECT `title` FROM `tbl_category` WHERE `cat_id` = '{$cat_id}'");
            $menu['slug']  = "category-product/{$title['title']}-{$menu['connect_category_product']}";
        }
    }
    if ($menu['connect_category_post'] >= 0) {
        if ($menu['connect_category_post'] == 0) {
            $menu['slug'] = "category-post/all";
        } else {
            $cat_id = $menu['connect_category_post'];
            $title = db_fetch_row("SELECT `title` FROM `tbl_category` WHERE `cat_id` = '{$cat_id}'");
            $menu['slug']  = "category-post/{$title['title']}-{$menu['connect_category_post']}";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>">
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="public/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="public/reset.css" rel="stylesheet" type="text/css" />
    <link href="public/css/carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="public/css/carousel/owl.theme.css" rel="stylesheet" type="text/css" />
    <link href="public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="public/style.css" rel="stylesheet" type="text/css" />
    <link href="public/responsive.css" rel="stylesheet" type="text/css" />

    <script src="public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="public/js/elevatezoom-master/jquery.elevatezoom.js" type="text/javascript"></script>
    <script src="public/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    <script src="public/js/carousel/owl.carousel.js" type="text/javascript"></script>
    <script src="public/js/main.js" type="text/javascript"></script>
    <script src="public/js/custom.js" type="text/javascript"></script>
</head>

<body>
    <div id="site" module="<?php echo get_module() ?>">
        <div id="container">
            <div id="header-wp">


                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="<?php echo $list_menu[0]['slug'] ?>" title="" id="payment-link" class="fl-left"><?php echo $list_menu[0]['title'] ?></a>
                        <div id="main-menu-wp" class="fl-right">
                            <?php if (!empty($list_menu)) {
                            ?>
                                <ul id="main-menu" class="clearfix">
                                    <?php for ($i = 1; $i < count($list_menu); $i++) {
                                    ?>
                                        <li>
                                            <a href="<?php echo $list_menu[$i]['slug'] ?>" title=""><?php echo $list_menu[$i]['title'] ?></a>
                                        </li>
                                    <?php
                                    } ?>

                                </ul>
                            <?php
                            } ?>

                        </div>
                    </div>
                </div>


                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <!-- logo -->
                        <a href="index.html" title="" id="logo" class="fl-left"><img src="public/images/logo.png" /></a>
                        <!-- search -->
                        <div id="search-wp" class="fl-left">
                            <form method="GET" action="search/">
                                <input type="search" name="key" id="s" placeholder="Nhập sản phẩm bạn cần tìm !" value="<?php if (isset($_GET['key']) and !empty($_GET['key'])) echo $_GET['key'] ?>">
                                <input type="submit" id="sm-s" value="Tìm kiếm">
                            </form>
                        </div>

                        <div id="action-wp" class="fl-right">
                            <!-- info -->
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0764.710.821</span>
                            </div>

                            <!-- Giỏ hàng responsive -->
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="cart/" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num"><?php echo !empty($_SESSION['cart']['info']) ? $_SESSION['cart']['info']['total_qty'] : 0 ?></span>
                            </a>
                            <!-- Giỏ hàng thường -->
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num"><?php echo !empty($_SESSION['cart']['info']) ? $_SESSION['cart']['info']['total_qty'] : 0 ?></span>
                                </div>
                                <div id="dropdown">
                                    <p class="desc">Có <span><?php echo !empty($_SESSION['cart']['info']) ? $_SESSION['cart']['info']['total_qty'] : 0 ?> sản phẩm</span> trong giỏ hàng</p>
                                    <ul class="list-cart">
                                        <?php
                                        if (!empty($_SESSION['cart']['buy'])) {
                                            foreach ($_SESSION['cart']['buy'] as $item) {
                                        ?>
                                                <li class="clearfix" data-id="<?php echo $item['product_id'] ?>">
                                                    <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="thumb fl-left">
                                                        <img src="admin/<?php echo $item['url'] ?>" alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="product/<?php echo create_slug($item['name']) . "-" . $item['product_id'] ?>" title="" class="product-name"><?php echo $item['name'] ?></a>
                                                        <p class="price"><?php echo current_format($item['price']) ?></p>
                                                        <p class="qty sub-qty-<?php echo $item['product_id'] ?>">Số lượng: <span><?php echo $item['qty'] ?></span></p>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        } ?>

                                    </ul>
                                    <div class="total-price clearfix">
                                        <p class="title fl-left">Tổng:</p>
                                        <p class="price fl-right"><?php echo !empty($_SESSION['cart']['info']) ? current_format($_SESSION['cart']['info']['total_price']) : current_format(0) ?></p>
                                    </div>
                                    <dic class="action-cart clearfix">
                                        <a href="cart/" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                        <a href="checkout/" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                    </dic>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>