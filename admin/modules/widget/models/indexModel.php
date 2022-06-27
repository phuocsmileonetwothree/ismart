<?php
// ------------------------ INDEX ------------------------
function get_total_widget($where = ''){
    $result = db_num_rows("SELECT * FROM `tbl_widget` {$where}");
    if(!empty($result)){
        return $result;
    }else{
        return 0;
    }
}

function get_list_widget($where = '', $limit = ''){
    $result = db_fetch_array("SELECT `widget_id`, `title`, `code`, `creation_time`, `creator`
                              FROM `tbl_widget`
                              {$where}
                              ORDER BY `widget_id` DESC
                              {$limit}");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

// ------------------------ UPDATE ------------------------
function get_widget($widget_id){
    $result = db_fetch_row("SELECT * FROM `tbl_widget` WHERE `widget_id` = '{$widget_id}'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function update_widget($widget_id, $data){
    $result = db_update('tbl_widget', $data, "`widget_id` = '{$widget_id}'");
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}

// ------------------------ DELETE ------------------------
function delete_widget($widget_id){
    $result = db_delete('tbl_widget', "`widget_id` = '{$widget_id}'");
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}

function delete_widget_ajax($where_in){
    $result = db_delete('tbl_widget', $where_in);
    if($result > 0){
        return $result;
    }else{
        return false;
    }
}

// ------------------------ ADD ------------------------
function add_widget($data){
    $result = db_insert('tbl_widget', $data);
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}