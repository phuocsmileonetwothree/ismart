<?php

function check_permission_module($module)
{
    global $config;
    $list_module_none_check = ['user', $config['default_module']];
    if (in_array($module, $list_module_none_check)) {
        return true;
    } else {
        $check_module_user = db_num_rows("SELECT *
                               FROM `tbl_user_permission` as `tup`
                               LEFT JOIN `tbl_module` as `tm` ON `tup`.`module_id` = `tm`.`module_id`
                               WHERE `tup`.`user_id` = '{$_SESSION['user_id']}' AND `tm`.`title` = 'All'");
        if ($check_module_user > 0) {
            return true;
        } else {
            $module = ucfirst($module);
            $check_module_user = db_num_rows("SELECT * 
                                              FROM `tbl_user_permission` as `tup`
                                              LEFT JOIN `tbl_module` as `tm` ON `tup`.`module_id` = `tm`.`module_id`
                                              WHERE `tup`.`user_id` = '{$_SESSION['user_id']}' AND `tm`.`title` = '{$module}'");
            if ($check_module_user > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}

function check_permission_action($action)
{
    $list_action_none_check = array(
        '0' => 'login',
        '1' => 'logout',
        '2' => 'index',
        '3' => 'update_info',
        '4' => 'update_info',
        '5' => 'update_password',
        '6' => 'add_image_ajax',
    );
    if (in_array($action, $list_action_none_check)) {
        return true;
    } else {
        $check_action_user = db_num_rows("SELECT *
                                          FROM `tbl_user_permission` as `tup`
                                          LEFT JOIN `tbl_permission` as `tp` ON `tup`.`permission_id` = `tp`.`permission_id`
                                          WHERE `tup`.`user_id` = '{$_SESSION['user_id']}' AND `tp`.`title` = 'All'");
        if ($check_action_user > 0) {
            return true;
        } else {
            $action = strtoupper($action);
            $check_action_user = db_num_rows("SELECT * 
                                              FROM `tbl_user_permission` as `tup`
                                              LEFT JOIN `tbl_permission` as `tp` ON `tup`.`permission_id` = `tp`.`permission_id`
                                              LEFT JOIN `tbl_permission_detail` as `tpd` ON `tpd`.`permission_id` = `tp`.`permission_id`
                                              WHERE `tup`.`user_id` = '{$_SESSION['user_id']}' AND `tpd`.`action_code` = '{$action}' AND `tpd`.`check_action` = '1'");
            if ($check_action_user > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}
