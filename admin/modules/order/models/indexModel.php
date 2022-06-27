<?php
// ------------------------ INDEX ------------------------
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
    $result = db_fetch_array("SELECT `to`.`order_id`, `to`.`order_code`, `to`.`fullname`, `to`.`status`, `to`.`order_time`, SUM(`od`.`qty`) as `total_qty`, SUM(`tp`.`price` * `od`.`qty`) as `total_price`
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

// ------------------------ DETAIL ------------------------
function check_order($order_id)
{
    $result = db_num_rows("SELECT * FROM `tbl_order` WHERE `order_id` = '{$order_id}'");
    if (!empty($result)) {
        return true;
    } else {
        return false;
    }
}

function get_list_order_detail($order_id)
{
    $result['info'] = db_fetch_row("SELECT `to`.`order_code`, `to`.`address`, `to`.`phone`, `to`.`payment`, `to`.`status`, `to`.`order_time`, SUM(`od`.`qty`) as `total_qty`, SUM(`tp`.`price` * `od`.`qty`) as `total_price`
                                    FROM `tbl_order` as `to`
                                    LEFT JOIN `order_detail` as `od` ON `od`.`order_id` = `to`.`order_id`
                                    LEFT JOIN `tbl_product` as `tp` ON `od`.`product_id` = `tp`.`product_id`
                                    WHERE `to`.`order_id` = '{$order_id}'");



    $result['detail'] = db_fetch_array("SELECT `ti`.`url`, `tp`.`name`, `tp`.`price`, `od`.`qty`
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

function update_status_order($order_id, $status)
{
    $result = db_update('tbl_order', array('status' => $status), "`order_id` = '{$order_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}
// ------------------------ DELETE ------------------------
function delete_order_ajax($where_in)
{

    if (db_num_rows("SELECT * FROM `tbl_order` WHERE {$where_in} AND `status` = 'cancelled'") == 0) {
        return false;
    } else {
        $result = db_delete('order_detail', $where_in);
        $result = db_delete('tbl_order', $where_in);
        if(!empty($result)){
            return $result;
        }else{
            return false;
        }
    }
}

// ------------------------ CUSTOMER INDEX ------------------------
function get_total_customer($where = ''){
    $result = db_num_rows("SELECT * FROM `tbl_order` as `to` {$where} GROUP BY `to`.`phone`, `to`.`email`, `to`.`address`, `to`.`fullname`");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}
function get_list_customer($where = '', $limit = ''){
    $result = db_fetch_array("SELECT `to`.* , SUM(`od`.`qty`) as `total_qty`, COUNT(`to`.`order_id`) as `total_order`
                              FROM `order_detail` as `od`
                              LEFT JOIN `tbl_order` as `to` ON `od`.`order_id` = `to`.`order_id`
                              {$where}
                              GROUP BY `to`.`phone`, `to`.`email`, `to`.`address`, `to`.`fullname`
                              ORDER BY `to`.`order_id` DESC
                              {$limit}");

    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}