<?php

function enough_length($least_char, $most_char, $string)
{
    if ((strlen($string) >= $least_char) and (strlen($string) <= $most_char))
        return true;
}


function is_product_price($price)
{
    $price = trim($price);
    $partten = "/^[0-9]{4,10}$/";
    if (preg_match($partten, $price, $matchs)) {
        return true;
    }
}

function validation__product($label_field, $error_class, $least_char = 0, $most_char = 150)
{
    global $_POST, $error;

    # product_name
    if ($label_field == 'name') {
        if (empty($_POST['name'])) {
            $error['name'] = "<p class='{$error_class}'>Nhập tên sản phẩm</p>";
        } else {
            if (!enough_length($least_char, $most_char, $_POST['name'])) {
                $error['name'] = "<p class='{$error_class}'>Tên sản phẩm có số lượng từ {$least_char} - {$most_char} ký tự</p>";
            } else {
                return trim($_POST['name']);
            }
        }
        
    }

    # product_price
    if ($label_field == 'price') {
        if (empty($_POST['price'])) {
            $error['price'] = "<p class='{$error_class}'>Nhập giá tiền sản phẩm</p>";
        } else {
            if (!is_product_price($_POST['price'])) {
                $error['price'] = "<p class='{$error_class}'>Bạn vui lòng nhập giá sản phẩm bằng số . Ví dụ : 1000000 = 1.000.000VND</p>";
            } else {
                return trim($_POST['price']);
            }
        }
    }


    # product_desc
    if ($label_field == 'desc') {
        if (empty($_POST['desc'])) {
            return NULL;
        } else {
            if (!enough_length($least_char, $most_char, $_POST['desc'])) {
                $error['desc'] = "Bạn hãy mô tả ngắn gọn trong khoảng {$least_char} - {$most_char} ký tự";
            } else {
                return trim($_POST['desc']);
            }
        }
    }

    # product_content
    if ($label_field == 'content') {
        if (empty($_POST['content'])) {
            return NULL;
        } else {
            if (!enough_length($least_char, $most_char, $_POST['content'])) {
                $error['content'] = "Bạn hãy mô tả ngắn gọn trong khoảng {$least_char} - {$most_char} ký tự";
            } else {
                return trim($_POST['content']);
            }
        }
    }

    # product_status
    if($label_field == 'status'){
        if ($_POST['status'] === '') {
            $error['status'] = "<p class='{$error_class}'>Chọn trạng thái cho sản phẩm</p>";
        } else {
            return $_POST['status'];
        }
    }

    # cat_id
    if ($label_field == 'cat_id') {
        if ($_POST['cat_id'] === '') {
            $error['cat_id'] = "<p class='{$error_class}'>Chọn danh mục mà sản phẩm thuộc vào</p>";
        } else {
            return $_POST['cat_id'];
        }
    }



}
