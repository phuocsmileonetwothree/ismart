<?php

function construct()
{
    load_model('index');
}

// SUCCESS
function indexAction()
{
    global $type, $filter;
    $type = !empty($_GET['type']) ? $_GET['type'] : 'product';

    check_uncategorized();
    if (!empty($_SESSION['delete_category']) and $_SESSION['delete_category'] == 'uncategorized') {
        unset($_SESSION['delete_category']);
        $message = strip_tags(note("{$type}_category", 'delete'));
        get_notify('warning', $message);
    }
    if (!empty($_SESSION['delete_category']) and $_SESSION['delete_category'] == 'true') {
        unset($_SESSION['delete_category']);
        get_notify('success', "Danh mục đã được xóa");
    }
    if (!empty($_SESSION['delete_category']) and $_SESSION['delete_category'] == 'false') {
        unset($_SESSION['delete_category']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc danh mục không còn hoạt động");
    }
    if (!empty($_SESSION['update_category']) and $_SESSION['update_category'] == 'uncategorized') {
        unset($_SESSION['update_category']);
        get_notify('warning', "Không thể cập nhật danh mục mặc định");
    }
    if (!empty($_SESSION['update_category']) and $_SESSION['update_category'] == 'false') {
        unset($_SESSION['update_category']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc danh mục không còn hoạt động");
    }

    $filter['actions'] = array();
    $filter['actions']['delete'] = "Xóa";
    $filter['filter']['all'] = get_total_category($type);
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $where_and = "AND (`title` LIKE '%{$filter['search']['key']}%') OR (`slug` LIKE '%{$filter['search']['key']}%')";
    } else {
        $where_and = "";
    }

    $data['list_category'] = data_tree(get_list_category($type, $where_and));
    $data['list_category'] = array_merge($data['list_category'], data_tree(get_list_category($type, $where_and), 999999));
    load_view('index', $data);
}

// SUCCESS
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $type = '';
    $result = array();
    foreach ($checked_array as $value) {
        $type = get_type_ajax($value);
        break;
    }
    $id_uncategorized = get_cat_id_uncategorized($type);
    if (in_array($id_uncategorized, $checked_array)) {
        $result['delete'] = "Bạn không được phép xóa danh mục \"Uncategorized\"";
    } else {
        foreach ($checked_array as $value) {
            if (delete_category($type, $value)) {
                $result['delete'] = true;
            } else {
                $result['delete'] = "Hệ thống đang xảy ra lỗi , mong bạn thử lại";
            }
        }
    }
    $result['all'] = get_total_category();
    echo json_encode($result);
}

// SUCCESS
function addAction()
{
    global $type, $error, $list_category, $title, $slug, $desc;
    $type = !empty($_GET['type']) ? $_GET['type'] : 'product';
    load('lib', 'validation_form');

    if (isset($_POST['btn_add'])) {

        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tên danh mục</p>";
        } else {
            $title = $_POST['title'];
        }

        #slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "<p class='error'>Nhập đường dẫn tĩnh</p>";
        } else {
            $slug = $_POST['slug'];
        }

        #parent_id
        if ($_POST['parent_id'] === '') {
            $error['parent_id'] = "<p class='error'>Chọn danh mục cha phụ thuộc</p>";
        } else {
            $parent_id = $_POST['parent_id'];
        }

        $desc = !empty($_POST['desc']) ? $_POST['desc'] : NULL;

        if (empty($error)) {
            $data = array(
                '`title`' => htmlentities($title),
                '`slug`' => htmlentities($slug),
                '`parent_id`' => $parent_id,
                '`desc`' => htmlentities($desc),
                '`creation_time`' => time(),
                '`creator`' => $_SESSION['user_login'],
                '`type`' => $type
            );
            if ($last_id_insert = add_category($data)) {
                unset($GLOBALS['title']);
                unset($GLOBALS['slug']);
                unset($GLOBALS['desc']);
                get_notify('success', "Danh mục sản phẩm đã được thêm .<a href='?mod=category&type={$type}&action=index'>Đi đến danh mục</a>");
            } else {
                get_notify('error', 'Hệ thống đang xảy ra lỗi , mong bạn thử lại sau');
            }
        }
    }
    $list_category = data_tree(get_list_category($type));
    load_view('add');
}

// SUCCESS
function updateAction()
{
    global $type, $list_category, $info_category, $error, $title, $slug, $desc, $parent_id;
    load('lib', 'validation_form');
    $cat_id = !empty($_GET['id']) ? (int)$_GET['id'] : FALSE;
    $type = !empty($_GET['type']) ? $_GET['type'] : 'product';

    if (get_cat_id_uncategorized($type) == $cat_id) {
        $_SESSION['update_category'] = 'uncategorized';
        redirect_to("?mod=category&type={$type}&action=index");
    }



    if ($info_category = get_category($cat_id)) {
        if (isset($_POST['btn_update'])) {

            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên danh mục</p>";
            } else {
                $title = $_POST['title'];
            }

            #slug
            if (empty($_POST['slug'])) {
                $error['slug'] = "<p class='error'>Nhập đường dẫn tĩnh</p>";
            } else {
                $slug = $_POST['slug'];
            }

            #desc
            $desc = !empty($_POST['desc']) ? $_POST['desc'] : NULL;

            #parent_id
            if ($_POST['parent_id'] === '') {
                $error['parent_id'] = "<p class='error'>Chọn danh mục cha phụ thuộc</p>";
            } else {
                $parent_id = $_POST['parent_id'];
            }

            if (empty($error)) {
                $data = array(
                    '`title`' => $title,
                    '`slug`' => $slug,
                    '`parent_id`' => $parent_id,
                    '`desc`' => $desc,
                );
                if (update_category($cat_id, $data)) {
                    get_notify('success', "Danh mục đã được cập nhật.<br><a href='?mod=category&type={$type}&action=index'>Đi đến Danh mục</a>");
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi , mong bạn thử lại sau');
                }
            }
        }else{
            $title = $info_category['title'];
            $slug = $info_category['slug'];
            $desc = $info_category['desc'];
            $parent_id = $info_category['parent_id'];
        }

    } else {
        $_SESSION['update_category'] = 'false';
        redirect_to("?mod=category&type={$type}&acton=index");
    }

    $list_category = data_tree(get_list_category($type));
    load_view('update');
}


// SUCCESS
function deleteAction()
{
    $type = !empty($_GET['type']) ? $_GET['type'] : 'product';
    $cat_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    $id_uncategorized = get_cat_id_uncategorized($type);
    if ($id_uncategorized == $cat_id) {
        $_SESSION['delete_category'] = 'uncategorized';
    } else {
        if (delete_category($type, $cat_id)) {
            $_SESSION['delete_category'] = 'true';
        } else {
            $_SESSION['delete_category'] = 'false';
        }
    }
    redirect_to("?mod=category&type={$type}&action=index");
}
