<?php
function truncate($string, $length = 9, $append = '...')
{
    if (mb_strlen($string) > $length)
        $string = mb_substr($string, 0, $length) . $append;

    return $string;
}
