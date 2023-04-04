<?php 

error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function ($className) {
	$className = str_replace('_', '/', $className);
    require_once $className .'.php';
});

$request = Ccc::getModel('Core_Request');
if(!$request->getParams('a') || !$request->getParams('c')){
	header("Location: http://localhost/project-ujjawal-rajyaguru-04-average/index.php?c=product&a=grid");
	exit();
}

$session = Ccc::getModel('Core_Session');
$session->start();

class Ccc
{
	static function init()
	{
		$front = new Controller_Core_Front();
		$front->init();
	}

	static function getModel($modelName)
	{
		$model = "Model_".$modelName;
		return new $model();
	}

	static function getSingleton($className) 
	{
		$className = "Model_".$className;
		if (!array_key_exists($className,$GLOBALS)) {
			$GLOBALS[$className] = new $className();
		}
		return $GLOBALS[$className];
	}
}

Ccc :: init();

?>