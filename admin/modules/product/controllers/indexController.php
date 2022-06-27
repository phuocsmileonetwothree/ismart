<?php

function construct()
{
    load_model('index');
}

// Success
function indexAction()
{
    if (!empty($_SESSION['delete_product']) and $_SESSION['delete_product'] == 'true') {
        unset($_SESSION['delete_product']);
        get_notify('success', "Sản phẩm đã được xóa");
    }
    if (!empty($_SESSION['delete_product']) and $_SESSION['delete_product'] == 'false') {
        unset($_SESSION['delete_product']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc sản phẩm không còn hoạt động");
    }
    if (!empty($_SESSION['update_product']) and $_SESSION['update_product'] == 'false') {
        unset($_SESSION['update_product']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc sản phẩm không còn hoạt động");
    }
    if (!empty($_SESSION['detail_product']) and $_SESSION['detail_product'] == 'false') {
        unset($_SESSION['detail_product']);
        get_notify('error', "Hệ thống đã xảy ra lỗi hoặc sản phẩm không còn hoạt động");
    }
    if (!empty($_SESSION['detail_product']) and $_SESSION['detail_product'] == 'true') {
        unset($_SESSION['detail_product']);
        get_notify('warning', "Không thể xem vì sản phẩm đang ở trạng thái ẩn . Hãy cập nhật trạng thái để xem chi tiết");
    }



    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    global $filter, $pagging, $list_product;
    $filter['filter'] = array();
    $filter['actions'] = array();

    $filter['filter']['all'] = get_total_product();
    foreach (db_enum_values('tbl_product', 'status') as $key => $value) {
        $filter['filter'][$key] = get_total_product("WHERE `tp`.`status` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    foreach (db_enum_values('tbl_product', 'stocking') as $key => $value) {
        $filter['filter'][$key] = get_total_product("WHERE `tp`.`stocking` = '{$key}'");
        $filter['actions'][$key] = convert_action($key);
    }
    $filter['actions']['delete'] = convert_action('delete');

    // Người dùng tìm kiếm 1 value
    if (isset($_GET['key']) and !empty($_GET['key'])) {
        $filter['search']['key'] = htmlentities($_GET['key']);
        $pagging['key_search'] =  htmlentities($_GET['key']);

        $where = "WHERE ((`tp`.`name` LIKE '%{$pagging['key_search']}%') OR (`tc`.`title` LIKE'%{$pagging['key_search']}%') OR (`tp`.`content` LIKE'%{$pagging['key_search']}%') OR (`tp`.`desc` LIKE'%{$pagging['key_search']}%'))";
        $total_product = get_total_product("LEFT JOIN `tbl_category` as `tc` ON `tp`.`cat_id` = `tc`.`cat_id` {$where}");
        $pagging = get_param_pagging($total_product, $page);
    } else { # Người dùng không tìm kiếm gì cả
        if (isset($_GET['status']) and !empty($_GET['status'])) {
            $pagging['status'] = $_GET['status'];
            $where = "WHERE `tp`.`status` = '{$pagging['status']}'";
        } else {
            if (isset($_GET['stocking']) and !empty($_GET['stocking'])) {
                $pagging['stocking'] = $_GET['stocking'];
                $where = "WHERE `tp`.`stocking` = '{$pagging['stocking']}'";
            } else {
                $where = "WHERE 1";
            }
        }
        $total_product = get_total_product($where);
        $pagging = get_param_pagging($total_product, $page);
    }
    $list_product = get_list_product($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index');
}

// Success
function actions_ajaxAction()
{
    $checked_array = $_POST['checked_array'];
    $action = $_POST['action'];
    $where_in_product = "`product_id` IN(" . implode(', ', $checked_array) . ")";
    $where_in_using_images = "`relation_id` IN(" . implode(', ', $checked_array) . ")";
    $result = array();

    if ($action != 'delete') {
        if ($action == 'on' or $action == 'off') {
            db_update('tbl_product', array('`status`' => $action), $where_in_product);
            $result['update'] = strtoupper($action);
        } else {
            db_update('tbl_product', array('`stocking`' => $action), $where_in_product);
            $result['update'] = strtoupper($action);
        }
    } else {
        if ($local_url_image = delete_product_ajax($where_in_product, $where_in_using_images)) {
            foreach ($local_url_image as $item) {
                unlink($item['url']);
            }
            $result['delete'] = true;
        } else {
            $result['delete'] = "Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau";
        }
    }
    $result['all'] = get_total_product();
    foreach (db_enum_values('tbl_product', 'status') as $key => $value) {
        $result[$key] = get_total_product("WHERE `tp`.`status` = '{$key}'");
    }
    echo json_encode($result);
}


function delete_image_ajaxAction()
{
    $result = array();
    $image_id = $_POST['id'];
    $action = $_POST['action'];

    if ($url = db_fetch_row("SELECT `url` FROM `tbl_image` WHERE `id` = '{$image_id}'")) {
        $value1 = db_delete('using_images', "`image_id` = '{$image_id}'");
        $value2 = db_delete('tbl_image', "`id` = '{$image_id}'");
        if ($value1 > 0 and $value2 > 0) {
            unlink($url['url']);
            $result['delete'] = true;
        } else {
            $result['delete'] = 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau';
        }
    } else {
        $result['delete'] = 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau';
    }
    echo json_encode($result);
}

function upload_image_ajaxAction()
{
    global $error;
    load('helper', 'file');
    $product_id = $_POST['product_id'];
    $result = '';
    $list_image = array();
    $list_image = validation_image("files", "error", "public/images/product/");
    if (empty($error) and !empty($list_image)) {
        foreach ($list_image as $key => $value) {
            if ($last_id_tbl_image = db_insert('tbl_image', array('`name`' => $value['name'], '`url`' => $value['url']))) {
                if ($last_id_using_images = db_insert('using_images', array('`image_id`' => $last_id_tbl_image, '`type`' => "product", '`relation_id`' => $product_id))) {
                    if (move_uploaded_file($value['tmp_name'], $value['url'])) {
                        $url = $value['url'];
                        $result .= "<li>";
                        $result .=      "<img data-image='{$last_id_tbl_image}' src='{$url}' alt=''>";
                        $result .= "    <ul class='list-update-thumb'>";
                        $result .= "        <li><a class='delete' href='' data-image='{$last_id_tbl_image}' title='Xóa hình ảnh' class='edit'><i class='fa fa-trash' aria-hidden='true'></i></a></li>";
                        $result .= "    </ul>";
                        $result .= "</li>";
                    } else {
                        $error = "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau";
                    }
                } else {
                    $error = "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau";
                }
            } else {
                $error = "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau";
            }
        }
    } else {
        $tmp = strip_tags($error['files']);
        unset($error);
        $error = $tmp;
    }
    if (empty($error)) {
        echo $result;
    } else {
        echo $error;
    }
}

function swap_order_image_ajaxAction()
{
    $result = array();
    $id_one = $_POST['image_one'];
    $id_two = $_POST['image_two'];

    $url_image_one = db_fetch_row("SELECT `url`, `name` FROM `tbl_image` WHERE `id` = '{$id_one}'");
    $url_image_two = db_fetch_row("SELECT `url`, `name` FROM `tbl_image` WHERE `id` = '{$id_two}'");


    $affected_rows_one = db_update('tbl_image', array('`url`' => $url_image_two['url'], '`name`' => $url_image_two['name']), "`id` = '{$id_one}'");
    if ($affected_rows_one > 0) {
        $affected_rows_two = db_update('tbl_image', array('`url`' => $url_image_one['url'], '`name`' => $url_image_one['name']), "`id` = '{$id_two}'");
        if ($affected_rows_two > 0) {
            $result = array(
                'swap_image' => true,
                'new_src_img_one' => $url_image_two['url'],
                'new_src_img_two' => $url_image_one['url'],
            );
        } else {
            $result['swap_image'] = false;
        }
    } else {
        $result['swap_image'] = false;
    }

    echo json_encode($result);
}
// SUCCESS
function addAction()
{
    load('lib', 'validation_form');
    load('helper', 'product');
    load('helper', 'file');
    global $list_category, $error, $name, $code, $code_auto, $price, $desc, $content;
    if (isset($_POST['btn_add'])) {
        # name
        $name = validation__product('name', 'error', 0, 150);
        # code
        $code = $_POST['code'];

        # price
        $price = validation__product('price', 'error');

        # desc
        $desc = validation__product('desc', 'error', 0, 1000);

        # content
        $content = validation__product('content', 'error', 0, 1000000);

        #thumb
        $thumb = validation_image('thumb', 'error', 'public/images/product/');

        #cat_id
        $cat_id = validation__product('cat_id', 'error');
        if (empty($error)) {
            $data_product = array(
                '`name`' => htmlentities($name),
                '`code`' => $code,
                '`price`' => htmlentities($price),
                '`desc`' => htmlentities($desc),
                '`content`' => htmlentities($content),
                '`creator`' => $_SESSION['user_login'],
                '`creation_time`' => time(),
                '`cat_id`' => (int)$cat_id,
            );

            if ($last_id_insert = add_product($data_product)) {
                if (empty($error['thumb'])) {
                    foreach ($thumb as $item) {
                        if (move_uploaded_file($item['tmp_name'], $item['url'])) {
                            add_image_product($item['name'], $item['url'], "product", $last_id_insert);
                        }
                    }
                }
                unset($GLOBALS['name'], $GLOBALS['code'], $GLOBALS['price'], $GLOBALS['desc'], $GLOBALS['content']);
                get_notify('success', "Sản phẩm đã được thêm.<br><a href='?mod=product&action=index'>Đi đến Danh sách sản phẩm</a>");
            } else {
                get_notify('error', 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
            }
        }
    }

    $list_category = data_tree(get_list_category());
    $code_auto = !empty(get_last_id()) ? convert_code(get_last_id() + 1) : convert_code(1);


    load_view('add');
}


// SUCCESS
function deleteAction()
{
    $product_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($local_url_image = delete_product($product_id)) {
        foreach ($local_url_image as $item) {
            unlink($item['url']);
        }
        # Sản phẩm có tồn tại và đã xóa thành công
        $_SESSION['delete_product'] = 'true';
    } else {
        # Sản phẩm không tồn tại và xóa không thành công
        $_SESSION['delete_product'] = 'false';
    }
    redirect_to('?mod=product&action=index');
}

// SUCCESS
function updateAction()
{
    load('lib', 'validation_form');
    load('helper', 'product');
    global $list_category, $error, $name, $code, $price, $desc, $content, $list_thumb, $status, $cat_id, $product_id;
    $product_id = !empty($_GET['id']) ? (int)($_GET['id']) : 0;
    if ($product = get_product($product_id)) {
        if (!isset($_POST['btn_update'])) {
            $name = $product['name'];
            $price = $product['price'];
            $desc = $product['desc'];
            $content = $product['content'];
            $status = $product['status'];
            $cat_id = $product['cat_id'];
        } else {
            $name = validation__product('name', 'error', 0, 150);
            $price = validation__product('price', 'error');
            $desc = validation__product('desc', 'error', 0, 1000);
            $content = validation__product('content', 'error', 0, 1000000);
            $status = validation__product('status', 'error');
            $cat_id = validation__product('cat_id', 'error');

            if (empty($error)) {
                $data = array(
                    '`name`' => $name,
                    '`price`' => $price,
                    '`desc`' => $desc,
                    '`content`' => $content,
                    '`status`' => $status,
                    '`cat_id`' => $cat_id,
                );
                if (update_product($product_id, $data)) {
                    get_notify('success', "Sản phẩm đã được cập nhật.<br><a href='?mod=product&action=index'>Đi đến Danh sách sản phẩm</a>");
                } else {
                    get_notify('error', 'Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau');
                }
            }
        }
        // Không thay đổi thì nằm ngoài
        $list_thumb = $product['list_thumb'];
        $code = $product['code'];
        $list_category = data_tree(get_list_category());
        load_view('update');
    } else {
        $_SESSION['update_product'] = 'false';
        redirect_to('?mod=product&action=index');
    }
}

// SUCCESS
function detailAction()
{
    $product_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if (check_product($product_id)) {
        if (get_status_on($product_id)) {
            redirect_to_client("?mod=product&action=detail&id={$product_id}");
        } else {
            $_SESSION['detail_product'] = 'true';
            redirect_to('?mod=product&action=index');
        }
    } else {
        $_SESSION['detail_product'] = 'false';
        redirect_to('?mod=product&action=index');
    }
}
