<?php

function construct()
{
    load_model('index');
}

function indexAction()
{
    global $pagging;
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $cat_id = !empty($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;

    if($cat_id == 0){
        $where = "WHERE 1";
        $total_post = get_total_post();
        $pagging = get_param_pagging($total_post, $page);
    }else{
        $where = "WHERE `tp`.`cat_id` IN (SELECT `cat_id` FROM `tbl_category` WHERE `parent_id` = '{$cat_id}' OR `cat_id` = '{$cat_id}')";
        $total_post = get_total_post($where);
        $pagging = get_param_pagging($total_post, $page);
    }
    
    if($data__['category'] = get_category($cat_id)){
        $pagging['cat_id'] = $cat_id;
        $pagging['title'] = create_slug($data__['category']['title']);

    }else{
        $pagging['cat_id'] = 0;
    }
    $data__['list_post'] = get_list_post($where, "LIMIT {$pagging['start']}, {$pagging['end']}");
    load_view('index', $data__);
}

function detailAction()
{
    $post_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if($data__['post'] = get_post($post_id)){
        load_view('detail', $data__);
    }else{
        echo "Có thể bài viết không còn hoạt động";
    }
}
