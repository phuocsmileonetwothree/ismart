<?php
function base_url(){
    global $config;
    return $config['base_url'];
}

function redirect_to($url){
    $base_url = base_url();
    header("Location: {$base_url}{$url}");
}