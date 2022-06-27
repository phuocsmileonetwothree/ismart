<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if (!empty($_SESSION['update_image']) and $_SESSION['update_image'] == 'false') {
        unset($_SESSION['update_image']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc hình ảnh không còn hoạt động");
    }
    global $filter, $pagging, $list_media;

    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter['filter'] = array();
    $filter['actions'] = array();
    $filter['filter']['all'] = get_total_image();

    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        
        $where = "WHERE (`ti`.`name` LIKE '%{$pagging['key_search']}%') OR (`ti`.`url` LIKE '%{$pagging['key_search']}%') OR (`ui`.`type` LIKE '%{$pagging['key_search']}%')";
        $total_image = get_total_image("LEFT JOIN `using_images` as `ui` ON `ui`.`image_id` = `ti`.`id` {$where}");
        $pagging = get_param_pagging($total_image, $page);
    } else { # Người dùng không tìm kiếm gì cả

        $where = "WHERE 1";

        $total_image = get_total_image($where);
        $pagging = get_param_pagging($total_image, $page);
    }

    $list_media = get_list_media($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

function updateAction()
{
    load('lib', 'validation_form');
    global $url, $name;
    $image_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($image = get_image($image_id)) {

        if (isset($_POST['btn_update'])) {
            if (empty($_POST['name'])) {
                $error = "<p class='error'>Vui lòng nhập tên ảnh</p>";
            } else {
                $name = $_POST['name'];
            }

            if (empty($error)) {
                if (update_name_image($image_id, array('`name`' => htmlentities($name)))) {
                    get_notify('success', "Đã cập nhật tên ảnh mới");
                } else {
                    get_notify('error', "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau");
                }
            }
        } else {
            $name = $image['name'];
        }
        $url = $image['url'];
    } else {
        $_SESSION['update_image'] = 'false';
        redirect_to("?mod=media&action=index");
    }
    load_view('update');
}
