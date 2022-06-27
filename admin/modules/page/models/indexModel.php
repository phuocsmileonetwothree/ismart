<?php
// ---------------------------- INDEX ---------------------------
function get_list_page($where, $limit){
    $result = db_fetch_array("SELECT `title`, `page_id`, `status`, `creator`, `creation_time`
                              FROM `tbl_page`
                              {$where}
                              ORDER BY `page_id` DESC
                              {$limit}");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function get_total_page($where = ''){
    $result = db_num_rows("SELECT * FROM `tbl_page` {$where}");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}

// ---------------------------- UPDATE ---------------------------
function get_page($page_id){
    $result = db_fetch_row("SELECT * FROM `tbl_page` WHERE `page_id` = '{$page_id}'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}
function update_page($page_id, $data){
    $result = db_update('tbl_page', $data, "`page_id` = '{$page_id}'");
    if($result > 0){
        return true;
    }else{
        return false;
    }
}

// ---------------------------- ADD ---------------------------
function add_page($data){
    $result = db_insert('tbl_page', $data);
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

// ---------------------------- DELETE ---------------------------
function delete_page($page_id){
    $result = db_delete('tbl_page', "`page_id` = '{$page_id}'");
    if($result > 0){
        return true;
    }else{
        return false;
    }
}