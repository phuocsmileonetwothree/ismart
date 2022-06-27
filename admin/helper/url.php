<?php
function base_url(){
    global $config;
    return $config['base_url'];
}

function base_url_client(){
    global $config;
    return $config['base_url_client'];
}

function redirect_to($url){
    $base_url = base_url();
    header("Location: {$base_url}{$url}");
}

function redirect_to_client($url){
    $base_url = base_url_client();
    header("Location: {$base_url}{$url}");
}