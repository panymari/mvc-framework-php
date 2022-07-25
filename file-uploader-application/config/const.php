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

//language const
const  ATTEMPTS_ERROR = 'Please wait for 15 minutes.';
const  LOGIN_ERROR = 'Login is incorrect.';

// number const
const WEEK_TO_SEC = 604800;
const BLOCK_TIME = 900;
const LIMITED_ATTEMPTS = 3;