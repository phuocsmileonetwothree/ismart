<?php

function timestamp_to_date_format($timestamp, $char_date = array('d', 'm', 'Y')){
    return date("{$char_date[0]}/{$char_date[1]}/{$char_date[2]}", $timestamp);
}
function timestamp_to_date_format_His($timestamp, $char_date = array('d', 'm', 'Y')){
    return date("{$char_date[0]}-{$char_date[1]}-{$char_date[2]}  {$char_date[3]}:{$char_date[4]}:{$char_date[5]}", $timestamp);
}
function timestamp_to_date_format_($timestamp, $char_date = array('H', 'i', 's')){
    return date("{$char_date[0]}:{$char_date[1]}:{$char_date[2]}", $timestamp);
}