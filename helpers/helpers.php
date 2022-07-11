<?php

function redirect($code, $url)
{
    if ($code === 301) {
        header("Location: $url", true, $code);
        exit;
    } elseif ($code === 404) {
        header("Location: $url", true, $code);
        exit;
    }
}
