<?php
/* Changed permission to 755 */
// Define LIVE constant as true if 'localhost' is not present in the host name. Configure the detecting of environment as necessary of course.

if (isset($_SERVER['HTTP_HOST'])){

	if (strpos($_SERVER['HTTP_HOST'],'localhost')===false ){
		defined('LIVE') || define('LIVE', true);
	}else{
		defined('LIVE') || define('LIVE', false);
	}

}else{
	defined('LIVE') || define('LIVE', false);
}

// remove the following lines when in production mode
if (!LIVE) {
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}

if ((strpos(dirname(__FILE__) ,'MH_DEV')===false) &&
	(strpos(dirname(__FILE__) ,'MH_UAT')===false)){
	defined('RLS_ENV') || define('RLS_ENV', true);
}else{
	defined('RLS_ENV') || define('RLS_ENV', false);
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
require_once($yii);


$custom=dirname(__FILE__).'/protected/includes/HelperMethods.php';
require_once($custom);

$fb=dirname(__FILE__).'/protected/components/Facebook/autoload.php';
require_once $fb. 
 
Yii::createWebApplication($config)->run();
