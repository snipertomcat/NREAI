<?php
/*error_reporting(0);
spl_autoload_register(function ($class) {
	if (!class_exists($class)) {
		include 'src/classes/' . $class . '.php';	
	}
});*/

// instantiate the loader
$loader = new \App\Psr4AutoloaderClass;
// register the autoloader
$loader->register();
// register the base directories for the namespace prefix
$loader->addNamespace('App', '/lib/src');
$loader->addNamespace('App\Io', '/lib/src/Io');
$loader->addNamespace('App\Db', '/lib/src/Db');
$loader->addNamespace('App\Api', '/lib/src/Api');
$loader->addNamespace('App\Helpers', '/lib/src/Helpers');