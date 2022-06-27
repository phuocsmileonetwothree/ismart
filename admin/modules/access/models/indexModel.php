<?php

function get_list_admin()
{
    $result = db_fetch_array("SELECT `ta`.`users_id`, `ta`.`thumb`, `ta`.`fullname`, `ta`.`phone`, `ta`.`email`, `ta`.`address`, `ta`.`creation_time`, `ta`.`creator`, `tr`.`title` 
                              FROM `tbl_admin` as `ta`
                              LEFT JOIN `tbl_role` as `tr` ON `ta`.`role_id` = `tr`.`role_id`");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_role(){
    $result = db_fetch_array("SELECT * FROM `tbl_role` WHERE NOT (`title` = 'Quản lý' OR `title` = 'Quản trị hệ thống' OR `title` = 'Cộng tác viên')");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}

function get_list_module($where = '')
{
    $result = db_fetch_array("SELECT * FROM `tbl_module` {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_permission($where = '')
{
    $result = db_fetch_array("SELECT *
                              FROM `tbl_permission`
                              {$where}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function add_admin($data)
{
    $result = db_insert('tbl_admin', $data);
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}

function check_admin($username, $email)
{
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `username` = '{$username}' OR `email` = '{$email}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

function add_permisison($admin_id, $data)
{
    $result = db_insert('tbl_user_permission', $data);
    if ($result > 0) {
        return $result;
    } else {
        return false;
    }
}


function get_admin($admin_id)
{
    $result = db_fetch_row("SELECT `fullname` FROM `tbl_admin` WHERE `users_id` = '{$admin_id}'");
    $result['permission'] = db_fetch_array("SELECT `permission_id`, `module_id` FROM `tbl_user_permission` WHERE `user_id` = '{$admin_id}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}


function delete_permission($admin_id)
{
    $result = db_delete('tbl_user_permission', "`user_id` = '{$admin_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}
function update_admin($admin_id, $data)
{
    $result = db_insert('tbl_user_permission', $data);
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

function check_admin_exist($admin_id)
{
    $result = db_num_rows("SELECT * FROM `tbl_admin` WHERE `users_id` = '{$admin_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

function get_thumb_admin($admin_id)
{
    $result = db_fetch_row("SELECT `thumb` FROM `tbl_admin` WHERE `users_id` = '{$admin_id}'");
    if (!empty($result)) {
        return $result['thumb'];
    } else {
        return '';
    }
}

function delete_admin($admin_id)
{
    if (delete_permission($admin_id)) {
        $result = db_delete('tbl_admin', "`users_id` = '{$admin_id}'");
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
