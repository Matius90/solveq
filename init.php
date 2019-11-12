<?php

use Core\Config;

include('vendor/adodb/adodb-php/adodb.inc.php');

$_DB = ADONewConnection('mysqli'); # eg. 'mysql' or 'oci8'
$_DB->debug = Config::get('debug');
$_DB->SetFetchMode(ADODB_FETCH_ASSOC);
$_DB->Connect(
    Config::get('dbHost'),
    Config::get('dbUser'),
    Config::get('dbPassword'),
    Config::get('dbSchema')
);

foreach($_GET as $k => $v) {
    $_GET[$k] = is_numeric($v) ? (int) $v : $v;
}
if (array_key_exists('module',$_GET)) {
    define("MODULE", ucfirst($_GET['module']));
    unset($_GET['module']);
}
if (array_key_exists('action',$_GET)) {
    define("ACTION", $_GET['action']);
    unset($_GET['action']);
}