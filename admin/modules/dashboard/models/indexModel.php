<?php

function get_order_status()
{
    $result = array();
    $list_status = db_enum_values('tbl_order', 'status');
    foreach ($list_status as $status) {
        $tmp = db_fetch_row("SELECT COUNT(`order_id`) as `{$status}` FROM `tbl_order` WHERE `status` = '{$status}'");
        $result[$status] = $tmp[$status];
    }
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_total_sales($field_return = '')
{
    $result = db_fetch_row("SELECT SUM(`tp`.`price` * `od`.`qty`) as `a`
                            FROM `order_detail` as `od`
                            LEFT JOIN `tbl_product` as `tp` ON `od`.`product_id` = `tp`.`product_id`");
    if (!empty($result)) {
        return $result['a'];
    } else {
        return false;
    }
}

// ------------------------ INDEX ------------------------
function check_permission_dashboard($user_id){
    // module_order_id = 7
    $result = db_num_rows("SELECT `tup`.`id`
                           FROM `tbl_user_permission` as `tup`
                           LEFT JOIN `tbl_module` as `tm` ON `tm`.`module_id` = `tup`.`module_id`
                           WHERE (`tup`.`user_id` = {$user_id} AND `tup`.`module_id` = 1) OR (`tup`.`user_id` = {$user_id} AND `tup`.`module_id` = 7)");
    if(!empty($result)){
        return true;
    }else{
        return false;
    }
}

function get_total_order($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_order` as `to` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_order($where = '', $limit = '')
{
    $result = db_fetch_array("SELECT `to`.`order_id`, `to`.`order_code`, `to`.`fullname`,`to` .`phone`, `to`.`status`, `to`.`order_time`, SUM(`od`.`qty`) as `total_qty`, SUM(`tp`.`price` * `od`.`qty`) as `total_price`
                              FROM `tbl_order` as `to`
                              LEFT JOIN `order_detail` as `od` ON `od`.`order_id` = `to`.`order_id`
                              LEFT JOIN `tbl_product` as `tp` ON `od`.`product_id` = `tp`.`product_id`
                              {$where}
                              GROUP BY `to`.`order_id`
                              ORDER BY `order_id` DESC
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_order_detail($order_id)
{
    $result = db_fetch_array("SELECT `ti`.`url`, `tp`.`name`
                              FROM `order_detail` as `od`
                              LEFT JOIN `tbl_product` as `tp` ON `od`.`product_id` = `tp`.`product_id`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              WHERE `od`.`order_id` = '{$order_id}' AND `ui`.`type` = 'product'
                              GROUP BY `tp`.`product_id`");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
