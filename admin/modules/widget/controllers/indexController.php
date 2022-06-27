<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if (!empty($_SESSION['update_widget']) and $_SESSION['update_widget'] == 'false') {
        unset($_SESSION['update_widget']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc khối giao diện không còn hoạt động");
    }
    if (!empty($_SESSION['delete_widget']) and $_SESSION['delete_widget'] == 'false') {
        unset($_SESSION['delete_widget']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc khối giao diện không còn hoạt động");
    }
    if (!empty($_SESSION['delete_widget']) and $_SESSION['delete_widget'] == 'true') {
        unset($_SESSION['delete_widget']);
        get_notify('success', "Khối giao diện đã được xóa");
    }

    global $filter, $pagging, $list_widget;
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter['filter'] = array();
    $filter['filter']['all'] = get_total_widget();
    $filter['actions'] = array();
    $filter['actions']['delete'] = convert_action('delete');

    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] = htmlentities($_GET['key']);

        $where = "WHERE (`title` LIKE '%{$pagging['key_search']}%') OR (`code` LIKE'%{$pagging['key_search']}%')";
        $total_widget = get_total_widget($where);
        $pagging = get_param_pagging($total_widget, $page);
    } else {
        $where = "WHERE 1";
        $total_widget = get_total_widget($where);
        $pagging = get_param_pagging($total_widget, $page);
    }
    $list_widget = get_list_widget($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in = "`widget_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if (delete_widget_ajax($where_in)) {
        $result['delete'] = true;
    } else {
        $result['delete'] = "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
    }

    $result['all'] = get_total_widget();
    echo json_encode($result);
}

function addAction()
{
    load('lib', 'validation_form');
    global $error, $title, $code, $content;
    if (isset($_POST['btn_add'])) {

        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tên của khối</p>";
        } else {
            $title = $_POST['title'];
        }

        #code
        if (empty($_POST['code'])) {
            $error['code'] = "<p class='error'>Nhập mã khối</p>";
        } else {
            $code = $_POST['code'];
        }

        #content
        if (empty($_POST['content'])) {
            $error['content'] = "<p class='error'>Nhập chi tiết khối</p>";
        } else {
            $content = $_POST['content'];
        }

        if (empty($error)) {
            $data = array(
                '`title`' => htmlentities($title),
                '`code`' => htmlentities($code),
                '`content`' => htmlentities($content),
                '`creation_time`' => time(),
                '`creator`' => $_SESSION['user_login'],
            );
            if ($widget_id = add_widget($data)) {
                unset($GLOBALS['title'], $GLOBALS['code'], $GLOBALS['content']);
                get_notify('success', "Đã thêm khối giao diện . <a href='?mod=widget&action=index'>Đi đến danh sách khối</a>");
            } else {
                get_notify('error', "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau");
            }
        }
    }
    load_view('add');
}

function updateAction()
{
    load('lib', 'validation_form');
    $widget_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;

    global $error, $title, $code, $content;


    if ($widget = get_widget($widget_id)) {
        if (isset($_POST['btn_update'])) {

            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên khối</p>";
            } else {
                $title = $_POST['title'];
            }

            #code
            if (empty($_POST['code'])) {
                $error['code'] = "<p class='error'>Nhập mã khối</p>";
            } else {
                $code = $_POST['code'];
            }

            #content
            if (empty($_POST['content'])) {
                $error['content'] = "<p class='error'>Nhập nội dung khối</p>";
            } else {
                $content = $_POST['content'];
            }

            if (empty($error)) {
                $data = array(
                    '`title`' => htmlentities($title),
                    '`code`' => htmlentities($code),
                    '`content`' => htmlentities($content),
                );
                if (update_widget($widget_id, $data)) {
                    get_notify('success', "Đã cập nhật khối giao diện . <a href='?mod=widget&action=index'>Đi đến danh sách khối</a>");
                } else {
                    get_notify('error', "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau");
                }
            }
        }else{
            $title = $widget['title'];
            $code = $widget['code'];
            $content = $widget['content'];
        }

    } else {
        $_SESSION['update_widget'] = 'false';
        redirect_to('?mod=widget&action=index');
    }
    load_view('update');
}


function deleteAction()
{
    $widget_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if (delete_widget($widget_id)) {
        $_SESSION['delete_widget'] = 'true';
    } else {
        $_SESSION['delete_widget'] = 'false';
    }
    redirect_to("?mod=widget&action=index");
}
