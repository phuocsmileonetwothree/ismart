<?php

function construct()
{
    load_model('index');
}

// SUCCESS
function indexAction()
{
    if (!empty($_SESSION['detail_order']) and $_SESSION['detail_order'] == 'false') {
        unset($_SESSION['detail_order']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc đơn hàng đã được xóa");
    }

    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    global $filter, $pagging, $list_order;
    $filter['filter'] = array();
    $filter['actions'] = array();

    $filter['filter']['all'] = get_total_order(); 
    foreach(db_enum_values('tbl_order', 'status') as $key => $value){
        $filter['filter'][$key] = get_total_order("WHERE `to`.`status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete'); 

    // Người dùng có tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE (`to`.`order_code` LIKE '%{$pagging['key_search']}%') OR (`to`.`fullname` LIKE '%{$pagging['key_search']}%') OR (`to`.`email` LIKE '%{$pagging['key_search']}%') OR (`to`.`phone` LIKE '%{$pagging['key_search']}%') OR (`to`.`address` LIKE '%{$pagging['key_search']}%')";
        $total_order = get_total_order($where);
        $pagging = get_param_pagging($total_order, $page);
    } else { # Người dùng không tìm kiếm
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `to`.`status` = '{$pagging['status']}'";
        } else {
            $where = "WHERE 1";
        }
        $total_order = get_total_order($where);
        $pagging = get_param_pagging($total_order, $page);
    }
    $list_order = get_list_order($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// SUCCESS
function actions_ajaxAction(){
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in = "`order_id` IN (" . implode(', ', $checked_array) . ")";
    $result = array();

    if($action != 'delete'){
        db_update('tbl_order', array('`status`' => $action), $where_in);
        $result['update'] = convert_action($action);
    }else{
        if($id_delete = delete_order_ajax($where_in)){
            $result['delete'] = true;
        }else{
            $result['delete'] = "Bạn chỉ được xóa những đơn hàng có trạng thái \"Đã hủy\"";
        }
    }
    $result['all'] = get_total_order();
    foreach(db_enum_values('tbl_order', 'status') as $key => $value){
        $result[$key] = get_total_order("WHERE `to`.`status` = '{$key}'");
    }
    echo json_encode($result);
}

// SUCCESS
function updateAction()
{
    $order_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    global $list_order_detail;
    if (check_order($order_id)) {
        if (isset($_POST['btn_update'])) {
            $status = $_POST['status'];
            if (update_status_order($order_id, $status)) {
                get_notify('success', "Đã cập nhật tình trạng đơn hàng . <a href='?mod=order&action=index'>Xem danh sách đơn hàng</a>");
            }
        }
        $list_order_detail = get_list_order_detail($order_id);
        load_view('update');
    } else {
        $_SESSION['detail_order'] = 'false';
        redirect_to('?mod=order&action=index');
    }
}


// Đối với nhận diện 1 khách hàng
// Chỉ cần đủ 3 điều kiện sau : trùng số điện thoại và trùng email và trùng tên
// SUCCESS
function customerAction()
{
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    global $filter, $pagging, $list_customer;

    $filter['filter']['all'] = get_total_customer();
    $filter['actions'] = array();
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $pagging['key_search'] = htmlentities($_GET['key']);
        $filter['search']['key'] = htmlentities($_GET['key']);

        $where = "WHERE (`to`.`fullname` LIKE '%{$pagging['key_search']}%') OR (`to`.`email` LIKE '%{$pagging['key_search']}%') OR (`to`.`phone` LIKE '%{$pagging['key_search']}%') OR (`to`.`address` LIKE '%{$pagging['key_search']}%')";
        $total_customer = get_total_customer($where);
        $pagging = get_param_pagging($total_customer, $page);
    }else{
        $total_customer = get_total_customer();
        $pagging = get_param_pagging($total_customer, $page);
        $where = "WHERE 1";
    }
    $list_customer = get_list_customer($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index_customer');
}
