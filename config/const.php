<?php

//common
define('ROOT', $_SERVER['DOCUMENT_ROOT']); // root folder
define('CONFIG_ROOT', ROOT.'/config/'); // configuration root folder
define('VIEW_ROOT_FILE', ROOT.'/views/file/'); // folder with file views
define('UPLOAD_FOLDER', ROOT.'/upload'); //upload folder
define('LOGS_FOLDER', ROOT.'/logs'); //upload folder


//ref
define('ROOT_REF', 'http://' . $_SERVER['HTTP_HOST']); // root ref
define('ROOT_REF_FILE', 'http://' . $_SERVER['HTTP_HOST'].'/file'); // ref of the view
