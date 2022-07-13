<?php

//common
define('ROOT', $_SERVER['DOCUMENT_ROOT']); // root folder
const CONFIG_ROOT = ROOT . '/config/'; // configuration root folder
const LOGS_FOLDER = ROOT . '/logs'; //upload folder

//ref
define('ROOT_REF', 'http://' . $_SERVER['HTTP_HOST']);
const USER_ROOT_REF = ROOT_REF . '/user'; // root user's ref
const USER_PROFILE_REF = ROOT_REF . '/user/profile'; // root user's ref
const USER_LOGIN_REF = ROOT_REF . '/user/login'; // root user's ref
