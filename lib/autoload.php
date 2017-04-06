<?php
error_reporting(0);
spl_autoload_register(function ($class) {
	if (!class_exists($class)) {
		include 'src/classes/' . $class . '.php';	
	}
});