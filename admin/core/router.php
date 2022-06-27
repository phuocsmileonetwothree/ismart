<?php
global $config;
if (empty($_SESSION['is_login']) and get_action() != 'login') {
    redirect_to('?mod=user&action=login');
}


$path = MODULES_PATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . get_controller() . "Controller.php";
if (check_permission_module(get_module())) {
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
    if (check_permission_action(get_action())) {
        $action = get_action() . "Action";
        call_function(array('construct', $action));
    } else {
        $_SESSION['permission_action'] = "Bạn không có quyền trong Action : " . strtoupper(get_action()) . " . Liên hệ quản lý hoặc quản trị hệ thống để biết thêm chi tiết";
        redirect_to("?mod={$config['default_module']}&action={$config['default_action']}");
    }
} else {
    $_SESSION['permission_module'] = "Bạn không có quyền trong Module : " . strtoupper(get_module()) . " . Liên hệ quản lý hoặc quản trị hệ thống để biết thêm chi tiết";
    redirect_to("?mod={$config['default_module']}&action={$config['default_action']}");
}
