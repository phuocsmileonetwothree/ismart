<?php


function check_user_login($username, $password)
{
    $result = db_fetch_row("SELECT `fullname`, `users_id`, `thumb` FROM `tbl_admin` WHERE `username` = '{$username}' AND `password` = '{$password}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_info_user($user_id)
{
    $result = db_fetch_row("SELECT `tr`.`title`, `ta`.`fullname`, `ta`.`username`, `ta`.`email`, `ta`.`phone`, `ta`.`address`, `ta`.`creation_time`, `ta`.`thumb` 
                            FROM `tbl_admin` as `ta`
                            LEFT JOIN `tbl_role` as `tr` ON `ta`.`role_id` = `tr`.`role_id`
                            WHERE `users_id` = '{$user_id}'");


    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function update_info_user($user_id, $data)
{
    $result = db_update('tbl_admin', $data, "`users_id` = '{$user_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

function check_password($password)
{
    $result = db_num_rows("SELECT `creation_time` FROM `tbl_admin` WHERE `password` = '{$password}'");
    if (!empty($result)) {
        return true;
    } else {
        return false;
    }
}

function update_password($user_id, $new_password)
{
    $result = db_update('tbl_admin', array('`password`' => $new_password), "`users_id` = '{$user_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}
