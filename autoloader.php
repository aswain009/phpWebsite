<?php
spl_autoload_register(function ($class) {
	$className = ltrim($class, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	try{
		require 'classes'.DIRECTORY_SEPARATOR.$fileName;
	} catch (Exception $e){
		var_dump($e->getMessage());
	}
	
});