<?php
// ---------------------------- INDEX ----------------------------
function get_total_slider($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_slider` as `ts` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_slider($where = '', $limit = '')
{
    $result = db_fetch_array("SELECT `ts`.*, `ti`.`url` as `url_slider`
                              FROM `tbl_slider` as `ts`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `ts`.`slider_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'slider'
                              ORDER BY `ts`.`order`
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ---------------------------- UPDATE ----------------------------
function get_slider($slider_id)
{
    $result = db_fetch_row("SELECT `ts`.*, `ti`.`url` as `url_slider`
                            FROM `tbl_slider` as `ts`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `ts`.`slider_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `ts`.`slider_id` = '{$slider_id}' AND `ui`.`type` = 'slider'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function update_slider($slider_id, $data)
{
    $result = db_update('tbl_slider', $data, "`slider_id` = '{$slider_id}'");
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}

// ---------------------------- DELETE ----------------------------
function delete_slider($slider_id)
{
    $local_url_slider = db_fetch_row("SELECT `ti`.`url` as `url_slider`, `ui`.`id` as `using_id`, `ti`.`id` as `image_id`
                                      FROM `tbl_slider` as `ts`
                                      LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `ts`.`slider_id`
                                      LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                                      WHERE `ts`.`slider_id` = '{$slider_id}' AND `ui`.`type` = 'slider'");

    if (!empty($local_url_slider)) {
        db_delete('using_images', "`id` = '{$local_url_slider['using_id']}'");
        db_delete('tbl_image', "`id` = '{$local_url_slider['image_id']}'");
        $result = db_delete('tbl_slider', "`slider_id` = '{$slider_id}'");
        if ($result > 0) {
            return $local_url_slider['url_slider'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function delete_slider_ajax($where_in_slider, $where_in_using_images)
{
    $data = db_fetch_array("SELECT `ti`.`url` as `url_slider`
                            FROM `tbl_slider` as `ts`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `ts`.`slider_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `ts`.{$where_in_slider} AND `ui`.`type` = 'slider'");

    $image_id = db_fetch_array("SELECT `image_id` FROM `using_images` WHERE {$where_in_using_images} AND `type` = 'slider'");
    db_delete('using_images', $where_in_using_images . "AND `type` = 'slider'");
    foreach ($image_id as $key => $value) {
        db_delete('tbl_image', "`id` = '{$value['image_id']}'");
    }
    $result = db_delete('tbl_slider', $where_in_slider);
    if ($result > 0) {
        return $data;
    } else {
        return false;
    }
}

// ---------------------------- ADD ----------------------------
function add_slider($data)
{
    $result = db_insert('tbl_slider', $data);
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
function add_image_slider($name, $url, $type = 'slider', $last_id_slider)
{
    $last_id_tbl_image = db_insert('tbl_image', array('`name`' => $name, '`url`' => $url));
    if ($last_id_tbl_image > 0) {
        $last_id_using_images = db_insert('using_images', array('`image_id`' => $last_id_tbl_image, '`type`' => $type, '`relation_id`' => $last_id_slider));
        if ($last_id_using_images > 0) {
            return true;
        }
    } else {
        return false;
    }
}
