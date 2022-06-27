<?php
// ------------------------------ INDEX ------------------------------
function get_total_post($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_post` as `tp` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_post($where = '', $limit = '')
{
    $result = db_fetch_array("SELECT `tc`.`title` as `category_title`, `tp`.`post_id`, `tp`.`title`, `tp`.`status`, `tp`.`creator`, `tp`.`creation_time`, `ti`.`url` as `thumb`
                              FROM `tbl_post` as `tp`
                              LEFT JOIN `tbl_category` as `tc` ON `tp`.`cat_id` = `tc`.`cat_id`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`post_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'post'
                              ORDER BY `tp`.`post_id` DESC
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ------------------------------ ADD ------------------------------
function get_list_category()
{
    $result = db_fetch_array("SELECT * FROM `tbl_category` WHERE `type` = 'post'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function add_post($data)
{
    $result = db_insert('tbl_post', $data);
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}

function add_image_post($name, $url, $type = 'post', $last_id_post)
{
    $last_id_tbl_image = db_insert('tbl_image', array('`name`' => $name, '`url`' => $url));
    if ($last_id_tbl_image > 0) {
        $last_id_using_images = db_insert('using_images', array('`image_id`' => $last_id_tbl_image, '`type`' => $type, '`relation_id`' => $last_id_post));
        if ($last_id_using_images > 0) {
            return true;
        }
    } else {
        return false;
    }
}

// ------------------------------ UPDATE ------------------------------
function get_post($post_id)
{
    $result = db_fetch_row("SELECT `tp`.*, `ti`.`url` as `thumb` 
                            FROM `tbl_post` as `tp` 
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`post_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `post_id` = '{$post_id}' AND `ui`.`type` = 'post'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function update_post($post_id, $data)
{
    $result = db_update('tbl_post', $data, "`post_id` = '{$post_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}


// ------------------------------ DELETE ------------------------------
function delete_post($post_id)
{
    $data = db_fetch_row("SELECT `ti`.`url` as `thumb`
                          FROM `tbl_post` as `tp` 
                          LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`post_id`
                          LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                          WHERE `tp`.`post_id` = '{$post_id}' AND `ui`.`type` = 'post'");

    $image_id = db_fetch_row("SELECT `image_id` FROM `using_images` WHERE `relation_id` = '{$post_id}' AND `type` = 'post'");
    db_delete('using_images', "`relation_id` = '{$post_id}' AND `type` = 'post'");
    db_delete('tbl_image', "`id` = '{$image_id['image_id']}'");
    $result = db_delete('tbl_post', "`post_id` = '{$post_id}'");
    if ($result > 0) {
        return $data['thumb'];
    } else {
        return false;
    }
}

function delete_post_ajax($where_in_post, $where_in_using_images)
{
    $data = db_fetch_array("SELECT `ti`.`url` as `thumb` 
                            FROM `tbl_post` as `tp`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`post_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `tp`.{$where_in_post} AND `ui`.`type` = 'post'");

    $image_id = db_fetch_array("SELECT `image_id` FROM `using_images` WHERE {$where_in_using_images} AND `type` = 'post'");
    db_delete('using_images', $where_in_using_images . "AND `type` = 'post'");
    foreach ($image_id as $key => $value) {
        db_delete('tbl_image', "`id` = '{$value['image_id']}'");
    }
    $result = db_delete('tbl_post', $where_in_post);
    if ($result > 0) {
        return $data;
    } else {
        return false;
    }
}
