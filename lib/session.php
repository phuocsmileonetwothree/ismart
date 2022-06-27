<?php

// function set_seesion_login($user = array()){
//     $_SESSION['is_login'] = true;
//     $_SESSION['user_login'] = $user['fullname'];
//     $_SESSION['user_id'] = $user['users_id'];
// }

function unset_seesion_login(){
    session_destroy();
}