<?php
/*
 * File appload.php gọi những file mặc định chạy trong hệ thống
 */

session_start();
ob_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");

# Từ folder config
require CONFIG_PATH . DIRECTORY_SEPARATOR . "config.php";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "database.php";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "email.php";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "autoload.php";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "note.php";
require CONFIG_PATH . DIRECTORY_SEPARATOR . "pagging.php";


# Từ folder lib
require LIB_PATH . DIRECTORY_SEPARATOR . "database.php";
db_connect($db);

# Từ folder core
require CORE_PATH . DIRECTORY_SEPARATOR . "base.php";

# Gọi file autoload
if(!empty($autoload)){
    foreach($autoload as $type => $list_auto){
        if(!empty($list_auto)){
            foreach($list_auto as $auto){
                load($type, $auto);
            }
        }
    }
}

require CORE_PATH . DIRECTORY_SEPARATOR . "router.php";

