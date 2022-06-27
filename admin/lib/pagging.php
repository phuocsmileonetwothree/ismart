<?php

function get_param_pagging($total_row, $page_on_click)
{
    global $pagging;
    $pagging['page'] = $page_on_click;
    $pagging['total_row'] = $total_row;
    $pagging['total_page'] = ceil($total_row / $pagging['num_per_page']);
    $pagging['index'] = ($page_on_click * $pagging['num_per_page']) - $pagging['num_per_page'] + 1;
    $pagging['start'] = ($page_on_click - 1) * $pagging['num_per_page'];
    $pagging['end'] = $pagging['num_per_page'];
    return $pagging;
}

function get_pagging($page_on_click, $total_pages, $url, $key_search = '', $status = '', $stocking = '')
{
    $str_pagging = "";
    $first_active = "";
    $last_active = "";
    if($total_pages == 1){
        return;
    }
    if (!empty($key_search)) {
        $key_search = "&key={$key_search}{$status}";
    }
    if (!empty($status)) {
        $status = "&status={$status}";
    }
    if (!empty($stocking)) {
        $stocking = "&stocking={$stocking}";
    }
    $range = 3; #Giới hạn tổng li>a nằm trên 1 page trừ đi 1 và cuối cùng -> 5 li>a . CHỈ ĐƯỢC LẺ

    if ($page_on_click == 1) {
        $first_active = "class='active'";
    }
    if ($page_on_click == $total_pages) {
        $last_active = "class='active'";
    }


    $str_pagging = "<ul id='list-pagging' class='clearfix'>";

    if ($total_pages <= $range) {
        $i = 1;
        while ($i <= $total_pages) {
            $class_active = "";
            if ($page_on_click == $i) {
                $class_active = "class='active'";
            }
            $str_pagging .= "<li><a {$class_active} href='{$url}{$i}{$key_search}{$status}{$stocking}'>{$i}</a></li>";
            $i++;
        }
    } else {
        $str_pagging .= "<li><a {$first_active} href='{$url}1{$key_search}{$status}{$stocking}'>1</a></li>";

        $middle = floor($range / 2);
        $behind = $page_on_click - $middle;
        $forward = $page_on_click + $middle;
        if ($behind <= 1) {
            $behind = 2;
        }
        if ($forward >= $total_pages) {
            $forward = $total_pages - 1;
        }
        if ($behind - 1 > 1) {
            $str_pagging .= "<li><a>...</a></li>";
        }
        while ($behind <= $forward) {
            $class_active = "";
            if ($behind == $page_on_click) {
                $class_active = "class='active'";
            }
            $str_pagging .= "<li><a {$class_active} href='{$url}{$behind}{$key_search}{$status}{$stocking}'>{$behind}</a></li>";
            $behind++;
        }
        if ($forward + 1 != $total_pages) {
            $str_pagging .= "<li><a>...</a></li>";
        }

        $str_pagging .= "<li><a {$last_active} href='{$url}{$total_pages}{$key_search}{$status}{$stocking}'>{$total_pages}</a></li>";
    }



    $str_pagging .= "</ul>";
    echo $str_pagging;
}
