<?php
/*
 * File autoload.php sẽ lưu giữ các file sẽ được tự động load
 * khi dự án chạy
 */

$autoload['lib'] = array('session', 'pagging', 'permission');

$autoload['helper'] = array('data', 'url', 'time', 'string', 'number');