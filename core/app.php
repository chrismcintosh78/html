<?php
set_include_path(get_include_path() . ":" . '/var/www/html/');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ALL FILE PATHS RELATIVE TO:: 
require_once("../core/classes/File.php");
require_once("../core/classes/Document.php");
require_once("../core/classes/Template.php");
require_once ("../core/classes/Dir.php");
require_once ("../core/classes/Router.php");
?>