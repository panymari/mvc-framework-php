<?php

function redirect($code, $url)
{
    if ($code === 301) {
        header("Location: $url", true, $code);
        exit;
    }
}
