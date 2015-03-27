<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "books";
$route['404_override'] = '';
$route["(:any)"] = 'books/$1';

//end of routes.php