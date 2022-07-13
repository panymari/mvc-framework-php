<?php

function redirect($code, $url = null): void
{
    $header = !isset($url)
        ?  "Location: " . USER_LOGIN_REF
        : "Location: $url";
    header($header, true, $code);

    die;
}

function createFolder(string $folder)
{
    if (!file_exists($folder)) {
        @mkdir($folder, 0777, true); //create folder in server
        chmod($folder, 0777); //change the file mode
    }
}