<?php

function get_total_post($where = ''){
    $result = db_num_rows("SELECT * FROM `tbl_post` as `tp` {$where}");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}

function get_category($cat_id){
    $result = db_fetch_row("SELECT `cat_id`, `title` FROM `tbl_category` WHERE `cat_id` = '{$cat_id}' AND `type` = 'post'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function get_list_post($where = '', $limit = ''){
    $result = db_fetch_array("SELECT `tp`.`post_id`, `tp`.`title`, `tp`.`slug`, `tp`.`desc`, `tp`.`content`, `tp`.`creator`, `tp`.`creation_time`, `tp`.`cat_id`, `ti`.`url` as `thumb`
                              FROM `tbl_post` as `tp`
                              LEFT JOIN `using_images` as `ui` ON `ui`.`relation_id` = `tp`.`post_id`
                              LEFT JOIN `tbl_image` as `ti` ON `ui`.`image_id` = `ti`.`id`
                              {$where} AND `ui`.`type` = 'post' AND `tp`.`status` = 'ON'
                              GROUP BY `tp`.`post_id`
                              ORDER BY `tp`.`post_id` DESC
                              {$limit}");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function get_post($post_id){
    $result = db_fetch_row("SELECT * FROM `tbl_post` WHERE `post_id` = '{$post_id}' AND `status` = 'ON'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

