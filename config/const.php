<?php

//common
define('ROOT', $_SERVER['DOCUMENT_ROOT']); // root folder
define('CONFIG_ROOT', ROOT.'/config/'); // configuration root folder
define('VIEW_ROOT_USERS', ROOT.'/views/users/'); // folder with users views

//ref
if (isset($_SERVER['HTTP_ORIGIN'])) {
    define('ROOT_REF', $_SERVER['HTTP_ORIGIN']); // root ref
    define('USER_ROOT_REF', ROOT_REF.'/user'); // root user's ref
}
