<?php

function strtounix($string) {
    $string = str_replace("\r\n", "\n", $string);
    $string = str_replace("\r", "\n", $string);
    $string = preg_replace("/\n{2,}/", "\n\n", $string);

    return $string;
}