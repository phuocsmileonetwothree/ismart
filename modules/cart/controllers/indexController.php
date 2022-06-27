<?php

function construct()
{
    load_model('index');

}

function indexAction()
{
    load_view('index');
}

function update_ajaxAction()
{
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    $_SESSION['cart']['buy'][$product_id]['qty'] = $qty;
    $_SESSION['cart']['buy'][$product_id]['sub_total'] = $_SESSION['cart']['buy'][$product_id]['price'] * $_SESSION['cart']['buy'][$product_id]['qty'];

    $total_qty = 0;
    $total_price = 0;
    if (!empty($_SESSION['cart']['buy'])) {
        foreach ($_SESSION['cart']['buy'] as $item) {
            $total_price += $item['sub_total'];
            $total_qty += $item['qty'];
        }
        $_SESSION['cart']['info'] = array(
            'total_qty' => $total_qty,
            'total_price' => $total_price,
        );
    }

    $result = array(
        'sub_qty' => $_SESSION['cart']['buy'][$product_id]['qty'],
        'sub_total' => current_format($_SESSION['cart']['buy'][$product_id]['sub_total']),
        'total_qty' => $_SESSION['cart']['info']['total_qty'],
        'total_price' => current_format($_SESSION['cart']['info']['total_price'])
    );

    echo json_encode($result);
}

function addAction()
{
    $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
    if (empty($qty)) {
        $qty = 1;
    }
    $product_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($product = get_product($product_id)) {
        if (array_key_exists($product_id, $_SESSION['cart']['buy'])) {
            $_SESSION['cart']['buy'][$product_id]['qty'] = $qty + $_SESSION['cart']['buy'][$product_id]['qty'];
            $_SESSION['cart']['buy'][$product_id]['sub_total'] = $_SESSION['cart']['buy'][$product_id]['price'] * $_SESSION['cart']['buy'][$product_id]['qty'];
        } else {
            $_SESSION['cart']['buy'][$product_id] = $product;
            $_SESSION['cart']['buy'][$product_id]['qty'] = $qty;
            $_SESSION['cart']['buy'][$product_id]['sub_total'] = $_SESSION['cart']['buy'][$product_id]['price'] * $_SESSION['cart']['buy'][$product_id]['qty'];
        }

        $total_qty = 0;
        $total_price = 0;
        if (!empty($_SESSION['cart']['buy'])) {
            foreach ($_SESSION['cart']['buy'] as $item) {
                $total_price += $item['sub_total'];
                $total_qty += $item['qty'];
            }
            $_SESSION['cart']['info'] = array(
                'total_qty' => $total_qty,
                'total_price' => $total_price,
            );
        }
        redirect_to("?mod=cart&action=index");
    } else {
        echo "Có thể sản phẩm không còn hoạt động";
    }
}

function deleteAction()
{
    $product_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if (array_key_exists($product_id, $_SESSION['cart']['buy'])) {
        $_SESSION['cart']['info']['total_qty'] = $_SESSION['cart']['info']['total_qty'] - $_SESSION['cart']['buy'][$product_id]['qty'];
        $_SESSION['cart']['info']['total_price'] = $_SESSION['cart']['info']['total_price'] - $_SESSION['cart']['buy'][$product_id]['sub_total'];
        unset($_SESSION['cart']['buy'][$product_id]);
    }
    redirect_to('?mod=cart&action=index');
}

function delete_allAction()
{
    unset($_SESSION['cart']);
    redirect_to('?mod=cart&action=index');
}

