<?php

if (!isset($_SESSION['cart']) and empty($_SESSION['cart'])) {
    $_SESSION['cart']['buy'] = array();
    $_SESSION['cart']['info'] = array();
}

$path = MODULES_PATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . get_controller() . "Controller.php";
if (file_exists($path)) {
    require $path;
} else {
    $module = get_module();
    $controller = get_controller();
    echo "<br>
    <strong>PLEASE CHECK [MODULE : {$module}] OR [CONTROLLER : {$controller}]<br>
    FILE NOT EXITS : {$path}</strong>
    <br>";
}

$action = get_action() . "Action";
call_function(array('construct', $action));