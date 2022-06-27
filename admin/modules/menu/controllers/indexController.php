<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if (!empty($_SESSION['update_menu']) and $_SESSION['update_menu'] == 'false') {
        unset($_SESSION['update_menu']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc menu không còn hoạt động");
    }
    if (!empty($_SESSION['delete_menu']) and $_SESSION['delete_menu'] == 'false') {
        unset($_SESSION['delete_menu']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc menu không còn hoạt động");
    }
    if (!empty($_SESSION['delete_menu']) and $_SESSION['delete_menu'] == 'true') {
        unset($_SESSION['delete_menu']);
        get_notify('success', "Đã xóa menu thành công");
    }
    load('lib', 'validation_form');

    global $list_page, $list_category_product, $list_category_post, $next_order, $error;
    global $title, $slug;
    global $list_menu;

    if (isset($_POST['btn_add'])) {

        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tên menu</p>";
        } else {
            $title = $_POST['title'];
        }

        #slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "<p class='error'>Nhập đường dẫn tĩnh menu</p>";
        } else {
            $slug = $_POST['slug'];
        }

        #page #category_product #category_post
        if ($_POST['page'] == -1 and $_POST['category_product'] == -1 and $_POST['category_post'] == -1) {
            $error['connect_id'] = "<p class='error'>Vui lòng chọn 1 trong 3 danh mục liên kết với menu</p>";
        } else {
            $page = $_POST['page'];
            $category_product = $_POST['category_product'];
            $category_post = $_POST['category_post'];
        }

        #order
        if (empty($_POST['order'])) {
            $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện</p>";
        } else {
            $order = $_POST['order'];
        }

        if (empty($error)) {
            $data = array(
                '`title`' => htmlentities($title),
                '`slug`' => htmlentities($slug),
                '`connect_page`' => $page,
                '`connect_category_product`' => $category_product,
                '`connect_category_post`' => $category_post,
                '`order`' => htmlentities($order),
            );
            if (!check_menu($title, $slug)) {
                if (add_menu($data)) {
                    unset($GLOBALS['title'], $GLOBALS['slug']);
                    get_notify('success', "Đã thêm menu thành công");
                } else {
                    get_notify('Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
                }
            } else {
                get_notify('warning', 'Tên menu hoặc đường dẫn tĩnh đã tồn tại');
            }
        }
    }
    $next_order = !empty(get_last_order()) ? get_last_order() + 1 : 1;
    $list_page = get_list_page();
    $list_category_product = data_tree(get_list_category());
    $list_category_post = data_tree(get_list_category('post'));

    $list_menu = get_list_menu();
    load_view('index');
}


// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in = "`menu_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if (db_delete('tbl_menu', $where_in)) {
        $result['delete'] = true;
    } else {
        $result['delete'] = "Hệ thống đang xảy ra lỗi , mong bạn thử lại";
    }
    echo json_encode($result);
}

function updateAction()
{
    load('lib', 'validation_form');
    global $list_page, $list_category_product, $list_category_post, $error;
    global $title, $slug, $order, $connect_page, $connect_category_post, $connect_category_product;
    $menu_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;



    if ($menu = get_menu($menu_id)) {
        if (isset($_POST['btn_update'])) {

            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên menu</p>";
            } else {
                $title = $_POST['title'];
            }
    
            #slug
            if (empty($_POST['slug'])) {
                $error['slug'] = "<p class='error'>Nhập đường dẫn tĩnh menu</p>";
            } else {
                $slug = $_POST['slug'];
            }
    
            #page #category_product #category_post
            if (!empty($_POST['page']) or !empty($_POST['category_product']) or !empty($_POST['category_post'])) {
                $page = $_POST['page'];
                $category_product = $_POST['category_product'];
                $category_post = $_POST['category_post'];
            } else {
                $error['connect_id'] = "<p class='error'>Vui lòng chọn 1 trong 3 danh mục liên kết với menu</p>";
            }
    
            #order
            if (empty($_POST['order'])) {
                $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện</p>";
            } else {
                $order = $_POST['order'];
            }
    
            if(empty($error)){
                $data = array(
                    '`title`' => htmlentities($title),
                    '`slug`' => htmlentities($slug),
                    '`connect_page`' => $page,
                    '`connect_category_product`' => $category_product,
                    '`connect_category_post`' => $category_post,
                    '`order`' => htmlentities($order),
                );
                if(check_menu($title, $slug, "AND `menu_id` = '{$menu_id}'")){
                    if(update_menu($menu_id, $data)){
                        get_notify('success', "Đã cập nhật menu");
                    }else{
                        get_notify('error', "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau");
                    }
                }else{
                    get_notify('warning', "Tên menu hoặc đường dẫn tĩnh đã tồn tại");
                }
            }
        }else{
            $title = $menu['title'];
            $slug = $menu['slug'];
            $order = $menu['order'];
            $connect_page = $menu['connect_page'];
            $connect_category_product = $menu['connect_category_product'];
            $connect_category_post = $menu['connect_category_post'];
        }

    } else {
        $_SESSION['update_menu'] = 'false';
        redirect_to("?mod=menu&action=index");
    }
    $list_page = get_list_page();
    $list_category_product = data_tree(get_list_category());
    $list_category_post = data_tree(get_list_category('post'));
    load_view('update');
}


function deleteAction(){
    $menu_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if(delete_menu($menu_id)){
        $_SESSION['delete_menu'] = 'true';
    }else{
        $_SESSION['delete_menu'] = 'false';
    }
    redirect_to("?mod=menu&action=index");
}