<?php
// ========================= INDEX =========================
function check_uncategorized($list_type = array('product', 'post'), $parent_id = 999999)
{
    foreach ($list_type as $type) {
        $result = db_fetch_row("SELECT * FROM `tbl_category` WHERE `parent_id` = '{$parent_id}' AND `type` = '{$type}'");
        if (empty($result)) {
            $data = array(
                '`title`' => 'Uncategorized',
                '`slug`' => 'uncategorized',
                '`desc`' => 'Danh mục chưa phân loại',
                '`parent_id`' => $parent_id,
                '`creator`' => "Auto",
                '`type`' => $type,
            );
            db_insert('tbl_category', $data);
        }
    }
}

function get_total_category($type = 'product')
{
    $result = db_num_rows("SELECT * FROM `tbl_category` WHERE `type` = '{$type}'");
    if (!empty($result)) {
        return $result;
    } else {
        return 0;
    }
}

function get_list_category($type = 'product', $where_and = '')
{
    $result = db_fetch_array("SELECT * 
                              FROM `tbl_category`
                              WHERE `type` = '{$type}' {$where_and}");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ========================= ADD =========================
function add_category($data)
{
    $result = db_insert('tbl_category', $data);
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

// ========================= UPDATE =========================
function get_cat_id_uncategorized($type = 'product', $parent_id = 999999)
{
    $result = db_fetch_row("SELECT `cat_id` FROM `tbl_category` WHERE `parent_id` = '{$parent_id}' AND `type` = '{$type}'");
    if (!empty($result)) {
        return (int)$result['cat_id'];
    } else {
        return false;
    }
}
function update_category($cat_id, $data)
{
    $result = db_update('tbl_category', $data, "`cat_id` = '{$cat_id}'");
    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}

// ========================= DELETE =========================
#   Xóa danh mục
# 1. Kiểm tra danh mục đang xóa có danh mục con phụ thuộc hay không . Nếu có trả về danh mục con đó
# 1.1 Cập nhật panent_id của danh mục con = với parent_id danh mục cha => Tức danh mục con của danh mục đang xóa sẽ có parent_id = parent_id danh mục đang xóa
# 2. Kiểm tra danh mục đang xóa có sản phẩm hay bài viết phụ thuộc không . Nếu có trả về danh sách sản phẩm hoặc bài viết
# 2.1 Cập nhật cat_id của sản phẩm phụ thuộc = với cat_id của danh mục chưa xác định
# 3. Xóa danh mục cha cần xóa
function get_type_ajax($cat_id)
{
    $result = db_fetch_row("SELECT `type` FROM `tbl_category` WHERE `cat_id` = '{$cat_id}'");
    if (!empty($result)) {
        return $result['type'];
    }
}

function get_category($cat_id)
{
    $result = db_fetch_row("SELECT * FROM `tbl_category` WHERE `cat_id` = '{$cat_id}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_category_child($cat_id)
{
    $result = db_fetch_array("SELECT `cat_id` FROM `tbl_category` WHERE `parent_id` = '{$cat_id}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function get_list_product($cat_id)
{
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `cat_id` = '{$cat_id}'");
    if (!empty($result)) {
        return $result;
    } else {
        return false;
    }
}

function delete_category($type, $cat_id)
{
    # Bước 1
    if ($category_delete = get_category($cat_id)) {
        if ($list_child_category = get_category_child($cat_id)) {
            $parent_id_category_delete = $category_delete['parent_id'];
            foreach ($list_child_category as $category_child) {
                $cat_id_child = $category_child['cat_id'];
                db_update('tbl_category', array('`parent_id`' => $parent_id_category_delete), "`cat_id` = '{$cat_id_child}'");
            }
        }

        # Bước 2
        $cat_id_uncategorized = get_cat_id_uncategorized($type);
        if ($list_product_category_delete = get_list_product($cat_id)) {
            foreach ($list_product_category_delete as $product) {
                $product_id = $product['product_id'];
                db_update('tbl_product', array('`cat_id`' => $cat_id_uncategorized), "`product_id` = '{$product_id}'");
            }
        }

        # Bước 3
        $result = db_delete('tbl_category', "`cat_id` = '{$cat_id}'");

        # Bước 4 : Kết luận
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }else{
        return false;
    }
}


function check_category_update($cat_id, $title, $slug)
{
    $result = db_num_rows("SELECT * FROM `tbl_category` WHERE NOT `cat_id` = '{$cat_id}' AND (`title` = '{$title}' OR `slug` = '{$slug}')");
    if (!empty($result)) {
        return true;
    } else {
        return false;
    }
}
