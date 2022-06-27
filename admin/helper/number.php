<?php

function current_format($number, $unit = "₫"){
    return number_format($number, 0, ".", ".").$unit;
}