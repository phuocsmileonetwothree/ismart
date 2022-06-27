<?php
// ----------------------------- INDEX -----------------------------
function get_total_product($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_product` as `tp` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}
function get_list_category()
{
    $result = db_fetch_array("SELECT * FROM `tbl_category` WHERE `type` = 'product'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_product($where = '', $order_limit = '')
{
    $result = db_fetch_array("SELECT `tp`.`product_id`, `tp`.`name`, `tp`.`price`, `tp`.`old_price`, `ti`.`url`
                              FROM `tbl_product` as `tp`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'product' AND `tp`.`status` = 'ON'
                              GROUP BY `tp`.`product_id`
                              {$order_limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_category($cat_id)
{
    $result = db_fetch_row("SELECT `cat_id`, `title` FROM `tbl_category` WHERE `cat_id` = '{$cat_id}' AND `type` = 'product'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ----------------------------- DETAIL -----------------------------
function get_product($product_id)
{
    $array_empty = array();

    $result = db_fetch_row("SELECT * FROM `tbl_product` WHERE `product_id` = '{$product_id}' AND `status` = 'ON'");
    if (!empty($result)) {
        $result['url_image'] = db_fetch_array("SELECT `ti`.`url`
        FROM `using_images` as `ui` 
        LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
        WHERE `ui`.`relation_id` = '{$product_id}' AND `ui`.`type` = 'product'");
        foreach ($result['url_image'] as $k_item => $v_item) {
            $result['url_image'][] = $v_item['url'];
            unset($result['url_image'][$k_item]);
        }
        $result['url_image'] = array_merge($result['url_image'], $array_empty);
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

