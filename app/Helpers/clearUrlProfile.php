<?php

if (!function_exists('clearUrlProfile')) {
    function clearUrlProfile($value)
    {
        $value = str_replace('-', '_removed', $value);
        $convert = preg_match('~(?:https?://)?(?:www\.)?(?:instagram?:\.)?\.com(?:/[^/]+)*/\K\w+~',
            $value, $m)
            ? $m[0] : str_replace('@', '', $value);

        return str_replace('_removed', '-', $convert);
    }
}