function checkoutAction()
{
    // Checkout có 2 luồng
    # 1. Từ cart qua nên ko có id
    # 2. Mua ngay bất kì đâu nên có id
    load('lib', 'validation_form');
    global $list_checkout;
    $list_checkout = array(
        'buy' => array(),
        'info' => array(),
    );
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $product_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($product = get_product($product_id)) {
            $product['qty'] = 1;
            $product['sub_total'] = $product['price'];

            $list_checkout['buy'][] = $product;
            $list_checkout['info'] = array(
                'total_qty' => 1,
                'total_price' => $product['price'],
            );
        } else {
            redirect_to("?mod=home&action=index");
        }
    } else {
        $list_checkout['buy'] = $_SESSION['cart']['buy'];
        $list_checkout['info'] = $_SESSION['cart']['info'];
        if (empty($_SESSION['cart']['buy'])) {
            redirect_to("?mod=home&action=index");
        }
    }


    global $error, $fullname, $email, $address, $phone, $notes;
    if (isset($_POST['btn_checkout'])) {

        #fullname
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "<p class='error'>Nhập họ và tên</p>";
        } else {
            $fullname = $_POST['fullname'];
        }

        #email
        if (empty($_POST['email'])) {
            $error['email'] = "<p class='error'>Nhập tài khoản email</p>";
        } else {
            $email = $_POST['email'];
        }

        #phone
        if (empty($_POST['phone'])) {
            $error['phone'] = "<p class='error'>Nhập số điện thoại</p>";
        } else {
            $phone = $_POST['phone'];
        }

        #address
        if (empty($_POST['address'])) {
            $error['address'] = "<p class='error'>Nhập địa chỉ</p>";
        } else {
            $address = $_POST['address'];
        }

        #note
        if (empty($_POST['note'])) {
            $notes = "";
        } else {
            $notes = $_POST['note'];
        }

        #payment_method
        $payment_method = $_POST['payment_method'];

        if (empty($error)) {
            $data = array(
                '`fullname`' => $fullname,
                '`email`' => $email,
                '`address`' => $address,
                '`phone`' => $phone,
                '`note`' => $notes,
                '`payment`' => $payment_method,
                '`order_time`' => time(),
                '`status`' => 'processing',
            );
            if ($last_order_id = add_order($data, $list_checkout)) {
                if (!isset($product)) {
                    unset($_SESSION['cart']);
                }
                $info_order_email = get_order($last_order_id);
                load('lib', 'mail');
                $content_detail = set_content_email($info_order_email);
                $order_code = $info_order_email[0]['order_code'];
                $order_fullname = $info_order_email[0]['fullname'];
                $order_phone = $info_order_email[0]['phone'];
                $order_address = $info_order_email[0]['address'];
                $content  = "<h2>Chào bạn <b>{$order_fullname}</b> . Bạn vui lòng kiểm tra lại thông tin đơn hàng vừa đặt ở ISMART</h2><hr>";

                $content .= "<h3>Thông tin cá nhân</h3>";
                $content .= "<p>Mã đơn hàng <b>{$order_code}</b></p>";
                $content .= "<p>Tên khách hàng <b>{$order_fullname}</b></p>";
                $content .= "<p>Số điện thoại liên lạc <b>{$order_phone}</b></p>";
                $content .= "<p>Địa chỉ nhận hàng <b>{$order_address}</b></p><br><hr><br>";


                $content .= $content_detail;

                $content .= "<br><hr><br><p>Chúng tôi thực sự biết ơn bạn vì đã chọn chúng tôi làm nhà cung cấp dịch vụ và cho chúng tôi cơ hội phát triển. Không có thành tựu nào mà chúng tôi có thể đạt được nếu không có bạn , bởi sự tin tưởng của bạn dành cho của chúng tôi là động lực giúp chúng tôi phát triển mạnh mẽ hơn nữa<p>";
                $content .= "<p style='color:red;'>Nếu có bất kỳ thắc mắc nào về đơn hàng trên thì hãy liên hệ với TEAM SUPPORT qua hotline : <b>0764710821</b></h3>";
                load('lib', 'sendmail');
                global $config;
                sendMailEasy($config['email'], $email, $fullname, "Chúc mừng bạn đã đặt hàng thành công", $content);




                redirect_to("thanks/");
            } else {
                echo "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
                die();
            }
        }
    }

    load_view('checkout');
}

function thanksAction()
{
    load_view('thanks');
}
