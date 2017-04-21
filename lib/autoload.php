<?php
error_reporting(0);
spl_autoload_register(function ($class) {
	if (!class_exists($class)) {
		include __DIR__ . '/src/classes/' . $class . '.php';
	}
});