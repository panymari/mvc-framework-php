<?php

function redirect($code, $url = null): void
{
    $header = empty($url)
        ? 'Location: ' . USER_LOGIN_REF
        : "Location: $url";
    header($header, true, $code);

    die;
}

// check is file is existed and if not create it

function createFolder(string $folder)
{
    if (!file_exists($folder)) {
        @mkdir($folder, 0777, true); //create folder in server
        chmod($folder, 0777); //change the file mode
    }
}
