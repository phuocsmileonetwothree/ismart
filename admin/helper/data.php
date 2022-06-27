<?php

function show_array($data){
    if(is_array($data) and !empty($data)){
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