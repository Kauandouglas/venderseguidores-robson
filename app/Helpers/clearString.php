<?php

if (!function_exists('clearString')) {
    function clearString($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }
}
