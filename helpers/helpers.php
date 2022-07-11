<?php

function redirect($code, $url): void
{
    header("Location: $url", true, $code);
    die;
}
