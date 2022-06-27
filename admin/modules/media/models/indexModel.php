<?php

function get_total_image($where = ''){
    $result = db_num_rows("SELECT * FROM `tbl_image` as `ti` {$where}");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}

function get_list_media($where = '', $limit = '')
{
    $info = array();
    $enum_value = db_enum_values('using_images', 'type');
    $result = db_fetch_array("SELECT `ti`.`id`, `ti`.`name`, `ti`.`url`, `ui`.`relation_id`, `ui`.`type`
                              FROM `tbl_image` as `ti`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`image_id` = `ti`.`id`
                              {$where}
                              ORDER BY `ti`.`id` DESC
                              {$limit}");
    foreach ($result as $key => &$value) {
        if ($value['type'] == 'product') {
            $info = db_fetch_row("SELECT `name` as `title`, `creator`, `creation_time` FROM `tbl_{$value['type']}` WHERE `{$value['type']}_id` = '{$value['relation_id']}'");
        } else {
            $info = db_fetch_row("SELECT  `title`, `creator`, `creation_time` FROM `tbl_{$value['type']}` WHERE `{$value['type']}_id` = '{$value['relation_id']}'");
        }

        $value['title'] = $info['title'];
        $value['creator'] = $info['creator'];
        $value['creation_time'] = $info['creation_time'];
    }
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}


function get_image($image_id){
    $result = db_fetch_row("SELECT `url`, `name` FROM `tbl_image` WHERE `id` = '{$image_id}'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function update_name_image($image_id, $data){
    $result = db_update('tbl_image', $data, "`id` = '{$image_id}'");
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}
