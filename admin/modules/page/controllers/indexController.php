<?php

function construct()
{
    load_model('index');
}

// SUCCESS
function indexAction()
{
    global $filter, $pagging, $list_pages;
    if (!empty($_SESSION['delete_page']) and $_SESSION['delete_page'] == 'true') {
        unset($_SESSION['delete_page']);
        get_notify('success', "Trang đã được xóa");
    }
    if (!empty($_SESSION['delete_page']) and $_SESSION['delete_page'] == 'false') {
        unset($_SESSION['delete_page']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc trang không còn hoạt động");
    }
    if (!empty($_SESSION['update_page']) and $_SESSION['update_page'] == 'false') {
        unset($_SESSION['update_page']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc trang không còn hoạt động");
    }


    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    $filter['filter'] = array();
    $filter['actions'] = array();
    $filter['filter']['all'] = get_total_page();
    foreach (db_enum_values('tbl_page', 'status') as $key => $value) {
        $filter['filter'][$key] = get_total_page("WHERE `status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete');

    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE (`title` LIKE '%{$pagging['key_search']}%') OR (`slug` LIKE'%{$pagging['key_search']}%')";
        $total_page = get_total_page($where);
        $pagging = get_param_pagging($total_page, $page);
    } else { # Người dùng không tìm kiếm gì cả
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `status` = '{$pagging['status']}'";
        } else {
            $where = "WHERE 1";
        }
        $total_page = get_total_page($where);
        $pagging = get_param_pagging($total_page, $page);
    }

    $list_pages = get_list_page($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in = "`page_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if ($action != 'delete') {
        db_update('tbl_page', array('`status`' => $action), $where_in);
        $result['update'] = strtoupper($action);
    } else {
        if (db_delete('tbl_page', $where_in)) {
            $result['delete'] = true;
        } else {
            $result['delete'] = "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau";
        }
    }
    $result['all'] = get_total_page();
    foreach (db_enum_values('tbl_page', 'status') as $key => $value) {
        $result[$key] = get_total_page("WHERE `status` = '{$key}'");
    }
    echo json_encode($result);
}

// SUCCESS
function addAction()
{
    load('lib', 'validation_form');
    global $error, $title, $slug, $content;

    if (isset($_POST['btn_add'])) {

        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tên trang</p>";
        } else {
            $title = $_POST['title'];
        }

        #slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "<p class='error'>Nhập slug trang</p>";
        } else {
            $slug = $_POST['slug'];
        }

        #content
        if (empty($_POST['content'])) {
            $error['content'] = "<p class='error'>Nhập nội dung trang</p>";
        } else {
            $content = $_POST['content'];
        }

        if (empty($error)) {
            $data = array(
                '`title`' => htmlentities($title),
                '`slug`' => htmlentities($slug),
                '`content`' => htmlentities($content),
                '`creator`' => $_SESSION['user_login'],
                '`creation_time`' => time(),
            );

            if ($page_id = add_page($data)) {
                unset($GLOBALS['title'], $GLOBALS['slug'], $GLOBALS['content']);
                get_notify('success', "Đã thêm trang thành công . <a href='?mod=page&action=index'>Đi đến danh sách trang</a>");
            } else {
                get_notify('error', 'Hệ thống đang xảy ra lỗi , mong bạn thử lại sau');
            }
        }
    }
    load_view('add');
}

// SUCCESS
function updateAction()
{
    load('lib', 'validation_form');
    $page_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    global $title, $slug, $content, $error;



    if ($page = get_page($page_id)) {
        if (isset($_POST['btn_update'])) {
            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên trang</p>";
            } else {
                $title = $_POST['title'];
            }

            #slug
            if (empty($_POST['slug'])) {
                $error['slug'] = "<p class='error'>Nhập slug trang</p>";
            } else {
                $slug = $_POST['slug'];
            }

            #content
            if (empty($_POST['content'])) {
                $error['content'] = "<p class='error'>Nhập chi tiết trang</p>";
            } else {
                $content = $_POST['content'];
            }

            if (empty($error)) {
                $data = array(
                    '`title`' => htmlentities($title),
                    '`slug`' => htmlentities($slug),
                    '`content`' => htmlentities($content),
                );
                if (update_page($page_id, $data)) {
                    get_notify('success', "Cập nhật trang thành công . <a href='?mod=page&action=index'>Đi đến danh sách trang</a>");
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi , mong bạn thử lại sau');
                }
            }
        }else{
            $title = $page['title'];
            $slug = $page['slug'];
            $content = $page['content'];
        }

    } else {
        $_SESSION['update_page'] = 'false';
        redirect_to("?mod=page&action=index");
    }
    load_view('update');
}

// SUCCESS
function deleteAction()
{
    $page_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if (delete_page($page_id)) {
        $_SESSION['delete_page'] = 'true';
    } else {
        $_SESSION['delete_page'] = 'false';
    }
    redirect_to("?mod=page&action=index");
}
