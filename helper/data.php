<?php

function show_array($data)
{
    if (is_array($data) and !empty($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

function data_tree($data = array(), $parent_id = 0, $level = 0)
{
    $result = array();
    if (!empty($data)) {
        foreach ($data as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['level'] = $level;
                $result[] = $item;
                unset($data[$item['cat_id']]);
                $child = data_tree($data, $item['cat_id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
    }
    return $result;
}

function show_category_data_tree($list_category, $link, $parent_id = 0)
{
    $result = array();
    $array_empty = array();
    foreach ($list_category as $key => $value) {
        if ($value['parent_id'] == $parent_id) {
            $value['link_cat_id'] = $link . create_slug($value['title']) . "-" . $value['cat_id'];
            $result[] = $value;
            unset($list_category[$key]);
        }
    }
    $list_category = array_merge($list_category, $array_empty);

    if (empty($result[0]['parent_id'])) {
        echo "<ul class='list-item'>";
    } else {
        echo "<ul class='sub-menu'>";
    }
    foreach ($result as $key => $value) {
        echo "<li>";
        echo "<a href='{$value['link_cat_id']}' title=''>{$value['title']}</a>";
        show_category_data_tree($list_category, $link, $value['cat_id']);
        echo "</li>";
    }
    echo "</ul>";
}


// Mục đích tìm thằng danh mục có parent_id = 0
// Ở đây đã có sẵn thằng sản phẩm có cat_id = ...
function get_root_parent($list_category, $product_cat_id)
{
    $root_id = 0;
    if (!empty($list_category)) {
        foreach ($list_category as $key => $item) {
            if ($item['cat_id'] == $product_cat_id) {
                if ($item['parent_id'] != 0) {
                    $root_id = $item['parent_id'];
                    unset($list_category[$key]);
                    get_root_parent($list_category, $root_id);
                }
            }
        }
    }
    return $root_id;
}


function get_list_root_parent_by_cat_id($module, $action, $cat_id, &$list_root_parent)
{
    $result = db_fetch_row("SELECT * FROM `tbl_category` WHERE `cat_id` = '{$cat_id}'");

    if (!empty($result)) {
        $list_root_parent[] = array(
            'cat_id' => $result['cat_id'],
            'title' => $result['title'],
        );
        if ($result['parent_id'] != 0) {
            get_list_root_parent_by_cat_id($module, $action, $result['parent_id'], $list_root_parent);
        }
    }
    return ($list_root_parent);
}

