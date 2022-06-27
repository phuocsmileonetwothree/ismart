<!DOCTYPE html>
<html>

<head>
    <title>Quản lý ISMART</title>
    <base href="<?php echo base_url(); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="public/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="public/reset.css" rel="stylesheet" type="text/css" />
    <link href="public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="public/style.css" rel="stylesheet" type="text/css" />
    <link href="public/responsive.css" rel="stylesheet" type="text/css" />

    <script src="public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="public/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    <script src="public/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <!-- <script src="public/js/plugins/ckfinder/ckfinder.js"></script> -->
    <script src="public/js/main.js" type="text/javascript"></script>

</head>


<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div class="wp-inner clearfix">
                    <a href="?" title="" id="logo" class="fl-left">ADMIN</a>
                    <ul id="main-menu" class="fl-left">
                        <!-- DASHBOARD -->
                        <li>
                            <a href="?" title="">Dashboard</a>
                        </li>
                        <!-- PRODUCT -->
                        <li>
                            <a href="" title="">Sản phẩm</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=product&action=add" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=product&action=index" title="">Danh sách sản phẩm</a>
                                </li>
                                <li>
                                    <a href="?mod=category&type=product&action=index" title="">Danh mục sản phẩm</a>
                                </li>
                            </ul>
                        </li>
                        <!-- ORDER -->
                        <li>
                            <a href="" title="">Bán hàng</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=order&action=index" title="">Danh sách đơn hàng</a>
                                </li>
                                <li>
                                    <a href="?mod=order&action=customer" title="">Danh sách khách hàng</a>
                                </li>
                            </ul>
                        </li>
                        <!-- PAGE -->
                        <li>
                            <a href="" title="">Trang</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=page&action=add" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=page&action=index" title="">Danh sách trang</a>
                                </li>
                            </ul>
                        </li>
                        <!-- POST -->
                        <li>
                            <a href="" title="">Bài viết</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=post&action=add" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=post&action=index" title="">Danh sách bài viết</a>
                                </li>
                                <li>
                                    <a href="?mod=category&type=post&action=index" title="">Danh mục bài viết</a>
                                </li>
                            </ul>
                        </li>

                        <!-- MENU -->
                        <li>
                            <a href="?mod=menu&action=index" title="">Menu</a>
                        </li>
                    </ul>
                    <div id="dropdown-user" class="dropdown dropdown-extended fl-right">
                        <button class="dropdown-toggle clearfix" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <div id="thumb-circle" class="fl-left">
                                <?php if (!empty($_SESSION['thumb'])) {
                                ?>
                                    <img src="<?php echo $_SESSION['thumb'] ?>">

                                <?php
                                } else {
                                ?>
                                    <img src="public/images/avatar.jpg">

                                <?php
                                } ?>
                            </div>
                            <span style="color: #fff;">Hi!</span>
                            <h3 id="account" class="fl-right"><?php if (!empty($_SESSION['user_login'])) echo $_SESSION['user_login'] ?></h3>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="?mod=user&action=index" title="Thông tin cá nhân">Thông tin tài khoản</a></li>
                            <li><a href="?mod=user&action=logout" title="Thoát">Thoát</a></li>
                        </ul>
                    </div>
                </div>
            </div>