<?php

function construct()
{
    load_model('index');
}

// SUCCESS
function indexAction()
{
    global $filter, $pagging, $list_post;
    if (!empty($_SESSION['delete_post']) and $_SESSION['delete_post'] == 'true') {
        unset($_SESSION['delete_post']);
        get_notify('success', "Bài viết đã được xóa");
    }
    if (!empty($_SESSION['delete_post']) and $_SESSION['delete_post'] == 'false') {
        unset($_SESSION['delete_post']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc bài viết không còn hoạt động");
    }
    if (!empty($_SESSION['update_post']) and $_SESSION['update_post'] == 'false') {
        unset($_SESSION['update_post']);
        get_notify('error', "Hệ thống vừa xảy ra lỗi hoặc bài viết không còn hoạt động");
    }

    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    $filter['filter'] = array();
    $filter['actions'] = array();
    $filter['filter']['all'] = get_total_post();
    foreach (db_enum_values('tbl_post', 'status') as $key => $value) {
        $filter['filter'][$key] = get_total_post("WHERE `tp`.`status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete');

    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE (`tp`.`title` LIKE '%{$pagging['key_search']}%') OR (`tc`.`title` LIKE'%{$pagging['key_search']}%')";
        $total_post = get_total_post("LEFT JOIN `tbl_category` as `tc` ON `tp`.`cat_id` = `tc`.`cat_id` {$where}");
        $pagging = get_param_pagging($total_post, $page);
    } else { # Người dùng không tìm kiếm gì cả
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `tp`.`status` = '{$pagging['status']}'";
        } else {
            $where = "WHERE 1";
        }
        $total_post = get_total_post($where);
        $pagging = get_param_pagging($total_post, $page);
    }
    $list_post = get_list_post($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in_post = "`post_id` IN(" . implode(', ', $checked_array) . ")";
    $where_in_using_images = "`relation_id` IN(" . implode(', ', $checked_array) . ")";

    $result = array();

    if ($action != 'delete') {
        db_update('tbl_post', array('`status`' => $action), $where_in_post);
        $result['update'] = strtoupper($action);
    } else {
        if ($local_thumb_post = delete_post_ajax($where_in_post, $where_in_using_images)) {
            foreach ($local_thumb_post as $key => $value) {
                unlink($value['thumb']);
            }
            $result['delete'] = true;
        } else {
            $result['delete'] = "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
        }
    }
    $result['all'] = get_total_post();
    foreach (db_enum_values('tbl_post', 'status') as $key => $value) {
        $result[$key] = get_total_post("WHERE `tp`.`status` = '{$key}'");
    }
    echo json_encode($result);
}

// SUCCESS
function addAction()
{
    load('lib', 'validation_form');
    load('helper', 'file');
    global $list_category, $error, $title, $slug, $content;

    if (isset($_POST['btn_add'])) {
        #title
        if (empty($_POST['title'])) {
            $error['title'] = "<p class='error'>Nhập tiêu đề bài viết</p>";
        } else {
            $title = $_POST['title'];
        }

        #slug
        if (empty($_POST['slug'])) {
            $error['slug'] = "<p class='error'>Nhập slug bài viết</p>";
        } else {
            $slug = $_POST['slug'];
        }

        #content
        if (empty($_POST['content'])) {
            $error['content'] = "<p class='error'>Nhập chi tiết đề bài viết</p>";
        } else {
            $content = $_POST['content'];
        }

        #cat_id
        if ($_POST['cat_id'] === '') {
            $error['cat_id'] = "<p class='error'>Chọn danh mục mà bài viết thuộc vào</p>";
        } else {
            $cat_id = $_POST['cat_id'];
        }

        #thumb
        $thumb = validation_image('thumb', 'error', "public/images/post/");

        if (empty($error)) {
            $data = array(
                '`title`' => htmlentities($title),
                '`slug`' => htmlentities($slug),
                '`content`' => htmlentities($content),
                '`creator`' => $_SESSION['user_login'],
                '`creation_time`' => time(),
                '`cat_id`' => $cat_id,
            );
            if ($last_post_id = add_post($data)) {
                if (move_uploaded_file($thumb['tmp_name'], $thumb['url'])) {
                    add_image_post($thumb['name'], $thumb['url'], "post", $last_post_id);
                }
                unset($GLOBALS['title'], $GLOBALS['slug'], $GLOBALS['content']);
                get_notify('success', "Thêm bài viết thành công . <a href='?mod=post&action=index'>Đi đến danh sách bài viết</a>");
            } else {
                get_notify('error', "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau");
            }
        }
    }
    $list_category = data_tree(get_list_category());
    load_view('add');
}

// SUCCESS
function updateAction()
{
    load('lib', 'validation_form');
    global $list_category, $error, $title, $slug, $content, $thumb, $cat_id;
    $post_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;





    if ($post = get_post($post_id)) {
        if (isset($_POST['btn_update'])) {
            #title
            if (empty($_POST['title'])) {
                $error['title'] = "<p class='error'>Nhập tiêu đề bài viết</p>";
            } else {
                $title = $_POST['title'];
            }

            #slug
            if (empty($_POST['slug'])) {
                $error['slug'] = "<p class='error'>Nhập slug bài viết</p>";
            } else {
                $slug = $_POST['slug'];
            }

            #content
            if (empty($_POST['content'])) {
                $error['content'] = "<p class='error'>Nhập chi tiết đề bài viết</p>";
            } else {
                $content = $_POST['content'];
            }

            #cat_id
            if ($_POST['cat_id'] === '') {
                $error['cat_id'] = "<p class='error'>Chọn danh mục mà bài viết thuộc vào</p>";
            } else {
                $cat_id = $_POST['cat_id'];
            }

            if (empty($error)) {
                $data = array(
                    '`title`' => $title,
                    '`slug`' => $slug,
                    '`content`' => $content,
                    '`cat_id`' => $cat_id,
                );
                if (update_post($post_id, $data)) {
                    get_notify('success', "Cập nhật bài viết thành công");
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
                }
            }
        } else {
            $title = $post['title'];
            $slug = $post['slug'];
            $content = $post['content'];
            $thumb = $post['thumb'];
            $cat_id = $post['cat_id'];
        }
    } else {
        $_SESSION['update_post'] = 'false';
        redirect_to("?mod=post&action=index");
    }
    $list_category = data_tree(get_list_category());
    load_view('update');
}

// SUCCESS
function deleteAction()
{
    $post_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($local_thumb = delete_post($post_id)) {
        unlink($local_thumb);
        $_SESSION['delete_post'] = 'true';
    } else {
        $_SESSION['delete_post'] = 'false';
    }
    redirect_to('?mod=post&action=index');
}
