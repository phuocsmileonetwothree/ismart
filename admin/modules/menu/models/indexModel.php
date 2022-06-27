<?php

function get_total_menu(){
    $result = db_num_rows("SELECT * FROM `tbl_menu`");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}

function get_last_order(){
    $result = db_fetch_row("SELECT `order` FROM `tbl_menu` ORDER BY `order` DESC LIMIT 1");
    if(!empty($result)){
        return (int)$result['order'];
    }else{
        return 0;
    }
}

function get_list_page($where = ''){
    $result = db_fetch_array("SELECT `page_id`, `title` 
                              FROM `tbl_page`
                              {$where}");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function get_list_category($type = 'product')
{
    $result = db_fetch_array("SELECT `cat_id`, `title`, `parent_id`
                              FROM `tbl_category`
                              WHERE `type` = '{$type}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_menu($where = '', $limit = ''){
    $result = db_fetch_array("SELECT * 
                              FROM `tbl_menu`
                              {$where}
                              ORDER BY `order`
                              {$limit}");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}


function check_menu($title, $slug, $where_and = ''){
    $result = db_num_rows("SELECT * FROM `tbl_menu` WHERE (`title` = '{$title}' OR `slug` = '{$slug}') {$where_and}");
    if(!empty($result)){
        return true;
    }else{
        return false;
    }
}

function add_menu($data){
    $result = db_insert('tbl_menu', $data);
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}

function get_menu($menu_id){
    $result = db_fetch_row("SELECT * FROM `tbl_menu` WHERE `menu_id` = '{$menu_id}'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function update_menu($menu_id, $data){
    $result = db_update('tbl_menu', $data, "`menu_id` = '{$menu_id}'");
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}

function delete_menu($menu_id){
    $result = db_delete('tbl_menu', "`menu_id` = '{$menu_id}'");
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}