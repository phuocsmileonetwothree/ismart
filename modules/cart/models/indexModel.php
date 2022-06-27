<?php

function get_product($product_id)
{
    $result = db_fetch_row("SELECT `tp`.`product_id`, `tp`.`code`, `tp`.`name`, `tp`.`price`, `ti`.`url`
                            FROM `tbl_product` as `tp`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `tp`.`product_id` = '{$product_id}' AND `ui`.`type` = 'product' AND `tp`.`status` = 'ON'
                            GROUP BY `tp`.`product_id`");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function add_order($data, $list_order)
{
    $result = db_insert('tbl_order', $data);
    if ($result > 0) {
        db_update('tbl_order', array('`order_code`' => "PHP" . $result), "`order_id` = {$result}");

        foreach ($list_order['buy'] as $item) {
            $data_order_detail = array(
                'order_id' => $result,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
            );
            db_update('tbl_product', array('`purchased`' => $item['qty']), "`product_id` = '{$item['product_id']}'");
            db_insert('order_detail', $data_order_detail);
        }
        return $result;
    } else {
        return false;
    }
}

function get_order($order_id){
    $result = db_fetch_array("SELECT `to`.`order_code`, `to`.`fullname`, `to`.`phone`, `to`.`address`, `to`.`note`, `to`.`payment`, `od`.`qty`, `tp`.`name`, `tp`.`price`, `ti`.`url`
                              FROM `tbl_order` as `to`
                              LEFT JOIN `order_detail` as `od` ON `od`.`order_id` = `to`.`order_id`
                              LEFT JOIN `tbl_product` as `tp` ON `od`.`product_id` = `tp`.`product_id`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              WHERE `to`.`order_id` = '{$order_id}' AND `ui`.`type` = 'product'
                              GROUP BY `tp`.`product_id`");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

