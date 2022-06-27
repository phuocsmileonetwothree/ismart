<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if (!empty($_SESSION['update_slider']) and $_SESSION['update_slider'] == 'false') {
        unset($_SESSION['update_slider']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc slider không còn hoạt động");
    }
    if (!empty($_SESSION['delete_slider']) and $_SESSION['delete_slider'] == 'false') {
        unset($_SESSION['delete_slider']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc slider không còn hoạt động");
    }
    if (!empty($_SESSION['delete_slider']) and $_SESSION['delete_slider'] == 'true') {
        unset($_SESSION['delete_slider']);
        get_notify('success', "Đã xóa slider thành công");
    }

    global $filter, $pagging, $list_slider;
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter['filter'] = array();
    $filter['actions'] = array();
    $filter['filter']['all'] = get_total_slider();
    foreach (db_enum_values('tbl_slider', 'status') as $key => $value) {
        $filter['filter'][$key] = get_total_slider("WHERE `ts`.`status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete');



    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE (`ts`.`title` LIKE '%{$pagging['key_search']}%') OR (`ts`.`link` LIKE'%{$pagging['key_search']}%') OR (`ts`.`desc` LIKE'%{$pagging['key_search']}%')";
        $total_slider = get_total_slider($where);
        $pagging = get_param_pagging($total_slider, $page);
    } else { # Người dùng không tìm kiếm gì cả
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `ts`.`status` = '{$pagging['status']}'";
        } else {
            $where = "WHERE 1";
        }
        $total_slider = get_total_slider($where);
        $pagging = get_param_pagging($total_slider, $page);
    }


    $list_slider = get_list_slider($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in_slider = "`slider_id` IN(" . implode(', ', $checked_array) . ")";
    $where_in_using_images = "`relation_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if ($action != 'delete') {
        db_update('tbl_slider', array('`status`' => $action), $where_in_slider);
        $result['update'] = strtoupper($action);
    } else {
        if ($local_url_slider = delete_slider_ajax($where_in_slider, $where_in_using_images)) {
            foreach ($local_url_slider as $key => $value) {
                unlink($value['url_slider']);
            }
            $result['delete'] = true;
        } else {
            $result['delete'] = "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
        }
    }
    $result['all'] = get_total_slider();
    foreach (db_enum_values('tbl_slider', 'status') as $key => $value) {
        $result[$key] = get_total_slider("WHERE `status` = '{$key}'");
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
            $error['title'] = "<p class='error'>Nhập tên slider</p>";
        } else {
            $title = $_POST['title'];
        }

        #link
        if (empty($_POST['link'])) {
            $error['link'] = "<p class='error'>Nhập đường dẫn mà slider muốn đưa khách hàng đến</p>";
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
            $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện của slider</p>";
        } else {
            $order = $_POST['order'];
        }

        #url_slider
        $url_slider = validation_image('url_slider', 'error', "public/images/slider/");


        if (empty($error)) {
            $data = array(
                '`title`' => $title,
                '`link`' => $link,
                '`desc`' => $desc,
                '`order`' => $order,
                '`creation_time`' => time(),
                '`creator`' => $_SESSION['user_login'],
            );
            if ($slider_id = add_slider($data)) {
                if (move_uploaded_file($url_slider['tmp_name'], $url_slider['url'])) {
                    add_image_slider($url_slider['name'], $url_slider['url'], "slider", $slider_id);
                }
                unset($GLOBALS['title'], $GLOBALS['link'], $GLOBALS['desc'], $GLOBALS['order']);
                get_notify('success', "Đã thêm slider thành công . <a href='?mod=slider&action=index'>Đi đến danh sách slider</a>");
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

    global $error, $title, $link, $desc, $order, $url_slider;
    $slider_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($slider = get_slider($slider_id)) {
        if (isset($_POST['btn_update'])) {

            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tên slider</p>";
            } else {
                $title = $_POST['title'];
            }

            #link
            if (empty($_POST['link'])) {
                $error['link'] = "<p class='error'>Nhập đường dẫn mà slider muốn đưa khách hàng đến</p>";
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
                $error['order'] = "<p class='error'>Nhập thứ tự xuất hiện của slider</p>";
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
                if (update_slider($slider_id, $data)) {
                    get_notify('success', 'Đã cập nhật slider');
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
                }
            }
        } else {
            $title = $slider['title'];
            $link = $slider['link'];
            $desc = $slider['desc'];
            $order = $slider['order'];
        }
        $url_slider = $slider['url_slider'];
        load_view('update');
    } else {
        $_SESSION['update_slider'] = 'false';
        redirect_to("?mod=slider&action=index");
    }
}


function deleteAction()
{
    $slider_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($local_url_slider = delete_slider($slider_id)) {
        unlink($local_url_slider);
        $_SESSION['delete_slider'] = 'true';
    } else {
        $_SESSION['delete_slider'] = 'false';
    }
    redirect_to('?mod=slider&action=index');
}
