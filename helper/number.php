<?php

function current_format($number, $unit = " đ"){
    return number_format($number, 0, ".", ".").$unit;
}