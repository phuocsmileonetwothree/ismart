<?php

// index Action

function get_list_slider($limit = '')
{
    $result = db_fetch_array("SELECT `ti`.`url`, `ts`.`link`, `ts`.`title`
                              FROM `tbl_slider` as `ts`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `ts`.`slider_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              WHERE `ts`.`status` = 'ON' AND `ui`.`type` = 'slider'
                              ORDER BY `ts`.`order`
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_category($type = 'product', $where_and = '')
{
    $result = db_fetch_array("SELECT `cat_id`, `title`, `parent_id` FROM `tbl_category` WHERE NOT `parent_id` = '999999' AND `type` = '{$type}' {$where_and}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_product($order_by = '', $limit = '')
{
    $result = db_fetch_array("SELECT `tp`.`product_id`, `tp`.`name`, `tp`.`price`, `tp`.`old_price`, `tp`.`purchased`, `tp`.`creation_time`, `ti`.`url`
                              FROM `tbl_product` as `tp`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              WHERE `tp`.`status` = 'ON' AND `ui`.`type` = 'product' 
                              GROUP BY `tp`.`product_id`
                              {$order_by}
                              {$limit}");

    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_product_by_category()
{
    $result = array();
    $result = get_list_category('product', "AND `parent_id` = 0");
    $list_category = db_fetch_array("SELECT `cat_id`, `parent_id`, `title` FROM `tbl_category` WHERE `type` = 'product'");
    
    foreach ($result as $key => $value) {
        $where_in = category_tree($list_category, $value['cat_id']);
        $where_in = implode(", ", $where_in);
        $list_product = db_fetch_array("SELECT `tp`.`product_id`, `tp`.`name`, `tp`.`price`, `tp`.`old_price`, `tp`.`purchased`, `tp`.`creation_time`, `ti`.`url`
                                        FROM `tbl_product` as `tp`
                                        LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                                        LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                                        WHERE `tp`.`cat_id` IN ($where_in)
                                        GROUP BY `tp`.`product_id`
                                        ORDER BY RAND()
                                        LIMIT 12");
        $result[$key]['list_product'] = $list_product;
    }
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
function get_product_ajax($product_id)
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