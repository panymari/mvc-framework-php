<?php

//common
define('ROOT', $_SERVER['DOCUMENT_ROOT']); // root folder
const CONFIG_ROOT = ROOT . '/config/'; // configuration root folder
const LOGS_FOLDER = ROOT . '/logs'; //upload folder
const UPLOAD_FOLDER = ROOT . '/upload'; //upload folder

//ref
define('ROOT_REF', 'http://' . $_SERVER['HTTP_HOST']);
const USER_ROOT_REF = ROOT_REF . '/user'; // root user's ref
const USER_LOGIN_REF = ROOT_REF . '/user/login'; // root user's ref
define('ROOT_REF_FILE', 'http://' . $_SERVER['HTTP_HOST'] . '/file'); // ref of the view
