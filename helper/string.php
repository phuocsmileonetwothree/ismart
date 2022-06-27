<?php

function create_slug($string)
{
    $search = array(
        '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
        '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
        '#(ì|í|ị|ỉ|ĩ)#',
        '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
        '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
        '#(ỳ|ý|ỵ|ỷ|ỹ)#',
        '#(đ)#',
        '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
        '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
        '#(Ì|Í|Ị|Ỉ|Ĩ)#',
        '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
        '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
        '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
        '#(Đ)#',
        "/[^a-zA-Z0-9\-\_]/",
    );
    $replace = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'y',
        'd',
        'A',
        'E',
        'I',
        'O',
        'U',
        'Y',
        'D',
        '-',
    );
    $string = preg_replace($search, $replace, $string);
    $string = preg_replace('/(-)+/', '-', $string);
    $string = strtolower($string);
    return $string;
}

function note($type, $name)
{
    global $note;
    if (isset($note)) {
        return $note[$type][$name];
    }
}

function convert_role($role = 1)
{
    if ($role == 1) {
        return "Bạn có mọi quyền truy cập nhưng chỉ chỉnh sửa theo quyền được phân cho bạn";
    }
    if ($role == 2) {
        return "Bạn có mọi quyền truy cập , chỉnh sửa , thêm thành viên mới và phân quyền cho họ";
    }
    if ($role == 3) {
        return "Bạn có mọi quyền truy cập , chỉnh sửa , phân quyền và tạo thêm thành viên quản lý mới";
    }
}

function convert_stocking($stocking){
    $stocking = strtolower($stocking);
    $list_stocking = array(
        'still' => "Còn hàng",
        'out' => "Hết hàng",
    );
    if (array_key_exists($stocking, $list_stocking)) {
        return $list_stocking[$stocking];
    } else {
        return "NONE";
    }
}