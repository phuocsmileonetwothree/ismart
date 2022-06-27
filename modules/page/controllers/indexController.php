<?php

function construct(){
    load_model('index');
}

function detailAction(){
    global $page;
    $page_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;
    if($page_id == 0){
        redirect_to("?");
    }else{
        if($page = get_page($page_id)){
            load_view('detail');
        }
    }
}