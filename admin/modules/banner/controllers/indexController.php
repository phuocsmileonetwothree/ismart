<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if (!empty($_SESSION['update_banner']) and $_SESSION['update_banner'] == 'false') {
        unset($_SESSION['update_banner']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc banner không còn hoạt động");
    }
    if (!empty($_SESSION['delete_banner']) and $_SESSION['delete_banner'] == 'false') {
        unset($_SESSION['delete_banner']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc banner không còn hoạt động");
    }
    if (!empty($_SESSION['delete_banner']) and $_SESSION['delete_banner'] == 'true') {
        unset($_SESSION['delete_banner']);
        get_notify('success', "Đã xóa banner thành công");
    }

    global $filter, $pagging, $list_banner;
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter['filter'] = array();
    $filter['actions'] = array();
    $filter['filter']['all'] = get_total_banner();
    foreach (db_enum_values('tbl_banner', 'status') as $key => $value) {
        $filter['filter'][$key] = get_total_banner("WHERE `tb`.`status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete');



    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE (`tb`.`title` LIKE '%{$pagging['key_search']}%') OR (`tb`.`link` LIKE'%{$pagging['key_search']}%') OR (`tb`.`desc` LIKE'%{$pagging['key_search']}%')";
        $total_banner = get_total_banner($where);
        $pagging = get_param_pagging($total_banner, $page);
    } else { # Người dùng không tìm kiếm gì cả
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `tb`.`status` = '{$pagging['status']}'";
        } else {
            $where = "WHERE 1";
        }
        $total_banner = get_total_banner($where);
        $pagging = get_param_pagging($total_banner, $page);
    }


    $list_banner = get_list_banner($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in_banner = "`banner_id` IN(" . implode(', ', $checked_array) . ")";
    $where_in_using_images = "`relation_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if ($action != 'delete') {
        db_update('tbl_banner', array('`status`' => $action), $where_in_banner);
        $result['update'] = strtoupper($action);
    } else {
        if ($local_url_banner = delete_banner_ajax($where_in_banner, $where_in_using_images)) {
            foreach ($local_url_banner as $key => $value) {
                unlink($value['url_banner']);
            }
            $result['delete'] = true;
        } else {
            $result['delete'] = "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
        }
    }
    $result['all'] = get_total_banner();
    foreach (db_enum_values('tbl_banner', 'status') as $key => $value) {
        $result[$key] = get_total_banner("WHERE `status` = '{$key}'");
    }
    echo json_encode($result);
}


function addAction()
{
    load('lib', 'validation_form');
    load('helper', 'file');
    global $error, $title, $link, $desc, $order;
    if (isset($_POST['btn_add'])) {

        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tên banner</p>";
        } else {
            $title = $_POST['title'];
        }

        #link
        if (empty($_POST['link'])) {
            $error['link'] = "<p class='error'>Nhập đường dẫn mà banner muốn đưa khách hàng đến</p>";
        } else {
            $link = $_POST['link'];
        }

        #desc
        if (empty($_POST['desc'])) {
            $desc = '';
        } else {
            $desc = $_POST['desc'];
        }

        #order
        if (empty($_POST['order'])) {
            $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện của banner</p>";
        } else {
            $order = $_POST['order'];
        }

        #url_banner
        $url_banner = validation_image('url_banner', 'error', "public/images/banner/");


        if (empty($error)) {
            $data = array(
                '`title`' => $title,
                '`link`' => $link,
                '`desc`' => $desc,
                '`order`' => $order,
                '`creation_time`' => time(),
                '`creator`' => $_SESSION['user_login'],
            );
            if ($banner_id = add_banner($data)) {
                if (move_uploaded_file($url_banner['tmp_name'], $url_banner['url'])) {
                    add_image_banner($url_banner['name'], $url_banner['url'], "banner", $banner_id);
                }
                unset($GLOBALS['title'], $GLOBALS['link'], $GLOBALS['desc'], $GLOBALS['order']);
                get_notify('success', "Đã thêm banner thành công . <a href='?mod=banner&action=index'>Đi đến danh sách banner</a>");
            } else {
                get_notify('error', "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau");
            }
        }
    }

    load_view('add');
}

function updateAction()
{
    load('lib', 'validation_form');

    global $error, $title, $link, $desc, $order, $url_banner;
    $banner_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($banner = get_banner($banner_id)) {
        if (isset($_POST['btn_update'])) {

            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên banner</p>";
            } else {
                $title = $_POST['title'];
            }

            #link
            if (empty($_POST['link'])) {
                $error['link'] = "<p class='error'>Nhập đường dẫn mà banner muốn đưa khách hàng đến</p>";
            } else {
                $link = $_POST['link'];
            }

            #desc
            if (empty($_POST['desc'])) {
                $desc = '';
            } else {
                $desc = $_POST['desc'];
            }

            #order
            if (empty($_POST['order'])) {
                $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện của banner</p>";
            } else {
                $order = $_POST['order'];
            }

            if (empty($error)) {
                $data = array(
                    '`title`' => $title,
                    '`link`' => $link,
                    '`desc`' => $desc,
                    '`order`' => $order,
                );
                if (update_banner($banner_id, $data)) {
                    get_notify('success', 'Đã cập nhật banner');
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
                }
            }
        } else {
            $title = $banner['title'];
            $link = $banner['link'];
            $desc = $banner['desc'];
            $order = $banner['order'];
        }
        $url_banner = $banner['url_banner'];
        load_view('update');
    } else {
        $_SESSION['update_banner'] = 'false';
        redirect_to("?mod=banner&action=index");
    }
}


function deleteAction()
{
    $banner_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($local_url_banner = delete_banner($banner_id)) {
        unlink($local_url_banner);
        $_SESSION['delete_banner'] = 'true';
    } else {
        $_SESSION['delete_banner'] = 'false';
    }
    redirect_to('?mod=banner&action=index');
}
