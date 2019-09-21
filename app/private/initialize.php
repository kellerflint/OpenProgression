<?php

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/html');
define("SHARED_PATH", PRIVATE_PATH . '/shared');

define("WWW_ROOT", '');

//require_once 'validation.php';
require_once 'functions.php';
require_once 'database.php';
require_once 'query_functions.php';
//require_once 'auth_functions.php';

$db = db_connect();
$errors = [];

/*
SERVER:
define("WWW_ROOT", '');
*/