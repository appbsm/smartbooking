<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;
$active_record = TRUE;

$query_builder = TRUE;
$db['default'] = array(
    'dsn'	   => '',
    'hostname' => '192.168.20.211',
    'port' 	   => '1433',
    'username' => 'sa',
    'password' => 'bsm@2015',
    'database' => 'smartbooking_test',
    'dbdriver' => 'sqlsrv',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'autoinit' => TRUE,
    'stricton' => FALSE,
	'save_queries' => TRUE
);