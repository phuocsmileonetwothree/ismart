<?php

/*
 * -----
 * Get Query URL
 * -----
 * Get các truy vấn không cố định của URL và theo sau 1 dấu chấm hỏi
 * Ví dụ: path_project.com/?mod=home&controller=index&action=index
 * ------------------------------------------------------------------------------------
 * GIẢI THÍCH
 * ------------------------------------------------------------------------------------
 * Đầu vào
 * - Không có đầu vào
 * --
 */
function get_module()
{
    global $config;
    $module = isset($_GET['mod']) ? $_GET['mod'] : $config['default_module'];
    return $module;
}

function get_controller()
{
    global $config;
    $controller = isset($_GET['controller']) ? $_GET['controller'] : $config['default_controller'];
    return $controller;
}

function get_action()
{
    global $config;
    $action = isset($_GET['action']) ? $_GET['action'] : $config['default_action'];
    return $action;
}



/*
 * -----
 * Load Autoload File
 * -----
 * Load các file từ các phân vùng vào hệ thống tham gia xử lý
 * Ví dụ: load('lib','database');
 * ------------------------------------------------------------------------------------
 * GIẢI THÍCH
 * ------------------------------------------------------------------------------------
 * Đầu vào
 * - $type: Loại phân vùng hệ thống: lib, helper...
 * - $name: Tên chức năng được load: database, string...
 * --
 */
function load($type, $name)
{
    if ($type == 'lib') {
        $path = LIB_PATH . DIRECTORY_SEPARATOR . "{$name}.php";
    }
    if ($type == 'helper') {
        $path = HELPER_PATH . DIRECTORY_SEPARATOR . "{$name}.php";
    }

    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br>
              <strong>FUNCTION : load()<br>
              PLEASE CHECK [TYPE : {$type}] OR [NAME : {$name}]<br>
              FILE NOT EXITS : {$path}</strong>
              <br>";
    }
}



/*
 * -----
 * Get Template File
 * -----
 * Get các file giao diện từ các phân vùng vào hệ thống tham gia xử lý
 * Ví dụ: get_header('admin')
 * ------------------------------------------------------------------------------------
 * GIẢI THÍCH
 * ------------------------------------------------------------------------------------
 * Đầu vào
 * - $name :Nếu rỗng thì mặc định : "header, footer, sidebar". Nếu không rỗng thì
 * -        "header-{$name},..."
 * --
 */
function get_header($name = '')
{
    if (!empty($name)) {
        $name = "header-{$name}";
    } else {
        $name = "header";
    }

    $path = LAYOUT_PATH . DIRECTORY_SEPARATOR . "{$name}.php";

    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : get_header()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}

function get_footer($name = '')
{

    if (!empty($name)) {
        $name = "footer-{$name}";
    } else {
        $name = "footer";
    }

    $path = LAYOUT_PATH . DIRECTORY_SEPARATOR . "{$name}.php";

    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : get_footer()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}

function get_sidebar($name = '')
{
    global $data__;
    if (!empty($name)) {
        $name = "sidebar-{$name}";
    } else {
        $name = "sidebar";
    }

    $path = LAYOUT_PATH . DIRECTORY_SEPARATOR . "{$name}.php";

    if (file_exists($path)) {
        if (is_array($data__)) {
            foreach ($data__ as $key => $a) {
                $$key = $a;
            }
        }
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : get_footer()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}
function get_notify($name, $mess)
{
    global $message;
    $message = $mess;
    $path = LAYOUT_PATH . DIRECTORY_SEPARATOR . "notification" . DIRECTORY_SEPARATOR .  "{$name}.php";
    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br><strong>FUNCTION : get_notify()<br>PLEASE CHECK [NAME : {$name}]<br>FILE NOT EXITS : {$path}</strong><br>";
    }
}

function get_breadcrumb($name = '')
{

    if (!empty($name)) {
        $name = "breadcrumb-{$name}";
    } else {
        $name = "breadcrumb";
    }

    $path = LAYOUT_PATH . DIRECTORY_SEPARATOR . "{$name}.php";

    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : get_breadcrumb()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}

/*
 * -----
 * Load Model View File
 * -----
 * Load các file model và view từ phân vùng module đang chạy vào hệ thống tham gia xử lý
 * Ví dụ: load_view'index', $global_data);
 * ------------------------------------------------------------------------------------
 * GIẢI THÍCH
 * ------------------------------------------------------------------------------------
 * Đầu vào
 * - $name :Tên file được load
 * --
 */
function load_model($name)
{
    $path = MODULES_PATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . "$name" . "Model.php";
    if (file_exists($path)) {
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : load_model()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}

function load_view($name, $data_send = array())
{
    global $data;
    $data = $data_send;
    $path = MODULES_PATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "$name" . "View.php";
    if (file_exists($path)) {
        if (is_array($data)) {
            foreach ($data as $k_data => $v_data) {
                $$k_data = $v_data;
            }
        }
        require $path;
    } else {
        echo "<br>
        <strong>FUNCTION : load_view()<br>
        PLEASE CHECK [NAME : {$name}]<br>
        FILE NOT EXITS : {$path}</strong>
        <br>";
    }
}


/*
 * -----------------------------
 * callFunction
 * -----------------------------
 * Gọi đến hàm theo tham số biến
 */
function call_function($list_function = array())
{
    if (is_array($list_function)) {
        foreach ($list_function as $f) {
            if (function_exists($f())) {
                $f();
            }
        }
    }
}
