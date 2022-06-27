<?php

function construct(){
    load_model('index');
}

function indexAction(){
    global $data__;
    $data__['list_slider'] = get_list_slider("LIMIT 6");
    $data__['list_product_newest'] = get_list_product("ORDER BY `tp`.`creation_time` DESC", "LIMIT 10");
    $data__['list_product_by_category'] = get_list_product_by_category();
    
    load_view('index');
}
function add_product_ajaxAction()
{
    $qty = $_POST['qty'];
    $product_id = $_POST['product_id'];
    $result = array();

    $product = get_product_ajax($product_id);
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

    $result['product_id'] = $product_id;
    $result['name'] = $product['name'];
    $result['slug'] = create_slug($product['name']) . $product_id;
    $result['url'] = $product['url'];
    $result['price'] = current_format($product['price']);
    $result['qty'] = $_SESSION['cart']['buy'][$product_id]['qty'];
    $result['total_qty'] = $_SESSION['cart']['info']['total_qty'];
    $result['total_price'] = current_format($_SESSION['cart']['info']['total_price']);

    echo json_encode($result);
}