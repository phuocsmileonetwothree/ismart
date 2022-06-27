<?php
// ------------- Index & Update Action -------------
function get_list_category()
{
    $result = db_fetch_array("SELECT * FROM `tbl_category` WHERE `type` = 'product'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
// ------------- Index Action -------------
function get_total_product($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_product` as `tp` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_product($where = '', $limit = '')
{
    $result = db_fetch_array("SELECT `tp`.*, `ti`.`url`, `tc`.`title` as `category_name`
                              FROM `tbl_product` as `tp`
                              LEFT JOIN `tbl_category` as `tc` ON `tp`.`cat_id` = `tc`.`cat_id`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`product_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'product'
                              GROUP BY `tp`.`product_id`
                              ORDER BY `tp`.`product_id` DESC
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
// ------------- Add Action -------------
function get_last_id()
{
    $result = db_fetch_row("SELECT `product_id` FROM `tbl_product` ORDER BY `product_id` DESC LIMIT 1;");
    if (!empty($result)) {
        return $result['product_id'];
    } else {
        return 0;
    }
}

function add_product($data)
{
    $result = db_insert('tbl_product', $data);
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}

function add_image_product($name, $thumb_url, $type = 'product', $product_id)
{
    $id_tbl_image = db_insert('tbl_image', array('`name`' => $name, '`url`' => $thumb_url));
    $id_using_images = db_insert('using_images', array('`image_id`' => $id_tbl_image, '`type`' => $type, '`relation_id`' => $product_id));

    if ($id_tbl_image > 0 and $id_using_images > 0) {
        return true;
    } else {
        return false;
    }
}
// ------------- Delete Action -------------
function delete_product($product_id)
{
    if (db_num_rows("SELECT * FROM `tbl_product` WHERE `product_id` = '{$product_id}'") > 0) {
        // 0. Mảng đường dẫn ảnh cục bộ - Return
        $local_url_image = array();

        // 1. Lấy `image_id` từ bảng `using_images` bằng `product_id`
        $image_id = db_fetch_array("SELECT `image_id` FROM `using_images` WHERE `relation_id` = '{$product_id}' AND `type` = 'product'");
        // 1. Sau đó xóa all record trong bảng `using_images` có `product_id`
        db_delete('using_images', "`relation_id` = '{$product_id}' AND `type` = 'product'");

        // 2. Sau khi có `image_id` thì lấy all record `url` từ bảng `tbl_image` để xóa hình ở máy chủ cục bộ
        foreach ($image_id as $item) {
            $id = $item['image_id'];
            $local_url_image[] = db_fetch_row("SELECT `url` FROM `tbl_image` WHERE `id` = '{$id}'");
            // 2. Sau khi lấy được `url` hình cục bộ thì xóa all record ở bảng `tbl_image` có `id`
            db_delete('tbl_image', "`id` = '{$id}'");
        }

        // 3. Tiếp tục xóa sản phẩm có `product_id`
        $result = db_delete('tbl_product', "`product_id` = '{$product_id}'");
        // 4. Return mảng đường dẫn hình ảnh nằm trong project
        if ($result > 0) {
            return $local_url_image;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function delete_product_ajax($where_in_product, $where_in_using_images)
{
    // 0. Mảng đường dẫn ảnh cục bộ - Return
    $local_url_image = array();

    // 1. Lấy `image_id` từ bảng `using_images` bằng `product_id`
    $image_id = db_fetch_array("SELECT `image_id` FROM `using_images` WHERE {$where_in_using_images} AND `type` = 'product'");
    // 1. Sau đó xóa all record trong bảng `using_images` có `product_id`
    db_delete('using_images', $where_in_using_images . "AND `type` = 'product'");

    // 2. Sau khi có `image_id` thì lấy all record `url` từ bảng `tbl_image` để xóa hình ở máy chủ cục bộ
    foreach ($image_id as $item) {
        $id = $item['image_id'];
        $local_url_image[] = db_fetch_row("SELECT `url` FROM `tbl_image` WHERE `id` = '{$id}'");
        // 2. Sau khi lấy được `url` hình cục bộ thì xóa all record ở bảng `tbl_image` có `id`
        db_delete('tbl_image', "`id` = '{$id}'");
    }

    // 3. Tiếp tục xóa sản phẩm có `product_id`
    $result = db_delete('tbl_product', $where_in_product);
    // 4. Return mảng đường dẫn hình ảnh nằm trong project
    if ($result > 0) {
        return $local_url_image;
    } else {
        return false;
    }
}

// ------------- Update Action -------------
function get_product($product_id)
{
    $list_thumb = array();
    $result = db_fetch_row("SELECT `name`, `code`, `price`, `desc`, `content`, `status`, `cat_id` FROM `tbl_product` WHERE `product_id` = '{$product_id}'");
    if (!empty($result)) {
        $result1 = db_fetch_array("SELECT `ti`.`url` , `ti`.`id`
                                   FROM `tbl_image` as `ti`
                                   LEFT JOIN `using_images` as `ui` ON `ui`.`image_id` = `ti`.`id`
                                   WHERE `ui`.`relation_id` = '{$product_id}' AND `type` = 'product'");
        foreach ($result1 as $item) {
            $list_thumb['list_thumb'][] = $item;

        }
        $result = array_merge($result, $list_thumb);
        return $result;
    } else {
        return false;
    }
}

function update_product($product_id, $data)
{
    $result = db_update('tbl_product', $data, "`product_id` = '{$product_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}


// ------------- Detail Action -------------
function check_product($product_id){
    $result = db_num_rows("SELECT * FROM `tbl_product` WHERE `product_id` = '{$product_id}'");
    if(!empty($result)){
        return true;
    }else{
        return false;
    }
}

function get_status_on($product_id){
    $result = db_num_rows("SELECT * FROM `tbl_product` WHERE `product_id` = '{$product_id}' AND `status` = 'ON'");
    if(!empty($result)){
        return true;
    }else{
        return false;
    }
}