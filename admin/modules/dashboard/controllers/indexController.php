<?php

function construct()
{
    load_model('index');
    if(!empty($_SESSION['permission_action'])){
        get_notify('warning', $_SESSION['permission_action']);
        unset($_SESSION['permission_action']);
    }
    if(!empty($_SESSION['permission_module'])){
        get_notify('warning', $_SESSION['permission_module']);
        unset($_SESSION['permission_module']);
    }
}

function indexAction()
{
    global $dashboard_status, $dashboard_sales;
    global $pagging, $list_order;


    if ($permission_dashboard = check_permission_dashboard($_SESSION['user_id'])) {
        $dashboard_status = get_order_status();
        $dashboard_sales = get_total_sales();
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $pagging['num_per_page'] = 5;
        $total_order = get_total_order("WHERE 1");
        $pagging = get_param_pagging($total_order, $page);
        $list_order = get_list_order("WHERE 1", "LIMIT {$pagging['start']}, {$pagging['end']}");
    }else{
        
    }
    load_view('index');
}

function hover_list_orderAction()
{
    $result = "";

    $order_id = $_POST['order_id'];
    $order = get_list_order_detail($order_id);

    $result .= "<div id='table-hover-list-order'>";
    $result .= "<table class='table'>";
    $result .= "<thead>";
    $result .=      "<tr>";
    $result .=          "<td class='thead-text'>Ảnh sản phẩm</td>";
    $result .=          "<td class='thead-text'>Tên sản phẩm</td>";
    $result .=      "</tr>";
    $result .= "</thead>";
    $result .= "<tbody>";

    foreach ($order as $value) {
        $result .= "<tr>";
        $result .= "<td><div class='tbody-thumb'><img src='{$value['url']}'></div></td>";
        $result .= "<td class='text-primary'>{$value['name']}</td>";
        $result .= "</tr>";
    }
    $result .= "</tbody>";
    $result .= "</table>";
    $result .= "<div>";
    echo $result;
}
