<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    global $pagging, $sort_by;
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $cat_id = !empty($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;

    if ($data__['category'] = get_category($cat_id)) {
        $list_category = get_list_category();
        $where_in = category_tree($list_category, $cat_id);
        $where_in = implode(", ", $where_in);
        $where = "WHERE `tp`.`cat_id` IN ({$where_in})";
        $total_product = get_total_product($where);
        $pagging = get_param_pagging($total_product, $page);
        $pagging['cat_id'] = $cat_id;
        $pagging['title'] = create_slug($data__['category']['title']);
    } else {
        $where = "WHERE 1";
        $total_product = get_total_product();
        $pagging = get_param_pagging($total_product, $page);
        $pagging['cat_id'] = 0;
    }

    $order_by = "";
    if (isset($_GET['sort-by'])) {
        $sort_by = $_GET['sort-by'];
        echo $sort_by;
        if ($sort_by == "price-ascending") {
            $order_by = "ORDER BY `tp`.`price` ASC";
        }
        if ($sort_by == "price-descending") {
            $order_by = "ORDER BY `tp`.`price` DESC";
        }
        if ($sort_by == "name-ascending") {
            $order_by = "ORDER BY `tp`.`name` ASC";
        }
        if ($sort_by == "name-descending") {
            $order_by = "ORDER BY `tp`.`name` DESC";
        }
    }

    $data__['list_product_by_cat_id'] = get_list_product($where, "{$order_by} LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index', $data__);
}


function filter_ajaxAction()
{
    $result = '';
    $range_price = $_POST['range_price'];
    $cat_id = $_POST['cat_id'];


    if ($range_price == "<500") {
        $range_price = "`tp`.`price` > 1000 AND `tp`.`price` < 500000";
    }
    if ($range_price == "500-1000") {
        $range_price = "`tp`.`price` > 500000 AND `tp`.`price` < 1000000";
    }
    if ($range_price == "1000-5000") {
        $range_price = "`tp`.`price` > 1000000 AND `tp`.`price` < 5000000";
    }
    if ($range_price == "5000-10000") {
        $range_price = "`tp`.`price` > 5000000 AND `tp`.`price` < 10000000";
    }
    if ($range_price == ">10000") {
        $range_price = "`tp`.`price` > 10000000";
    }

    $list_product = get_list_product("WHERE (`tp`.`cat_id` IN (SELECT `cat_id` FROM `tbl_category` WHERE `parent_id` = '{$cat_id}' OR `cat_id` = '{$cat_id}')) AND ($range_price)", "LIMIT 20");

    if (!empty($list_product)) {
        foreach ($list_product as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['name'];
            $product_url = $item['url'];
            $product_price = current_format($item['price']);
            $product_old_price = current_format($item['old_price']);

            $result .= "<li>";
            $result .= "<a href='?mod=product&action=detail&id={$product_id}' title='' class='thumb'>
                        <img src='admin/{$product_url}'>
                    </a>";
            $result .= "<a href='?mod=product&action=detail&id={$product_id}' title='' class='product-name'>{$product_name}</a>";
            $result .= "<div class='price'>
                        <span class='new'>{$product_price}</span>
                        <span class='old'>{$product_old_price}</span>
                    </div>";
            $result .= "<div class='action clearfix'>
                        <a href='?mod=cart&action=add&id={$product_id}' title='Thêm giỏ hàng' class='add-cart fl-left'>Thêm giỏ hàng</a>
                        <a href='?mod=cart&action=checkout&id={$product_id}' title='Mua ngay' class='buy-now fl-right'>Mua ngay</a>
                    </div>";
            $result .= "</li>";
        }
    } else {
        $result = "<p style='text-align:center;'>Đang cập nhật sản phẩm...</p>";
    }


    echo $result;
}

function searchAction()
{
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    if (!empty($_GET['key'])) {
        $pagging['key_search'] =  htmlentities($_GET['key']);
        $where = "LEFT JOIN `tbl_category` as `tc` ON `tp`.`cat_id` = `tc`.`cat_id` WHERE ((`tp`.`name` LIKE '%{$pagging['key_search']}%') OR (`tc`.`title` LIKE'%{$pagging['key_search']}%') OR (`tp`.`content` LIKE'%{$pagging['key_search']}%') OR (`tp`.`desc` LIKE'%{$pagging['key_search']}%'))";
        $total_product = get_total_product($where);
        $pagging = get_param_pagging($total_product, $page);

        $data__['list_product_search'] = get_list_product($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
        load_view('search', $data__);
    }
}

function detailAction()
{
    $id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($data__['product'] = get_product($id)) {
        $price = $data__['product']['price'];
        $root_id = get_root_parent(get_list_category(), $data__['product']['cat_id']);
        $data__['list_related_product'] = get_list_product("WHERE `tp`.`cat_id` IN (SELECT `cat_id` FROM `tbl_category` WHERE `parent_id` = '{$root_id}')
                                                          AND (`tp`.`price` BETWEEN {$price} - 10000000 AND {$price} + 10000000)
                                                          AND NOT `tp`.`product_id` = '{$id}'", "LIMIT 10");
        load_view('detail', $data__);
    } else {
        echo "Có thể sản phẩm không còn hoạt động";
    }
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
