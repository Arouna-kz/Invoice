<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Database Configuration
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $_ENV['DB_HOSTNAME'] ?? 'localhost',
	'username' => $_ENV['DB_USERNAME'] ?? 'root',
	'password' => $_ENV['DB_PASSWORD'] ?? '',
	'database' => $_ENV['DB_DATABASE'] ?? 'coinfinance_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);