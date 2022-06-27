<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    if(!empty($_SESSION['delete_admin']) and $_SESSION['delete_admin'] == 'true'){
        unset($_SESSION['delete_admin']);
        get_notify('success', "Đã xóa thành viên thành công");
    }
    if(!empty($_SESSION['delete_admin']) and $_SESSION['delete_admin'] == 'false'){
        unset($_SESSION['delete_admin']);
        get_notify('success', "Hệ thống đang xảy ra lỗi hoặc thành viên không còn hoạt động");
    }
    if(!empty($_SESSION['update_admin']) and $_SESSION['update_admin'] == 'false'){
        unset($_SESSION['update_admin']);
        get_notify('error', "Hệ thống đang xảy ra lỗi hoặc thành viên không còn hoạt động");
    }
    global $list_admin;
    $list_admin = get_list_admin();
    load_view('index');
}

function addAction()
{
    load('lib', 'validation_form');
    global $list_role, $list_module, $list_permission, $error, $fullname, $username, $phone, $email, $address, $role;
    if (isset($_POST['btn_add'])) {
        #fullname
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "<p class='error'>Nhập họ tên</p>";
        } else {
            $fullname = $_POST['fullname'];
        }

        #username
        if (empty($_POST['username'])) {
            $error['username'] = "<p class='error'>Nhập tên đăng nhập</p>";
        } else {
            $username = $_POST['username'];
        }

        #password
        if (empty($_POST['password'])) {
            $error['password'] = "<p class='error'>Nhập mật khẩu</p>";
        } else {
            $password = md5($_POST['password']);
        }

        #phone
        if (empty($_POST['phone'])) {
            $error['phone'] = "<p class='error'>Nhập số điện thoại</p>";
        } else {
            $phone = $_POST['phone'];
        }

        #email
        if (empty($_POST['email'])) {
            $error['email'] = "<p class='error'>Nhập tài khoản email</p>";
        } else {
            $email = $_POST['email'];
        }

        #address
        if (empty($_POST['address'])) {
            $address = "";
        } else {
            $address = $_POST['address'];
        }

        #role
        $role = (int)$_POST['role'];

        #check_permission
        if (empty($_POST['check_permission'])) {
            $error['check_permission'] = "<p class='error'>(*)Vui lòng chọn quyền cho thành viên mới</p>";
        } else {
            $check_permission = $_POST['check_permission'];
        }

        if (empty($error)) {
            if (check_admin($username, $email) == false) {
                $data = array(
                    '`fullname`' => $fullname,
                    '`username`' => $username,
                    '`password`' => $password,
                    '`phone`' => $phone,
                    '`email`' => $email,
                    '`address`' => $address,
                    '`role_id`' => $role,
                    '`creation_time`' => time(),
                    '`creator`' => $_SESSION['user_login'],
                );
                if ($last_id_admin = add_admin($data)) {
                    foreach ($check_permission as $key => $value) {
                        if (is_array($value)) {
                            // Chọn từ 3 action trở xuống không chọn all 1 module
                            foreach ($value as $sub_value) {
                                $data = array(
                                    '`permission_id`' => (int)$sub_value,
                                    '`user_id`' => $last_id_admin,
                                    '`module_id`' => (int)$key,
                                    '`licensed`' => 1,

                                );
                                add_permisison($last_id_admin, $data);
                            }
                        } else {
                            $data = array(
                                '`permission_id`' => (int)$value,
                                '`user_id`' => $last_id_admin,
                                '`module_id`' => (int)$key,
                                '`licensed`' => 1,

                            );
                            add_permisison($last_id_admin, $data);
                        }
                    }
                    unset($GLOBALS['fullname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['email'], $GLOBALS['phone'], $GLOBALS['address']);
                    get_notify('success', "Đã thêm thành viên thành công .  <a href='?mod=access&action=index'>Đi đến danh sách thành viên</a>");
                } else {
                    get_notify('error', "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau");
                }
            } else {
                get_notify('warning', "Tên tài khoản hoặc email đã tồn tại");
            }
        }
    }
    $list_role = get_list_role();
    $list_module = get_list_module("WHERE NOT (`title` = 'Access' OR `title` = 'All')");
    $list_permission = get_list_permission();
    load_view('add');
}

function updateAction()
{
    load('lib', 'validation_form');
    global $list_module, $list_permission, $error, $fullname, $admin_module_permission;
    $admin_module_permission = array();
    $admin_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($admin = get_admin($admin_id)) {
        if (isset($_POST['btn_update'])) {
            #check_permission
            if (empty($_POST['check_permission'])) {
                $error['check_permission'] = "<p class='error'>(*)Vui lòng chọn quyền cho thành viên mới</p>";
            } else {
                $check_permission = $_POST['check_permission'];
            }
            // Kết luận
            if (empty($error)) {
                // Không thể cập nhật vì có quá nhiều quyền
                // Cho nên sẽ xóa tất cả quyền của user cần update quyền
                // Và thêm quyền mới
                if (delete_permission($admin_id)) {
                    foreach ($check_permission as $key => $value) {
                        if (is_array($value)) {
                            // Chọn từ 3 action trở xuống không chọn all 1 module
                            foreach ($value as $sub_value) {
                                $data = array(
                                    '`permission_id`' => (int)$sub_value,
                                    '`user_id`' => $admin_id,
                                    '`module_id`' => (int)$key,
                                    '`licensed`' => 1,
                                );
                                add_permisison($admin_id, $data);
                            }
                        } else {
                            $data = array(
                                '`permission_id`' => (int)$value,
                                '`user_id`' => $admin_id,
                                '`module_id`' => (int)$key,
                                '`licensed`' => 1,

                            );
                            add_permisison($admin_id, $data);
                        }
                    }
                }
                foreach ($check_permission as $key => $value) {
                    if (is_array($value)) {
                        // Chọn từ 3 action trở xuống không chọn all 1 module
                        foreach ($value as $sub_value) {
                            $data = array(
                                '`permission_id`' => (int)$sub_value,
                                '`user_id`' => $admin_id,
                                '`module_id`' => (int)$key,
                                '`licensed`' => 1,
                            );

                            add_permisison($admin_id, $data);
                        }
                    } else {
                        $data = array(
                            '`permission_id`' => (int)$value,
                            '`user_id`' => $admin_id,
                            '`module_id`' => (int)$key,
                            '`licensed`' => 1,

                        );
                    }
                }
                get_notify('success', "Đã cập nhật quyền cho thành viên .  <a href='?mod=access&action=index'>Đi đến danh sách thành viên</a>");
                $admin = get_admin($admin_id);
            }
        }
        if(isset($_POST['btn_cancel'])){
            redirect_to("?mod=access&action=index");
        }
        $fullname = $admin['fullname'];
        unset($admin['fullname']);
        foreach ($admin as $value) {
            foreach ($value as $sub_value) {
                if (in_array($sub_value['module_id'], $sub_value)) {
                    $admin_module_permission[$sub_value['module_id']][] = $sub_value['permission_id'];
                } else {
                    $admin_module_permission[$sub_value['module_id']] = $sub_value['permission_id'];
                }
            }
        }



        $list_module = get_list_module("WHERE NOT (`title` = 'Access' OR `title` = 'All')");
        $list_permission = get_list_permission();
        load_view('update');
    } else {
        $_SESSION['update_admin'] = 'false';
        redirect_to('?mod=access&action=index');
    }
}

function deleteAction(){
    $admin_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if(check_admin_exist($admin_id)){
        $thumb = get_thumb_admin($admin_id);
        if(delete_admin($admin_id)){
            $_SESSION['delete_admin'] = 'true';
            if(!empty($thumb)){
                unlink($thumb);
            }
        }else{
            $_SESSION['delete_admin'] = 'false';
        }
    }else{
        $_SESSION['delete_admin'] = 'false';
    }
    redirect_to("?mod=access&action=index");
}
