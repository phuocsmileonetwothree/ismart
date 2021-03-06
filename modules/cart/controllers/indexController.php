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
        echo "C?? th??? s???n ph???m kh??ng c??n ho???t ?????ng";
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
    // Checkout c?? 2 lu???ng
    # 1. T??? cart qua n??n ko c?? id
    # 2. Mua ngay b???t k?? ????u n??n c?? id
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
            $error['fullname'] = "<p class='error'>Nh???p h??? v?? t??n</p>";
        } else {
            $fullname = $_POST['fullname'];
        }

        #email
        if (empty($_POST['email'])) {
            $error['email'] = "<p class='error'>Nh???p t??i kho???n email</p>";
        } else {
            $email = $_POST['email'];
        }

        #phone
        if (empty($_POST['phone'])) {
            $error['phone'] = "<p class='error'>Nh???p s??? ??i???n tho???i</p>";
        } else {
            $phone = $_POST['phone'];
        }

        #address
        if (empty($_POST['address'])) {
            $error['address'] = "<p class='error'>Nh???p ?????a ch???</p>";
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
                $content  = "<h2>Ch??o b???n <b>{$order_fullname}</b> . B???n vui l??ng ki???m tra l???i th??ng tin ????n h??ng v???a ?????t ??? ISMART</h2><hr>";

                $content .= "<h3>Th??ng tin c?? nh??n</h3>";
                $content .= "<p>M?? ????n h??ng <b>{$order_code}</b></p>";
                $content .= "<p>T??n kh??ch h??ng <b>{$order_fullname}</b></p>";
                $content .= "<p>S??? ??i???n tho???i li??n l???c <b>{$order_phone}</b></p>";
                $content .= "<p>?????a ch??? nh???n h??ng <b>{$order_address}</b></p><br><hr><br>";


                $content .= $content_detail;

                $content .= "<br><hr><br><p>Ch??ng t??i th???c s??? bi???t ??n b???n v?? ???? ch???n ch??ng t??i l??m nh?? cung c???p d???ch v??? v?? cho ch??ng t??i c?? h???i ph??t tri???n. Kh??ng c?? th??nh t???u n??o m?? ch??ng t??i c?? th??? ?????t ???????c n???u kh??ng c?? b???n , b???i s??? tin t?????ng c???a b???n d??nh cho c???a ch??ng t??i l?? ?????ng l???c gi??p ch??ng t??i ph??t tri???n m???nh m??? h??n n???a<p>";
                $content .= "<p style='color:red;'>N???u c?? b???t k??? th???c m???c n??o v??? ????n h??ng tr??n th?? h??y li??n h??? v???i TEAM SUPPORT qua hotline : <b>0764710821</b></h3>";
                load('lib', 'sendmail');
                global $config;
                sendMailEasy($config['email'], $email, $fullname, "Ch??c m???ng b???n ???? ?????t h??ng th??nh c??ng", $content);




                redirect_to("thanks/");
            } else {
                echo "H??? th???ng ???? x???y ra l???i . Mong b???n th??? l???i sau";
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
