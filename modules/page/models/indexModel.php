<?php

function get_page($page_id){
    $result = db_fetch_row("SELECT * FROM `tbl_page` WHERE `page_id` = '{$page_id}'");
    if(!empty($result)){
        return $result;
    }else{
        return false;
    }
}