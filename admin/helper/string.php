<?php


function note($type, $name)
{
    global $note;
    if (isset($note)) {
        return $note[$type][$name];
    }
}

function convert_permission($permission){
    $permission = strtolower($permission);
    $list_permission = array(
        'add' => 'Thêm',
        'update' => 'Cập nhật',
        'delete' => 'Xóa',
        'read' => "Chỉ xem",
    );
    if (array_key_exists($permission, $list_permission)) {
        return $list_permission[$permission];
    } else {
        return "NONE";
    }
}

function convert_role_detail($role = 1)
{
    if ($role == 1) {
        return "Bạn có mọi quyền truy cập , chỉnh sửa , thêm thành viên mới và phân quyền cho họ";
    }
    if ($role == 2) {
        return "Bạn có mọi quyền truy cập , chỉnh sửa trong mà bạn được phân quyền";
    }

}

function convert_role($role){
    $role = strtolower($role);
    $list_role = array(
        '1' => 'Quản trị hệ thống',
        '2' => 'Biên tập viên',
    );
    if (array_key_exists($role, $list_role)) {
        return $list_role[$role];
    } else {
        return "NONE";
    }
}

function convert_code($code, $string = "0 0 0 0 0 0", $store_short_name = "ISM")
{
    $code = (string)$code;
    $str = explode(' ', $string);

    $arr = array();
    for ($i = 0; $i < strlen($code); $i++) {
        $arr[] = substr($code, $i, 1);
    }


    $k = 0;
    for ($i = count($str) - count($arr); $i < count($str); $i++) {
        for ($j = $k; $j < count($arr); $j++) {
            $str[$i] = $arr[$j];
            break;
        }
        $k++;
    }


    return $store_short_name . implode('', $str);
}

function convert_status($status)
{
    $status = strtolower($status);
    $list_status = array(
        'on' => 'Hoạt động',
        'off' => 'Không hoạt động',
        'processing' => 'Đang xử lý',
        'cancelled' => 'Đã hủy',
        'transported' => 'Đang vận chuyển',
        'successful' => 'Giao hàng thành công'
    );
    if (array_key_exists($status, $list_status)) {
        return $list_status[$status];
    } else {
        return "NONE";
    }
}

function convert_payment($payment)
{
    $payment = strtolower($payment);
    $list_payment = array(
        'cod' => 'Thanh toán tại nhà',
        'store' => 'Thanh toán tại cửa hàng'
    );
    if (array_key_exists($payment, $list_payment)) {
        return $list_payment[$payment];
    } else {
        return "NONE";
    }
}

function convert_category($title)
{
    $title = strtolower($title);
    $list_category = array(
        'product' => 'sản phẩm',
        'post' => 'bài viết'
    );
    if (array_key_exists($title, $list_category)) {
        return $list_category[$title];
    } else {
        return "NONE";
    }
}

function convert_filter($filter){
    $list_filter = array(
        'all' => 'Tất cả',
        'on' => 'Đã đăng',
        'off' => 'Đã ẩn',
        'still' => "Còn hàng",
        'out' => "Hết hàng",
        'processing' => 'Đang xử lý',
        'cancelled' => 'Đã hủy',
        'transported' => 'Đang vận chuyển',
        'successful' => 'Giao hàng thành công',

    );
    if (array_key_exists($filter, $list_filter)) {
        return $list_filter[$filter];
    } else {
        return "NONE";
    }
}

function convert_action($action){ 
    $list_action = array(
        'on' => "Công khai",
        'off' => "Tắt công khai",
        'still' => "Còn hàng",
        'out' => "Hết hàng",
        'delete' => "Xóa",
        'processing' => 'Đang xử lý',
        'cancelled' => 'Đã hủy',
        'transported' => 'Đang vận chuyển',
        'successful' => 'Giao hàng thành công',
    );
    if (array_key_exists($action, $list_action)) {
        return $list_action[$action];
    } else {
        return "NONE";
    }
}

function convert_media($type){
    $list_type = array(
        'product' => 'Sản phẩm',
        'post' => 'Bài viết',
        'slider' => 'Slider',
    );
    if (array_key_exists($type, $list_type)) {
        return $list_type[$type];
    } else {
        return "NONE";
    }
}


