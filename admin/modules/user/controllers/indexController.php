<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    $data['info'] = get_info_user($_SESSION['user_id']);
    load_view('index', $data);
}

function add_image_ajaxAction()
{
    $old_thumb = array();
    $old_thumb = db_fetch_row("SELECT `thumb` FROM `tbl_admin` WHERE `users_id` = '{$_SESSION['user_id']}'");
    $format = array('jpg', 'jpeg', 'png', 'gif');
    $size = 20000000;
    $thumb = array();

    # Đường dẫn tạm của file ảnh khi lên server
    $tmp_name = $_FILES['thumb']['tmp_name'];
    # Đường dẫn từ .. đến file ảnh
    $upload_file = "public/images/users/" . $_FILES['thumb']['name'];
    # Chỉ định dạng ảnh . VD : jpg, png 
    $file_format = pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION);
    # Chỉ tên ảnh . VD : hehe, huhu
    $file_name = pathinfo($_FILES['thumb']['name'], PATHINFO_FILENAME);

    if (!in_array(strtolower($file_format), $format)) {
        echo "Hệ thống chỉ hỗ trợ file ảnh có định dạng 'jpg', 'jpeg', 'png', 'gif'";
    } else {
        if ($_FILES['thumb']['size'] > $size) {
            echo "Hệ thống hỗ trợ file ảnh có kích thước <20MB";
        } else {
            if (file_exists($upload_file)) {
                $new_upload_file =  "public/images/users/" . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($new_upload_file)) {
                    $new_upload_file =  "public/images/users/" . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
                if ($result = db_update('tbl_admin', array('`thumb`' => $new_upload_file), "`users_id` = '{$_SESSION['user_id']}'")) {
                    if (!empty($old_thumb)) {
                        unlink($old_thumb['thumb']);
                    }
                    move_uploaded_file($tmp_name, $new_upload_file);
                }
            } else {
                if ($result = db_update('tbl_admin', array('`thumb`' => $upload_file), "`users_id` = '{$_SESSION['user_id']}'")) {
                    if (!empty($old_thumb)) {
                        unlink($old_thumb['thumb']);
                    }
                    move_uploaded_file($tmp_name, $upload_file);
                }
            }
        }
    }
    $thumb = db_fetch_row("SELECT `thumb` FROM `tbl_admin` WHERE `users_id` = '{$_SESSION['user_id']}'");
    echo $thumb['thumb'];
}

function loginAction()
{
    if (!empty($_SESSION['is_login'])) {
        redirect_to('?');
    }
    load('lib', 'validation_form');
    global $error, $username;
    if (isset($_POST['btn_login'])) {
        #username
        if (empty($_POST['username'])) {
            $error['username'] = "<p class='error'>Nhập tên tài khoản</p>";
        } else {
            $username = $_POST['username'];
        }

        #password
        if (empty($_POST['password'])) {
            $error['password'] = "<p class='error'>Nhập mật khẩu</p>";
        } else {
            $password = md5($_POST['password']);
        }

        if (empty($error)) {
            if ($user = check_user_login($username, $password)) {
                set_seesion_login($user);
                redirect_to("?");
            } else {
                $error['acc_not_exist'] = "<p class='error'>Tài khoản hoặc mật khẩu không chính xác</p>";
            }
        }
    }
    load_view('login');
}

function logoutAction()
{
    unset_seesion_login();
    redirect_to("?mod=user&action=login");
}

function update_infoAction()
{
    load('lib', 'validation_form');
    global $error, $fullname, $username, $email, $phone, $address;
    if (isset($_POST['btn_update'])) {
        $fullname = validation_field('fullname', 'error');
        $email = validation_field('email', 'error');
        $phone = validation_field('phone', 'error');
        $address = validation_field('address', 'error');
        if (empty($error)) {
            $data = array(
                '`fullname`' => $fullname,
                '`email`' => $email,
                '`phone`' => $phone,
                '`address`' => $address,
            );
            if (update_info_user($_SESSION['user_id'], $data) == true) {
                get_notify('success', "Đã cập nhật thông tin mới");
            } else {
                get_notify('warning', "Có điều gì bất thường vừa xảy ra hoặc bạn không thay đổi bất kỳ thông tin nào");
            }
        }
    }
    $info = get_info_user($_SESSION['user_id'], true);
    $username = $info['username'];
    $fullname = $info['fullname'];
    $email = $info['email'];
    $phone = $info['phone'];
    $address = $info['address'];

    load_view('update_info');
}

function update_passwordAction()
{
    load('lib', 'validation_form');
    global $error;
    if (isset($_POST['btn_update'])) {
        #old_password
        if (empty($_POST['old_password'])) {
            $error['old_password'] = "<p class='error'>Vui lòng nhập mật khẩu cũ</p>";
        } else {
            $old_password = md5($_POST['old_password']);
        }

        #new_password
        $new_password = validation_field('new_password', 'error');

        #re_password
        $re_password = validation_field('re_password', 'error');

        if (empty($error)) {
            if (check_password($old_password)) {
                if ($new_password != $re_password) {
                    $error['password'] = "<p class='error'>Xác nhận mật khẩu phải trùng với mật khẩu mới</p>";
                } else {
                    if ($old_password == $new_password) {
                        get_notify('warning', "Có điều bất thường vừa xảy ra hoặc mật khẩu mới của bạn không có sự khác biệt với mật khẩu cũ");
                    } else {
                        if (update_password($_SESSION['user_id'], $new_password)) {
                            get_notify('success', "Mật khẩu đã được thay đổi");
                        }
                    }
                }
            } else {
                get_notify('error', "Mật khẩu cũ không chính xác");
            }
        }
    }
    load_view('update_password');
}
