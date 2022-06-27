<?php
/*
 * File index nơi tạo ra đường dẫn chính của dự án và những đường dẫn dẫn đến các thư
 * mục có trong dự án đó
 */


# Đường dẫn chính của project
$app_path = dirname(__FILE__);
define("APP_PATH", $app_path);

# Đến folder config
define("CONFIG_PATH", $app_path . DIRECTORY_SEPARATOR . "config");

# Đến folder core
define("CORE_PATH", $app_path . DIRECTORY_SEPARATOR . "core");

# Đến folder layout
define("LAYOUT_PATH", $app_path . DIRECTORY_SEPARATOR . "layout");

# Đến folder lib
define("LIB_PATH", $app_path . DIRECTORY_SEPARATOR . "lib");

# Đến folder helper
define("HELPER_PATH", $app_path . DIRECTORY_SEPARATOR . "helper");

# Đến folder modules
define("MODULES_PATH", $app_path . DIRECTORY_SEPARATOR . "modules");

# Đến folder public
define("PUBLIC_PATH", $app_path . DIRECTORY_SEPARATOR . "public");


require CORE_PATH . DIRECTORY_SEPARATOR . "appload.php";
