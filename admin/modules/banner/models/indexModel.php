<?php
// ---------------------------- INDEX ----------------------------
function get_total_banner($where = '')
{
    $result = db_num_rows("SELECT * FROM `tbl_banner` as `tb` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_banner($where = '', $limit = '')
{
    $result = db_fetch_array("SELECT `tb`.*, `ti`.`url` as `url_banner`
                              FROM `tbl_banner` as `tb`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'banner'
                              ORDER BY `tb`.`order`
                              {$limit}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ---------------------------- UPDATE ----------------------------
function get_banner($banner_id)
{
    $result = db_fetch_row("SELECT `tb`.*, `ti`.`url` as `url_banner`
                            FROM `tbl_banner` as `tb`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `tb`.`banner_id` = '{$banner_id}' AND `ui`.`type` = 'banner'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function update_banner($banner_id, $data)
{
    $result = db_update('tbl_banner', $data, "`banner_id` = '{$banner_id}'");
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}

// ---------------------------- DELETE ----------------------------
function delete_banner($banner_id)
{
    $local_url_banner = db_fetch_row("SELECT `ti`.`url` as `url_banner`, `ui`.`id` as `using_id`, `ti`.`id` as `image_id`
                                      FROM `tbl_banner` as `tb`
                                      LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                                      LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                                      WHERE `tb`.`banner_id` = '{$banner_id}' AND `ui`.`type` = 'banner'");

    if (!empty($local_url_banner)) {
        db_delete('using_images', "`id` = '{$local_url_banner['using_id']}'");
        db_delete('tbl_image', "`id` = '{$local_url_banner['image_id']}'");
        $result = db_delete('tbl_banner', "`banner_id` = '{$banner_id}'");
        if ($result > 0) {
            return $local_url_banner['url_banner'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function delete_banner_ajax($where_in_banner, $where_in_using_images)
{
    $data = db_fetch_array("SELECT `ti`.`url` as `url_banner`
                            FROM `tbl_banner` as `tb`
                            LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tb`.`banner_id`
                            LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                            WHERE `tb`.{$where_in_banner} AND `ui`.`type` = 'banner'");

    $image_id = db_fetch_array("SELECT `image_id` FROM `using_images` WHERE {$where_in_using_images} AND `type` = 'banner'");
    db_delete('using_images', $where_in_using_images . "AND `type` = 'banner'");
    foreach ($image_id as $key => $value) {
        db_delete('tbl_image', "`id` = '{$value['image_id']}'");
    }
    $result = db_delete('tbl_banner', $where_in_banner);
    if ($result > 0) {
        return $data;
    } else {
        return false;
    }
}

// ---------------------------- ADD ----------------------------
function add_banner($data)
{
    $result = db_insert('tbl_banner', $data);
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}
function add_image_banner($name, $url, $type = 'banner', $last_id_banner)
{
    $last_id_tbl_image = db_insert('tbl_image', array('`name`' => $name, '`url`' => $url));
    if ($last_id_tbl_image > 0) {
        $last_id_using_images = db_insert('using_images', array('`image_id`' => $last_id_tbl_image, '`type`' => $type, '`relation_id`' => $last_id_banner));
        if ($last_id_using_images > 0) {
            return true;
        }
    } else {
        return false;
    }
}
